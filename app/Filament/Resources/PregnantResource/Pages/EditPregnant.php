<?php

namespace App\Filament\Resources\PregnantResource\Pages;

use App\Filament\Resources\PregnantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPregnant extends EditRecord
{
    protected static string $resource = PregnantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
