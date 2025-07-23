<?php

namespace Database\Seeders;

use App\Models\Erderly;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ErderlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $erderlies = [
            [
                'user_id' => 1,
                'blood_pressure' => 130.5,
                'blood_glucose' => 110.2,
                'cholesterol' => 190.4,
                'nutrition_status' => 'Cukup',
                'functional_ability' => 'Mandiri',
                'chronic_disease_history' => 'Hipertensi',
            ],
            [
                'user_id' => 2,
                'blood_pressure' => 145.3,
                'blood_glucose' => 130.8,
                'cholesterol' => 210.0,
                'nutrition_status' => 'Kurang',
                'functional_ability' => 'Sebagian Bantuan',
                'chronic_disease_history' => 'Diabetes',
            ],
        ];

        foreach ($erderlies as $erderly) {
            Erderly::create($erderly);
        }
    }
}
