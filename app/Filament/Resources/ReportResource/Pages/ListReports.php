<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            // Export Bulanan
            Actions\Action::make('export-excel')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalSubmitActionLabel('Export')
                ->form([
                    TextInput::make('month')
                        ->type('month') // HTML5 input type
                        ->label('Pilih Bulan')
                        ->default(now()->format('Y-m')) // Default format yang valid: '2025-08'
                        ->required()
                    // \Filament\Forms\Components\DatePicker::make('month')
                    //     ->label('Pilih Bulan')
                    //     ->native(false)
                    //     ->extraInputAttributes(['type' => 'month'])
                    //     ->format('m/Y')
                    //     ->displayFormat('F Y') // Format bulan & tahun
                    //     ->required(),
                ])
                ->action(function (array $data) {
                    $query = $this->getFilteredTableQuery();
                    
                    // Filter berdasarkan bulan terpilih
                    if (!empty($data['month'])) {
                        $month = \Carbon\Carbon::parse($data['month']);
                        $query->whereMonth('created_at', $month->month)
                        ->whereYear('created_at', $month->year);
                    }

                    $filteredData = $query->get();

                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\ReportExport($filteredData),
                            'laporan-posyandu.xlsx'
                        )->getFile()->getContent()),
                        'laporan-list-data-posyandu.xlsx'
                    );
                }),

            // Export Tahunan
            Actions\Action::make('export-yearly')
                ->label('Export Tahunan')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalSubmitActionLabel('Export')
                ->form([
                    TextInput::make('year')
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(now()->year)
                        ->default(now()->year)
                        ->label('Pilih Tahun')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $query = $this->getFilteredTableQuery();

                    if (!empty($data['year'])) {
                        $query->whereYear('created_at', $data['year']);
                    }

                    $filteredData = $query->get();

                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\ReportExport($filteredData, 'yearly'),
                            'laporan-tahunan-posyandu.xlsx'
                        )->getFile()->getContent()),
                        'laporan-tahunan-posyandu.xlsx'
                    );
                }),
        ];
    }
}
