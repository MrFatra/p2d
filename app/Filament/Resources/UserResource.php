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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('nik')
                        ->label('NIK')
                        ->disabled(),
                    Forms\Components\TextInput::make('no_kk')
                        ->label('No. KK')
                        ->disabled(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama'),
                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->disabled(),
                    Forms\Components\TextInput::make('date_birth')
                        ->label('Tanggal Lahir'),
                    Forms\Components\TextInput::make('age')
                        ->label('Usia'),
                    Forms\Components\Select ::make('gender')
                        ->label('Jenis Kelamin')
                        ->options([
                            'L' => 'Laki-laki',
                            'P' => 'Perempuan',
                        ]),
                    Forms\Components\TextInput::make('phone_number')
                        ->label('No. HP'),
                        Forms\Components\TextInput::make('email')
                        ->label('Email'),
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat'),
                    Forms\Components\TextInput::make('latitude')
                        ->label('Latitude'),
                    Forms\Components\TextInput::make('longitude')
                        ->label('Longitude'),
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
