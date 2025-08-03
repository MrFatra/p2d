<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PregnantExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
{
    protected $pregnants;

    public function __construct($pregnants)
    {
        $this->pregnants = $pregnants;
    }

    /**
     * Return the collection to be exported
     */
    public function view(): View
    {
        return view('exports.list-pregnants', [
            'pregnants' => $this->pregnants
        ]);
    }

    /**
     * Map data for each row
     */
    public function map($pregnant): array
    {
        return [
            $pregnant->user->name,
            $pregnant->pregnancy_status,
            $pregnant->muac,
            $pregnant->blood_pressure,
            $pregnant->tetanus_immunization,
            $pregnant->iron_tablets,
            Date::dateTimeToExcel($pregnant->anc_schedule),
            Date::dateTimeToExcel($pregnant->created_at),
        ];
    }

    /**
     * Column headings
     */
    public function headings(): array
    {
        return [
            'Nama',
            'Status Kehamilan',
            'Lingkar Lengan Atas Tengah',
            'Tekanan Darah',
            'Imunisasi Tetanus',
            'Tablet Tambah Darah',
            'Jadwal Pemeriksaan ANC',
            'Dibuat Pada',
        ];
    }

    /**
     * Column formatting
     */
    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
