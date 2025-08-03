<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ScheduleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ScheduleResource\RelationManagers;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-s-calendar';

    protected static ?string $label = 'Jadwal';

    protected static ?string $navigationGroup = 'Jadwal';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Jadwal')
                    ->description('Detail informasi pembuatan jadwal.')
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        Select::make('type')
                            ->label('Pilih Jadwal Untuk:')
                            ->required()
                            ->options([
                                'Donor' => 'Donor',
                                'Posyandu Bayi' => 'Posyandu Bayi',
                                'Posyandu Balita' => 'Posyandu Balita',
                                'Posyandu Ibu Hamil' => 'Posyandu Ibu Hamil',
                                'Posyandu Remaja' => 'Posyandu Remaja',
                                'Posyandu Lansia' => 'Posyandu Lansia',
                            ])
                            ->native(false),
                        TextInput::make('notes')
                            ->label('Deskripsi')
                            ->required(),
                    ]),
                Section::make('Tanggal Jadwal')
                    ->description('Pilih tanggal jadwal buka & tutup.')
                    ->icon('heroicon-o-calendar')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        DatePicker::make('date_open')
                            ->native(false)
                            ->label('Tanggal Buka')
                            ->displayFormat('Y-m-d')
                            ->closeOnDateSelection()
                            ->required(),
                        DatePicker::make('date_closed')
                            ->native(false)
                            ->label('Tanggal Tutup')
                            ->displayFormat('Y-m-d')
                            ->closeOnDateSelection()
                            ->required(),
                    ]),
                Section::make('Waktu')
                    ->description('Pilih waktu buka & tutup.')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TimePicker::make('time_opened')
                            ->seconds(false)
                            ->label('Jam Buka')
                            ->native(false)
                            ->required(),
                        TimePicker::make('time_closed')
                            ->seconds(false)
                            ->label('Jam Tutup')
                            ->native(false)
                            ->required(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Jadwal Posyandu'),
                TextColumn::make('date_open')
                    ->label('Tanggal Buka')
                    ->date('Y-m-d'),
                TextColumn::make('date_closed')
                    ->label('Tanggal Buka')
                    ->date('Y-m-d'),
                TextColumn::make('time_opened')
                    ->time('H:i')
                    ->label('Waktu Buka'),
                TextColumn::make('time_closed')
                    ->time('H:i')
                    ->label('Waktu Tutup'),
                TextColumn::make('notes')
                    ->label('Deskripsi'),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'view' => Pages\ViewSchedule::route('/{record}'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
