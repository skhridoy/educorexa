<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')
                     ->withCount('users')
                     ->orderBy('id', 'DESC')
                     ->get();

        return view('super.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        
        // ডাটাবেজ থেকে ইউনিক রোল টাইপগুলো নিয়ে আসা
        $role_types = Role::distinct()->pluck('role_type');

        return view('super.roles.create', compact('permissions', 'role_types'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'role_type' => 'required|in:school_admin,teacher,student,employee,custom',
            'permissions' => 'required|array|min:1'
        ], [
            'permissions.required' => 'অন্তত একটি পারমিশন সিলেক্ট করুন।'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $role = Role::create([
                    'name' => $request->name,
                    'role_type' => $request->role_type,
                    'guard_name' => 'web'
                ]);

                $role->syncPermissions($request->permissions);
            });

            return redirect()->route('super.roles.index')
                             ->with('success', 'নতুন রোল সফলভাবে তৈরি হয়েছে।');

        } catch (\Exception $e) {
            return back()->with('error', 'কিছু একটা ভুল হয়েছে: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        if ($role->name === 'super_admin') {
            return back()->with('error', 'সুপার এডমিন রোল এডিট করা সম্ভব নয়।');
        }

        $permissions = Permission::all();
        $role->load('permissions');
        
        // ডাটাবেজ থেকে ইউনিক রোল টাইপগুলো নিয়ে আসা
        $role_types = Role::distinct()->pluck('role_type');

        return view('super.roles.edit', compact('role', 'permissions', 'role_types'));
    }
    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'role_type' => 'required|in:school_admin,teacher,student,employee,custom',
            'permissions' => 'nullable|array'
        ]);

        try {
            DB::transaction(function () use ($request, $role) {
                $name = ($role->name === 'super_admin') ? 'super_admin' : $request->name;

                $role->update([
                    'name' => $name,
                    'role_type' => $request->role_type
                ]);

                $role->syncPermissions($request->permissions ?? []);
            });

            return redirect()->route('super.roles.index')
                             ->with('success', 'রোল আপডেট সফল হয়েছে।');

        } catch (\Exception $e) {
            return back()->with('error', 'আপডেট করতে সমস্যা হয়েছে।');
        }
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        $protected_roles = ['super_admin', 'school_admin', 'teacher', 'student'];

        if (in_array($role->name, $protected_roles)) {
            return back()->with('error', 'সিস্টেমের ডিফল্ট রোল ডিলিট করা যাবে না।');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'এই রোলে ইউজার এসাইন করা আছে, তাই ডিলিট করা সম্ভব নয়।');
        }

        $role->delete();

        return redirect()->route('super.roles.index')
                         ->with('success', 'রোলটি সফলভাবে ডিলিট করা হয়েছে।');
    }
}