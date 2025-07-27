<?php

namespace App\Filament\Resources\ToddlerResource\Widgets;

use App\Filament\Resources\ToddlerResource\Pages\ListToddlers;
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

        $thisMonthVisits = $this->getPageTableQuery()
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $lastMonth = $now->copy()->subMonth();

        $lastMonthVisits = $this->getPageTableQuery()
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $diff = $thisMonthVisits - $lastMonthVisits;

        $percentage = $lastMonthVisits > 0
            ? round(($diff / $lastMonthVisits) * 100, 2)
            : ($thisMonthVisits > 0 ? 100 : 0);

        $isUp = $percentage >= 0;

        return [
            Stat::make('Kunjungan Bulan Ini', $thisMonthVisits . ' Balita')
                ->description('Data per ' . $now->translatedFormat('F Y'))
                ->color('success'),

            Stat::make('Kunjungan Bulan Lalu', $lastMonthVisits . ' Balita')
                ->description('Data dari ' . $lastMonth->translatedFormat('F Y'))
                ->color('gray'),

            Stat::make('Perubahan Kunjungan', $percentage . '%')
                ->description($isUp ? 'Naik dibanding bulan lalu' : 'Turun dibanding bulan lalu')
                ->color($isUp ? 'success' : 'danger'),
        ];
    }
}
