<?php

namespace App\Filament\Resources\TeenagerGrowthResource\Pages;

use App\Filament\Resources\TeenagerGrowthResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeenagerGrowth extends EditRecord
{
    protected static string $resource = TeenagerGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
