<?php

namespace App\Filament\Resources\InfantGrowthResource\Pages;

use App\Filament\Resources\InfantGrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfantGrowths extends ListRecords
{
    protected static string $resource = InfantGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
