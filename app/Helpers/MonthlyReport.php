<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MonthlyReport
{
    public function countPerModelByDate(Carbon $date, $hamlet = null): array
    {
        $year = $date->year;
        $month = $date->month;

        $data = [
            'month' => $date->translatedFormat('F'),
            'year'  => $year,
        ];

        $models = [
            'Elderly' => 'elderlies',
            'Adult' => 'adults',
            // TODO: belum ada children
            'Infant' => 'infants',
            'Pregnant' => 'pregnantPostpartumBreastfeedings',
            'Teenager' => 'teenagers',
            'Toddler' => 'toddlers',
        ];

        $user = Auth::user();

        if ($user && $user->hasRole('cadre')) {
            $hamlet = $hamlet ?? $user->hamlet;
        } else if ($user && $user->hasRole(['admin', 'resident'])) {
            $hamlet = null;
        }

        foreach ($models as $label => $relation) {
            $data[$label] = User::when($hamlet, function ($query) use ($hamlet) {
                return $query->where('hamlet', $hamlet);
            })
                ->whereHas($relation, function ($query) use ($year, $month) {
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month);
                })->count();
        }

        $data['hamlet'] = $hamlet;

        return $data;
    }

    public static function getMonthlyReportByRecord(Model $record): array
    {
        $cacheKey = 'monthly-report-' . optional(Auth::user())->hamlet . Carbon::parse($record->created_at)->format('Y-m');

        return Cache::remember($cacheKey, now()->addHours(12), function () use ($record) {
            return (new MonthlyReport())->countPerModelByDate(Carbon::parse($record->created_at));
        });
    }
}
