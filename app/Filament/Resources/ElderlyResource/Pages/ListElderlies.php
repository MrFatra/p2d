<?php

namespace App\Filament\Resources\ElderlyResource\Pages;

use App\Filament\Resources\ElderlyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElderlies extends ListRecords
{
    protected static string $resource = ElderlyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
