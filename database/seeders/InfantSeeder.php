<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Infant;

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
                'birth_height' => 50.0,
                'head_circumference' => 45.0,
                'upper_arm_circumference' => 14.0,
                'nutrition_status' => 'Gizi Baik',
                'complete_immunization' => true,
                'vitamin_a' => true,
                'exclusive_breastfeeding' => true,
                'complementary_feeding' => true,
                'motor_development' => 'Normal',
                'checkup_date' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'weight' => 8.8,
                'height' => 73.0,
                'birth_weight' => 2.9,
                'birth_height' => 48.0,
                'head_circumference' => 43.5,
                'upper_arm_circumference' => 13.5,
                'nutrition_status' => 'Gizi Cukup',
                'complete_immunization' => true,
                'vitamin_a' => false,
                'exclusive_breastfeeding' => true,
                'complementary_feeding' => true,
                'motor_development' => 'Normal',
                'checkup_date' => Carbon::now()->subMonth(),
                'created_at' => Carbon::now()->subMonth(),
            ],
            [
                'user_id' => 3,
                'weight' => 7.5,
                'height' => 71.0,
                'birth_weight' => 2.7,
                'birth_height' => 47.0,
                'head_circumference' => 41.0,
                'upper_arm_circumference' => 12.0,
                'nutrition_status' => 'Gizi Kurang',
                'complete_immunization' => false,
                'vitamin_a' => false,
                'exclusive_breastfeeding' => false,
                'complementary_feeding' => true,
                'motor_development' => 'Perlu Pemantauan',
                'checkup_date' => Carbon::now()->subMonths(2),
                'created_at' => Carbon::now()->subMonths(2),
            ],
            [
                'user_id' => 3,
                'weight' => 6.2,
                'height' => 68.0,
                'birth_weight' => 2.5,
                'birth_height' => 45.0,
                'head_circumference' => 39.0,
                'upper_arm_circumference' => 11.0,
                'nutrition_status' => 'Gizi Buruk',
                'complete_immunization' => false,
                'vitamin_a' => false,
                'exclusive_breastfeeding' => false,
                'complementary_feeding' => false,
                'motor_development' => 'Terlambat',
                'checkup_date' => Carbon::now()->subMonths(3),
                'created_at' => Carbon::now()->subMonths(3),
            ],
            [
                'user_id' => 3,
                'weight' => 11.5,
                'height' => 73.0,
                'birth_weight' => 3.8,
                'birth_height' => 51.0,
                'head_circumference' => 47.0,
                'upper_arm_circumference' => 15.5,
                'nutrition_status' => 'Obesitas',
                'complete_immunization' => true,
                'vitamin_a' => true,
                'exclusive_breastfeeding' => false,
                'complementary_feeding' => true,
                'motor_development' => 'Normal',
                'checkup_date' => Carbon::now()->subMonths(4),
                'created_at' => Carbon::now()->subMonths(4),
            ],
        ];

        foreach ($infants as $infant) {
            Infant::create($infant);
        }
    }
}
