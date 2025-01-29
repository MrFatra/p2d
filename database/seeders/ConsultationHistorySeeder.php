<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultations = [
            [
                'patient_id' => 1,
                'doctor_id' => 3,
                'topic' => 'Sakit Dada',
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 3,
                'topic' => 'Sakit Kepala',
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 3,
                'topic' => 'Sakit Perut',
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 3,
                'topic' => 'Sakit Gigi',
            ],
            [
                'patient_id' => 1,
                'doctor_id' => 3,
                'topic' => 'Sakit Mata',
            ],
        ];

        foreach ($consultations as $consultation) {
            \App\Models\ConsultationHistory::firstOrCreate($consultation);
        }
    }
}
