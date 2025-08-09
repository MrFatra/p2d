<?php

namespace App\Filament\Resources\InfantGrowthResource\Widgets;

use App\Models\Infant;
use Filament\Widgets\ChartWidget;

class InfantGrowthChart extends ChartWidget
{
    public ?\App\Models\User $record = null;

    protected static ?string $heading = 'Grafik Perkembangan Bayi';

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $checkups = Infant::where('user_id', $this->record->id)
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
                    'label' => 'Lingkar Kepala (cm)',
                    'data' => $checkups->pluck('head_circumference')->toArray(),
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
