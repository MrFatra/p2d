<?php

namespace App\Exports;

use App\Helpers\Family;
use App\Models\Adult;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AdultExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
{
    protected $adults;

    public function __construct($adults)
    {
        $this->adults = $adults;
    }

    /**
     * Export pakai view blade (opsional kalau mau ditampilkan juga di tabel)
     */
    public function view(): View
    {
        return view('exports.list-adult', [
            'adults' => $this->adults
        ]);
    }

    /**
     * Mapping tiap baris
     */
    public function map($adult): array
    {
        return [
            Family::getFatherName($adult->user?->family_card_number),
            Family::getMotherName($adult->user?->family_card_number),
            $adult->user?->name,
            $adult->bmi,
            $adult->blood_pressure,
            $adult->diabetes ? 'Ya' : 'Tidak',
            $adult->hypertension ? 'Ya' : 'Tidak',
            $adult->cholesterol ? 'Ya' : 'Tidak',
            Date::dateTimeToExcel($adult->created_at),
        ];
    }

    /**
     * Headings kolom
     */
    public function headings(): array
    {
        return [
            'Nama Ayah',
            'Nama Ibu',
            'Nama Dewasa',
            'BMI',
            'Tekanan Darah',
            'Diabetes',
            'Hipertensi',
            'Kolesterol',
            'Dibuat Pada',
        ];
    }

    /**
     * Format kolom
     */
    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
