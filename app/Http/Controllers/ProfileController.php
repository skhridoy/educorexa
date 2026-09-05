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

        // ভ্যালিডেশন
        $validationRules = [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'designation' => 'nullable|string|max:255',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
        ];

        // সকল ইউজার ইমেইল পরিবর্তন করতে পারবে
        $validationRules['email'] = 'required|email|unique:users,email,' . $user->id;

        $request->validate($validationRules);

        // ১. ইউজার টেবিল আপডেট
        $user->name = $request->name;
        $user->phone = $request->phone;

        // সকল রোলের জন্য ইমেইল আপডেট
        $user->email = $request->email;

        // ২. রোল অনুযায়ী রিলেটেড টেবিল আপডেট
        if ($user->role == 'school_admin') {
            $user->facebook = $request->facebook;
            $user->twitter = $request->twitter;
            $user->linkedin = $request->linkedin;
            $user->insta = $request->instagram;

            // স্কুলের ইমেইল ও নাম সিঙ্ক করা (সুপার এডমিন প্যানেলের জন্য জরুরি)
            if ($user->school) {
                $user->school->update([
                    'email' => $request->email,
                    'name'  => $request->name,
                    'phone' => $request->phone,
                ]);
            }
        } 
        elseif ($user->role == 'teacher' && $user->teacher) {
            // ইউজার টেবিলের নাম ও ইমেইল টিচার টেবিলেও আপডেট হবে
            // (কারণ Teacher রিলেশন email কলাম দিয়ে যুক্ত)
            $user->teacher->update([
                'name'        => $request->name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'designation' => $request->designation,
                'facebook'    => $request->facebook,
                'twitter'     => $request->twitter,
                'linkedin'    => $request->linkedin,
                'insta'       => $request->instagram,
            ]);
        } 
        elseif ($user->role == 'student' && $user->student) {
            // স্টুডেন্ট টেবিলের নাম ও ফোন আপডেট
            $user->student->update([
                'name' => $request->name,
                'contact_number' => $request->phone, // আপনার ডাটাবেসে কলাম নাম অনুযায়ী চেক করে নিন
            ]);
        }

        // ৩. ইমেজ প্রসেসিং (পূর্বের লজিক ঠিক আছে, শুধু রোল পাথ নির্ধারণ)
        $roleFolder = $user->role == 'school_admin' ? 'admins' : ($user->role == 'teacher' ? 'teachers' : 'students');

        if ($request->cropped_image) {
            $folderPath = public_path("uploads/schools/{$tenantSlug}/{$roleFolder}/");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            // পুরনো ফটো ডিলিট
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

            // নতুন ইমেজ সেভ
            $image_parts = explode(";base64,", $request->cropped_image);
            $image_base64 = base64_decode($image_parts[1]);
            $filename = time() . '_' . uniqid() . '.webp';
            file_put_contents($folderPath . $filename, $image_base64);
            
            $photoPath = "uploads/schools/{$tenantSlug}/{$roleFolder}/" . $filename;

            // ৪. ডাটাবেসে ফটো পাথ আপডেট
            if ($user->role == 'teacher' && $user->teacher) {
                $user->teacher->update(['photo' => $photoPath]);
            } elseif ($user->role == 'student' && $user->student) {
                $user->student->update(['photo' => $photoPath]);
            } else {
                $user->photo = $photoPath;
            }
        }

        // ৫. প্রধান শিক্ষক / অধ্যক্ষের স্বাক্ষর হ্যান্ডলিং (School Admin / Principal Signature)
        if ($user->role == 'school_admin') {
            $sigFolder = public_path("uploads/schools/{$tenantSlug}/signatures/");
            if (!file_exists($sigFolder)) {
                mkdir($sigFolder, 0755, true);
            }

            // Remove signature if requested
            if ($request->remove_signature == '1') {
                if ($user->signature && file_exists(public_path($user->signature))) {
                    @unlink(public_path($user->signature));
                }
                $user->signature = null;
                if ($user->school) {
                    $user->school->update(['signature' => null]);
                }
            }

            // Cropped base64 signature
            if ($request->cropped_signature) {
                if ($user->signature && file_exists(public_path($user->signature))) {
                    @unlink(public_path($user->signature));
                }

                $sig_parts = explode(";base64,", $request->cropped_signature);
                $sig_base64 = base64_decode($sig_parts[1]);
                $sigFilename = 'sig_' . time() . '_' . uniqid() . '.webp';
                file_put_contents($sigFolder . $sigFilename, $sig_base64);

                $sigPath = "uploads/schools/{$tenantSlug}/signatures/" . $sigFilename;
                $user->signature = $sigPath;
                if ($user->school) {
                    $user->school->update(['signature' => $sigPath]);
                }
            }
            // Direct file upload signature
            elseif ($request->hasFile('signature')) {
                $request->validate([
                    'signature' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
                ]);

                if ($user->signature && file_exists(public_path($user->signature))) {
                    @unlink(public_path($user->signature));
                }

                $file = $request->file('signature');
                $ext = $file->getClientOriginalExtension();
                $sigFilename = 'sig_' . time() . '_' . uniqid() . '.' . $ext;
                $file->move($sigFolder, $sigFilename);

                $sigPath = "uploads/schools/{$tenantSlug}/signatures/" . $sigFilename;
                $user->signature = $sigPath;
                if ($user->school) {
                    $user->school->update(['signature' => $sigPath]);
                }
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