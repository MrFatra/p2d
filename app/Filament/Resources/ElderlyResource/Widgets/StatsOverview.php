<?php

namespace App\Filament\Resources\ElderlyResource\Widgets;

use App\Filament\Resources\ElderlyResource\Pages\ListElderlies;
use App\Helpers\Auth;
use App\Models\Elderly;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListElderlies::class;
    }

    protected function getStats(): array
    {
        $now = Carbon::now();

        $thisMonthVisits = Elderly::whereYear('created_at', $now->year)
            ->whereHas('user', fn($query) => $query->where('hamlet', Auth::user()->hamlet))
            ->whereMonth('created_at', $now->month)
            ->count();

        $lastMonth = $now->copy()->subMonth();

        $lastMonthVisits = Elderly::whereYear('created_at', $lastMonth->year)
            ->whereHas('user', fn($query) => $query->where('hamlet', Auth::user()->hamlet))
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $elderlyTotal = User::role('elderly')->where('hamlet', Auth::user()->hamlet)->count();

        $diff = $thisMonthVisits - $lastMonthVisits;

        $percentage = $lastMonthVisits > 0
            ? round(($diff / $lastMonthVisits) * 100, 2)
            : ($thisMonthVisits > 0 ? 100 : 0);

        if ($percentage > 0) {
            $description = 'Naik dibanding bulan lalu';
            $color = 'success';
        } elseif ($percentage < 0) {
            $description = 'Turun dibanding bulan lalu';
            $color = 'danger';
        } else {
            $description = 'Tidak ada kunjungan.';
            $color = 'gray';
        }

        return [
            Stat::make('Kunjungan Bulan Ini', $thisMonthVisits . ' Lansia')
                ->description('Data per ' . $now->translatedFormat('F Y'))
                ->color('success'),

            Stat::make('Kunjungan Bulan Lalu', $lastMonthVisits . ' Lansia')
                ->description('Data dari ' . $lastMonth->translatedFormat('F Y'))
                ->color('gray'),

            Stat::make('Perubahan Kunjungan', $percentage . '%')
                ->description($description)
                ->color($color),
            Stat::make('Total Lansia', $elderlyTotal . ' Orang')
                ->description('Terdata sebagai Lamsia saat ini')
                ->color($color),
        ];
    }
}
