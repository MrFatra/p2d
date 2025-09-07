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
            [
                'label' => 'Desa',
                'name' => 'resident',
            ],
            [
                'label' => 'Admin',
                'name' => 'admin',
            ],
            [
                'label' => 'Kader',
                'name' => 'cadre',
            ],
            [
                'label' => 'Bidan',
                'name' => 'midwife',
            ],
            [
                'label' => 'Bayi',
                'name' => 'baby',
            ],
            [
                'label' => 'Balita',
                'name' => 'toddler',
            ],
            [
                'label' => 'Apras',
                'name' => 'child',
            ],
            [
                'label' => 'Remaja',
                'name' => 'teenager',
            ],
            [
                'label' => 'Dewasa',
                'name' => 'adult',
            ],
            [
                'label' => 'Lansia',
                'name' => 'elderly',
            ],
            [
                'label' => 'Ibu Hamil',
                'name' => 'pregnant',
            ],
            [
                'label' => 'Tidak ada',
                'name' => 'none',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }

        // 2. Modules in English
        $modules = [
            'pengguna',
            'jadwal',
            'ibu-hamil',
            'remaja',
            'dewasa',
            'balita',
            'bayi',
            'anak_prasekolah',
            'lansia',
            'kategori-artikel',
            'artikel',
            'peran',
        ];

        $actions = ['create', 'read', 'update', 'delete', 'export', 'import'];

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
            'pertumbuhan-remaja',
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
