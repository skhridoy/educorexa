<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\FrontendSection;

class SettingController extends Controller
{
    public function edit() {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('super.settings.edit', compact('setting'));
    }

    public function update(Request $request) {
        $setting = SiteSetting::first() ?? new SiteSetting();
        
        // সাধারণ টেক্সট ডাটা আপডেট
        $setting->site_name = $request->site_name;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->footer_text = $request->footer_text;

        // --- নতুন SEO ডাটা আপডেট ---
        $setting->meta_title = $request->meta_title;
        $setting->meta_description = $request->meta_description;
        $setting->meta_keywords = $request->meta_keywords;

        // মেইন পাথ সেটআপ
        $basePath = 'uploads/settings';

        // ১. লোগো হ্যান্ডেলিং (Wide Logo)
        if ($request->hasFile('logo_wide')) {
            $logoPath = public_path($basePath . '/logos');
            if (!file_exists($logoPath)) mkdir($logoPath, 0755, true);

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

        // ৪. OG Image হ্যান্ডেলিং (SEO Social Preview)
        if ($request->hasFile('og_image')) {
            $seoPath = public_path($basePath . '/seo');
            if (!file_exists($seoPath)) mkdir($seoPath, 0755, true);

            if ($setting->og_image && file_exists(public_path($setting->og_image))) {
                @unlink(public_path($setting->og_image));
            }

            $file = $request->file('og_image');
            $fileName = 'seo_og_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($seoPath, $fileName);
            $setting->og_image = $basePath . '/seo/' . $fileName;
        }

        $setting->save();

        return back()->with('success', 'Site settings and SEO updated successfully!');
    }

    public function toggleSection(Request $request) {
        // শুধুমাত্র সুপার এডমিন চেক
        if(auth()->user()->role !== 'super_admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $section = FrontendSection::findOrFail($request->id);
        $section->status = $request->status;
        $section->save();

        return response()->json(['success' => 'Status updated!']);
    }
}