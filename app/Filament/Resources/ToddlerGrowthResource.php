<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToddlerGrowthResource\Pages;
use App\Filament\Resources\ToddlerGrowthResource\RelationManagers;
use App\Helpers\Auth;
use App\Models\ToddlerGrowth;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ToddlerGrowthResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'icon-child-reaching-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-child-reaching-solid-full-active';

    protected static ?string $navigationGroup = 'Pertumbuhan';

    protected static ?string $navigationLabel = 'Balita';

    protected static ?string $breadcrumb = 'Pertumbuhan Balita';

    protected static ?string $label = 'Pertumbuhan Balita';

    public static function canAccess(): bool
    {
        return auth()->user()->can('pertumbuhan-balita:view');
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

                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->toggleable(),
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
            'index' => Pages\ListToddlerGrowths::route('/'),
            'create' => Pages\CreateToddlerGrowth::route('/create'),
            'view' => Pages\ViewToddlerGrowth::route('/{record}'),
            'edit' => Pages\EditToddlerGrowth::route('/{record}/edit'),
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
            ->where('hamlet', Auth::user()->hamlet)
            ->whereDate('birth_date', '>', $now->copy()->subYears(5))
            ->whereDate('birth_date', '<=', $now->copy()->subYears(1));
    }
}
