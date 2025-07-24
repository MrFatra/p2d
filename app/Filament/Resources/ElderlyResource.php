<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElderlyResource\Pages;
use App\Filament\Resources\ElderlyResource\RelationManagers;
use App\Models\Elderly;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ElderlyResource extends Resource
{
    protected static ?string $model = Elderly::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user.name')
                    ->label('Nama Pengguna')
                    ->placeholder(fn($record) => $record?->user?->name ?? '-')
                    ->disabled(),

                TextInput::make('blood_pressure')
                    ->label('Tekanan Darah (mmHg)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('blood_glucose')
                    ->label('Gula Darah (mg/dL)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('cholesterol')
                    ->label('Kolesterol (mg/dL)')
                    ->numeric()
                    ->nullable(),

                TextInput::make('nutrition_status')
                    ->label('Status Gizi')
                    ->nullable(),

                TextInput::make('functional_ability')
                    ->label('Kemampuan Fungsional')
                    ->nullable(),

                TextInput::make('chronic_disease_history')
                    ->label('Riwayat Penyakit Kronis')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Pengguna')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('blood_pressure')
                    ->label('Tekanan Darah (mmHg)')
                    ->sortable(),

                TextColumn::make('blood_glucose')
                    ->label('Gula Darah (mg/dL)')
                    ->sortable(),

                TextColumn::make('cholesterol')
                    ->label('Kolesterol (mg/dL)')
                    ->sortable(),

                TextColumn::make('nutrition_status')
                    ->label('Status Gizi')
                    ->searchable(),

                TextColumn::make('functional_ability')
                    ->label('Kemampuan Fungsional')
                    ->searchable(),

                TextColumn::make('chronic_disease_history')
                    ->label('Riwayat Penyakit Kronis')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Input')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListElderlies::route('/'),
            'create' => Pages\CreateElderly::route('/create'),
            'view' => Pages\ViewElderly::route('/{record}'),
            'edit' => Pages\EditElderly::route('/{record}/edit'),
        ];
    }
}
