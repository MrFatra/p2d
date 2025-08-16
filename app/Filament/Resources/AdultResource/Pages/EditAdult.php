<?php

namespace App\Filament\Resources\AdultResource\Pages;

use App\Filament\Resources\AdultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdult extends EditRecord
{
    protected static string $resource = AdultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
