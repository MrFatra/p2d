<?php

namespace App\Filament\Resources\InfantGrowthResource\Pages;

use App\Filament\Resources\InfantGrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInfantGrowth extends ViewRecord
{
    protected static string $resource = InfantGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
