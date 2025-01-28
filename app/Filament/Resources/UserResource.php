<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $label = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pribadi')
                    ->description('Detail informasi pribadi pengguna.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('no_kk')
                            ->required()
                            ->numeric()
                            ->label('No. KK'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nama'),
                        Forms\Components\DatePicker::make('birth_date')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('Y-m-d')
                            ->required()
                            ->label('Tanggal Lahir'),
                        Forms\Components\TextInput::make('age')
                            ->required()
                            ->label('Usia'),
                        Forms\Components\Select::make('gender')
                            ->required()
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ]),
                    ]),

                Section::make('Kontak')
                    ->description('Informasi kontak pengguna.')
                    ->icon('heroicon-o-phone')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->label('No. HP'),
                    ]),

                Section::make('Alamat')
                    ->description('Detail lokasi pengguna.')
                    ->icon('heroicon-o-map-pin')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->label('Alamat'),
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude'),
                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude'),
                    ]),

                Section::make('Keamanan')
                    ->description('Informasi keamanan pengguna.')
                    ->icon('heroicon-o-lock-closed')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->preload()
                            ->options(
                                Role::all()->pluck('name', 'id')->mapWithKeys(function ($name, $id) {
                                    return [$id => \Illuminate\Support\Str::title($name)];
                                })
                            )
                            ->label('Roles'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Password')
                            ->hiddenOn('view')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('no_kk')
                    ->label('No. KK')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->badge()
                    ->searchable()
                    ->colors([
                        'info' => 'L',
                        'pink' => 'P',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    }),
                TextColumn::make('phone_number')
                    ->label('Nomor Telepon')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->address)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->colors([
                        'warning' => 'admin',
                        'info' => 'patient',
                        'success' => 'doctor',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'admin' => 'Admin',
                        'patient' => 'Pasien',
                        'doctor' => 'Dokter',
                    }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
