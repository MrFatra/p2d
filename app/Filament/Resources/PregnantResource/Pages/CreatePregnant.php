<?php

namespace App\Filament\Resources\PregnantResource\Pages;

use App\Filament\Resources\PregnantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePregnant extends CreateRecord
{
    protected static string $resource = PregnantResource::class;

    protected static ?string $breadcrumb = 'Tambah';

    protected static ?string $title = 'Tambah Data';
}
