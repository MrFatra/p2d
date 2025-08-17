<?php

namespace Database\Seeders;

use App\Models\Preschooler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreschoolerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'user_id' => 5,
                'weight' => 8.5,
                'height' => 70.0,
                'head_circumference' => 42.0,
                'upper_arm_circumference' => 13.5,
                'nutrition_status' => 'Gizi Baik',
                'motor_development' => 'Normal',
                'language_development' => 'Normal',
                'social_development' => 'Normal',
                'vitamin_a' => true,
                'complete_immunization' => true,
                'exclusive_breastfeeding' => true,
                'complementary_feeding' => false,
                'parenting_education' => true,
                'checkup_date' => \Carbon\Carbon::parse('2025-01-10'),
                'created_at' => \Carbon\Carbon::parse('2025-01-10'),
            ],
            [
                'user_id' => 5,
                'weight' => 7.8,
                'height' => 68.0,
                'head_circumference' => 41.0,
                'upper_arm_circumference' => 12.5,
                'nutrition_status' => 'Gizi Cukup',
                'motor_development' => 'Perlu Pemantauan',
                'language_development' => 'Perlu Pemantauan',
                'social_development' => 'Normal',
                'vitamin_a' => false,
                'complete_immunization' => false,
                'exclusive_breastfeeding' => false,
                'complementary_feeding' => true,
                'parenting_education' => false,
                'checkup_date' => \Carbon\Carbon::parse('2025-03-15'),
                'created_at' => \Carbon\Carbon::parse('2025-03-15'),
            ],
            [
                'user_id' => 5,
                'weight' => 6.9,
                'height' => 65.0,
                'head_circumference' => 40.0,
                'upper_arm_circumference' => 11.5,
                'nutrition_status' => 'Gizi Kurang',
                'motor_development' => 'Terlambat',
                'language_development' => 'Terlambat',
                'social_development' => 'Terlambat',
                'vitamin_a' => true,
                'complete_immunization' => true,
                'exclusive_breastfeeding' => false,
                'complementary_feeding' => true,
                'parenting_education' => true,
                'checkup_date' => \Carbon\Carbon::parse('2025-06-20'),
                'created_at' => \Carbon\Carbon::parse('2025-06-20'),
            ],
            [
                'user_id' => 5,
                'weight' => 10.2,
                'height' => 75.0,
                'head_circumference' => 43.5,
                'upper_arm_circumference' => 14.5,
                'nutrition_status' => 'Obesitas',
                'motor_development' => 'Normal',
                'language_development' => 'Normal',
                'social_development' => 'Perlu Pemantauan',
                'vitamin_a' => true,
                'complete_immunization' => false,
                'exclusive_breastfeeding' => true,
                'complementary_feeding' => true,
                'parenting_education' => false,
                'checkup_date' => \Carbon\Carbon::parse('2025-08-01'),
                'created_at' => \Carbon\Carbon::parse('2025-08-01'),
            ],
            [
                'user_id' => 5,
                'weight' => 5.4,
                'height' => 60.0,
                'head_circumference' => 39.0,
                'upper_arm_circumference' => 10.5,
                'nutrition_status' => 'Gizi Buruk',
                'motor_development' => 'Terlambat',
                'language_development' => 'Perlu Pemantauan',
                'social_development' => 'Normal',
                'vitamin_a' => false,
                'complete_immunization' => false,
                'exclusive_breastfeeding' => false,
                'complementary_feeding' => false,
                'parenting_education' => false,
                'checkup_date' => \Carbon\Carbon::parse('2025-02-01'),
                'created_at' => \Carbon\Carbon::parse('2025-02-01'),
            ],
        ];

        foreach ($records as $data) {
            Preschooler::create($data);
        }
    }
}
