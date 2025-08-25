<?php

namespace App\Filament\Resources\AdultResource\Widgets;

use App\Filament\Resources\AdultResource\Pages\ListAdults;
use App\Helpers\Auth;
use App\Models\Adult;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdultVisitor extends BaseWidget
{
    // use InteractsWithPageTable;

    // protected array $tableColumnSearches = [];

    protected function getTablePage(): string
    {
        return ListAdults::class;
    }

    protected function getStats(): array
    {
        $now = Carbon::now();
        $user = Auth::user();
        $isCadre = $user->hasRole('cadre');

        // --- Kunjungan Bulan Ini ---
        $thisMonthQuery = User::whereHas('adults', function ($query) use ($now) {
            return $query->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year);
        });
        
        if ($isCadre) {
            $thisMonthQuery->where('hamlet', $user->hamlet);
        }
        
        $thisMonthVisits = $thisMonthQuery->count();
        
        // --- Kunjungan Bulan Lalu ---
        $lastMonth = $now->copy()->subMonth();
        
        $lastMonthQuery = User::whereHas('adults', function ($query) use ($lastMonth) {
            return $query->whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year);
        });

        if ($isCadre) {
            $lastMonthQuery->where('hamlet', $user->hamlet);
        }

        $lastMonthVisits = $lastMonthQuery->count();

        // --- Total Dewasa ---
        $adultCount = User::role('adult');

        if ($isCadre) {
            $adultCount->where('hamlet', $user->hamlet);
        }

        $adultTotal = $adultCount->count();

        // --- Hitung Perubahan ---
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

        return [
            Stat::make('Kunjungan Bulan Ini', $thisMonthVisits . ' Dewasa')
                ->description('Data per ' . $now->translatedFormat('F Y'))
                ->color('success'),

            Stat::make('Kunjungan Bulan Lalu', $lastMonthVisits . ' Dewasa')
                ->description('Data dari ' . $lastMonth->translatedFormat('F Y'))
                ->color('gray'),

            Stat::make('Perubahan Kunjungan', $percentage . '%')
                ->description($description)
                ->color($color),

            Stat::make('Total Dewasa', $adultTotal . ' Orang')
                ->description('Terdata sebagai Dewasa saat ini')
                ->color($color),
        ];
    }
}
