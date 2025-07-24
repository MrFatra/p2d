<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PregnantPostpartumBreastfeendingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pregnants = [
            [
                'user_id' => 9,
                // 'pregnancy_status' => 'Trimester 1',
                'pregnancy_status' => 'pregnant',
                'muac' => 24.5,
                'blood_pressure' => 110.75,
                'tetanus_immunization' => 'TT1',
                'iron_tablets' => 30,
                'anc_schedule' => '2025-08-01',
            ],
        ];

        foreach ($pregnants as $pregnant) {
            \App\Models\PregnantPostpartumBreastfeending::create($pregnant);
        }
    }
}
