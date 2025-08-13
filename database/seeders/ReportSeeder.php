<?php

namespace Database\Seeders;

use App\Helpers\MonthlyReport;
use App\Models\Report;
use App\Models\User;
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
        $date = now();

        $hamlets = User::distinct()->pluck('hamlet')->filter();

        foreach ($hamlets as $hamlet) {
            $reportData = (new MonthlyReport())->countPerModelByDate($date, $hamlet);
            
            Report::create([
                'babies' => $reportData['Infant'] ?? 0,
                'toddlers' => $reportData['Toddler'] ?? 0,
                'children' => $reportData['Children'] ?? 0,
                'teenagers' => $reportData['Teenager'] ?? 0,
                'pregnants' => $reportData['Pregnant'] ?? 0,
                'elderlies' => $reportData['Elderly'] ?? 0,
                'hamlet' => $hamlet,
                'month' => $date->month,
                'year' => $date->year,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
