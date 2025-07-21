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
       // User 1
        $user1 = User::create([
            'family_card_number' => '3174012300012345',
            'national_id' => '3174011001900001',
            'name' => 'Andi Setiawan',
            'password' => bcrypt('password'),
            'birth_date' => '1990-05-10',
            'gender' => 'L',
            'phone_number' => '081234567890',
            'address' => 'Jl. Merpati No.1, Jakarta',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'hamlet' => 'RW 01',
        ]);
        $user1->assignRole('patient');

        // User 2
        $user2 = User::create([
            'family_card_number' => '3174012300012346',
            'national_id' => '3174012002850002',
            'name' => 'Siti Aminah',
            'password' => bcrypt('password'),
            'birth_date' => '1985-08-20',
            'gender' => 'P',
            'phone_number' => '081298765432',
            'address' => 'Jl. Melati No.5, Bandung',
            'latitude' => -6.914744,
            'longitude' => 107.609810,
            'hamlet' => 'RW 03',
        ]);
        $user2->assignRole('patient');

        // Admin User
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
    }
}
