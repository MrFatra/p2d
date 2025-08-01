<?php

namespace App\Filament\Resources\TeenagerResource\Pages;

use App\Filament\Resources\TeenagerResource;
use App\Filament\Resources\TeenagerResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListTeenagers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = TeenagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export-excel')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->action(function () {
                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TeenagerExport, 'remaja.xlsx')->getFile()->getContent()),
                        'laporan-list-data-remaja.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VisitorOverview::class
        ];
    }
}
