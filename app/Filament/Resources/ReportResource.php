<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Helpers\Auth;
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
use Illuminate\Database\Eloquent\Builder;
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
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('adult_count')
                //     ->label('Dewasa (18–59 Tahun)')
                //     ->state(fn() => $report['Adult'])
                //     ->sortable(),

                TextColumn::make('elderlies')
                    ->label('Lansia (60 Tahun ke Atas)'),

                TextColumn::make('babies')
                    ->label('Bayi (0-12 Bulan)'),

                TextColumn::make('pregnants')
                    ->label('Ibu Hamil'),

                TextColumn::make('teenagers')
                    ->label('Remaja (13-17 Tahun)'),

                TextColumn::make('toddlers')
                    ->label('Balita (1-5 Tahun)'),

                TextColumn::make('hamlet')
                    ->label('Dusun')
                    ->visible(fn() => Auth::user()->hasRole(['admin', 'resident'])),

                TextColumn::make('month')
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::create()->month((int) $state)->translatedFormat('F'))
                    ->label('Bulan'),

                TextColumn::make('year')
                    ->label('Tahun'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
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

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canView(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        if (Auth::user()->hasRole('cadre')) {
            return parent::getEloquentQuery()
                ->where('hamlet', Auth::user()->hamlet);
        } else {
            return parent::getEloquentQuery();
        }
    }
}
