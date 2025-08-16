<?php

namespace App\Filament\Resources\TeenagerResource\Pages;

use App\Filament\Resources\TeenagerResource;
use App\Filament\Resources\TeenagerResource\Widgets\TeenagerVisitsChart;
use App\Filament\Resources\TeenagerResource\Widgets\VisitorOverview;
use App\Helpers\Auth;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTeenagers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = TeenagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn() => auth()->user()->can('remaja:create')),
            Actions\Action::make('export-excel')
                ->visible(fn() => auth()->user()->can('remaja:export'))
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
                            new \App\Exports\TeenagerExport($filteredData),
                            'remaja.xlsx'
                        )->getFile()->getContent()),
                        'laporan-list-data-remaja.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TeenagerVisitsChart::class,
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
