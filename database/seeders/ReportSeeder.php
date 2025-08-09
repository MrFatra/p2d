<?php

namespace Database\Seeders;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
                'user_id' => 2,
                'file_name' => 'laporan_posyandu_januari_2025.pdf',
                'file_type' => 'PDF',
                'description' => 'Laporan kegiatan Posyandu bulan Agustus 2025',
                'uploaded_at' => Carbon::now(),
                'file_path' => 'uploads/laporan_posyandu/2025/januari/laporan_posyandu_januari_2025.pdf',
                'created_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'file_name' => 'laporan_posyandu_februari_2025.pdf',
                'file_type' => 'PDF',
                'description' => 'Laporan kegiatan Posyandu bulan September 2025',
                'uploaded_at' => Carbon::now()->addMonth(),
                'file_path' => 'uploads/laporan_posyandu/2025/februari/laporan_posyandu_februari_2025.pdf',
                'created_at' => Carbon::now()->addMonth()
            ],
            [
                'user_id' => 2,
                'file_name' => 'laporan_posyandu_maret_2025.pdf',
                'file_type' => 'PDF',
                'description' => 'Laporan kegiatan Posyandu bulan Maret 2025',
                'uploaded_at' => Carbon::now()->addMonths(2),
                'file_path' => 'uploads/laporan_posyandu/2025/maret/laporan_posyandu_maret_2025.pdf',
                'created_at' => Carbon::now()->addMonths(2)
            ],
        ];

        foreach ($reports as $report) {
            Report::create($report);
        }
    }
}
