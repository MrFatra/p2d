<?php

namespace App\Console\Commands;

use App\Helpers\MonthlyReport;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateMonthlyReport extends Command
{
    protected $signature = 'report:generate-monthly';
    protected $description = 'Generate laporan bulanan secara otomatis setiap awal bulan';

    public function handle()
    {
        $now = Carbon::now()->startOfMonth();

        // Cek apakah laporan bulan ini sudah ada
        $existing = Report::whereYear('uploaded_at', $now->year)
            ->whereMonth('uploaded_at', $now->month)
            ->first();

        if ($existing) {
            $this->info('Laporan bulan ini sudah ada.');
            return;
        }

        // Ambil data laporan bulanan
        $reportData = (new MonthlyReport())->countPerModelByDate($now);

        // Simulasi simpan sebagai file (jika perlu PDF/CSV bisa dikembangkan)
        $fileName = 'laporan-' . $reportData['year'] . '-' . strtolower($reportData['month']) . '.json';
        $filePath = 'reports/' . $fileName;
        Storage::put($filePath, json_encode($reportData, JSON_PRETTY_PRINT));

        // Simpan record ke DB
        Report::create([
            'user_id'     => null, // Jika perlu isi user tertentu
            'file_name'   => $fileName,
            'file_type'   => 'json',
            'description' => 'Laporan bulanan Posyandu bulan ' . $reportData['month'] . ' ' . $reportData['year'],
            'uploaded_at' => $now,
            'file_path'   => $filePath,
        ]);

        $this->info('Laporan berhasil dibuat untuk bulan ' . $reportData['month'] . ' ' . $reportData['year']);
    }
}
