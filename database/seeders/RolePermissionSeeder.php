<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
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

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 2. Modules in English
        $modules = [
            'pengguna',
            'jadwal',
            'ibu-hamil',
            'dewasa',
            'balita',
            'bayi',
            'lansia',
            'kategori-artikel',
            'artikel',
            'peran',
        ];

        $actions = ['create', 'read', 'update', 'delete', 'export'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}:{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        $modulesPrivate = [
            'dashboard',
            'pertumbuhan-bayi',
            'pertumbuhan-balita',
            'laporan-data-posyandu',
        ];

        foreach ($modulesPrivate as $module) {
            Permission::firstOrCreate([
                'name' => "{$module}:view",
                'guard_name' => 'web',
            ]);
        }

        // 3. Assign all permissions to admin
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions(Permission::all());
    }
}
