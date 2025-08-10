<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    public static function getMonthlyReportByRecord(Model $record): array
    {
        $cacheKey = 'monthly-report-' . Carbon::parse($record->uploaded_at)->format('Y-m');

        return Cache::remember($cacheKey, now()->addHours(12), function () use ($record) {
            return (new MonthlyReport())->countPerModelByDate(Carbon::parse($record->uploaded_at));
        });
    }
}
