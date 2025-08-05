<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
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
        $hamlets = ['Pahing', 'Wage', 'Manis', 'Puhun', 'Kliwon'];

        $categories = [
            'Bayi' => [0, 1],
            'Balita' => [2, 5],
            'Anak-anak' => [6, 12],
            'Remaja' => [13, 17],
            'Dewasa' => [18, 59],
            'Lansia' => [60, 150],
        ];

        $colors = [
            'Bayi' => 'rgb(255, 99, 132)',
            'Balita' => 'rgb(54, 162, 235)',
            'Anak-anak' => 'rgb(255, 205, 86)',
            'Remaja' => 'rgb(75, 192, 192)',
            'Dewasa' => 'rgb(153, 102, 255)',
            'Lansia' => 'rgb(201, 203, 207)',
            'Ibu Hamil' => 'rgb(255, 159, 64)',
        ];

        $datasets = [];

        foreach ($categories as $label => [$minAge, $maxAge]) {
            $data = [];

            foreach ($hamlets as $hamlet) {
                $count = User::where('hamlet', $hamlet)
                    ->whereNotNull('birth_date')
                    ->whereBetween('birth_date', [
                        Carbon::now()->subYears($maxAge),
                        Carbon::now()->subYears($minAge)->endOfDay()
                    ])
                    ->count();

                $data[] = $count;
            }

            $datasets[] = [
                'label' => $label,
                'data' => $data,
                'backgroundColor' => $colors[$label],
                'hoverOffset' => 4,
            ];
        }

        // Ibu Hamil
        $ibuHamilData = [];

        foreach ($hamlets as $hamlet) {
            $count = User::where('hamlet', $hamlet)
                ->where('gender', 'P')
                ->whereHas('pregnantPostpartumBreastfeedings', function ($query) {
                    $query->where('pregnancy_status', 'pregnant');
                })
                ->count();

            $ibuHamilData[] = $count;
        }

        $datasets[] = [
            'label' => 'Ibu Hamil',
            'data' => $ibuHamilData,
            'backgroundColor' => $colors['Ibu Hamil'],
            'hoverOffset' => 4,
        ];

        return [
            'labels' => $hamlets,
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
