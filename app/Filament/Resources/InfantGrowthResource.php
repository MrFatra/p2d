<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfantGrowthResource\Pages;
use App\Filament\Resources\InfantGrowthResource\RelationManagers;
use App\Helpers\Auth;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InfantGrowthResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'icon-baby-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-baby-solid-full-active';

    protected static ?string $navigationGroup = 'Pertumbuhan';

    protected static ?string $navigationLabel = 'Bayi';

    protected static ?string $breadcrumb = 'Pertumbuhan Bayi';

    protected static ?string $label = 'Pertumbuhan Bayi';

    public static function canAccess(): bool
    {
        return auth()->user()->can('pertumbuhan-bayi:view');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->sortable(),

                Tables\Columns\TextColumn::make('hamlet')
                    ->label('Dusun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
            'index' => Pages\ListInfantGrowths::route('/'),
            'create' => Pages\CreateInfantGrowth::route('/create'),
            'view' => Pages\ViewInfantGrowth::route('/{record}'),
            'edit' => Pages\EditInfantGrowth::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        $now = \Carbon\Carbon::now();

        return parent::getEloquentQuery()
            ->whereDate('birth_date', '>', $now->copy()->subYears(1))
            ->where('hamlet', Auth::user()->hamlet);
    }
}
