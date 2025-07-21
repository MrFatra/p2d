<?php

namespace Database\Seeders;

use App\Models\Adult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $adults = [
            [
                'user_id' => 1, 
                'blood_pressure' => 120.5,
                'blood_glucose' => 95.2,
                'cholesterol' => 180.7,
                'bmi' => 23.5,
            ],
            [
                'user_id' => 2,
                'blood_pressure' => 130.2,
                'blood_glucose' => 105.8,
                'cholesterol' => 200.1,
                'bmi' => 26.3,
            ],
            [
                'user_id' => 3,
                'blood_pressure' => 125.0,
                'blood_glucose' => 98.4,
                'cholesterol' => 190.0,
                'bmi' => 24.7,
            ],
        ];

        foreach ($adults as $adult) {
            Adult::create($adult);
        }
    }
}
