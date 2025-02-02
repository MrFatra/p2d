<?php

namespace App\Filament\Resources\GrowthResource\Pages;

use App\Filament\Resources\GrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrowths extends ListRecords
{
    protected static string $resource = GrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
