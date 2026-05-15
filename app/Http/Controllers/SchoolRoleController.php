<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\School;
use Illuminate\Support\Facades\DB;

class SchoolRoleController extends Controller
{
    public function index(Request $request, $tenant)
    {
        $school = app('currentSchool');
        
        // শুধুমাত্র স্কুলের নিজস্ব রোলগুলো দেখাবো
        // অথবা এমন গ্লোবাল রোল যেগুলো স্কুল লেভেলের জন্য প্রযোজ্য (যদি থাকে)
        // কিন্তু super_admin, hr, support, marketing, accountant এগুলো দেখাবো না
        $roles = Role::where('school_id', $school->id)
                    ->orWhere(function($query) {
                        $query->whereNull('school_id')
                              ->whereNotIn('name', ['super_admin', 'HR', 'Marketing', 'Support', 'Accountant', 'admin']);
                    })
                    ->orderBy('id', 'desc')
                    ->get();
                    
        return view('school.roles.index', compact('roles', 'school', 'tenant'));
    }

    public function create(Request $request, $tenant)
    {
        $school = app('currentSchool');
        
        // স্কুলের প্যাকেজ পারমিশন অনুযায়ী ফিল্টার করা
        $packagePermissions = optional($school->subscriptionPackage)->permissions ?? [];
        
        // ডাটাবেজ থেকে সেই পারমিশনগুলো আনা
        $permissions = Permission::whereIn('name', $packagePermissions)->get();
        
        $role_types = ['school_staff', 'teacher', 'student']; // স্কুলের জন্য প্রযোজ্য টাইপ
        
        return view('school.roles.create', compact('permissions', 'school', 'tenant', 'role_types'));
    }

    public function store(Request $request, $tenant)
    {
        $school = app('currentSchool');
        $packagePermissions = optional($school->subscriptionPackage)->permissions ?? [];

        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        // সিকিউরিটি চেক: ইউজার যেন প্যাকেজের বাইরের কোনো পারমিশন হ্যাক করে না দেয়
        $filteredPermissions = array_intersect($request->permissions, $packagePermissions);

        DB::transaction(function () use ($request, $school, $filteredPermissions) {
            $role = Role::create([
                'name' => $request->name . ' - ' . $school->id, // ইউনিক রাখার জন্য স্কুল আইডি যোগ
                'display_name' => $request->name,
                'guard_name' => 'web',
                'school_id' => $school->id,
                'role_type' => $request->role_type ?? 'school_staff'
            ]);

            $role->syncPermissions($filteredPermissions);
        });

        return redirect()->route('school.roles.index', ['tenant' => $tenant])
            ->with('success', 'Role created successfully');
    }

    public function edit(Request $request, $tenant, $id)
    {
        $school = app('currentSchool');
        $role = Role::where('school_id', $school->id)->findOrFail($id);
        
        $packagePermissions = optional($school->subscriptionPackage)->permissions ?? [];
        $permissions = Permission::whereIn('name', $packagePermissions)->get();
        
        $role_types = ['school_staff', 'teacher', 'student'];
        $currentPermissions = $role->permissions->pluck('name')->toArray();

        return view('school.roles.edit', compact('role', 'permissions', 'school', 'tenant', 'role_types', 'currentPermissions'));
    }

    public function update(Request $request, $tenant, $id)
    {
        $school = app('currentSchool');
        $role = Role::where('school_id', $school->id)->findOrFail($id);
        $packagePermissions = optional($school->subscriptionPackage)->permissions ?? [];

        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array'
        ]);

        $filteredPermissions = array_intersect($request->permissions, $packagePermissions);

        DB::transaction(function () use ($request, $role, $filteredPermissions) {
            $role->update([
                'display_name' => $request->name,
                'role_type' => $request->role_type ?? 'school_staff'
            ]);

            $role->syncPermissions($filteredPermissions);
        });

        return redirect()->route('school.roles.index', ['tenant' => $tenant])
            ->with('success', 'Role updated successfully');
    }

    public function destroy(Request $request, $tenant, $id)
    {
        $school = app('currentSchool');
        $role = Role::where('school_id', $school->id)->findOrFail($id);
        
        // ডিফল্ট রোলগুলো ডিলিট করতে বাধা দেওয়া
        if (in_array($role->name, ['school_admin', 'teacher', 'student'])) {
            return back()->with('error', 'Default roles cannot be deleted');
        }

        $role->delete();
        return redirect()->route('school.roles.index', ['tenant' => $tenant])
            ->with('success', 'Role deleted successfully');
    }
}
