<?php

namespace Database\Seeders;

use App\Models\Elderly;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElderlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $erderlies = [
            [
                'user_id' => 8,
                'blood_pressure' => 130.5,
                'blood_glucose' => 110.2,
                'cholesterol' => 190.4,
                'nutrition_status' => 'Gizi Baik',
                'functional_ability' => 'Mandiri',
                'chronic_disease_history' => 'Hipertensi',
            ],
        ];

        foreach ($erderlies as $erderly) {
            Elderly::create($erderly);
        }
    }
}
