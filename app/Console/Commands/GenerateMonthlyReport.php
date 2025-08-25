<?php

namespace App\Console\Commands;

use App\Helpers\MonthlyReport;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMonthlyReport extends Command
{
    protected $signature = 'report:generate-monthly';
    protected $description = 'Generate laporan bulanan secara otomatis untuk setiap dusun (hamlet)';

    public function handle()
    {
        $now = Carbon::now()->endOfMonth();
        $month = $now->month;
        $year = $now->year;

        $hamlets = User::distinct()->pluck('hamlet')->filter();

        foreach ($hamlets as $hamlet) {
            $exists = Report::where('hamlet', $hamlet)
                ->where('month', $month)
                ->where('year', $year)
                ->exists();

            if ($exists) {
                $this->info("Laporan untuk dusun '{$hamlet}' bulan {$month}/{$year} sudah ada.");
                continue;
            }

            $reportData = (new MonthlyReport())->countPerModelByDate($now, $hamlet);

            Report::create([
                'babies'     => $reportData['Infant'] ?? 0,
                'toddlers'   => $reportData['Toddler'] ?? 0,
                'children'   => $reportData['Children'] ?? 0,
                'teenagers'  => $reportData['Teenager'] ?? 0,
                'pregnants'  => $reportData['Pregnant'] ?? 0,
                'elderlies'  => $reportData['Elderly'] ?? 0,
                'hamlet'     => $hamlet,
                'month'      => $month,
                'year'       => $year,
            ]);

            $this->info("Laporan berhasil dibuat untuk dusun '{$hamlet}' bulan {$month}/{$year}.");
        }
    }
}
