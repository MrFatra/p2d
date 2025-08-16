<?php

namespace App\Filament\Resources\AdultResource\Widgets;

use App\Helpers\Auth;
use Filament\Widgets\ChartWidget;

class AdultOverview extends ChartWidget
{
    protected static ?string $heading = 'Statistik Kunjungan Dewasa';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $months = collect();
        $now = \Carbon\Carbon::now();

        $user = Auth::user();

        // Loop 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthLabel = $date->translatedFormat('M Y');

            $count = \App\Models\Adult::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);

            // Filter berdasarkan dusun (kalau user kader)
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
                    'label' => 'Jumlah Kunjungan Dewasa',
                    'data' => $months->pluck('value'),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',   // Biru transparan
                    'borderColor' => 'rgba(59, 130, 246, 1)',       // Biru solid
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
                        'text' => 'Dewasa',
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
