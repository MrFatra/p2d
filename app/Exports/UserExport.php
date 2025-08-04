<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserExport implements
    FromView,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting,
    WithCustomValueBinder
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Return the collection to be exported
     */
    public function view(): View
    {
        return view('exports.list-users', [
            'users' => $this->users
        ]);
    }

    /**
     * Map data for each row
     */
    public function map($user): array
    {
        return [
            $user->family_card_number,
            $user->national_id,
            $user->name,
            $user->birth_date,
            $user->gender,
            $user->phone_number,
            $user->rt,
            $user->rw,
            $user->address,
            $user->hamlet,
            Date::dateTimeToExcel($user->created_at),
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return self::bindValue($cell, $value);
    }

    /**
     * Column headings
     */
    public function headings(): array
    {
        return [
            'Nomor KK',
            'NIK',
            'Nama',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Nomor Telepon',
            'RT',
            'RW',
            'Alamat Lengkap',
            'Dusun',
            'Dibuat Pada',
        ];
    }

    /**
     * Column formatting
     */
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
