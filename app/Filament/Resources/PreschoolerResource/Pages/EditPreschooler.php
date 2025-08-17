<?php

namespace App\Filament\Resources\PreschoolerResource\Pages;

use App\Filament\Resources\PreschoolerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreschooler extends EditRecord
{
    protected static string $resource = PreschoolerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
