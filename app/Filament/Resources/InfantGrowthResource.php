<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfantGrowthResource\Pages;
use App\Filament\Resources\InfantGrowthResource\RelationManagers\InfantsRelationManager;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InfantGrowthResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Pertumbuhan';
    protected static ?string $navigationLabel = 'Pertumbuhan Bayi';
    protected static ?string $pluralModelLabel = 'Daftar Bayi';
    protected static ?string $modelLabel = 'Bayi';

    public static function form(Form $form): Form
    {
        return $form->schema([]); // Form bayi kosong, kita fokus ke pertumbuhan
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                fn(Builder $query) => $query
                    ->whereDate('birth_date', '>=', now()->subYear())
                    ->orderBy('name')
            )
            ->columns([
                TextColumn::make('name')->label('Nama Bayi')->searchable(),
                TextColumn::make('birth_date')->label('Tanggal Lahir')->date(),
                TextColumn::make('gender')->label('Jenis Kelamin'),
            ])
            ->actions([
                ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            InfantsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInfantGrowths::route('/'),
            'view' => Pages\ViewInfantGrowth::route('/{record}'),
        ];
    }
}
