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
        $roles = Role::with('permissions')->get();
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
            'role_type' => 'required|in:school_admin,teacher,student,custom',
            'permissions' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {

            $role = Role::create([
                'name' => $request->name,
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
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('super.roles.index')->with('success','Role Updated Successfully');
    }
    public function destroy(Role $role)
    {
        if(in_array($role->name, ['school_admin','teacher','student'])) {
            return back()->with('error','Default role cannot be deleted.');
        }
        $role->delete();
        return redirect()->route('super.roles.index')->with('success','Role Deleted Successfully');
    }
}


