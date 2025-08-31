<?php

namespace App\Filament\Resources\PreschoolerResource\Pages;

use App\Filament\Resources\PreschoolerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPreschooler extends ViewRecord
{
    protected static string $resource = PreschoolerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn() => auth()->user()->can('anak_prasekolah:update')),
        ];
    }
}
