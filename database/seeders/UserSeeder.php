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
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1995-01-15',
            'place_of_birth' => 'Jakarta',
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
            'email' => 'cadre@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-04-18',
            'place_of_birth' => 'Bandung',
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
            'family_card_number' => '3174012300012347',
            'national_id' => '3174011506240005',
            'name' => 'Aurelia Putri',
            'email' => 'aurelia.putri@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '2025-06-15',
            'place_of_birth' => 'Depok',
            'gender' => 'P',
            'phone_number' => '081222334455',
            'address' => 'Jl. Dahlia No.9, Depok',
            'hamlet' => 'Pahing',
            'rt' => 3,
            'rw' => 1,
        ]);

        // TODDLER
        $toddler = User::create([
            'family_card_number' => '3174012300012347',
            'national_id' => '3174011003220006',
            'name' => 'Tasya Kamila',
            'email' => 'tasya.kamila@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '2022-03-10',
            'place_of_birth' => 'Bogor',
            'gender' => 'P',
            'phone_number' => '081333445566',
            'address' => 'Jl. Cempaka No.3, Bogor',
            'hamlet' => 'Manis',
            'rt' => 4,
            'rw' => 2,
        ]);

        // CHILD
        $child = User::create([
            'family_card_number' => '3174012300012347',
            'national_id' => '3174011407150007',
            'name' => 'Agung Prasetyo',
            'email' => 'agung.prasetyo@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '2015-07-14',
            'place_of_birth' => 'Tangerang',
            'gender' => 'L',
            'phone_number' => '081344556677',
            'address' => 'Jl. Sawo No.10, Tangerang',
            'hamlet' => 'Kliwon',
            'rt' => 5,
            'rw' => 3,
        ]);

        // TEENAGER
        $teenager = User::create([
            'family_card_number' => '3174012300012347',
            'national_id' => '3174011603090008',
            'name' => 'Rina Marlina',
            'email' => 'rina.marlina@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '2009-03-16',
            'place_of_birth' => 'Surabaya',
            'gender' => 'P',
            'phone_number' => '081355667788',
            'address' => 'Jl. Anggrek No.8, Jakarta',
            'hamlet' => 'Wage',
            'rt' => 6,
            'rw' => 4,
        ]);

        // ADULT
        $adult = User::create([
            'family_card_number' => '3174012300012353',
            'national_id' => '3174011901900009',
            'name' => 'Yudi Pranata',
            'email' => 'yudi.pranata@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-19',
            'place_of_birth' => 'Medan',
            'gender' => 'L',
            'phone_number' => '081366778899',
            'address' => 'Jl. Flamboyan No.4, Cikarang',
            'hamlet' => 'Puhun',
            'rt' => 7,
            'rw' => 5,
        ]);

        // ELDERLY
        $elderly = User::create([
            'family_card_number' => '3174012300012354',
            'national_id' => '3174010405500010',
            'name' => 'Sukirah',
            'email' => 'sukirah@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1950-05-04',
            'place_of_birth' => 'Yogyakarta',
            'gender' => 'P',
            'phone_number' => '081377889900',
            'address' => 'Jl. Cemara No.6, Karawang',
            'hamlet' => 'Manis',
            'rt' => 8,
            'rw' => 6,
        ]);

        // PREGNANT
        $pregnant = User::create([
            'family_card_number' => '3174012300012356',
            'national_id' => '3174012109970012',
            'name' => 'Fitri Handayani',
            'email' => 'fitri.handayani@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1997-09-21',
            'place_of_birth' => 'Malang',
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
            'email' => 'anonim@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '2000-01-01',
            'place_of_birth' => 'Unknown',
            'gender' => 'L',
            'phone_number' => '081388990011',
            'address' => 'Jl. Tidak Diketahui, Unknown',
            'hamlet' => 'Kliwon',
            'rt' => 0,
            'rw' => 0,
        ]);
        $none->syncRoles('none');
    }
}
