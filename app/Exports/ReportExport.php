<?php

namespace App\Exports;

use App\Helpers\MonthlyReport;
use App\Models\Report;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
{
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    /**
     * Return the collection to be exported
     */
    public function view(): View
    {
        return view('exports.list-reports', [
            'reports' => $this->reports
        ]);
    }
    public function map($record): array
    {
        // Ambil data dari helper sama seperti di Filament table
        $data = MonthlyReport::getMonthlyReportByRecord($record);

        return [
            $data['Elderly'],
            $data['Infant'],
            $data['Pregnant'],
            $data['Teenager'],
            $data['Toddler'],
            $data['month'],
            $data['year'],
        ];
    }

    public function headings(): array
    {
        return [
            'Lansia (60 Tahun ke Atas)',
            'Bayi (0-12 Bulan)',
            'Ibu Hamil',
            'Remaja (13-17 Tahun)',
            'Balita (1-5 Tahun)',
            'Bulan',
            'Tahun',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT, // Kolom Bulan
            'G' => NumberFormat::FORMAT_TEXT, // Kolom Tahun
        ];
    }
}
