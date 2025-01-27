<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrowthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $growths = [
            [
                'user_id' => 1,
                'height' => 160.5,
                'weight' => 60.2,
                'smoking' => false,
                'abdominal_circumference' => 85.0,
                'blood_sugar_levels' => 95.5,
                'taking_blood_supplement' => true,
                'blood_pressure' => 120.8,
                'gestational_age' => 20,
                'gestational_category' => 'Hamil',
                'head_circumference' => 35.0,
                'arm_circumference' => 25.0,
                'exclusive_breastfeeding' => false,
                'imt' => 23.5,
                'stunting_status' => 'Normal',
                'imt_status' => 'Normal',
            ],
            [
                'user_id' => 2,
                'height' => 170.5,
                'weight' => 70.2,
                'smoking' => true,
                'abdominal_circumference' => 95.0,
                'blood_sugar_levels' => 105.5,
                'taking_blood_supplement' => false,
                'blood_pressure' => 130.8,
                'gestational_age' => 30,
                'gestational_category' => 'Lahir',
                'head_circumference' => 45.0,
                'arm_circumference' => 35.0,
                'exclusive_breastfeeding' => true,
                'imt' => 25.5,
                'stunting_status' => 'Stunting',
                'imt_status' => 'Obesitas Kelas 1',
            ],
        ];

        foreach ($growths as $growth) {
            \App\Models\Growth::firstOrCreate($growth);
        }
        
    }
}
