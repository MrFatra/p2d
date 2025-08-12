<?php

namespace App\Filament\Resources\InfantGrowthResource\Pages;

use App\Filament\Resources\InfantGrowthResource;
use App\Filament\Resources\InfantGrowthResource\Widgets\InfantGrowthChart;
use App\Filament\Resources\InfantGrowthResource\Widgets\InfantGrowthTable;
use App\Models\Infant;
use Filament\Actions;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class ViewInfantGrowth extends ViewRecord
// implements HasTable
{
    // use InteractsWithTable;

    protected static string $resource = InfantGrowthResource::class;

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
            InfantGrowthTable::make(),
            InfantGrowthChart::make(),
        ];
    }
}
