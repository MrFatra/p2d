<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalStat extends BaseWidget
{
    public function getStats(): array
    {
        $totalUsers = User::count();

        return [
            Stat::make('Total Penduduk', number_format($totalUsers) . ' Orang')
                ->icon('heroicon-o-user-group')
                ->description('Berdasarkan data terakhir diinput'),

            Stat::make('Dusun Pahing', User::where('hamlet', 'Pahing')->count() . ' Orang')
                ->icon('heroicon-o-user-group')
                ->description('Berdasarkan data terakhir diinput'),

            Stat::make('Dusun Wage', User::where('hamlet', 'Wage')->count() . ' Orang')
                ->icon('heroicon-o-user-group')
                ->description('Berdasarkan data terakhir diinput'),

            Stat::make('Dusun Manis', User::where('hamlet', 'Manis')->count() . ' Orang')
                ->icon('heroicon-o-user-group')
                ->description('Berdasarkan data terakhir diinput'),

            Stat::make('Dusun Puhun', User::where('hamlet', 'Puhun')->count() . ' Orang')
                ->icon('heroicon-o-user-group')
                ->description('Berdasarkan data terakhir diinput'),

            Stat::make('Dusun Kliwon', User::where('hamlet', 'Kliwon')->count() . ' Orang')
                ->icon('heroicon-o-user-group')
                ->description('Berdasarkan data terakhir diinput'),
        ];
    }
}
