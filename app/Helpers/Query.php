<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class Query
{
    public static function takeTeenagers(Builder $query): Builder
    {
        $now = \Carbon\Carbon::now();

        $query->whereDate('birth_date', '>', $now->copy()->subYears(17));
        $query->whereDate('birth_date', '<=', $now->copy()->subYears(10));

        return $query;
    }

    public static function takeInfants(Builder $query): Builder
    {
        $now = \Carbon\Carbon::now();

        $query->whereDate('birth_date', '>', $now->copy()->subYears(1));

        return $query;
    }

    public static function takeToddlers(Builder $query): Builder
    {
        $now = \Carbon\Carbon::now();

        $query->whereDate('birth_date', '>', $now->copy()->subYears(5));
        $query->whereDate('birth_date', '<=', $now->copy()->subYears(1));

        return $query;
    }
}
