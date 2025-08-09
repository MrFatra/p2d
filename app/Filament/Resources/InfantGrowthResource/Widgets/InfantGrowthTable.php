<?php

namespace App\Filament\Resources\InfantGrowthResource\Widgets;

use App\Models\Infant;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class InfantGrowthTable extends BaseWidget
{
    public ?\App\Models\User $record = null;

    protected static ?string $heading = 'Riwayat Pertumbuhan Bayi';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('checkup_date')
                    ->label('Tanggal Pemeriksaan')
                    ->date('d M Y'),

                TextColumn::make('weight')
                    ->label('Berat (kg)'),

                TextColumn::make('height')
                    ->label('Tinggi (cm)'),

                TextColumn::make('head_circumference')
                    ->label('Lingkar Kepala (cm)'),
            ])
            ->query(Infant::query()->where('user_id', $this->record->id))
            ->defaultPaginationPageOption(5);
    }
}
