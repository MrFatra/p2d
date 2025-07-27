<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfant extends EditRecord
{
    protected static string $resource = InfantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
