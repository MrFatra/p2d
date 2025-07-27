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
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class
        ];
    }
}
