<?php

namespace App\Filament\Resources\TeenagerResource\Widgets;

use App\Helpers\Auth;
use Filament\Widgets\ChartWidget;

class TeenagerVisitsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Kunjungan Remaja';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $months = collect();
        $now = \Carbon\Carbon::now();

        // for loop 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthLabel = $date->translatedFormat('M Y');
            $count = \App\Models\Teenager::whereYear('created_at', $date->year)
                ->whereHas('user', fn($query) => $query->where('hamlet', Auth::user()->hamlet))
                ->whereMonth('created_at', $date->month)
                ->count();

            $months->push([
                'label' => $monthLabel,
                'value' => $count,
            ]);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kunjungan Remaja',
                    'data' => $months->pluck('value'),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $months->pluck('label'),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'responsive' => true,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Remaja',
                    ],
                    'ticks' => [
                        'precision' => 0,
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
