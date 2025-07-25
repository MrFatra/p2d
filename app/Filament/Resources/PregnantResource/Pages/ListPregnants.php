<?php

namespace App\Filament\Resources\PregnantResource\Pages;

use App\Filament\Resources\PregnantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PregnantResource\Widgets\PregnantGrowthStats; // ✅ pastikan namespace benar

class ListPregnants extends ListRecords
{
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
            PregnantGrowthStats::class,
        ];
    }
}
