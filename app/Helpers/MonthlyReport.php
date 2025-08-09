<?php

namespace App\Helpers;

use App\Models\Adult;
use App\Models\Elderly;
use App\Models\Infant;
use App\Models\PregnantPostpartumBreastfeending;
use App\Models\Teenager;
use App\Models\Toddler;
use Carbon\Carbon;

class MonthlyReport
{
    public function countPerModelByMonth(?int $month = null, ?int $year = null): array
    {
        $month = $month ?? Carbon::now()->month;
        $year = $year ?? Carbon::now()->year;

        $data = [
            'month' => Carbon::createFromDate($year, $month)->translatedFormat('F'), // Nama bulan sesuai lokal
            'year'  => $year,
        ];

        $models = [
            'Adult' => Adult::class,
            'Elderly' => Elderly::class,
            'Infant' => Infant::class,
            'Pregnant' => PregnantPostpartumBreastfeending::class,
            'Teenager' => Teenager::class,
            'Toddler' => Toddler::class,
        ];

        foreach ($models as $label => $model) {
            $data[$label] = $model::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
        }

        return $data;
    }
}
