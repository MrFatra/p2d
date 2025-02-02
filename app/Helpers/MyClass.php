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
        // Pastikan $birthDate tidak null dan $height merupakan nilai numerik
        if (!$birthDate || !$height) {
            return 'Normal';
        }
        
        // Hitung usia dalam tahun berdasarkan birth_date menggunakan Carbon
        $age = Carbon::parse($birthDate)->age;
    
        // Contoh logika perhitungan (silakan sesuaikan threshold-nya dengan standar yang berlaku):
        if ($age < 2) {
            // Misalnya, untuk usia di bawah 2 tahun, jika tinggi < 75 cm dianggap stunting
            return $height < 75 ? 'Stunted' : 'Normal';
        } elseif ($age < 5) {
            // Untuk anak usia 2 - 5 tahun, jika tinggi < 85 cm dianggap stunting
            return $height < 85 ? 'Stunted' : 'Normal';
        } else {
            // Untuk usia di atas 5 tahun, logika perhitungan bisa berbeda atau dianggap normal
            return 'Normal';
        }
    }
}
