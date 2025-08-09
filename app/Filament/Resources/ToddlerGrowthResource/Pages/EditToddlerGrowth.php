<?php

namespace App\Filament\Resources\ToddlerGrowthResource\Pages;

use App\Filament\Resources\ToddlerGrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditToddlerGrowth extends EditRecord
{
    protected static string $resource = ToddlerGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
