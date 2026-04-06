<?php

namespace App\Http\Controllers;
use App\Notifications\SuperAdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\School;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SchoolRegisterController extends Controller
{
    public function create()
    {
        return view('auth.school-register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'school_name'     => 'required|string|max:255',
            'slug'            => 'required|alpha_num|unique:schools,slug',
            'admin_name'      => 'required|string|max:255',
            'admin_email'     => 'required|email|unique:users,email',
            'admin_password'  => 'required|min:8',
        ]);

        // আমরা ডাটাগুলো ট্রানজাকশনের বাইরে এক্সেস করার জন্য ভেরিয়েবলে রাখছি
        $newSchool = null;

        DB::transaction(function () use ($request, &$newSchool) {

            // 1️⃣ Create School
            $newSchool = School::create([
                'name'   => $request->school_name,
                'slug'   => strtolower($request->slug),
                'email'  => $request->admin_email,
                'status' => 'pending',
            ]);

            // 2️⃣ Create School Admin User
            $user = User::create([
                'name'      => $request->admin_name,
                'email'     => $request->admin_email,
                'password'  => Hash::make($request->admin_password),
                'role'      => 'school_admin',
                'school_id' => $newSchool->id,
            ]);

            if (method_exists($user, 'assignRole')) {
                $user->assignRole('school_admin');
            }
        });

        $superAdmin = User::where('role', 'super_admin')->first();

        if (!$superAdmin) {
            
            // যদি এটি দেখায়, তবে বুঝবেন আপনার ডাটাবেসে 'super_admin' রোলে কেউ নেই।
            dd("Error: সুপার এডমিন ইউজার পাওয়া যায় নাই! আপনার ডাটাবেসের role কলাম চেক করুন।"); 
        }

        try {
            $details = [
                'message' => "New School Registered: {$newSchool->name}",
                'icon'    => 'home',
                'link'    => route('super.schools.pending'),
            ];
            $superAdmin->notify(new SuperAdminNotification($details));
        } catch (\Exception $e) {
            dd("Error: " . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'School registered successful! Waiting for approval. You will receive an email once your school is approved.');
    }

    // ১. এডিট পেজ দেখানোর জন্য (GET Method)
    public function edit()
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);
        return view('school.setting.school_info', compact('school'));
    }

    // ২. ডাটা আপডেট করার জন্য (POST/PUT Method)
    public function update(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);

        $request->validate([
            'name'    => 'required|string|max:255',
            'logo'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            // 'image' রুলটি অনেক সময় ICO বা কিছু বিশেষ PNG-তে ঝামেলা করে, তাই শুধু mimes ব্যবহার করা নিরাপদ
            'favicon' => 'nullable|mimes:png,ico,jpg,jpeg|max:1024', 
        ]);

        $school->name = $request->name;
        $school->email = $request->email;
        $school->phone = $request->phone;
        $school->ein_number = $request->ein_number;
        $school->emis_code = $request->emis_code;
        $school->address = $request->address;

        $tenantSlug = $school->slug;
        $basePath = "uploads/schools/{$tenantSlug}";

        // লোগো হ্যান্ডেলিং
        if ($request->hasFile('logo')) {
            $logoPath = public_path($basePath . '/logo');
            if (!file_exists($logoPath)) mkdir($logoPath, 0755, true);

            if ($school->logo && file_exists(public_path($school->logo))) {
                unlink(public_path($school->logo));
            }

            $logoFile = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move($logoPath, $logoName);
            $school->logo = $basePath . '/logo/' . $logoName;
        }

        // ফেভিকন হ্যান্ডেলিং
        if ($request->hasFile('favicon')) {
            $favPath = public_path($basePath . '/favicon');
            // ফোল্ডার তৈরি নিশ্চিত করা
            if (!file_exists($favPath)) mkdir($favPath, 0755, true);

            if ($school->favicon && file_exists(public_path($school->favicon))) {
                @unlink(public_path($school->favicon));
            }

            $favFile = $request->file('favicon');
            $favName = 'fav_' . time() . '.' . $favFile->getClientOriginalExtension();
            
            // ফাইল মুভ করা
            if ($favFile->move($favPath, $favName)) {
                $school->favicon = $basePath . '/favicon/' . $favName;
            }
        }
        
        $school->save();

        return back()->with('success', 'আপনার স্কুলের তথ্য সফলভাবে আপডেট হয়েছে!');
    }

}
