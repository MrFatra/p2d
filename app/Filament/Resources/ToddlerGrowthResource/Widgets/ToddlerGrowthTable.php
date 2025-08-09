<?php

namespace App\Filament\Resources\ToddlerGrowthResource\Widgets;

use App\Models\Toddler;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ToddlerGrowthTable extends BaseWidget
{
    public ?\App\Models\User $record = null;

    protected static ?string $heading = 'Riwayat Pertumbuhan Balita';

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

                TextColumn::make('upper_arm_circumference')
                    ->label('Lingkar Lengan Atas (cm)'),
            ])->query(Toddler::query()->where('user_id', $this->record->id))
            ->defaultPaginationPageOption(5);
    }
}
