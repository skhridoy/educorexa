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
        // ক্যাশ ক্লিয়ার করা (Spatie-র জন্য জরুরি)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // কনফিগ ফাইল থেকে পারমিশনগুলো নেওয়া
        $permissionGroups = config('permissions.permissions');

        foreach ($permissionGroups as $group => $permissions) {
            foreach ($permissions as $name => $displayName) {
                // পারমিশন তৈরি করা (যদি আগে থেকে না থাকে)
                Permission::firstOrCreate([
                    'name' => $name,
                    'guard_name' => 'web'
                ]);
            }
        }

        // উদাহরণস্বরূপ একটি 'Super Admin' রোল তৈরি করে সব পারমিশন দেওয়া
        $adminRole = Role::firstOrCreate(['name' => 'school_admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());
    }
}