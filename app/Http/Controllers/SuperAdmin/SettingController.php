<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit() {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('super.settings.edit', compact('setting'));
    }

    public function update(Request $request) {
        $setting = SiteSetting::first() ?? new SiteSetting();
        
        // টেক্সট ডাটা আপডেট
        $setting->site_name = $request->site_name;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->footer_text = $request->footer_text;

        // মেইন পাথ সেটআপ
        $basePath = 'uploads/settings';

        // ১. লোগো হ্যান্ডেলিং (Wide Logo)
        if ($request->hasFile('logo_wide')) {
            $logoPath = public_path($basePath . '/logos');
            // ফোল্ডার না থাকলে তৈরি করা
            if (!file_exists($logoPath)) mkdir($logoPath, 0755, true);

            // পুরনো ফাইল ডিলিট করা
            if ($setting->logo_wide && file_exists(public_path($setting->logo_wide))) {
                @unlink(public_path($setting->logo_wide));
            }

            $file = $request->file('logo_wide');
            $fileName = 'logo_wide_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($logoPath, $fileName);
            
            $setting->logo_wide = $basePath . '/logos/' . $fileName;
        }

        // ২. স্কয়ার লোগো হ্যান্ডেলিং (Square Logo)
        if ($request->hasFile('logo_square')) {
            $squarePath = public_path($basePath . '/logos_square');
            if (!file_exists($squarePath)) mkdir($squarePath, 0755, true);

            if ($setting->logo_square && file_exists(public_path($setting->logo_square))) {
                @unlink(public_path($setting->logo_square));
            }

            $file = $request->file('logo_square');
            $fileName = 'logo_sq_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($squarePath, $fileName);
            
            $setting->logo_square = $basePath . '/logos_square/' . $fileName;
        }

        // ৩. ফেভিকন হ্যান্ডেলিং
        if ($request->hasFile('favicon')) {
            $favPath = public_path($basePath . '/favicons');
            if (!file_exists($favPath)) mkdir($favPath, 0755, true);

            if ($setting->favicon && file_exists(public_path($setting->favicon))) {
                @unlink(public_path($setting->favicon));
            }

            $file = $request->file('favicon');
            $fileName = 'fav_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($favPath, $fileName);
            
            $setting->favicon = $basePath . '/favicons/' . $fileName;
        }

        $setting->save();

        return back()->with('success', 'Site settings updated successfully!');
    }
}
