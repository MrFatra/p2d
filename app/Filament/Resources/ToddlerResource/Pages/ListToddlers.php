<?php

namespace App\Filament\Resources\ToddlerResource\Pages;

use App\Filament\Resources\ToddlerResource;
use App\Filament\Resources\ToddlerResource\Widgets\ToddlerVisitsChart;
use App\Filament\Resources\ToddlerResource\Widgets\VisitorOverview;
use App\Helpers\Auth;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListToddlers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ToddlerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn() => auth()->user()->can('balita:create'))
                ->icon('heroicon-o-plus')
                ->label('Tambah Balita'),
            Actions\Action::make('export-excel')
                ->visible(fn() => auth()->user()->can('balita:export'))
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
                            new \App\Exports\ToddlerExport($filteredData),
                            'balita.xlsx'
                        )->getFile()->getContent()),
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
