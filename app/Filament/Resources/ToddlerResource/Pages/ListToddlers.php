<?php

namespace App\Filament\Resources\ToddlerResource\Pages;

use App\Filament\Resources\ToddlerResource;
use App\Filament\Resources\ToddlerResource\Widgets\ToddlerVisitsChart;
use App\Filament\Resources\ToddlerResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListToddlers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ToddlerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export-excel')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->action(function () {
                    $query = $this->getFilteredTableQuery();
                    $data = $query->get();

                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ToddlerExport($data), 'balita.xlsx')->getFile()->getContent()),
                        'laporan-list-data-balita.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ToddlerVisitsChart::class,
            VisitorOverview::class
        ];
    }
}
