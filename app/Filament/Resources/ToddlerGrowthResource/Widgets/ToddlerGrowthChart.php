<?php

namespace App\Filament\Resources\ToddlerGrowthResource\Widgets;

use App\Models\Toddler;
use Filament\Widgets\ChartWidget;

class ToddlerGrowthChart extends ChartWidget
{
    public ?\App\Models\User $record = null;

    protected static ?string $heading = 'Grafik Perkembangan Balita';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $checkups = Toddler::where('user_id', $this->record->id)
            ->orderBy('checkup_date')
            ->get();

        $dates = $checkups->pluck('checkup_date')->map(function ($date) {
            return $date ? \Carbon\Carbon::parse($date)->format('d M Y') : '-';
        });

        return [
            'datasets' => [
                [
                    'label' => 'Berat Badan (kg)',
                    'data' => $checkups->pluck('weight')->toArray(),
                    'borderColor' => 'rgb(255, 99, 132)',
                    'fill' => false,
                ],
                [
                    'label' => 'Tinggi Badan (cm)',
                    'data' => $checkups->pluck('height')->toArray(),
                    'borderColor' => 'rgb(54, 162, 235)',
                    'fill' => false,
                ],
                [
                    'label' => 'Lingkar Lengan Atas (cm)',
                    'data' => $checkups->pluck('upper_arm_circumference')->toArray(),
                    'borderColor' => 'rgb(255, 206, 86)',
                    'fill' => false,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
