<?php

namespace App\Filament\Resources\PreschoolerResource\Pages;

use App\Filament\Resources\PreschoolerResource;
use App\Helpers\Family;
use App\Models\User;
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::with(['father', 'mother'])->find($data['user_id']);

        $data['father_name'] = optional($user->father)->name;
        $data['mother_name'] = optional($user->mother)->name;

        return $data;
    }
}
