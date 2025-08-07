<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'icon-user-tag-solid-full';
    protected static ?string $activeNavigationIcon = 'icon-user-tag-solid-full-active';
    protected static ?string $label = 'Peran Pengguna';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 999;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ✅ Section with Grid(2) for role name and description
                Section::make('Informasi Peran')
                    ->description('Detail informasi peran pengguna.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Peran')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ]),

                // ✅ Section with Grid(2) to group permissions by module
                Section::make('Permissions')
                    ->description('Pilih izin akses yang diberikan kepada peran ini.')
                    ->icon('heroicon-o-shield-check')
                    ->columns(2)
                    ->schema([
                        Grid::make(2)
                            ->schema(static::groupedPermissions()),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
    }
    protected static function groupedPermissions(): array
    {
        $permissions = Permission::all()
            ->groupBy(function ($permission) {
                return ucfirst(explode(':', $permission->name)[0]); // e.g. Users
            });

        $fields = [];

        foreach ($permissions as $module => $items) {
            $fields[] = Card::make()
                ->schema([
                    CheckboxList::make('permissions')
                        ->label($module)
                        ->relationship('permissions', 'name')
                        ->options(
                            $items->mapWithKeys(fn($item) => [$item->id => $item->name])->toArray()
                        )
                        ->columns(2)
                        ->bulkToggleable()
                ])
                ->columnSpan(1); // ✅ Agar Card tetap mengikuti grid 2 kolom
        }

        return $fields;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Peran')
                    ->searchable(),

                TextColumn::make('permissions.name')
                    ->label('Izin Akses')
                    ->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
