<?php

namespace App\Filament\Resources\AdultResource\Pages;

use App\Filament\Resources\AdultResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdult extends ViewRecord
{
    protected static string $resource = AdultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn() => auth()->user()->can('dewasa:update')),
        ];
    }
}
