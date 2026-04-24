<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ১. পারমিশন ক্যাশ ক্লিয়ার করা
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ২. কনফিগ ফাইল থেকে পারমিশন তৈরি/আপডেট
        foreach (config('permissions.permissions') as $groupName => $permissions) {
            foreach ($permissions as $name => $displayName) {
                Permission::updateOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group_name' => $groupName]
                );
            }
        }

        // ৩. সুপার এডমিন রোল তৈরি এবং সব পারমিশন অ্যাসাইন করা
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web'],
            ['role_type' => 'super_admin'] // যদি role_type কলাম থাকে
        );

        // সব পারমিশন সিঙ্ক করা
        $allPermissions = Permission::all();
        $superAdmin->syncPermissions($allPermissions);
        
        $this->command->info('Permissions seeded and assigned to Super Admin successfully!');
    }
}