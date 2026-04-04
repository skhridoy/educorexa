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

    $roleFolder = 'students'; 
    if($user->role == 'school_admin') {
        $roleFolder = 'admins';
    } elseif($user->role == 'teacher') {
        $roleFolder = 'teachers';
    }

    $request->validate([
        'name' => 'required|string|max:255',
        
        'phone' => 'nullable|string|max:15',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:512',
        // নতুন ভ্যালিডেশন
        'facebook' => 'nullable|url',
        'twitter' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'instagram' => 'nullable|url',
    ]);

    $user->name = $request->name;
    $user->phone = $request->phone;

    // যদি অ্যাডমিন হয়, তবে সরাসরি ইউজার টেবিলে সোশ্যাল লিঙ্ক সেভ হবে
    if ($user->role == 'school_admin') {
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->linkedin = $request->linkedin;
        $user->insta = $request->instagram;
    }

    // যদি টিচার হয়, তবে টিচার টেবিলে সোশ্যাল লিঙ্ক এবং পদবী সেভ হবে
    if ($user->role == 'teacher' && $user->teacher) {
        $user->teacher->update([
            'designation' => $request->designation,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'insta' => $request->instagram,
        ]);
    }

    if ($request->hasFile('photo')) {
        $folder = public_path("uploads/schools/{$tenantSlug}/{$roleFolder}");
        
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $oldPhoto = $user->photo; 
        if($user->role == 'teacher' && $user->teacher) {
            $oldPhoto = $user->teacher->photo; // আপনার টিচার টেবিলে কলাম নাম 'image' হলে
        } elseif($user->role == 'student' && $user->student) {
            $oldPhoto = $user->student->photo;
        }

        if ($oldPhoto && file_exists(public_path($oldPhoto))) {
            unlink(public_path($oldPhoto));
        }

        $file = $request->file('photo');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $filename);
        
        $photoPath = "uploads/schools/{$tenantSlug}/{$roleFolder}/" . $filename;

        if ($user->role == 'teacher' && $user->teacher) {
            $user->teacher->update(['photo' => $photoPath]); // টিচার টেবিলের ইমেজ কলাম আপডেট
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