<?php

namespace App\Filament\Resources\ToddlerGrowthResource\Pages;

use App\Filament\Resources\ToddlerGrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListToddlerGrowths extends ListRecords
{
    protected static string $resource = ToddlerGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
