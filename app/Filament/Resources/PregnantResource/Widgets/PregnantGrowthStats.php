<?php

namespace App\Filament\Resources\PregnantResource\Widgets;

use App\Models\PregnantPostpartumBreastfeending;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as Widget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PregnantGrowthStats extends Widget
{
    protected static string $view = 'filament.widgets.pregnant-growth-stats';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $thisMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;
        $year = Carbon::now()->year;

        $currentMonthCount = PregnantPostpartumBreastfeending::whereYear('created_at', $year)
            ->whereMonth('created_at', $thisMonth)
            ->count();

        $lastMonthCount = PregnantPostpartumBreastfeending::whereYear('created_at', $year)
            ->whereMonth('created_at', $lastMonth)
            ->count();

        $diff = $currentMonthCount - $lastMonthCount;

        $percent = $lastMonthCount > 0
            ? round(($diff / $lastMonthCount) * 100, 2)
            : ($currentMonthCount > 0 ? 100 : 0);

        return [
            'currentMonthCount' => $currentMonthCount,
            'lastMonthCount' => $lastMonthCount,
            'diff' => $diff,
            'percent' => $percent,
        ];
    }
}
