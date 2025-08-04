<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        $admin = User::create([
            'family_card_number' => '3174012300012347',
            'national_id' => '3174011501950003',
            'name' => 'Rudi Hartono',
            'password' => bcrypt('password'),
            'birth_date' => '1995-01-15',
            'gender' => 'L',
            'phone_number' => '085312345678',
            'address' => 'Jl. Kenanga No.10, Surabaya',
            'hamlet' => 'Pahing',
            'rt' => 1,
            'rw' => 5,
        ]);
        $admin->syncRoles('admin');

        // CADRE
        $cadre = User::create([
            'family_card_number' => '3174012300012348',
            'national_id' => '3174011804900004',
            'name' => 'Dewi Lestari',
            'password' => bcrypt('password'),
            'birth_date' => '1990-04-18',
            'gender' => 'P',
            'phone_number' => '081311223344',
            'address' => 'Jl. Mawar No.7, Bekasi',
            'hamlet' => 'Manis',
            'rt' => 2,
            'rw' => 6,
        ]);
        $cadre->syncRoles('cadre');

        // BABY
        $baby = User::create([
            'family_card_number' => '3174012300012349',
            'national_id' => '3174011506240005',
            'name' => 'Aurelia Putri',
            'password' => bcrypt('password'),
            'birth_date' => '2025-06-15',
            'gender' => 'P',
            'phone_number' => '081222334455',
            'address' => 'Jl. Dahlia No.9, Depok',
            'hamlet' => 'Pahing',
            'rt' => 3,
            'rw' => 1,
        ]);

        // TODDLER
        $toddler = User::create([
            'family_card_number' => '3174012300012350',
            'national_id' => '3174011003220006',
            'name' => 'Tasya Kamila',
            'password' => bcrypt('password'),
            'birth_date' => '2022-03-10',
            'gender' => 'P',
            'phone_number' => '081333445566',
            'address' => 'Jl. Cempaka No.3, Bogor',
            'hamlet' => 'Manis',
            'rt' => 4,
            'rw' => 2,
        ]);

        // CHILD
        $child = User::create([
            'family_card_number' => '3174012300012351',
            'national_id' => '3174011407150007',
            'name' => 'Agung Prasetyo',
            'password' => bcrypt('password'),
            'birth_date' => '2015-07-14',
            'gender' => 'L',
            'phone_number' => '081344556677',
            'address' => 'Jl. Sawo No.10, Tangerang',
            'hamlet' => 'Kliwon',
            'rt' => 5,
            'rw' => 3,
        ]);

        // TEENAGER
        $teenager = User::create([
            'family_card_number' => '3174012300012352',
            'national_id' => '3174011603090008',
            'name' => 'Rina Marlina',
            'password' => bcrypt('password'),
            'birth_date' => '2009-03-16',
            'gender' => 'P',
            'phone_number' => '081355667788',
            'address' => 'Jl. Anggrek No.8, Jakarta',
            'hamlet' => 'Pon',
            'rt' => 6,
            'rw' => 4,
        ]);

        // ADULT
        $adult = User::create([
            'family_card_number' => '3174012300012353',
            'national_id' => '3174011901900009',
            'name' => 'Yudi Pranata',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-19',
            'gender' => 'L',
            'phone_number' => '081366778899',
            'address' => 'Jl. Flamboyan No.4, Cikarang',
            'hamlet' => 'Pon',
            'rt' => 7,
            'rw' => 5,
        ]);

        // ELDERLY
        $elderly = User::create([
            'family_card_number' => '3174012300012354',
            'national_id' => '3174010405500010',
            'name' => 'Sukirah',
            'password' => bcrypt('password'),
            'birth_date' => '1950-05-04',
            'gender' => 'P',
            'phone_number' => '081377889900',
            'address' => 'Jl. Cemara No.6, Karawang',
            'hamlet' => 'Manis',
            'rt' => 8,
            'rw' => 6,
        ]);

        // Pregnant
        $pregnant = User::create([
            'family_card_number' => '3174012300012356',
            'national_id' => '3174012109970012',
            'name' => 'Fitri Handayani',
            'password' => bcrypt('password'),
            'birth_date' => '1997-09-21',
            'gender' => 'P',
            'phone_number' => '081399001122',
            'address' => 'Jl. Teratai No.12, Bekasi',
            'hamlet' => 'Pahing',
            'rt' => 9,
            'rw' => 1,
        ]);

        // NONE
        $none = User::create([
            'family_card_number' => '3174012300012355',
            'national_id' => '3174010101010011',
            'name' => 'Anonim',
            'password' => bcrypt('password'),
            'birth_date' => '2000-01-01',
            'gender' => 'L',
            'phone_number' => '081388990011',
            'address' => 'Jl. Tidak Diketahui, Unknown',
            'hamlet' => 'Pon',
            'rt' => 0,
            'rw' => 0,
        ]);
        $none->syncRoles('none');
    }
}
