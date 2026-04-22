<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (config('permissions.permissions') as $groupName => $permissions) {
            foreach ($permissions as $name => $displayName) {
                Permission::updateOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group_name' => $groupName]
                );
            }
        }

        // সুপার এডমিনকে সব পারমিশন দেওয়া
        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(\Spatie\Permission\Models\Permission::all());
    }
}