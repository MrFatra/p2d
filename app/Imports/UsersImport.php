<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $data = $this->sanitizeRow($row);

        return new User([
            'family_card_number' => $data['no_kk'],
            'national_id' => $data['nik'],
            'name' => $data['nama'],
            'password' => Hash::make($data['kata_sandi']),
            'email' => $data['email'],
            'birth_date' => $data['tanggal_lahir'],
            'gender' => $data['jenis_kelamin'],
            'phone_number' => $data['no_hp'],
            'rt' => $data['rt'],
            'rw' => $data['rw'],
            'address' => $data['alamat'],
            'hamlet' => $data['dusun'],
        ]);
    }

    public function rules(): array
    {
        return [
            'no_kk' => ['required', 'string'],
            'nik' => ['required', 'string', 'unique:users,national_id'],
            'nama' => ['required', 'string'],
            'kata_sandi' => ['required', 'string', 'min:6'],
            'email' => ['email', 'unique:users,email'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'no_hp' => ['nullable', 'string'],
            'rt' => ['nullable', 'integer'],
            'rw' => ['nullable', 'integer'],
            'alamat' => ['nullable', 'string'],
            'dusun' => ['nullable', 'string'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'kata_sandi.min' => 'Kata sandi minimal harus 6 karakter.',
        ];
    }

    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika Excel dalam format tanggal Excel (angka), convert ke format tanggal
        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Jika string valid
        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function sanitizeRow(array $row): array
    {
        return [
            'no_kk' => $row['no_kk'] ?: null,
            'nik' => $row['nik'] ?: null,
            'nama' => $row['nama'] ?: null,
            'kata_sandi' => $row['kata_sandi'] ?: null,
            'email' => $row['email'] ?: null,
            'tanggal_lahir' => $this->parseDate($row['tanggal_lahir']),
            'jenis_kelamin' => in_array($row['jenis_kelamin'], ['L', 'P']) ? $row['jenis_kelamin'] : null,
            'no_hp' => $row['no_hp'] ?: null,
            'rt' => is_numeric($row['rt']) ? (int) $row['rt'] : null,
            'rw' => is_numeric($row['rw']) ? (int) $row['rw'] : null,
            'alamat' => $row['alamat'] ?: null,
            'dusun' => $row['dusun'] ?: null,
        ];
    }
}
