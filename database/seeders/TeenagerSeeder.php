<?php

namespace Database\Seeders;

use App\Models\Teenagers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeenagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teenagers = [
            [
                'user_id' => 4,
                'weight' => 55.5,
                'height' => 165.0,
                'bmi' => 20.3,
                'blood_pressure' => 110.2,
                'anemia' => false,
                'iron_tablets' => 4,
                'reproductive_health' => 3,
                'mental_health' => 4,
            ],
            [
                'user_id' => 5,
                'weight' => 60.0,
                'height' => 170.0,
                'bmi' => 20.8,
                'blood_pressure' => 115.4,
                'anemia' => true,
                'iron_tablets' => 6,
                'reproductive_health' => 4,
                'mental_health' => 3,
            ],
            [
                'user_id' => 6,
                'weight' => 62.3,
                'height' => 172.0,
                'bmi' => 21.0,
                'blood_pressure' => 112.5,
                'anemia' => false,
                'iron_tablets' => 2,
                'reproductive_health' => 5,
                'mental_health' => 5,
            ],
        ];

        foreach ($teenagers as $teenager) {
            Teenagers::create($teenager);
        }
    }
}
