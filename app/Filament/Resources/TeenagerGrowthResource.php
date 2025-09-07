<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeenagerGrowthResource\Pages;
use App\Filament\Resources\TeenagerGrowthResource\RelationManagers;
use App\Helpers\Auth;
use App\Helpers\Query;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeenagerGrowthResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'icon-children-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-children-solid-full-active';

    protected static ?string $navigationGroup = 'Pertumbuhan';

    protected static ?string $navigationLabel = 'Remaja';

    protected static ?string $breadcrumb = 'Pertumbuhan Remaja';

    protected static ?string $label = 'Pertumbuhan Remaja';

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
            'index' => Pages\ListTeenagerGrowths::route('/'),
            'create' => Pages\CreateTeenagerGrowth::route('/create'),
            'view' => Pages\ViewTeenagerGrowth::route('/{record}'),
            'edit' => Pages\EditTeenagerGrowth::route('/{record}/edit'),
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
        $query = parent::getEloquentQuery();
        $user = Auth::user();

        $query = Query::takeTeenagers($query);

        if ($user->hasRole('cadre')) {
            $query->where('hamlet', $user->hamlet);
        }

        return $query;
    }
}
