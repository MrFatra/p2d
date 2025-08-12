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
        $hamlet = auth()->user()->hamlet; // ambil hamlet user login

        return [
            'Elderly'  => Elderly::whereYear('created_at', $year)
                ->whereHas('user', function ($q) use ($hamlet) {
                    $q->where('hamlet', $hamlet);
                })
                ->count(),

            'Infant'   => Infant::whereYear('created_at', $year)
                ->whereHas('user', function ($q) use ($hamlet) {
                    $q->where('hamlet', $hamlet);
                })
                ->count(),

            'Pregnant' => PregnantPostpartumBreastfeending::whereYear('created_at', $year)
                ->whereHas('user', function ($q) use ($hamlet) {
                    $q->where('hamlet', $hamlet);
                })
                ->count(),

            'Teenager' => Teenager::whereYear('created_at', $year)
                ->whereHas('user', function ($q) use ($hamlet) {
                    $q->where('hamlet', $hamlet);
                })
                ->count(),

            'Toddler'  => Toddler::whereYear('created_at', $year)
                ->whereHas('user', function ($q) use ($hamlet) {
                    $q->where('hamlet', $hamlet);
                })
                ->count(),

            'year'     => $year,
        ];
    }
}
