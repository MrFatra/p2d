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
        $user1 = User::firstOrCreate(
            [
                'nik' => '3208100020003000',
            ],
            [
                'no_kk' => '3208100020003000',
                'name' => 'Patient 1',
                'password' => bcrypt('foobarrr'),
                'birth_date' => '2000-01-01',
                'age' => 22,
                'gender' => 'L',
                'phone_number' => '08881263622',
                'address' => 'Jln. Mana Aja No.16 RT.03/RW.02',
                'latitude' => -6.912,
                'longitude' => 107.609,
            ]
        );

        $user2 = User::firstOrCreate(
            [
                'nik' => '3208100020003001',
            ],
            [
                'no_kk' => '3208100020003001',
                'name' => 'Patient 2',
                'password' => bcrypt('foobarrr'),
                'birth_date' => '2001-01-01',
                'age' => 23,
                'gender' => 'P',
                'phone_number' => '08881263623',
                'address' => 'Jln. Mana Aja No.17 RT.03/RW.02',
                'latitude' => -6.912,
                'longitude' => 107.609,
            ]
        );

        $admin = User::firstOrCreate(
            [
                'nik' => '3208100020003002',
            ],
            [
                'no_kk' => '3208100020003002',
                'name' => 'Admin 1',
                'password' => bcrypt('foobarrr'),
                'birth_date' => '2002-01-01',
                'age' => 24,
                'gender' => 'L',
                'phone_number' => '08881263624',
                'address' => 'Jln. Mana Aja No.18 RT.03/RW.02',
                'latitude' => -6.912,
                'longitude' => 107.609,
                'password' => bcrypt('foobarrr'),
            ]
        );

        $user1->assignRole('patient');
        $user2->assignRole('patient');
        $admin->assignRole('admin');
    }
}
