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
                'user_id' => 1,
                'weight' => 9.5,
                'height' => 75.0,
                'nutrition_status' => 'Baik',
                'complete_immunization' => true,
                'vitamin_a' => true,
                'exclusive_breastfeeding' => true,
                'complementary_feeding' => true,
                'motor_development' => 'Sesuai Usia',
            ],
            [
                'user_id' => 2,
                'weight' => 8.0,
                'height' => 70.5,
                'nutrition_status' => 'Kurang',
                'complete_immunization' => false,
                'vitamin_a' => true,
                'exclusive_breastfeeding' => false,
                'complementary_feeding' => true,
                'motor_development' => 'Sedikit Terlambat',
            ],
            [
                'user_id' => 3,
                'weight' => 10.2,
                'height' => 78.3,
                'nutrition_status' => 'Baik',
                'complete_immunization' => true,
                'vitamin_a' => false,
                'exclusive_breastfeeding' => true,
                'complementary_feeding' => false,
                'motor_development' => 'Normal',
            ],
        ];

        foreach ($infants as $infant) {
            \App\Models\Infant::create($infant);
        }
    }
}
