<?php

namespace App\Exports;

use App\Models\Elderly;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ElderlyExport implements WithMapping, FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Elderly::exclude(['user_id', 'id', 'updated_at'])->get();
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
