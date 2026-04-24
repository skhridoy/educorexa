<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ১. সুপার এডমিন রোলটি নিশ্চিত করা (না থাকলে তৈরি করবে)
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web'], [
            'role_type' => 'super_admin' // আপনার আগের সমস্যা অনুযায়ী টাইপটি সেট করে দেওয়া হলো
        ]);

        // ২. সুপার এডমিন ইউজার তৈরি বা খুঁজে বের করা
        $user = User::updateOrCreate(
            ['email' => 'superadmin@schoolerp.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'super_admin', // আপনার কাস্টম কলামের জন্য
            ]
        );

        // ৩. ইউজারকে রোল অ্যাসাইন করা
        // syncRoles ব্যবহার করা নিরাপদ, কারণ এটি ডুপ্লিকেট এন্ট্রি হতে দেয় না
        $user->syncRoles($role);

        $this->command->info('Super Admin created and role assigned successfully!');
    }
}