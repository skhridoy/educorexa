<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class SchoolStaffController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $staffs = User::where('school_id', $schoolId)
                      ->where('role', 'school_staff')
                      ->get();
        return view('school.staff.index', compact('staffs'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $roles = Role::where('school_id', $schoolId)
                     ->orWhere(function($query) {
                         $query->whereNull('school_id')
                               ->whereNotIn('name', ['super_admin', 'HR', 'Marketing', 'Support', 'Accountant', 'admin']);
                     })
                     ->get();
        return view('school.staff.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $schoolId = auth()->user()->school_id;

        DB::transaction(function () use ($request, $schoolId) {
            $userData = [
                'school_id' => $schoolId,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'school_staff',
                'phone' => $request->phone,
            ];

            if ($request->cropped_image) {
                $tenantSlug = auth()->user()->school->slug;
                $folderPath = public_path("uploads/schools/{$tenantSlug}/staff/");
                
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                $image_parts = explode(";base64,", $request->cropped_image);
                $image_base64 = base64_decode($image_parts[1]);
                $filename = time() . '_' . uniqid() . '.webp';
                file_put_contents($folderPath . $filename, $image_base64);
                
                $userData['photo'] = "uploads/schools/{$tenantSlug}/staff/" . $filename;
            } elseif ($request->hasFile('photo')) {
                // Fallback for normal file upload if cropper is not used
                $image = $request->file('photo');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/staff');
                $image->move($destinationPath, $name);
                $userData['photo'] = '/uploads/staff/' . $name;
            }

            $user = User::create($userData);

            $role = Role::findById($request->role_id, 'web');
            $user->syncRoles([$role]);
        });

        return redirect()->route('staff.index', ['tenant' => auth()->user()->school->slug])
                         ->with('success', 'Staff member added successfully');
    }

    public function edit($tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $staff = User::where('school_id', $schoolId)
                     ->where('role', 'school_staff')
                     ->findOrFail($id);
        
        $roles = Role::where('school_id', $schoolId)
                     ->orWhere(function($query) {
                         $query->whereNull('school_id')
                               ->whereNotIn('name', ['super_admin', 'HR', 'Marketing', 'Support', 'Accountant', 'admin']);
                     })
                     ->get();

        return view('school.staff.edit', compact('staff', 'roles'));
    }

    public function update(Request $request, $tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $staff = User::where('school_id', $schoolId)
                     ->where('role', 'school_staff')
                     ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        DB::transaction(function () use ($request, $staff) {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            if ($request->cropped_image) {
                $tenantSlug = auth()->user()->school->slug;
                $folderPath = public_path("uploads/schools/{$tenantSlug}/staff/");
                
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                // Delete old photo if exists
                if ($staff->photo && file_exists(public_path($staff->photo))) {
                    @unlink(public_path($staff->photo));
                }

                $image_parts = explode(";base64,", $request->cropped_image);
                $image_base64 = base64_decode($image_parts[1]);
                $filename = time() . '_' . uniqid() . '.webp';
                file_put_contents($folderPath . $filename, $image_base64);
                
                $updateData['photo'] = "uploads/schools/{$tenantSlug}/staff/" . $filename;
            } elseif ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($staff->photo && file_exists(public_path($staff->photo))) {
                    @unlink(public_path($staff->photo));
                }

                $image = $request->file('photo');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/staff');
                $image->move($destinationPath, $name);
                $updateData['photo'] = '/uploads/staff/' . $name;
            }

            $staff->update($updateData);

            $role = Role::findById($request->role_id, 'web');
            $staff->syncRoles([$role]);
        });

        return redirect()->route('staff.index', ['tenant' => auth()->user()->school->slug])
                         ->with('success', 'Staff member updated successfully');
    }

    public function destroy($tenant, $id)
    {
        $schoolId = auth()->user()->school_id;
        $staff = User::where('school_id', $schoolId)
                     ->where('role', 'school_staff')
                     ->findOrFail($id);

        $staff->delete();

        return redirect()->back()->with('success', 'Staff member deleted successfully');
    }
}
