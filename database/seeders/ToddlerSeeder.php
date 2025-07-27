<?php

namespace Database\Seeders;

use App\Models\Toddler;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ToddlerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toddlers = [
            [
                'user_id' => 4,
                'weight' => 13.5, 
                'height' => 90.2,
                'upper_arm_circumference' => 15.0,
                'nutrition_status' => 'Gizi Baik',
                'vitamin_a' => true,
                'immunization_followup' => true,
                'food_supplement' => true,
                'parenting_education' => true,
                'motor_development' => 'Normal',
                'checkup_date' => Carbon::now(),
            ],
            [
                'user_id' => 4,
                'weight' => 13.0,
                'height' => 89.5,
                'upper_arm_circumference' => 14.8,
                'nutrition_status' => 'Gizi Cukup',
                'vitamin_a' => false,
                'immunization_followup' => false,
                'food_supplement' => true,
                'parenting_education' => true,
                'motor_development' => 'Normal',
                'checkup_date' => Carbon::now()->subMonth(),
            ],
            [
                'user_id' => 4,
                'weight' => 11.2,
                'height' => 88.0,
                'upper_arm_circumference' => 13.2,
                'nutrition_status' => 'Gizi Kurang',
                'vitamin_a' => false,
                'immunization_followup' => false,
                'food_supplement' => false,
                'parenting_education' => false,
                'motor_development' => 'Perlu Pemantauan',
                'checkup_date' => Carbon::now()->subMonths(2),
            ],
        ];

        foreach ($toddlers as $toddler) {
            Toddler::create($toddler);
        }
    }
}
