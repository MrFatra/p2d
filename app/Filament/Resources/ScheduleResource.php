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

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $label = 'Jadwal';

    protected static ?string $navigationGroup = 'Jadwal';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Informasi Kehamilan')
                ->description('Status kehamilan ibu saat ini.')
                ->icon('heroicon-o-user')
                ->columns(1)
                ->collapsible()
                ->schema([
                    Select::make('pregnancy_status')
                        ->label('Status Kehamilan')
                        ->required()
                        ->options([
                            'Trimester 1' => 'Trimester 1',
                            'Trimester 2' => 'Trimester 2',
                            'Trimester 3' => 'Trimester 3',
                            'Postpartum' => 'Postpartum',
                        ])
                        ->native(false),
                ]),

            Section::make('Pemeriksaan Fisik')
                ->description('Data hasil pemeriksaan fisik ibu hamil.')
                ->icon('heroicon-o-clipboard-document')
                ->columns(2)
                ->collapsible()
                ->schema([
                    TextInput::make('muac')
                        ->label('Lingkar Lengan Atas (cm)')
                        ->numeric()
                        ->required()
                        ->suffix('cm'),

                    TextInput::make('blood_pressure')
                        ->label('Tekanan Darah')
                        ->placeholder('Contoh: 120/80')
                        ->required(),
                ]),

            Section::make('Imunisasi & Suplemen')
                ->description('Catatan imunisasi dan konsumsi tablet penambah darah.')
                ->icon('heroicon-o-shield-check')
                ->columns(2)
                ->collapsible()
                ->schema([
                    Select::make('tetanus_immunization')
                        ->label('Status Imunisasi Tetanus')
                        ->options([
                            'Lengkap' => 'Lengkap',
                            'Belum Lengkap' => 'Belum Lengkap',
                            'Tidak Diketahui' => 'Tidak Diketahui',
                        ])
                        ->native(false)
                        ->required(),

                    Select::make('iron_tablets')
                        ->label('Jumlah Tablet Tambah Darah')
                        ->options([
                            '0' => '0 Tablet',
                            '30' => '30 Tablet',
                            '60' => '60 Tablet',
                            '90' => '90 Tablet',
                        ])
                        ->native(false)
                        ->required(),
                ]),

            Section::make('Jadwal Pemeriksaan (ANC)')
                ->description('Tanggal kunjungan atau jadwal pemeriksaan ANC berikutnya.')
                ->icon('heroicon-o-calendar-days')
                ->columns(1)
                ->collapsible()
                ->schema([
                    DatePicker::make('anc_schedule')
                        ->label('Jadwal Pemeriksaan ANC')
                        ->native(false)
                        ->displayFormat('Y-m-d')
                        ->closeOnDateSelection()
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
