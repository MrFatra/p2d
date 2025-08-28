<?php

namespace App\Filament\Resources\PreschoolerResource\Pages;

use App\Filament\Resources\PreschoolerResource;
use App\Filament\Resources\PreschoolerResource\Widgets\PreschoolerVisitsChart;
use App\Filament\Resources\PreschoolerResource\Widgets\VisitorOverview;
use App\Helpers\Auth;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPreschoolers extends ListRecords
{
    use ExposesTableToWidgets;
    
    protected static string $resource = PreschoolerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn() => auth()->user()->can('anak_prasekolah:create'))
                ->label('Tambah Data Kesehatan Apras')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),

            Actions\Action::make('export-excel')
                ->visible(fn() => auth()->user()->can('anak_prasekolah:export'))
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalSubmitActionLabel('Export')
                ->form([
                    TextInput::make('month')
                        ->type('month')
                        ->label('Pilih Bulan')
                        ->default(now()->format('Y-m'))
                        ->required()
                ])
                ->action(function (array $data) {
                    $query = \App\Models\Preschooler::query();

                    if (!empty($data['month'])) {
                        $month = \Carbon\Carbon::parse($data['month']);
                        $query->whereMonth('created_at', $month->month)
                            ->whereYear('created_at', $month->year);
                    }

                    $filteredData = $query->get();

                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\PreschoolerExport($filteredData),
                            'apras.xlsx'
                        )->getFile()->getContent()),
                        'laporan-list-data-apras.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PreschoolerVisitsChart::class,
            VisitorOverview::class,
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        $query = parent::getTableQuery();

        $user = Auth::user();

        if ($user->hasRole('cadre')) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('hamlet', $user->hamlet);
            });
        }

        return $query;
    }
}
