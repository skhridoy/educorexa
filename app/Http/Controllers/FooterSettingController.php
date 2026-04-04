<?php

namespace App\Http\Controllers;

use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function edit($tenant)
{
    $school = auth()->user()->school;
    // রিলেশনসহ ডাটা নিয়ে আসা
    $school->load('footerSetting'); 
    
    return view('school.admin.settings.footer', compact('school', 'tenant'));
}

public function update(Request $request, $tenant)
{
    $school = auth()->user()->school;

    // ১. স্কুল টেবিলের বেসিক ডাটা আপডেট
    $school->update($request->only(['address', 'phone', 'email']));

    // ২. ফুটার সেটিংস টেবিলের ডাটা আপডেট (Update or Create)
    $school->footerSetting()->updateOrCreate(
        ['school_id' => $school->id],
        $request->only(['facebook', 'twitter', 'instagram', 'linkedin', 'newsletter_text', 'copyright_text'])
    );

    return back()->with('success', 'Footer settings updated successfully!');
}

    
}
