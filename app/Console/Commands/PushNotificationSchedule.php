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
        // Ambil tanggal hari ini
        $today = Carbon::now()->format('Y-m-d');

        // Ambil data jadwal Posyandu yang aktif hari ini.
        // Asumsikan bahwa jadwal aktif adalah yang memiliki date_open <= hari ini dan date_closed >= hari ini.
        $schedules = Schedule::whereDate('date_open', '<=', $today)
                    ->whereDate('date_closed', '>=', $today)
                    ->whereIn('type', [
                        'Posyandu Bayi',
                        'Posyandu Balita',
                        'Posyandu Ibu Hamil',
                        'Posyandu Remaja',
                        'Posyandu Lansia'
                    ])
                    ->get();

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada jadwal Posyandu untuk hari ini.');
            return;
        }

        // Susun pesan notifikasi dengan detail dari tiap jadwal yang aktif
        $message = "Reminder Posyandu untuk hari ini ({$today}):\n";
        foreach ($schedules as $schedule) {
            $message .= "- {$schedule->type} dari {$schedule->opened_time} sampai {$schedule->closed_time}. Catatan: {$schedule->notes}\n";
        }

        // Inisialisasi helper WhatsApp
        $whatsapp = new Whatsapp();

        // Daftar ID grup yang akan dikirimi pesan

        $groupIds = [
            '120363372345829352', // Wage
            '120363394356203007', // Puhun
            '120363394771742909', // Pahing
            '120363375603128688', // Kliwon
            '120363393343781293'
        ];


        // Kirim notifikasi ke tiap grup
        foreach ($groupIds as $groupId) {
            // Parameter yang dikirimkan ke API WhatsApp
            // Sesuaikan parameter jika diperlukan, misalnya dengan mengirimkan pesan lengkap di key 'type'
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

