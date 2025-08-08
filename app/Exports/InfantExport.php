<?php

namespace App\Exports;

use App\Helpers\Family;
use App\Models\Infant;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class InfantExport implements WithMapping, FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Infant::exclude(['id', 'updated_at'])->get();
    }

    function boolToText($val)
    {
        return $val ? 'Ya' : 'Tidak';
    }

    public function map($infant): array
    {
        return [
            Family::getFatherName($infant->user?->family_card_number),
            Family::getMotherName($infant->user?->family_card_number),
            $infant->user->name,
            $infant->weight,
            $infant->height,
            $infant->head_circumference,
            $infant->birth_weight,
            $infant->birth_length,
            $infant->checkup_date,
            $infant->nutrition_status,
            $infant->complete_immunization ? 'Ya' : 'Tidak',
            $infant->vitamin_a ? 'Ya' : 'Tidak',
            $infant->exclusive_breastfeeding ? 'Ya' : 'Tidak',
            $infant->complementary_feeding ? 'Ya' : 'Tidak',
            $infant->motor_development,
            Date::dateTimeToExcel($infant->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Ayah',
            'Nama Ibu',
            'Nama Bayi',
            'Berat Badan',
            'Tinggi Badan',
            'Lingkar Kepala',
            'Berat Lahir',
            'Panjang Lahir',
            'Tanggal Pemeriksaan',
            'Status Gizi',
            'Imunisasi Lengkap',
            'Vitamin A',
            'ASI Eksklusif',
            'MPASI',
            'Perkembangan Motorik',
            'Dibuat Pada',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
