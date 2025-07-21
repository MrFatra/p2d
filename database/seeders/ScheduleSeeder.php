<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'type' => 'Infant Posyandu',
                'date_open' => '2025-08-01',
                'date_closed' => '2025-08-01',
                'time_opened' => '08:00:00',
                'time_closed' => '11:00:00',
                'notes' => 'Bawa KMS dan buku imunisasi.'
            ],
            [
                'type' => 'Pregnant Women Posyandu',
                'date_open' => '2025-08-03',
                'date_closed' => '2025-08-03',
                'time_opened' => '09:00:00',
                'time_closed' => '12:00:00',
                'notes' => 'Pemeriksaan kehamilan rutin.'
            ],
            [
                'type' => 'Elderly Posyandu',
                'date_open' => '2025-08-05',
                'date_closed' => '2025-08-05',
                'time_opened' => '07:30:00',
                'time_closed' => '10:00:00',
                'notes' => 'Cek tekanan darah dan konsultasi gizi.'
            ],
        ];

        foreach ($schedules as $schedule) {
            \App\Models\Schedule::create($schedule);
        }
    }
}
