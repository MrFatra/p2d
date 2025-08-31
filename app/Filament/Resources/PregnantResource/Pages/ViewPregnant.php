<?php

namespace App\Filament\Resources\PregnantResource\Pages;

use App\Filament\Resources\PregnantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPregnant extends ViewRecord
{
    protected static string $resource = PregnantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn() => auth()->user()->can('ibu-hamil:update')),
        ];
    }
}
