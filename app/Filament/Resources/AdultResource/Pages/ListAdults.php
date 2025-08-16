<?php

namespace App\Filament\Resources\AdultResource\Pages;

use App\Filament\Resources\AdultResource;
use App\Filament\Resources\AdultResource\Widgets\AdultOverview;
use App\Filament\Resources\AdultResource\Widgets\AdultVisitor;
use App\Helpers\Auth;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAdults extends ListRecords
{
    protected static string $resource = AdultResource::class;

    protected function getHeaderActions(): array
    {
        return [
             Actions\CreateAction::make()
                ->visible(fn() => auth()->user()->can('dewasa:create')),
            Actions\Action::make('export-excel')
                ->visible(fn() => auth()->user()->can('dewasa:export'))
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalSubmitActionLabel('Export')
                ->form([
                    TextInput::make('month')
                        ->type('month') // HTML5 input type
                        ->label('Pilih Bulan')
                        ->default(now()->format('Y-m')) // Default format yang valid: '2025-08'
                        ->required(),
                ])
                ->action(function (array $data) {
                    $query = $this->getFilteredTableQuery();

                    // dd($data, $query);

                    if (!empty($data['month'])) {
                        $month = \Carbon\Carbon::parse($data['month']);
                        $query->whereMonth('created_at', $month->month)
                            ->whereYear('created_at', $month->year);
                    }

                    $filteredData = $query->get();

                    return response()->streamDownload(
                        fn() => print(\Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\AdultExport($filteredData),
                            'dewasa.xlsx'
                        )->getFile()->getContent()),
                        'laporan-list-data-dewasa.xlsx'
                    );
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AdultOverview::class,
            AdultVisitor::class
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
