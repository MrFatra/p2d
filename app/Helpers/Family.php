<?php

namespace App\Helpers;

use App\Models\User;

class Family
{
    public static function getFatherName(string $familyCardNumber): ?string
    {
        if (!$familyCardNumber) {
            return null;
        }

        return User::query()
            ->where('family_card_number', $familyCardNumber)
            ->where('gender', 'L')
            ->orderBy('birth_date', 'asc') // tertua lebih dulu
            ->value('name');
    }

    public static function getMotherName(string $familyCardNumber): ?string
    {
        if (!$familyCardNumber) {
            return null;
        }

        return User::query()
            ->where('family_card_number', $familyCardNumber)
            ->where('gender', 'P')
            ->orderBy('birth_date', 'asc') // tertua lebih dulu
            ->value('name');
    }
}
