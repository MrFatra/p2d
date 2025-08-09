<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;

class MonthlyReport
{
    public function countPerModelByDate(Carbon $date): array
    {
        $year = $date->year;
        $month = $date->month;

        $data = [
            'month' => $date->translatedFormat('F'),
            'year'  => $year,
        ];

        $models = [
            'Elderly' => 'elderlies',
            'Infant' => 'infants',
            'Pregnant' => 'pregnantPostpartumBreastfeedings',
            'Teenager' => 'teenagers',
            'Toddler' => 'toddlers',
        ];

        foreach ($models as $label => $relation) {
            $data[$label] = User::whereHas($relation, function ($query) use ($year, $month) {
                $query->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);
            })->count();
        }

        return $data;
    }
}
