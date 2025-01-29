<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $replies = [
            [
                'consultation_history_id' => 1,
                'sender_id' => 1,
                'receiver_id' => 2,
                'message' => 'awokaowk',
            ],
            [
                'consultation_history_id' => 2,
                'sender_id' => 2,
                'receiver_id' => 1,
                'message' => 'awokaowk',
            ],
            [
                'consultation_history_id' => 3,
                'sender_id' => 1,
                'receiver_id' => 2,
                'message' => 'awokaowk',
            ],
            [
                'consultation_history_id' => 4,
                'sender_id' => 2,
                'receiver_id' => 1,
                'message' => 'aowkaowk',
            ],
        ];

        foreach ($replies as $reply) {
            \App\Models\Reply::create($reply);
        }
    }
}
