<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SchoolSettingController extends Controller
{
    public function apiSetup()
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);
        return view('school.setting.api_setup', compact('school'));
    }

    public function updateApiSetup(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);

        $request->validate([
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'whatsapp_api_key' => 'nullable|string',
        ]);

        $school->update($request->only([
            'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 
            'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name',
            'whatsapp_api_provider', 'whatsapp_api_key', 'whatsapp_api_instance_id'
        ]));

        return back()->with('success', 'API settings updated successfully!');
    }

    public function requestProfessionalEmail(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);

        if ($school->pro_email_status !== 'none' && $school->pro_email_status !== 'rejected') {
            return back()->with('error', 'You already have a request in progress or approved.');
        }

        $request->validate([
            'prefix' => 'required|string|alpha_num|max:20',
        ]);

        $school->update([
            'pro_email_status' => 'pending',
            'pro_email_prefix' => strtolower($request->prefix)
        ]);

        return back()->with('success', 'Professional email request submitted successfully! Super Admin will review it.');
    }
}
