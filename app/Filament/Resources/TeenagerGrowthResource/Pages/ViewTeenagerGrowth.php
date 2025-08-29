<?php

namespace App\Filament\Resources\TeenagerGrowthResource\Pages;

use App\Filament\Resources\TeenagerGrowthResource;
use App\Filament\Resources\TeenagerGrowthResource\Widgets\TeenagerGrowthChart;
use App\Filament\Resources\TeenagerGrowthResource\Widgets\TeenagerGrowthTable;
use Filament\Actions;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewTeenagerGrowth extends ViewRecord
{
    protected static string $resource = TeenagerGrowthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $user = $this->record;

        return $infolist
            ->schema([
                Section::make('Data Pribadi')
                    ->schema([
                        Group::make([
                            TextEntry::make('name')
                                ->label('Nama Lengkap')
                                ->getStateUsing(fn() => $user?->name ?? '-'),

                            TextEntry::make('birth_date')
                                ->label('Tanggal Lahir')
                                ->getStateUsing(fn() => $user?->birth_date ?? '-'),

                            TextEntry::make('gender')
                                ->label('Jenis Kelamin')
                                ->badge()
                                ->colors([
                                    'info' => 'L',
                                    'pink' => 'P',
                                ])
                                ->formatStateUsing(fn() => match ($user?->gender) {
                                    'P' => 'Perempuan',
                                    'L' => 'Laki-laki',
                                    default => '-',
                                }),
                        ])->columns(3),
                    ]),

                Section::make('Kontak & Alamat')
                    ->schema([
                        Group::make([
                            TextEntry::make('phone_number')
                                ->label('No. Telepon')
                                ->getStateUsing(fn() => $user?->phone_number ?? '-'),

                            TextEntry::make('hamlet')
                                ->label('Dusun')
                                ->getStateUsing(fn() => $user?->hamlet ?? '-'),

                            TextEntry::make('address')
                                ->label('Alamat')
                                ->getStateUsing(fn() => $user?->address ?? '-'),
                        ])->columns(2),
                    ]),

            ]);
    }

    protected function getFooterWidgets(): array
    {
        return [
            TeenagerGrowthTable::make(),
            TeenagerGrowthChart::make(),
        ];
    }
}
