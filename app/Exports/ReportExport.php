<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
{
    protected $reports;
    protected $mode; // 'monthly' atau 'yearly'

    public function __construct($reports, string $mode = 'monthly')
    {
        $this->reports = $reports;
        $this->mode = $mode;
    }

    public function view(): View
    {
        if ($this->mode === 'yearly') {
            return view('exports.list-reports-yearly', [
                'reports' => $this->reports,
            ]);
        }

        return view('exports.list-reports-monthly', [
            'reports' => $this->reports,
        ]);
    }

    public function map($record): array
    {
        if ($this->mode === 'yearly') {
            return [
                $record->elderlies,
                $record->babies,
                $record->pregnants,
                $record->teenagers,
                $record->toddlers,
                $record->hamlet,
                $record->year,
            ];
        }

        return [
            $record->elderlies,
            $record->babies,
            $record->pregnants,
            $record->teenagers,
            $record->toddlers,
            $record->hamlet,
            \Carbon\Carbon::create()->month($record->month)->translatedFormat('F'),
            $record->year,
        ];
    }


    public function headings(): array
    {
        if ($this->mode === 'yearly') {
            return [
                'Lansia (60 Tahun ke Atas)',
                'Bayi (0-12 Bulan)',
                'Ibu Hamil',
                'Remaja (13-17 Tahun)',
                'Balita (1-5 Tahun)',
                'Tahun',
            ];
        }

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
        if ($this->mode === 'yearly') {
            return [
                'F' => NumberFormat::FORMAT_TEXT, // Tahun
            ];
        }

        return [
            'F' => NumberFormat::FORMAT_TEXT, // Bulan
            'G' => NumberFormat::FORMAT_TEXT, // Tahun
        ];
    }
}
