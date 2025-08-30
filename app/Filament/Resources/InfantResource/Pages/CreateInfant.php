<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInfant extends CreateRecord
{
    protected static string $resource = InfantResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika data lahir sudah pernah diisi (readonly), maka pakai nilai growth
        $infant = \App\Models\Infant::where('user_id', $data['user_id'])->oldest()->first();

        if ($infant) {
            // Pindahkan nilai growth_* ke field utama
            $data['birth_weight'] = $infant->birth_weight;
            $data['birth_height'] = $infant->birth_height;
            $data['head_circumference'] = $data['growth_head_circumference'] ?? null;
            $data['upper_arm_circumference'] = $data['growth_upper_arm_circumference'] ?? null;
        }

        // Hapus field growth_* dari data agar tidak error karena tidak ada di DB
        unset(
            $data['growth_head_circumference'],
            $data['growth_upper_arm_circumference']
        );

        return $data;
    }
}
