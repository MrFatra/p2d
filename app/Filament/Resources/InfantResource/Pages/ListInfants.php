<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use App\Filament\Resources\InfantResource\Widgets\InfantVisitsChart;
use App\Filament\Resources\InfantResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListInfants extends ListRecords
{

    use ExposesTableToWidgets;

    protected static string $resource = InfantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => auth()->user()->can('bayi:create'))
                ->label('Tambah Bayi')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
            Actions\Action::make('export-excel')
                ->visible(fn () => auth()->user()->can('bayi:export'))
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
                            new \App\Exports\InfantExport($filteredData),
                            'bayi.xlsx'
                        )->getFile()->getContent()),
                        'laporan-list-data-bayi.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InfantVisitsChart::class,
            VisitorOverview::class,
        ];
    }
}
