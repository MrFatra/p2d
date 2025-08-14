<?php

namespace App\Filament\Resources\PregnantResource\Widgets;

use App\Helpers\Auth;
use Filament\Widgets\ChartWidget;

class PregnantVisitsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Kunjungan Ibu Hamil';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $months = collect();
        $now = \Carbon\Carbon::now();

        $user = Auth::user();

        // for loop 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthLabel = $date->translatedFormat('M Y');
            $count = \App\Models\PregnantPostpartumBreastfeending::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            if ($user->hasRole('cadre')) {
                $count->whereHas('user', fn($q) => $q->where('hamlet', $user->hamlet));
            }

            $total = $count->count();

            $months->push([
                'label' => $monthLabel,
                'value' => $total,
            ]);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kunjungan Ibu Hamil',
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
                        'text' => 'Ibu Hamil',
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
