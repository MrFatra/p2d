<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class TotalChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public function getHeading(): string|Htmlable|null
    {
        return 'Total Penduduk Berdasarkan Usia Tahun ' . date('Y');
    }

    protected function getData(): array
    {
        return [
            'labels' => ['Pahing', 'Pon', 'Wage', 'Kliwon', 'Legi'],
            'datasets' => [
                [
                    'label' => 'Bayi',
                    'data' => [5, 3, 4, 6, 2],
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'hoverOffset' => 4
                ],
                [
                    'label' => 'Balita',
                    'data' => [8, 5, 6, 7, 3],
                    'backgroundColor' => 'rgb(54, 162, 235)',
                    'hoverOffset' => 4
                ],
                [
                    'label' => 'Anak-anak',
                    'data' => [12, 14, 10, 15, 8],
                    'backgroundColor' => 'rgb(255, 205, 86)',
                    'hoverOffset' => 4
                ],
                [
                    'label' => 'Remaja',
                    'data' => [18, 22, 20, 25, 16],
                    'backgroundColor' => 'rgb(75, 192, 192)',
                    'hoverOffset' => 4
                ],
                [
                    'label' => 'Dewasa',
                    'data' => [20, 25, 23, 30, 22],
                    'backgroundColor' => 'rgb(153, 102, 255)',
                    'hoverOffset' => 4
                ],
                [
                    'label' => 'Ibu Hamil',
                    'data' => [2, 3, 1, 4, 2],
                    'backgroundColor' => 'rgb(255, 159, 64)',
                    'hoverOffset' => 4
                ],
                [
                    'label' => 'Lansia',
                    'data' => [10, 12, 8, 15, 9],
                    'backgroundColor' => 'rgb(201, 203, 207)',
                    'hoverOffset' => 4
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
