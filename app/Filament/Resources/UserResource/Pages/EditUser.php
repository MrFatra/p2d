<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Role;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['roles']);

        return $data;
    }

    public function afterSave(): void
    {
        $selectedRoleIds = $this->form->getState()['roles'] ?? [];

        if (!is_array($selectedRoleIds)) {
            $selectedRoleIds = [$selectedRoleIds];
        }

        // Cek apakah nilai roles berubah dari sebelumnya
        $currentRoleNames = $this->record->roles->pluck('name')->toArray();
        $newRoleNames = \Spatie\Permission\Models\Role::whereIn('id', $selectedRoleIds)->pluck('name')->toArray();

        sort($currentRoleNames);
        sort($newRoleNames);

        // Jika tidak berubah, tidak perlu sync
        if ($currentRoleNames === $newRoleNames) {
            return;
        }

        // Jika kosong atau masih punya role "none", tentukan role berdasarkan tanggal lahir
        if (empty($newRoleNames) || $this->record->hasRole('none')) {
            $newRoleNames = User::determineTypeOfUser($this->record->birth_date);
        }

        $this->record->syncRoles($newRoleNames);
    }
}
