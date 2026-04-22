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
    public function index()
    {
        // রোল টাইপ দেখার জন্য role_type কলামটিও লোড করা ভালো
        $roles = Role::with('permissions')
                 ->withCount('users')
                 ->get();
        return view('super.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('super.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            // এখানে 'employee' এবং 'school_admin' ভ্যালিডেশনে যোগ করা হয়েছে
            'role_type' => 'required|in:school_admin,teacher,student,employee,custom',
            'permissions' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {
            // আপনার ডাটাবেজ টেবিলে যদি role_type কলাম থাকে তবে এটি সেভ হবে
            $role = Role::create([
                'name' => $request->name,
                'role_type' => $request->role_type, 
                'guard_name' => 'web'
            ]);

            // Assign permissions
            $role->syncPermissions($request->permissions);
        });

        return redirect()
            ->route('super.roles.index')
            ->with('success','Role Created Successfully');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('super.roles.edit', compact('role','permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'role_type' => 'required|in:school_admin,teacher,student,employee,custom',
        ]);

        DB::transaction(function () use ($request, $role) {
            $role->update([
                'name' => $request->name,
                'role_type' => $request->role_type
            ]);
            
            $role->syncPermissions($request->permissions ?? []);
        });

        return redirect()->route('super.roles.index')->with('success','Role Updated Successfully');
    }

    public function destroy(Role $role)
    {
        // ডিফল্ট রোলগুলো প্রোটেক্ট করা
        if(in_array($role->name, ['school_admin','teacher','student','super_admin'])) {
            return back()->with('error','Default system role cannot be deleted.');
        }
        
        $role->delete();
        return redirect()->route('super.roles.index')->with('success','Role Deleted Successfully');
    }
}