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
                'type' => 'Donor',
                'date_open' => '2025-01-24',
                'date_closed' => '2025-01-25',
                'opened_time' => '08:00:00',
                'closed_time' => '12:00:00',
                'notes' => 'Gelar Donor Darah',
            ],
            [
                'type' => 'Posyandu',
                'date_open' => now(),
                'date_closed' => now()->addDay(),
                'opened_time' => '08:00:00',
                'closed_time' => '12:00:00',
                'notes' => 'Gelar Posyandu Balita',
            ],
        ];

        foreach ($schedules as $schedule) {
            \App\Models\Schedule::create($schedule);
        }
    }
}
