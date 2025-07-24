<?php

namespace App\Filament\Resources\ElderlyResource\Pages;

use App\Filament\Resources\ElderlyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewElderly extends ViewRecord
{
    protected static string $resource = ElderlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
