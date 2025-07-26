<?php

namespace App\Filament\Resources\TeenagerResource\Pages;

use App\Filament\Resources\TeenagerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeenager extends EditRecord
{
    protected static string $resource = TeenagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
