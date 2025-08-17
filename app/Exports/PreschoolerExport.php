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

class PreschoolerExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
{
    protected $preschoolers;

    public function __construct($preschoolers)
    {
        $this->preschoolers = $preschoolers;
    }

    /**
     * Return the collection to be exported
     */
    public function view(): View
    {
        return view('exports.list-preschoolers', [
            'preschoolers' => $this->preschoolers
        ]);
    }

    /**
     * Map data for each row
     */
    public function map($preschooler): array
    {
        return [
            Family::getFatherName($preschooler->user?->family_card_number),
            Family::getMotherName($preschooler->user?->family_card_number),
            $preschooler->user->name,
            $preschooler->weight,
            $preschooler->height,
            $preschooler->head_circumference,
            $preschooler->upper_arm_circumference,
            $preschooler->nutrition_status,
            $preschooler->motor_development,
            $preschooler->language_development,
            $preschooler->social_development,
            $preschooler->vitamin_a ? 'Ya' : 'Tidak',
            $preschooler->complete_immunization ? 'Ya' : 'Tidak',
            $preschooler->exclusive_breastfeeding ? 'Ya' : 'Tidak',
            $preschooler->complementary_feeding ? 'Ya' : 'Tidak',
            $preschooler->parenting_education ? 'Ya' : 'Tidak',
            $preschooler->checkup_date ? Date::dateTimeToExcel($preschooler->checkup_date) : null,
            Date::dateTimeToExcel($preschooler->created_at)
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
            'Nama Anak',
            'Berat Badan (kg)',
            'Tinggi Badan (cm)',
            'Lingkar Kepala (cm)',
            'LILA (cm)',
            'Status Gizi',
            'Perkembangan Motorik',
            'Perkembangan Bahasa',
            'Perkembangan Sosial',
            'Vitamin A',
            'Imunisasi Lengkap',
            'ASI Eksklusif',
            'MP-ASI',
            'Edukasi Pola Asuh',
            'Tanggal Pemeriksaan',
            'Dibuat Pada',
        ];
    }

    /**
     * Column formatting
     */
    public function columnFormats(): array
    {
        return [
            'Q' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'R' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
