<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ১. পারমিশন তৈরি (আগের মতোই কনফিগ থেকে)
        foreach (config('permissions.permissions') as $groupName => $permissions) {
            foreach ($permissions as $name => $displayName) {
                Permission::updateOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['group_name' => $groupName]
                );
            }
        }

        // ২. ইন্টারনাল কোম্পানি স্টাফ রোল (role_type: internal_staff)
        $internalRoles = ['HR', 'Marketing', 'Support', 'Accountant'];
        foreach ($internalRoles as $role) {
            Role::updateOrCreate(
                ['name' => $role, 'guard_name' => 'web'],
                ['role_type' => 'employee'] // আপনার কোম্পানির স্টাফ
            );
        }

        // ৩. স্কুল ভিত্তিক রোল (role_type: school_staff)
        $schoolRoles = ['teacher', 'student', 'school_admin'];
        foreach ($schoolRoles as $role) {
            Role::updateOrCreate(
                ['name' => $role, 'guard_name' => 'web'],
                ['role_type' => 'school_staff'] // স্কুলের অধীনে সরাসরি রোল
            );
        }

        // ৪. সুপার এডমিন (যিনি পুরো সিস্টেম কন্ট্রোল করবেন)
        $superAdmin = Role::updateOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web'],
            ['role_type' => 'employee'] // সুপার এডমিনকেও employee টাইপে রাখা হলো, কারণ তিনি কোম্পানির স্টাফ হিসেবেই কাজ করবেন
        );
        $superAdmin->syncPermissions(Permission::all());
    }
}
