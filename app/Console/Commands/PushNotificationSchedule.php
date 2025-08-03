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
        $today = Carbon::today();

        // Tentukan range untuk H+1 dan H+2 (besok & lusa)
        $startDate = $today->copy()->addDay(1); // H+1
        $endDate = $today->copy()->addDay(2);   // H+2

        // Ambil jadwal yang buka di tanggal range tersebut
        $schedules = Schedule::whereBetween('date_open', [$startDate, $endDate])
            ->whereIn('type', [
                'Donor',
                'Infant Posyandu',
                'Toddler Posyandu',
                'Pregnant Women Posyandu',
                'Teenager Posyandu',
                'Elderly Posyandu'
            ])
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('Tidak ada jadwal Posyandu untuk H+1 dan H+2.');
            return;
        }

        foreach ($schedules as $schedule) {
            // Hitung berapa hari lagi dari hari ini
            $daysDiff = $today->diffInDays(Carbon::parse($schedule->date_open));

            $message = "Reminder Posyandu: {$schedule->type} akan dibuka pada "
                . Carbon::parse($schedule->date_open)->translatedFormat('l, d F Y')
                . " (H-" . $daysDiff . ").";

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
                    'date' => $schedule->date_open,
                    'time' => Carbon::now()->format('H:i:s'),
                    'type' => $message
                ];

                $response = $whatsapp->sendMessageToGroup($groupId, $params);

                if ($response['status'] === 'success') {
                    $this->info("Notifikasi H-{$daysDiff} berhasil dikirim ke grup: $groupId");
                } else {
                    $this->error("Gagal mengirim notifikasi ke grup $groupId: " . $response['message']);
                }
            }
        }
    }
}
