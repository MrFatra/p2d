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
            'admin', 'cadre', 'baby', 'toddler', 'child',
            'teenager', 'adult', 'elderly', 'pregnant', 'none',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 2. Modules in English
        $modules = [
            'users',
            'schedules',
            'pregnant-women',
            'teenagers',
            'toddlers',
            'infants',
            'elderly',
            'article-categories',
            'articles',
            'roles',
        ];

        $actions = ['create', 'read', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}:{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // 3. Assign all permissions to admin
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions(Permission::all());
    }
}
