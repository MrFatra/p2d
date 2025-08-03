<?php

namespace App\Helpers;

use Filament\Facades\Filament;

class Auth
{
    public static function filamentUser()
    {
        return Filament::auth()->user();
    }

    public static function user()
    {
        return auth()->user();
    }

    public static function userHasRole(string $role)
    {
        return auth()->user()->hasRole($role);
    }

    public static function filamentUserHasRole(string $role)
    {
        return Filament::auth()->user()->hasRole($role);
    }
}
