<?php

namespace Database\Seeders;

use App\Models\Elderly;
use Illuminate\Database\Seeder;

class ElderlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elderlies = [
            [
                'user_id' => 8,
                'blood_pressure' => 130.5,
                'blood_glucose' => 110.2,
                'cholesterol' => 190.4,
                'nutrition_status' => 'Gizi Baik',
                'functional_ability' => 'Mandiri',
                'chronic_disease_history' => 'Hipertensi',
            ],
            [
                'user_id' => 8,
                'blood_pressure' => 125.0,
                'blood_glucose' => 105.0,
                'cholesterol' => 200.0,
                'nutrition_status' => 'Gizi Cukup',
                'functional_ability' => 'Mandiri',
                'chronic_disease_history' => 'Tidak Ada',
            ],
            [
                'user_id' => 8,
                'blood_pressure' => 110.0,
                'blood_glucose' => 95.0,
                'cholesterol' => 160.0,
                'nutrition_status' => 'Gizi Kurang',
                'functional_ability' => 'Tidak Mandiri',
                'chronic_disease_history' => 'Diabetes',
            ],
            [
                'user_id' => 8,
                'blood_pressure' => 100.0,
                'blood_glucose' => 85.0,
                'cholesterol' => 140.0,
                'nutrition_status' => 'Gizi Buruk',
                'functional_ability' => 'Butuh Bantuan',
                'chronic_disease_history' => 'Malnutrisi, Anemia',
            ],
            [
                'user_id' => 8,
                'blood_pressure' => 150.0,
                'blood_glucose' => 130.0,
                'cholesterol' => 250.0,
                'nutrition_status' => 'Obesitas',
                'functional_ability' => 'Mandiri',
                'chronic_disease_history' => 'Obesitas, Hipertensi',
            ],
        ];

        foreach ($elderlies as $elderly) {
            Elderly::create($elderly);
        }
    }
}
