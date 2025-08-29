<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Query
{
    public static function takeInfants(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query->whereDate('birth_date', '>', $now->copy()->subMonths(12)); // 0–11 bulan
    }

    public static function takeToddlers(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query
            ->whereDate('birth_date', '<=', $now->copy()->subMonths(12))   // ≥12 bulan
            ->whereDate('birth_date', '>', $now->copy()->subMonths(60));   // ≤59 bulan
    }

    public static function takeTeenagers(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query
            ->whereDate('birth_date', '<=', $now->copy()->subYears(10))    // ≥10 tahun
            ->whereDate('birth_date', '>', $now->copy()->subYears(18));    // ≤17 tahun
    }
}
