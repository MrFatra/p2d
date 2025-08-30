<?php

namespace App\Filament\Resources\InfantResource\Widgets;

use App\Filament\Resources\InfantResource\Pages\ListInfants;
use App\Helpers\Auth;
use App\Models\Infant;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListInfants::class;
    }

    protected function getStats(): array
    {
        $now = Carbon::now();
        $user = Auth::user();
        $isCadre = $user->hasRole('cadre');

        // --- Kunjungan Bulan Ini ---
        $thisMonthQuery = User::whereHas('infants', function ($query) use ($now) {
            return $query->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year);
        });

        if ($isCadre) {
            $thisMonthQuery->where('hamlet', $user->hamlet);
        }

        $thisMonthVisits = $thisMonthQuery->count();

        // --- Kunjungan Bulan Lalu ---
        $lastMonth = $now->copy()->subMonth();

        $lastMonthQuery = User::whereHas('infants', function ($query) use ($lastMonth) {
            return $query->whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year);
        });

        if ($isCadre) {
            $lastMonthQuery->where('hamlet', $user->hamlet);
        }

        $lastMonthVisits = $lastMonthQuery->count();

        // --- Total Bayi ---
        $infantQuery = User::role('baby');

        if ($isCadre) {
            $infantQuery->where('hamlet', $user->hamlet);
        }

        $babyTotal = $infantQuery->count();

        // --- Perubahan ---
        $diff = $thisMonthVisits - $lastMonthVisits;

        $percentage = $lastMonthVisits > 0
            ? round(($diff / $lastMonthVisits) * 100, 2)
            : ($thisMonthVisits > 0 ? 100 : 0);

        if ($percentage > 0) {
            $description = 'Naik dibanding bulan lalu';
            $color = 'success';
        } elseif ($percentage < 0) {
            $description = 'Turun dibanding bulan lalu';
            $color = 'danger';
        } else {
            $description = 'Tidak ada perubahan kunjungan.';
            $color = 'gray';
        }

        // --- Stunting ---
        $stuntingQuery = Infant::whereIn('stunting_status', ['Stunting', 'Kemungkinan Stunting']);

        if ($isCadre) {
            $stuntingQuery->whereHas('user', fn($q) => $q->where('hamlet', $user->hamlet));
        }

        $stuntingUsers = $stuntingQuery->get()
            ->filter(fn($infant) => Carbon::parse($infant->birth_date)->diffInMonths($now) <= 60)
            ->groupBy('user_id')
            ->count();

        // --- Malnutrisi ---
        $malnutritionQuery = Infant::whereIn('nutrition_status', ['Gizi Kurang', 'Gizi Buruk']);

        if ($isCadre) {
            $malnutritionQuery->whereHas('user', fn($q) => $q->where('hamlet', $user->hamlet));
        }

        $malnutritionUsers = $malnutritionQuery->get()
            ->filter(fn($infant) => Carbon::parse($infant->birth_date)->diffInMonths($now) <= 60)
            ->groupBy('user_id')
            ->count();

        return [
            Stat::make('Kunjungan Bulan Ini', $thisMonthVisits . ' Bayi')
                ->description('Data per ' . $now->translatedFormat('F Y'))
                ->color('success'),

            Stat::make('Kunjungan Bulan Lalu', $lastMonthVisits . ' Bayi')
                ->description('Data dari ' . $lastMonth->translatedFormat('F Y'))
                ->color('gray'),

            Stat::make('Perubahan Kunjungan', $percentage . '%')
                ->description($description)
                ->color($color),

            Stat::make('Total Bayi dengan Stunting', $stuntingUsers . ' Bayi')
                ->description('Jumlah bayi dengan tinggi badan di bawah standar usia mereka.')
                ->color('danger'),

            Stat::make('Total Bayi dengan Gizi Kurang & Buruk', $malnutritionUsers . ' Bayi')
                ->description('Bayi dengan berat badan yang tidak sesuai standar untuk usianya.')
                ->color('danger'),

            Stat::make('Total Bayi', $babyTotal . ' Orang')
                ->description('Terdata sebagai Bayi saat ini')
                ->color('primary'),
        ];
    }
}
