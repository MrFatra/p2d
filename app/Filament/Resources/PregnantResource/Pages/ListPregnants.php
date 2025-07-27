<?php

namespace App\Filament\Resources\PregnantResource\Pages;

use App\Filament\Resources\PregnantResource;
use App\Filament\Resources\PregnantResource\Widgets\VisitorOverview;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListPregnants extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = PregnantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // ✅ Tambahkan method ini
    protected function getHeaderWidgets(): array
    {
        return [
            VisitorOverview::class,
        ];
    }
}
