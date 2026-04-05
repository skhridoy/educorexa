<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('school.profile.index', compact('user'));
    }

public function updateProfile(Request $request, $tenant)
{
    $user = auth()->user();
    $tenantSlug = $tenant;

    // রোল অনুযায়ী ফোল্ডার পাথ নির্ধারণ
    $roleFolder = 'students'; 
    if($user->role == 'school_admin') {
        $roleFolder = 'admins';
    } elseif($user->role == 'teacher') {
        $roleFolder = 'teachers';
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:15',
        'facebook' => 'nullable|url',
        'twitter' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'instagram' => 'nullable|url',
    ]);

    $user->name = $request->name;
    $user->phone = $request->phone;

    // স্কুল অ্যাডমিন হলে সরাসরি ইউজার টেবিলে সেভ
    if ($user->role == 'school_admin') {
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->linkedin = $request->linkedin;
        $user->insta = $request->instagram;
    }

    // টিচার হলে টিচার টেবিলে আপডেট
    if ($user->role == 'teacher' && $user->teacher) {
        $user->teacher->update([
            'designation' => $request->designation,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'insta' => $request->instagram,
        ]);
    }

    // ইমেজ প্রসেসিং (Cropped WebP Base64)
    if ($request->cropped_image) {
        $folderPath = public_path("uploads/schools/{$tenantSlug}/{$roleFolder}/");
        
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // পুরনো ফটো ডিলিট করার লজিক
        $oldPhoto = null;
        if($user->role == 'teacher' && $user->teacher) {
            $oldPhoto = $user->teacher->photo;
        } elseif($user->role == 'student' && $user->student) {
            $oldPhoto = $user->student->photo;
        } else {
            $oldPhoto = $user->photo;
        }

        if ($oldPhoto && file_exists(public_path($oldPhoto))) {
            @unlink(public_path($oldPhoto));
        }

        // Base64 ডাটা ডিকোড করা
        $image_parts = explode(";base64,", $request->cropped_image);
        $image_base64 = base64_decode($image_parts[1]);
        
        // ফাইল নেম তৈরি
        $filename = time() . '_' . uniqid() . '.webp';
        $fullPath = $folderPath . $filename;
        
        // ফাইল সেভ করা
        file_put_contents($fullPath, $image_base64);
        
        // ডাটাবেস পাথ (রিলেটিভ পাথ)
        $photoPath = "uploads/schools/{$tenantSlug}/{$roleFolder}/" . $filename;

        // রোল অনুযায়ী সঠিক টেবিলে পাথ আপডেট করা
        if ($user->role == 'teacher' && $user->teacher) {
            $user->teacher->update(['photo' => $photoPath]);
        } elseif ($user->role == 'student' && $user->student) {
            $user->student->update(['photo' => $photoPath]);
        } else {
            $user->photo = $photoPath;
        }
    }
    
    $user->save();
    return back()->with('success', 'Profile updated successfully!');
}


    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with('error', 'Old password is not correct');
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password successfully changed!');
    }
}