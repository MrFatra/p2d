<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use App\Helpers\Family;
use App\Models\Infant;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInfant extends ViewRecord
{
    protected static string $resource = InfantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::with(['father', 'mother'])->find($data['user_id']);
        $infant = Infant::where('user_id', $data['user_id'])->oldest()->first();

        $data['father_name'] = $user->father->name;
        $data['mother_name'] = $user->mother->name;
        $data['birth_weight'] = $infant->birth_weight;
        $data['birth_height'] = $infant->birth_height;
        $data['upper_arm_circumference'] = $infant->upper_arm_circumference;
        $data['head_circumference'] = $infant->head_circumference;

        $data['growth_upper_arm_circumference'] = $this->record->upper_arm_circumference;
        $data['growth_head_circumference'] = $this->record->head_circumference;

        return $data;
    }
}
