<?php

namespace App\Helpers;

use App\Models\Elderly;
use App\Models\Infant;
use App\Models\PregnantPostpartumBreastfeending;
use App\Models\Teenager;
use App\Models\Toddler;

class YearlyReport
{
    public static function countPerModelByYear(int $year): array
    {
        return [
            'Elderly'  => Elderly::whereYear('created_at', $year)->count(),
            'Infant'   => Infant::whereYear('created_at', $year)->count(),
            'Pregnant' => PregnantPostpartumBreastfeending::whereYear('created_at', $year)->count(),
            'Teenager' => Teenager::whereYear('created_at', $year)->count(),
            'Toddler'  => Toddler::whereYear('created_at', $year)->count(),
            'year'     => $year,
        ];
    }
}
