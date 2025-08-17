<?php

namespace App\Filament\Resources\ElderlyResource\Pages;

use App\Filament\Resources\ElderlyResource;
use App\Filament\Resources\ElderlyResource\Widgets\ElderlyVisitsChart;
use App\Filament\Resources\ElderlyResource\Widgets\StatsOverview;
use App\Helpers\Auth;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListElderlies extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ElderlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Lansia')
                ->icon('heroicon-o-plus')
                ->visible(fn() => auth()->user()->can('lansia:create')),
            Actions\Action::make('export-excel')
                ->visible(fn() => auth()->user()->can('lansia:export'))
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
                    $query = \App\Models\Elderly::query();

                    // Filter berdasarkan bulan terpilih
                    if (!empty($data['month'])) {
                        $month = \Carbon\Carbon::parse($data['month']);
                        $query->whereMonth('created_at', $month->month)
                            ->whereYear('created_at', $month->year);
                    }

                    $filteredData = $query->get();

                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\ElderlyExport($filteredData),
                            'lansia.xlsx'
                        )->getFile()->getContent()),
                        'laporan-list-data-lansia.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ElderlyVisitsChart::class,
            StatsOverview::class
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
