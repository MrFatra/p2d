<?php

namespace App\Filament\Resources\InfantGrowthResource\Pages;

use App\Filament\Resources\InfantGrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfantGrowth extends EditRecord
{
    protected static string $resource = InfantGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
