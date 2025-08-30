<?php

namespace App\Filament\Resources\InfantResource\Pages;

use App\Filament\Resources\InfantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfant extends EditRecord
{
    protected static string $resource = InfantResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $infant = \App\Models\Infant::where('user_id', $data['user_id'])->oldest()->first();

        if ($infant) {
            $data['upper_arm_circumference'] = $infant->upper_arm_circumference ?? null;
            $data['head_circumference'] = $infant->head_circumference ?? null;
            $data['growth_head_circumference'] = $this->record->head_circumference ?? null;
            $data['growth_upper_arm_circumference'] = $this->record->upper_arm_circumference ?? null;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        $data['head_circumference'] = $data['growth_head_circumference'] ?? null;
        $data['upper_arm_circumference'] = $data['growth_upper_arm_circumference'] ?? null;

        unset(
            $data['growth_head_circumference'],
            $data['growth_upper_arm_circumference']
        );

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
