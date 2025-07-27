<?php

namespace App\Filament\Resources\ToddlerResource\Pages;

use App\Filament\Resources\ToddlerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditToddler extends EditRecord
{
    protected static string $resource = ToddlerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
