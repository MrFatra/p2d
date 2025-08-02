<?php

namespace App\Filament\Resources\ElderlyResource\Pages;

use App\Filament\Resources\ElderlyResource;
use App\Filament\Resources\ElderlyResource\Widgets\StatsOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListElderlies extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ElderlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export-excel')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->action(function () {
                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ElderlyExport, 'Lansia.xlsx')->getFile()->getContent()),
                        'laporan-list-data-lansia.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class
        ];
    }
}
