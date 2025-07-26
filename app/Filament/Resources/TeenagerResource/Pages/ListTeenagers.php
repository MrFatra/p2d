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
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VisitorOverview::class
        ];
    }
}
