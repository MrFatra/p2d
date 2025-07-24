<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label('Semua')
                ->badge(User::count()),

            'petugas' => Tab::make()
                ->label('Petugas')
                ->modifyQueryUsing(function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->whereIn('name', ['admin', 'cadre']);
                    });
                })
                ->badge(User::whereHas('roles', function ($q) {
                    $q->whereIn('name', ['admin', 'cadre']);
                })->count()),

            'pengguna' => Tab::make()
                ->label('Pengguna Posyandu')
                ->modifyQueryUsing(function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->whereIn('name', [
                            'baby',
                            'toddler',
                            'child',
                            'teenager',
                            'adult',
                            'elderly',
                            'pregnant'
                        ]);
                    });
                })
                ->badge(User::whereHas('roles', function ($q) {
                    $q->whereIn('name', [
                        'baby',
                        'toddler',
                        'child',
                        'teenager',
                        'adult',
                        'elderly',
                        'pregnant'
                    ]);
                })->count()),
        ];
    }
}
