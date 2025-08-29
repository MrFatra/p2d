<?php

namespace App\Filament\Resources\TeenagerGrowthResource\Widgets;

use App\Models\Teenager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TeenagerGrowthTable extends BaseWidget
{
    public ?\App\Models\User $record = null;

    protected static ?string $heading = 'Riwayat Pertumbuhan Remaja';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal Input')
                    ->date('d M Y'),

                TextColumn::make('weight')
                    ->label('Berat (kg)'),

                TextColumn::make('height')
                    ->label('Tinggi (cm)'),

                TextColumn::make('upper_arm_circumference')
                    ->label('Lingkar Lengan Atas (cm)'),
            ])->query(Teenager::query()->where('user_id', $this->record->id))
            ->defaultPaginationPageOption(5);
    }
}
