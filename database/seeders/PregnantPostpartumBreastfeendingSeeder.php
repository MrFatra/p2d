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
                'user_id' => 1,
                'pregnancy_status' => 'Trimester 1',
                'muac' => 24.5,
                'blood_pressure' => 110.75,
                'tetanus_immunization' => 'TT1',
                'iron_tablets' => 30,
                'anc_schedule' => '2025-08-01',
            ],
            [
                'user_id' => 2,
                'pregnancy_status' => 'Trimester 2',
                'muac' => 23.0,
                'blood_pressure' => 115.50,
                'tetanus_immunization' => 'TT2',
                'iron_tablets' => 20,
                'anc_schedule' => '2025-08-15',
            ],
        ];

        foreach ($pregnants as $pregnant) {
            \App\Models\PregnantPostpartumBreastfeending::create($pregnant);
        }
    }
}
