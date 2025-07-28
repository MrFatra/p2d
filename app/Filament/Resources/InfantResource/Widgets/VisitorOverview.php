<?php

namespace App\Filament\Resources\InfantResource\Widgets;

use App\Filament\Resources\InfantResource\Pages\ListInfants;
use App\Models\Infant;
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

        $thisMonthVisits = $this->getPageTableQuery()
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $lastMonth = $now->copy()->subMonth();

        $lastMonthVisits = Infant::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

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
        }

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
        ];
    }
}
