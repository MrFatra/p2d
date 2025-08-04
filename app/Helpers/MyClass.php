<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;

class MyClass
{
    /**
     * Menghitung status stunting berdasarkan tanggal lahir dan tinggi badan.
     *
     * @param string|null $birthDate Tanggal lahir dalam format yang dapat diparse oleh Carbon (misal: 'YYYY-MM-DD').
     * @param float|null $height Tinggi badan dalam satuan cm.
     * @return string 'Stunted' jika memenuhi kriteria stunting, atau 'Normal' jika tidak.
     */
    public static function calculateStuntingStatus(
        $birthDate,
        $height,
        $weight,
        $headCircumference,
        $gender = 'male'
    ) {
        $birth = Carbon::parse($birthDate);
        $now   = Carbon::now();
        $ageInMonths = $birth->diffInMonths($now);

        // Validasi usia
        if ($ageInMonths < 0 || $ageInMonths > 60) {
            return [
                'status' => 'Hanya untuk bayi dan balita (0-60 bulan)',
                'ageInMonths' => $ageInMonths
            ];
        }

        // Konversi gender P/L ke male/female
        $genderKey = in_array(strtolower($gender), ['p', 'female']) ? 'female' : 'male';

        // Tabel referensi sederhana (median & SD)
        $lengthForAge = [
            'male' => [
                0 => [49.9, 1.9],
                1 => [54.7, 1.8],
                2 => [58.4, 1.8],
                12 => [75.7, 2.3],
                24 => [87.8, 2.9],
                36 => [96.1, 3.2],
                48 => [103.3, 3.5],
                60 => [110.0, 3.8],
            ],
            'female' => [
                0 => [49.1, 1.8],
                1 => [53.7, 1.7],
                2 => [57.1, 1.7],
                12 => [74.0, 2.2],
                24 => [86.4, 2.7],
                36 => [95.1, 3.1],
                48 => [102.7, 3.4],
                60 => [109.4, 3.7],
            ]
        ];

        $weightForAge = [
            'male' => [
                0 => [3.3, 0.5],
                12 => [9.6, 0.9],
                24 => [12.2, 1.1],
                36 => [14.3, 1.3],
                48 => [16.3, 1.5],
                60 => [18.3, 1.7],
            ],
            'female' => [
                0 => [3.2, 0.5],
                12 => [8.9, 0.8],
                24 => [11.5, 1.0],
                36 => [13.9, 1.2],
                48 => [16.0, 1.4],
                60 => [18.0, 1.6],
            ]
        ];

        $headCircForAge = [
            'male' => [
                0 => [34.5, 1.2],
                12 => [46.0, 1.5],
                24 => [48.5, 1.7],
                60 => [51.5, 2.0],
            ],
            'female' => [
                0 => [33.9, 1.1],
                12 => [45.0, 1.4],
                24 => [47.5, 1.6],
                60 => [50.5, 1.9],
            ]
        ];

        // Fungsi untuk mencari key terdekat yang <= usia
        $findNearestKey = function ($array, $age) {
            return array_key_last(
                array_filter($array, fn($v, $k) => $k <= $age, ARRAY_FILTER_USE_BOTH)
            ) ?? 0;
        };

        $nearestLengthMonth = $findNearestKey($lengthForAge[$genderKey], $ageInMonths);
        $nearestWeightMonth = $findNearestKey($weightForAge[$genderKey], $ageInMonths);
        $nearestHeadMonth   = $findNearestKey($headCircForAge[$genderKey], $ageInMonths);

        // Hitung Z-Score
        $medianHeight = $lengthForAge[$genderKey][$nearestLengthMonth][0];
        $sdHeight     = $lengthForAge[$genderKey][$nearestLengthMonth][1];
        $zHeight      = ($height - $medianHeight) / $sdHeight;

        $medianWeight = $weightForAge[$genderKey][$nearestWeightMonth][0];
        $sdWeight     = $weightForAge[$genderKey][$nearestWeightMonth][1];
        $zWeight      = ($weight - $medianWeight) / $sdWeight;

        $medianHead   = $headCircForAge[$genderKey][$nearestHeadMonth][0];
        $sdHead       = $headCircForAge[$genderKey][$nearestHeadMonth][1];
        $zHead        = ($headCircumference - $medianHead) / $sdHead;

        // Klasifikasi stunting berdasarkan tinggi badan (TB/U)
        if ($zHeight < -3) {
            $status = 'Severe Stunting';
        } elseif ($zHeight < -2) {
            $status = 'Stunting';
        } else {
            $status = 'Normal';
        }

        return [
            'status' => $status,
            'ageInMonths' => $ageInMonths,
            'zHeight' => round($zHeight, 2),
            'zWeight' => round($zWeight, 2),
            'zHeadCirc' => round($zHead, 2),
        ];
    }



    public static function calculateImtStatus($height, $weight, $birthDate)
    {
        if ($height <= 0 || $weight <= 0 || empty($birthDate)) {
            return [
                'imt' => null,
                'status' => 'Invalid input'
            ];
        }

        // Hitung umur
        $birthDateObj = new DateTime($birthDate);
        $today = new DateTime();
        $age = $today->diff($birthDateObj)->y;

        // Hitung IMT
        $heightMeter = $height / 100;
        $imt = $weight / pow($heightMeter, 2);
        $imtRounded = round($imt, 1);

        // Tentukan kategori berdasarkan umur
        $status = '';
        if ($age < 5) {
            // Kategori bayi & balita sederhana
            if ($imt < 14) {
                $status = 'Sangat Kurus';
            } elseif ($imt < 15) {
                $status = 'Kurus';
            } elseif ($imt < 17) {
                $status = 'Normal';
            } elseif ($imt < 18) {
                $status = 'Gemuk';
            } else {
                $status = 'Obesitas';
            }
        } elseif ($age < 18) {
            // Kategori anak & remaja bisa ditandai, tapi tanpa z-score detail
            if ($imt < 18.5) {
                $status = 'Kurus (Remaja)';
            } elseif ($imt < 25) {
                $status = 'Normal (Remaja)';
            } elseif ($imt < 30) {
                $status = 'Gemuk (Remaja)';
            } else {
                $status = 'Obesitas (Remaja)';
            }
        } else {
            // Kategori dewasa
            if ($imt < 18.5) {
                $status = 'Kurus';
            } elseif ($imt < 25) {
                $status = 'Normal';
            } elseif ($imt < 30) {
                $status = 'Gemuk';
            } else {
                $status = 'Obesitas';
            }
        }

        return [
            'imt' => $imtRounded,
            'status' => $status,
            'age' => $age
        ];
    }
}
