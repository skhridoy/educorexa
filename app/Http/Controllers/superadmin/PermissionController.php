<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('super.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('super.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('super.permissions.index')->with('success','Permission Created Successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('super.permissions.index')->with('success','Permission Deleted');
    }
}

