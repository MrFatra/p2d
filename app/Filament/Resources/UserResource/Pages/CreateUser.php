<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // protected array $selectedRoleIds = [];

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Simpan dulu role ids ke property
    //     $this->selectedRoleIds = [$data['roles']] ?? [];

    //     // Hapus supaya tidak error saat create user (karena 'roles' bukan field di users table)
    //     unset($data['roles']);

    //     return $data;
    // }

    // protected function afterCreate(): void
    // {
    //     $user = $this->getRecord();

    //     // Ambil role ids yang sudah disimpan dari form sebelum create
    //     $selectedRoleIds = $this->selectedRoleIds;

    //     // Pastikan $selectedRoleIds selalu array
    //     if (!is_array($selectedRoleIds)) {
    //         $selectedRoleIds = [$selectedRoleIds];
    //     }

    //     if (empty($selectedRoleIds)) {
    //         // Jika tidak ada role dipilih, assign role berdasarkan tanggal lahir
    //         $roleName = User::determineTypeOfUser($user->birth_date);

    //         // syncRoles bisa menerima string atau array
    //         $user->syncRoles($roleName);
    //     } else {
    //         // Ambil nama role dari id yang dipilih
    //         $roleNames = \Spatie\Permission\Models\Role::whereIn('id', $selectedRoleIds)->pluck('name')->toArray();

    //         $user->syncRoles($roleNames);
    //     }
    // }
}
