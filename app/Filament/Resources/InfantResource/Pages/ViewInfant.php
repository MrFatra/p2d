<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInfant extends ViewRecord
{
    protected static string $resource = InfantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
