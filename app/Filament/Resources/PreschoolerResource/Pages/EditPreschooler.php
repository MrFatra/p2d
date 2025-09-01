<?php

namespace App\Filament\Resources\PreschoolerResource\Pages;

use App\Filament\Resources\PreschoolerResource;
use App\Helpers\Family;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreschooler extends EditRecord
{
    protected static string $resource = PreschoolerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::with(['father', 'mother'])->find($data['user_id']);

        if ($user) {
            $data['father_name'] = optional($user->father)->name;
            $data['mother_name'] = optional($user->mother)->name;
        }

        return $data;
    }
}
