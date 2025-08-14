<?php

namespace App\Filament\Resources\ToddlerResource\Widgets;

use App\Filament\Resources\ToddlerResource\Pages\ListToddlers;
use App\Helpers\Auth;
use App\Models\Toddler;
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
        return ListToddlers::class;
    }

    protected function getStats(): array
    {
        $now = Carbon::now();
        $user = Auth::user();
        $isCadre = $user->hasRole('cadre');

        // --- Kunjungan Bulan Ini ---
        $thisMonthQuery = Toddler::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year);

        if ($isCadre) {
            $thisMonthQuery->whereHas('user', fn($q) => $q->where('hamlet', $user->hamlet));
        }

        $thisMonthVisits = $thisMonthQuery->count();

        // --- Kunjungan Bulan Lalu ---
        $lastMonth = $now->copy()->subMonth();

        $lastMonthQuery = Toddler::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year);

        if ($isCadre) {
            $lastMonthQuery->whereHas('user', fn($q) => $q->where('hamlet', $user->hamlet));
        }

        $lastMonthVisits = $lastMonthQuery->count();

        // --- Total Balita ---
        $toddlerQuery = User::role('toddler');
        if ($isCadre) {
            $toddlerQuery->where('hamlet', $user->hamlet);
        }

        $toddlerTotal = $toddlerQuery->count();

        $diff = $thisMonthVisits - $lastMonthVisits;

        $percentage = $lastMonthVisits > 0
            ? round(($diff / $lastMonthVisits) * 100, 2)
            : ($thisMonthVisits > 0 ? 100 : 0);

        $description = 'Standar';
        $color = 'gray';

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

        return [
            Stat::make('Kunjungan Bulan Ini', $thisMonthVisits . ' Balita')
                ->description('Data per ' . $now->translatedFormat('F Y'))
                ->color('success'),

            Stat::make('Kunjungan Bulan Lalu', $lastMonthVisits . ' Balita')
                ->description('Data dari ' . $lastMonth->translatedFormat('F Y'))
                ->color('gray'),

            Stat::make('Perubahan Kunjungan', $percentage . '%')
                ->description($description)
                ->color($color),
            Stat::make('Total Balita', $toddlerTotal . ' Orang')
                ->description('Terdata sebagai Balita saat ini')
                ->color($color),
        ];
    }
}
