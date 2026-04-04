<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = config('permissions.permissions');

        // Create permissions
        foreach ($permissions as $key => $label) {
            Permission::firstOrCreate(['name' => $key]);
        }

        // Create roles
        $roles = ['school_admin', 'teacher', 'student'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
