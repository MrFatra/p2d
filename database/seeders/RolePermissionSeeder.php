<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'cadre',
            'baby',
            'toddler',
            'child',
            'teenager',
            'adult',
            'elderly',
            'pregnant',
            'none',
        ];
        
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
