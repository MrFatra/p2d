<?php

namespace App\Helpers;

use Carbon\Carbon;

class MyClass
{
    /**
     * Menghitung status stunting berdasarkan tanggal lahir dan tinggi badan.
     *
     * @param string|null $birthDate Tanggal lahir dalam format yang dapat diparse oleh Carbon (misal: 'YYYY-MM-DD').
     * @param float|null $height Tinggi badan dalam satuan cm.
     * @return string 'Stunted' jika memenuhi kriteria stunting, atau 'Normal' jika tidak.
     */
    public static function calculateStuntingStatus($birthDate, $height)
    {
        // Hitung usia dalam bulan menggunakan Carbon
        $birth = Carbon::parse($birthDate);
        $now   = Carbon::now();
        $ageInMonths = $birth->diffInMonths($now);

        // Validasi: hanya berlaku untuk balita (0-60 bulan)
        if ($ageInMonths < 0 || $ageInMonths > 60) {
            return 'Hanya untul bayi dan balita';
        }

        // Tentukan data referensi berdasarkan kelompok usia
        if ($ageInMonths < 24) {
            // Kelompok bayi (0-24 bulan): Pengukuran panjang badan (telentang)
            // Data contoh: median dan standar deviasi (nilai ini hanya contoh, sesuaikan dengan data referensi WHO)
            $median = 74.0;
            $sd     = 2.5;
        } else {
            // Kelompok anak (24-60 bulan): Pengukuran tinggi badan (berdiri)
            $median = 90.0;
            $sd     = 3.0;
        }

        // Menghitung Z-score
        $zScore = ($height - $median) / $sd;

        // Klasifikasi status gizi berdasarkan Z-score
        if ($zScore < -3) {
            return "Stunting";
        } elseif ($zScore < -2) {
            return "Kemungkinan Stunting";
        } else {
            return "Normal";
        }
    }

    public static function calculateImtStatus($height, $weight, $birthDate){

    }
}
