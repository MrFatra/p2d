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

        $roleNames = Role::whereIn('id', $selectedRoleIds)->pluck('name')->toArray();

        if (empty($roleNames)) {
            $roleNames = 'none';
        }

        if ($this->record->hasRole('none')) {
            $roleNames = User::determineTypeOfUser($this->record->birth_date);
        }

        $this->record->syncRoles($roleNames);
    }
}
