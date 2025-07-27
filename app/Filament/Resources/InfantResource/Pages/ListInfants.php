<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use App\Filament\Resources\InfantResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfants extends ListRecords
{
    protected static string $resource = InfantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            VisitorOverview::class,
        ];
    }
}
