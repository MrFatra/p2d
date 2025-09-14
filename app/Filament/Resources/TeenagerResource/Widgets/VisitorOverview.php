<?php

namespace App\Filament\Resources\TeenagerResource\Widgets;

use App\Filament\Resources\TeenagerResource\Pages\ListTeenagers;
use App\Helpers\Auth;
use App\Models\Teenager;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListTeenagers::class;
    }

    protected function getStats(): array
    {
        $now = Carbon::now();
        $user = Auth::user();
        $isCadre = $user->hasRole('cadre');

        // --- Kunjungan Bulan Ini ---
        $thisMonthQuery = User::whereHas('teenagers', function ($query) use ($now) {
            return $query->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year);
        });
        
        if ($isCadre) {
            $thisMonthQuery->where('hamlet', $user->hamlet);
        }
        
        $thisMonthVisits = $thisMonthQuery->count();
        
        // --- Kunjungan Bulan Lalu ---
        $lastMonth = $now->copy()->subMonth();

        $lastMonthQuery = User::whereHas('teenagers', function ($query) use ($lastMonth) {
            return $query->whereMonth('created_at', $lastMonth->month)
                ->whereYear('created_at', $lastMonth->year);
        });

        if ($isCadre) {
            $lastMonthQuery->where('hamlet', $user->hamlet);
        }

        $lastMonthVisits = $lastMonthQuery->count();

        // --- Total Remaja ---
        $teenagerCount = User::where('is_death', false)->role('teenager');

        if ($isCadre) {
            $teenagerCount->where('hamlet', $user->hamlet);
        }

        $teenagerTotal = $teenagerCount->count();

        // --- Hitung Perubahan ---
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
            $description = 'Tidak ada perubahan kunjungan.';
            $color = 'gray';
        }

        return [
            Stat::make('Kunjungan Bulan Ini', $thisMonthVisits . ' Remaja')
                ->description('Data per ' . $now->translatedFormat('F Y'))
                ->color('success'),

            Stat::make('Kunjungan Bulan Lalu', $lastMonthVisits . ' Remaja')
                ->description('Data dari ' . $lastMonth->translatedFormat('F Y'))
                ->color('gray'),

            Stat::make('Perubahan Kunjungan', $percentage . '%')
                ->description($description)
                ->color($color),
            Stat::make('Total Remaja', $teenagerTotal . ' Orang')
                ->description('Terdata sebagai Remaja saat ini'),
        ];
    }
}
