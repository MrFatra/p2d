<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ElderlyExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
{

    protected $elderlies;

    public function __construct($elderlies)
    {
        $this->elderlies = $elderlies;
    }

    public function view(): View
    {
        return view('exports.list-elderlies', [
            'elderlies' => $this->elderlies,
        ]);
    }

    function boolToText($val)
    {
        return $val ? 'Ya' : 'Tidak';
    }

    public function map($elderly): array
    {
        return [
            $elderly->blood_pressure,
            $elderly->blood_glucose,
            $elderly->cholesterol,
            $elderly->nutrition_status,
            $elderly->functional_ability,
            $elderly->chronic_disease_history,
            Date::dateTimeToExcel($elderly->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Tekanan Darah',
            'Tingkat Gula Darah',
            'Jumlah Kolesterol',
            'Status Gizi',
            'Kemampuan Fungsional',
            'Riwayat Penyakit Kronis',
            'Dibuat Pada',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
