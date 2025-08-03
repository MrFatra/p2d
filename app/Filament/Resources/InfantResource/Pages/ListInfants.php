<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use App\Filament\Resources\InfantResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListInfants extends ListRecords
{

    use ExposesTableToWidgets;
    
    protected static string $resource = InfantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export-excel')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->action(function () {
                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\InfantExport, 'bayi.xlsx')->getFile()->getContent()),
                        'laporan-list-data-bayi.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VisitorOverview::class,
        ];
    }
}
