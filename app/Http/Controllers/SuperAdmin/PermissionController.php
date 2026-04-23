<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('group_name')->get();
        return view('super.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $groups = Permission::select('group_name')->distinct()->pluck('group_name');
        return view('super.permissions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'group_name' => 'required'
        ]);

        Permission::create([
            'name' => strtolower(str_replace(' ', '-', $request->name)),
            'group_name' => $request->group_name,
            'guard_name' => 'web'
        ]);

        return redirect()
            ->route('super.permissions.index')
            ->with('success','Permission Created Successfully');
    }

    // --- এডিট মেথড যোগ করা হলো ---
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        // ড্রপডাউনে গ্রুপ দেখানোর জন্য
        $groups = Permission::select('group_name')->distinct()->pluck('group_name');
        
        return view('super.permissions.edit', compact('permission', 'groups'));
    }

    // --- আপডেট মেথড যোগ করা হলো ---
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'group_name' => 'required'
        ]);

        $permission->update([
            'name' => strtolower(str_replace(' ', '-', $request->name)),
            'group_name' => $request->group_name,
        ]);

        return redirect()
            ->route('super.permissions.index')
            ->with('success','Permission Updated Successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()
            ->route('super.permissions.index')
            ->with('success','Permission Deleted Successfully');
    }
}