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

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $label = 'Jadwal';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Informasi Jadwal')
            ->description('Detail informasi pembuatan jadwal.')
            ->icon('heroicon-o-information-circle')
            ->columns(2)
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
                TimePicker::make('opened_time')
                ->seconds(false)
                ->label('Jam Buka')
                ->required(),
                TimePicker::make('closed_time')
                ->seconds(false)
                ->label('Jam Tutup')
                ->required(),
                TextInput::make('notes')
                ->label('Deskripsi')
                ->required()
            ])
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
                TextColumn::make('opened_time')
                ->label('Waktu Buka'),
                TextColumn::make('closed_time')
                ->label('Waktu Tutup'),
                TextColumn::make('notes')
                ->label('Deskripsi'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
