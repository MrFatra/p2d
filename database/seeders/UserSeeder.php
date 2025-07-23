<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
            'latitude' => -7.257472,
            'longitude' => 112.752088,
            'hamlet' => 'RW 05',
        ]);
        $admin->assignRole('admin');

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
            'latitude' => -6.238270,
            'longitude' => 106.975572,
            'hamlet' => 'RW 02',
        ]);
        $cadre->assignRole('cadre');

        // BABY
        $baby = User::create([
            'family_card_number' => '3174012300012349',
            'national_id' => '3174011506240005',
            'name' => 'Bayu Saputra',
            'password' => bcrypt('password'),
            'birth_date' => '2024-06-15',
            'gender' => 'L',
            'phone_number' => '081222334455',
            'address' => 'Jl. Dahlia No.9, Depok',
            'latitude' => -6.402484,
            'longitude' => 106.794243,
            'hamlet' => 'RW 01',
        ]);
        $baby->assignRole('baby');

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
            'latitude' => -6.596298,
            'longitude' => 106.797242,
            'hamlet' => 'RW 04',
        ]);
        $toddler->assignRole('toddler');

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
            'latitude' => -6.176558,
            'longitude' => 106.631889,
            'hamlet' => 'RW 06',
        ]);
        $child->assignRole('child');

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
            'latitude' => -6.208763,
            'longitude' => 106.845599,
            'hamlet' => 'RW 07',
        ]);
        $teenager->assignRole('teenager');

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
            'latitude' => -6.288533,
            'longitude' => 107.144285,
            'hamlet' => 'RW 08',
        ]);
        $adult->assignRole('adult');

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
            'latitude' => -6.323644,
            'longitude' => 107.337579,
            'hamlet' => 'RW 09',
        ]);
        $elderly->assignRole('elderly');

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
            'latitude' => -6.240000,
            'longitude' => 106.980000,
            'hamlet' => 'RW 10',
        ]);
        $pregnant->assignRole('pregnant');

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
            'latitude' => -6.000000,
            'longitude' => 106.000000,
            'hamlet' => 'RW 00',
        ]);
        $none->assignRole('none');
    }
}
