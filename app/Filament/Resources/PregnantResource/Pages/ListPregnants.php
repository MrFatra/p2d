<?php

namespace App\Filament\Resources\PregnantResource\Pages;

use App\Filament\Resources\PregnantResource;
use App\Filament\Resources\PregnantResource\Widgets\PregnantVisitsChart;
use App\Filament\Resources\PregnantResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPregnants extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = PregnantResource::class;

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
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PregnantExport($data), 'ibu-hamil.xlsx')->getFile()->getContent()),
                        'laporan-list-data-ibu-hamil.xlsx'
                    );
                }),
        ];
    }

    // ✅ Tambahkan method ini
    protected function getHeaderWidgets(): array
    {
        return [
            PregnantVisitsChart::class,
            VisitorOverview::class,
        ];
    }
}
