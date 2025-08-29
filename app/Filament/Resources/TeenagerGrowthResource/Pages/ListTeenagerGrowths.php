<?php

namespace App\Filament\Resources\TeenagerGrowthResource\Pages;

use App\Filament\Resources\TeenagerGrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeenagerGrowths extends ListRecords
{
    protected static string $resource = TeenagerGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
