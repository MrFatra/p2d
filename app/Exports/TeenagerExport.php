<?php

namespace App\Exports;

use App\Models\Teenager;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TeenagerExport implements WithMapping, FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Teenager::exclude(['user_id', 'id', 'updated_at'])->get();
    }

    public function map($teenager): array
    {
        return [
            $teenager->weight,
            $teenager->height,
            $teenager->bmi,
            $teenager->blood_pressure,
            $teenager->anemia,
            $teenager->iron_tablets,
            $teenager->reproductive_health,
            $teenager->mental_health,
            Date::dateTimeToExcel($teenager->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'Berat Badan',
            'Tinggi Badan',
            'BMI',
            'Tekanan Darah',
            'Anemia',
            'Tablet Tambah Darah',
            'Kesehatan Reproduksi',
            'Kesehatan Mental',
            'Dibuat Pada',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
