<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Helpers\MonthlyReport;
use App\Models\Report;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    // Gunakan ikon yang lebih cocok untuk "Laporan"
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationLabel = 'Laporan Data Posyandu';

    protected static ?string $breadcrumb = 'Data Laporan Posyandu';

    protected static ?string $label = 'Data Laporan Posyandu';

    protected static ?string $navigationGroup = 'Master';

    protected static ?int $navigationSort = 10;

    public static function canAccess(): bool
    {
        return auth()->user()->can('laporan-data-posyandu:view');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi File')
                    ->columns(2)
                    ->schema([
                        TextInput::make('file_name')
                            ->label('Nama File')
                            ->disabled(),

                        TextInput::make('file_type')
                            ->label('Tipe File')
                            ->disabled(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->disabled(),
                    ]),

                Section::make('Tanggal & Waktu')
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('uploaded_at')
                            ->label('Tanggal Unggah')
                            ->disabled(),

                        DateTimePicker::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->disabled(),
                    ]),

                Section::make('Akses File')
                    ->schema([
                        TextInput::make('file_path')
                            ->label('Lokasi File')
                            ->disabled()
                            ->suffixAction(
                                Action::make('Buka')
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->url(fn($record) => asset('storage/' . $record->file_path), true)
                                    ->openUrlInNewTab()
                            ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('adult_count')
                //     ->label('Dewasa (18–59 Tahun)')
                //     ->state(fn() => $report['Adult'])
                //     ->sortable(),

                TextColumn::make('elderly_count')
                    ->label('Lansia (60 Tahun ke Atas)')
                    ->state(fn($record) => MonthlyReport::getMonthlyReportByRecord($record)['Elderly']),

                TextColumn::make('infant_count')
                    ->label('Bayi (0-12 Bulan)')
                    ->state(fn($record) => MonthlyReport::getMonthlyReportByRecord($record)['Infant']),

                TextColumn::make('pregnant_count')
                    ->label('Ibu Hamil')
                    ->state(fn($record) => MonthlyReport::getMonthlyReportByRecord($record)['Pregnant']),

                TextColumn::make('teenager_count')
                    ->label('Remaja (13-17 Tahun)')
                    ->state(fn($record) => MonthlyReport::getMonthlyReportByRecord($record)['Teenager']),

                TextColumn::make('toddler_count')
                    ->label('Balita (1-5 Tahun)')
                    ->state(fn($record) => MonthlyReport::getMonthlyReportByRecord($record)['Toddler']),

                TextColumn::make('month')
                    ->label('Bulan')
                    ->state(fn($record) => MonthlyReport::getMonthlyReportByRecord($record)['month']),

                TextColumn::make('year')
                    ->label('Tahun')
                    ->state(fn($record) => MonthlyReport::getMonthlyReportByRecord($record)['year']),
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
            'index' => Pages\ListReports::route('/'),
            'view' => Pages\ViewReport::route('/{record}'),
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

}
