<?php

namespace App\Filament\Resources\TeenagerGrowthResource\Widgets;

use App\Models\Teenager;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class TeenagerGrowthChart extends ChartWidget
{
    public ?\App\Models\User $record = null;

    protected static ?string $heading = 'Grafik Perkembangan Remaja';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $checkups = Teenager::where('user_id', $this->record->id)
            ->orderBy('created_at')
            ->get();

        $dates = $checkups->pluck('created_at')->map(function ($date) {
            return $date ? Carbon::parse($date)->format('d M Y') : '-';
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
                    'label' => 'BMI',
                    'data' => $checkups->pluck('bmi')->toArray(),
                    'borderColor' => 'rgb(75, 192, 192)',
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
