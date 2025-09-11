<?php

namespace App\Exports;

use App\Helpers\Family;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TeenagerExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting
    // WithStyles
{
    protected $teenagers;

    public function __construct($teenagers)
    {
        $this->teenagers = $teenagers;
    }

    /**
     * Return the collection to be exported
     */
    public function view(): View
    {
        return view('exports.list-teenagers', [
            'teenagers' => $this->teenagers
        ]);
    }
    
    /**
     * Map data for each row
     */
    public function map($teenager): array
    {
        return [
            $teenager->user?->father->name,
            $teenager->user?->mother->name,
            $teenager->user->name,
            $teenager->weight,
            $teenager->height,
            $teenager->bmi,
            $teenager->blood_pressure,
            $teenager->anemia ? 'Ya' : 'Tidak',
            $teenager->iron_tablets,
            $teenager->reproductive_health,
            $teenager->mental_health,
            Date::dateTimeToExcel($teenager->created_at),
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
            'Nama Remaja',
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

    /**
     * Column formatting
     */
    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    /**
     * Apply custom styles
     */
    // public function styles(Worksheet $sheet): array
    // {
    //     $sheet->getRowDimension(1)->setRowHeight(25);

    //     foreach (range('A', 'J') as $col) {
    //         $sheet->getStyle("{$col}")->getAlignment()->setWrapText(true);

    //         if (in_array($col, ['D', 'J'])) {
    //             $sheet->getStyle("{$col}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    //         } else {
    //             $sheet->getStyle("{$col}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    //         }
    //     }


    //     $rowCount = $this->teenagers->count() + 1;

    //     $cellRangeAnemia = "F2:F{$rowCount}";

    //     $conditionYa = new Conditional();
    //     $conditionYa->setConditionType(Conditional::CONDITION_CONTAINSTEXT)
    //         ->setOperatorType(Conditional::OPERATOR_CONTAINSTEXT)
    //         ->setText('Ya');

    //     $styleYa = $conditionYa->getStyle();
    //     $styleYa->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EF4444');
    //     $styleYa->getFont()->getColor()->setRGB('FFFFFF');

    //     $conditionTidak = new Conditional();
    //     $conditionTidak->setConditionType(Conditional::CONDITION_CONTAINSTEXT)
    //         ->setOperatorType(Conditional::OPERATOR_CONTAINSTEXT)
    //         ->setText('Tidak');

    //     $styleTidak = $conditionTidak->getStyle();
    //     $styleTidak->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('22C55E');
    //     $styleTidak->getFont()->getColor()->setRGB('FFFFFF');

    //     $conditionalStyles = $sheet->getStyle($cellRangeAnemia)->getConditionalStyles();
    //     $conditionalStyles[] = $conditionYa;
    //     $conditionalStyles[] = $conditionTidak;
    //     $sheet->getStyle($cellRangeAnemia)->setConditionalStyles($conditionalStyles);

    //     return [
    //         1 => [
    //             'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    //             'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    //             'fill' => [
    //                 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //                 'startColor' => ['rgb' => '008970'],
    //             ],
    //         ],
    //     ];
    // }
}
