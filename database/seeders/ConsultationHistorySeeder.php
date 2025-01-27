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
                'user_id' => 1,
                'reply_id' => 3,
                'title' => 'Sakit Dada',
                'description' => 'Tolong, dada saya sakit',
                'reply' => 'awokaowk',
            ],
            [
                'user_id' => 2,
                'reply_id' => 3,
                'title' => 'Sakit Perut',
                'description' => 'Tolong, perut saya sakit',
                'reply' => 'awokaowk',
            ],
            [
                'user_id' => 1,
                'reply_id' => 3,
                'title' => 'Sakit Kepala',
                'description' => 'Tolong, kepala saya sakit',
                'reply' => 'awokaowk',
            ],
            [
                'user_id' => 2,
                'reply_id' => 3,
                'title' => 'Sakit Gigi',
                'description' => 'Tolong, gigi saya sakit',
                'reply' => 'aowkaowk',
            ],
        ];

        foreach ($consultations as $consultation) {
            \App\Models\ConsultationHistory::firstOrCreate($consultation);
        }
    }
}
