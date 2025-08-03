<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $infants = [
            [
                'user_id' => 3,
                'weight' => 9.5,
                'height' => 75.0,
                'birth_weight' => 3.0,
                'birth_height' => 30,
                'head_circumference' => 25,
                'nutrition_status' => 'Gizi Baik',
                'complete_immunization' => true,
                'vitamin_a' => true,
                'exclusive_breastfeeding' => true,
                'complementary_feeding' => true,
                'motor_development' => 'Sesuai Usia',
                'checkup_date' => now()
            ],
        ];

        foreach ($infants as $infant) {
            \App\Models\Infant::create($infant);
        }
    }
}
