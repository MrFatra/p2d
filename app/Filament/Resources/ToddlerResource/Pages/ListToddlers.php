<?php

namespace App\Filament\Resources\ToddlerResource\Pages;

use App\Filament\Resources\ToddlerResource;
use App\Filament\Resources\ToddlerResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListToddlers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ToddlerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VisitorOverview::class
        ];
    }
}
