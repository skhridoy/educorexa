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

        // ২. কনফিগ ফাইল থেকে পারমিশন তৈরি/আপডেট করা
        $validPermissions = [];
        foreach (config('permissions.permissions') as $groupName => $permissions) {
            foreach ($permissions as $name => $displayName) {
                Permission::updateOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group_name' => $groupName]
                );
                $validPermissions[] = $name;
            }
        }

        // ৩. পূর্বে ভুলবশত ঢুকে পড়া ক্যাটাগরি/গ্রুপ হেডার পারমিশনগুলো রিমুভ করা
        $junkPermissions = [
            'Academic',
            'Attendance & Exams',
            'Coaching Center',
            'Finance (Fees)',
            'SaaS Management (Super Admin/Employee Only)',
            'Settings',
            'Staff & HR',
            'Students & Admissions',
            'Website & Communication',
        ];
        Permission::whereIn('name', $junkPermissions)->delete();

        // ৪. সুপার এডমিন রোল তৈরি এবং সব পারমিশন অ্যাসাইন করা
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web'],
            ['role_type' => 'super_admin']
        );

        // সব বৈধ পারমিশন সিঙ্ক করা
        $allPermissions = Permission::whereIn('name', $validPermissions)->get();
        $superAdmin->syncPermissions($allPermissions);
        
        $this->command->info('Permissions seeded and assigned to Super Admin successfully!');
    }
}