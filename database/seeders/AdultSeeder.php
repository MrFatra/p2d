<?php

namespace Database\Seeders;

use App\Models\Adult;
use Carbon\Carbon;
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
                'user_id' => 7,
                'weight' => 65.0,
                'height' => 168.0,
                'bmi' => 23.0,
                'smoking_status' => false,
                'blood_pressure' => '120/80',
                'blood_glucose' => 95.2,
                'cholesterol' => 180.7,
                'notes' => 'Kondisi normal',
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => 7,
                'weight' => 72.5,
                'height' => 170.0,
                'bmi' => 25.1,
                'smoking_status' => true,
                'blood_pressure' => '130/85',
                'blood_glucose' => 110.0,
                'cholesterol' => 220.0,
                'notes' => 'Perlu pemantauan kolesterol',
                'created_at' => Carbon::now()->subMonth(),
            ],
            [
                'user_id' => 7,
                'weight' => 58.0,
                'height' => 160.0,
                'bmi' => 22.7,
                'smoking_status' => false,
                'blood_pressure' => '110/75',
                'blood_glucose' => 90.0,
                'cholesterol' => 170.0,
                'notes' => 'Sehat',
                'created_at' => Carbon::now()->subMonths(2),
            ],
            [
                'user_id' => 7,
                'weight' => 80.0,
                'height' => 165.0,
                'bmi' => 29.4,
                'smoking_status' => true,
                'blood_pressure' => '140/90',
                'blood_glucose' => 125.0,
                'cholesterol' => 250.0,
                'notes' => 'Resiko tinggi, perlu intervensi',
                'created_at' => Carbon::now()->subMonths(3),
            ],
        ];

        foreach ($adults as $adult) {
            Adult::create($adult);
        }
    }
}
