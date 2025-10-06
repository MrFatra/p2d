<?php

namespace App\Exports;

use App\Helpers\Family;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ToddlerExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
{
    protected $toddlers;

    public function __construct($toddlers)
    {
        $this->toddlers = $toddlers;
    }

    /**
     * Return the collection to be exported
     */
    public function view(): View
    {
        return view('exports.list-toddlers', [
            'toddlers' => $this->toddlers
        ]);
    }

    /**
     * Map data for each row
     */
    public function map($toddler): array
    {
        return [
            $toddler->user?->father?->name,
            $toddler->user?->mother?->name,
            $toddler->user->name,
            $toddler->weight,
            $toddler->height,
            $toddler->upper_arm_circumference,
            $toddler->nutrition_status,
            $toddler->vitamin_a,
            $toddler->imunization_followup,
            $toddler->food_supplement,
            $toddler->parenting_education,
            $toddler->motor_development,
            Date::dateTimeToExcel($toddler->created_at),
        ];
    }

    /**
     * Column headings
     */
    public function headings(): array
    {
        return [
            'Nama Ayah',
            'Nama Ibu',
            'Nama Balita',
            'Berat Badan',
            'Tinggi Badan',
            'Lingkar Lengan Atas',
            'Status Gizi',
            'Vitamin A',
            'Tablet Tambah Darah',
            'Pemeriksaan Lanjutan Imunisasi',
            'Suplemen Makanan',
            'Edukasi Orang Tua',
            'Perkembangan Motorik',
            'Dibuat Pada',
        ];
    }

    /**
     * Column formatting
     */
    public function columnFormats(): array
    {
        return [
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
