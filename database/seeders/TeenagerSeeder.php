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
        ];

        foreach ($teenagers as $teenager) {
            Teenagers::create($teenager);
        }
    }
}
