<?php

namespace App\Helpers;

class Health
{
    public static function calculateBMI($weight, $height)
    {
        if (!is_numeric($weight) || !is_numeric($height) || $weight <= 0 || $height <= 0) {
            return null;
        }

        $heightInMeters = $height / 100;

        $bmi = $weight / ($heightInMeters * $heightInMeters);

        return round($bmi, 2);
    }

    public static function getBMICategory($bmi)
    {
        if (!is_numeric($bmi)) {
            return null;
        }

        if ($bmi < 18.5) {
            return 'Kurus';
        } elseif ($bmi < 25) {
            return 'Normal';
        } elseif ($bmi < 30) {
            return 'Gemuk';
        } else {
            return 'Obesitas';
        }
    }
}
