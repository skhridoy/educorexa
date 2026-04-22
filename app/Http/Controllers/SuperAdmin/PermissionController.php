<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        // মডিউল অনুযায়ী সাজিয়ে দেখানোর জন্য group_name সহ ডাটা আনা
        $permissions = Permission::orderBy('group_name')->get();
        return view('super.permissions.index', compact('permissions'));
    }

    public function create()
    {
        // আগে থেকে থাকা গ্রুপগুলোর নাম সংগ্রহ করা (ড্রপডাউনের জন্য)
        $groups = Permission::select('group_name')->distinct()->pluck('group_name');
        return view('super.permissions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'group_name' => 'required' // মডিউল গ্রুপিং নিশ্চিত করতে
        ]);

        Permission::create([
            'name' => strtolower(str_replace(' ', '-', $request->name)), // নামকে স্লাগ ফরম্যাটে সেভ করা
            'group_name' => $request->group_name,
            'guard_name' => 'web'
        ]);

        return redirect()
            ->route('super.permissions.index')
            ->with('success','Permission Created Successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()
            ->route('super.permissions.index')
            ->with('success','Permission Deleted Successfully');
    }
}