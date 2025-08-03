<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Whatsapp;
use Carbon\Carbon;
use App\Models\Schedule;

class PushNotificationSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:posyandu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp notifications for Posyandu schedule from the schedules table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');

        $schedules = Schedule::whereDate('date_open', '<=', $today)
                    ->whereDate('date_closed', '>=', $today)
                    ->whereIn('type', [
                      'Donor', 'Infant Posyandu', 'Toddler Posyandu', 'Pregnant Women Posyandu', 'Teenager Posyandu', 'Elderly Posyandu'
                    ])
                    ->get();

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada jadwal Posyandu untuk hari ini.');
            return;
        }

        $message = "";
        foreach ($schedules as $schedule) {
            $message .= $schedule->type;
        }

        // dd($message);

        $whatsapp = new Whatsapp();

        $groupIds = [
            '120363372345829352', // Wage
            '120363394356203007', // Puhun
            '120363394771742909', // Pahing
            '120363375603128688', // Kliwon
            '120363393343781293'
        ];


        foreach ($groupIds as $groupId) {
            $params = [
                'date' => $today,
                'time' => Carbon::now()->format('H:i:s'),
                'type' => $message
            ];

            $response = $whatsapp->sendMessageToGroup($groupId, $params);


            if ($response['status'] === 'success') {
                $this->info("Notifikasi Posyandu berhasil dikirim ke grup: $groupId");
            } else {
                $this->error("Gagal mengirim notifikasi ke grup $groupId: " . $response['message']);
            }
        }
    }
}

