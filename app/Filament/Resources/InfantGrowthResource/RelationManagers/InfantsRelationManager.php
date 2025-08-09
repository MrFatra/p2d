<?php

namespace App\Filament\Resources\InfantGrowthResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class InfantsRelationManager extends RelationManager
{
    protected static string $relationship = 'infants'; // relasi dari model User
    protected static ?string $title = 'Riwayat Pertumbuhan';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('checkup_date')->label('Tanggal Pemeriksaan')->required(),
            Forms\Components\TextInput::make('weight')->label('Berat (kg)')->numeric()->required(),
            Forms\Components\TextInput::make('height')->label('Tinggi (cm)')->numeric()->required(),
            Forms\Components\TextInput::make('head_circumference')->label('Lingkar Kepala')->numeric(),
            Forms\Components\Select::make('nutrition_status')
                ->options([
                    'Gizi Baik' => 'Gizi Baik',
                    'Gizi Cukup' => 'Gizi Cukup',
                    'Gizi Kurang' => 'Gizi Kurang',
                    'Gizi Buruk' => 'Gizi Buruk',
                    'Obesitas' => 'Obesitas',
                ])
                ->label('Status Gizi'),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('checkup_date')->label('Tanggal')->date(),
                Tables\Columns\TextColumn::make('weight')->label('Berat')->sortable(),
                Tables\Columns\TextColumn::make('height')->label('Tinggi')->sortable(),
                Tables\Columns\TextColumn::make('head_circumference')->label('Lingkar Kepala')->sortable(),
                TextColumn::make('nutrition_status')
                    ->label('Gizi')
                    ->badge()
                    ->colors([
                        'success' => 'Gizi Baik',
                        'warning' => 'Gizi Cukup',
                        'danger' => ['Gizi Kurang', 'Gizi Buruk', 'Obesitas'],
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('checkup_date', 'desc');
    }
}
