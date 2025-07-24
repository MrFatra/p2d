<?php

namespace App\Filament\Resources\ElderlyResource\Pages;

use App\Filament\Resources\ElderlyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElderly extends EditRecord
{
    protected static string $resource = ElderlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
