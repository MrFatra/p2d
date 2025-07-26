<?php

namespace App\Helpers;

class Health
{
    public static function calculateBMI($weight, $height)
    {
        if (!$weight || !$height) {
            return null;
        }

        $heightInMeters = $height / 100;

        if ($heightInMeters <= 0) {
            return null;
        }

        $bmi = $weight / ($heightInMeters * $heightInMeters);

        return number_format($bmi, 2);
    }

    public static function getBMICategory($bmi)
    {
        if ($bmi < 18.5) {
            return 'Kurus';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'Normal';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'Gemuk';
        } else {
            return 'Obesitas';
        }
    }
}
