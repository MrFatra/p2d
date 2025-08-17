<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            ScheduleSeeder::class,
            AdultSeeder::class,
            TeenagerSeeder::class,
            InfantSeeder::class,
            PregnantPostpartumBreastfeendingSeeder::class,
            ElderlySeeder::class,
            ToddlerSeeder::class,
            PreschoolerSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
