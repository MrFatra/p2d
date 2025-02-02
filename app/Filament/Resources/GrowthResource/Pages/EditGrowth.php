<?php

namespace App\Filament\Resources\GrowthResource\Pages;

use App\Filament\Resources\GrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrowth extends EditRecord
{
    protected static string $resource = GrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
