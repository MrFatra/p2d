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
                'user_id' => 7, 
                'blood_pressure' => 120.5,
                'blood_glucose' => 95.2,
                'cholesterol' => 180.7,
                'bmi' => 23.5,
            ],
        ];

        foreach ($adults as $adult) {
            Adult::create($adult);
        }
    }
}
