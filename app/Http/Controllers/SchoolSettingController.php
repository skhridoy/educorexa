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

    public function communicationSetup()
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);
        
        $events = [
            'fee_reminder' => [
                'title' => 'Fee Payment Reminder',
                'icon' => 'fa-money-bill-wave',
                'color' => 'primary',
                'description' => 'Send automatic reminders to students with unpaid fees.',
                'variables' => ['[student_name]', '[fee_amount]', '[month]', '[fee_name]', '[school_name]'],
                'defaults' => [
                    'email' => "Dear [student_name],\n\nThis is a friendly reminder that your [fee_name] for the month of [month] amounting to ৳[fee_amount] is currently unpaid.\n\nPlease pay at your earliest convenience.\n\nThank you,\n[school_name]",
                    'sms' => "Dear [student_name], your [fee_name] of ৳[fee_amount] for [month] is unpaid. Please pay soon. - [school_name]",
                    'whatsapp' => "Dear [student_name],\nYour [fee_name] of ৳[fee_amount] for [month] is unpaid.\nPlease pay soon.\n- [school_name]"
                ]
            ],
            'attendance' => [
                'title' => 'Daily Attendance Alert',
                'icon' => 'fa-calendar-check',
                'color' => 'info',
                'description' => 'Notify parents when a student is marked absent or present.',
                'variables' => ['[student_name]', '[date]', '[status]', '[school_name]'],
                'defaults' => [
                    'email' => "Dear Parent,\n\nYour child [student_name] was marked [status] today ([date]).\n\nRegards,\n[school_name]",
                    'sms' => "Dear Parent, [student_name] is [status] today ([date]). - [school_name]",
                    'whatsapp' => "Dear Parent,\n[student_name] is [status] today ([date]).\n- [school_name]"
                ]
            ],
            'notice' => [
                'title' => 'General Notice',
                'icon' => 'fa-bullhorn',
                'color' => 'warning',
                'description' => 'Send important school announcements and notices.',
                'variables' => ['[student_name]', '[notice_title]', '[school_name]'],
                'defaults' => [
                    'email' => "Dear [student_name],\n\nNotice: [notice_title]\n\nPlease check the portal for more details.\n\nRegards,\n[school_name]",
                    'sms' => "Notice: [notice_title]. Check portal for details. - [school_name]",
                    'whatsapp' => "Dear [student_name],\n*Notice:* [notice_title]\nPlease check the portal for details.\n- [school_name]"
                ]
            ]
        ];

        $settings = [];
        foreach ($events as $key => $eventData) {
            $settings[$key] = \App\Models\CommunicationSetting::firstOrCreate(
                ['school_id' => $schoolId, 'event' => $key],
                [
                    'email_enabled' => false,
                    'sms_enabled' => false,
                    'whatsapp_enabled' => false,
                    'email_template' => $eventData['defaults']['email'],
                    'sms_template' => $eventData['defaults']['sms'],
                    'whatsapp_template' => $eventData['defaults']['whatsapp']
                ]
            );
        }

        return view('school.setting.communication', compact('school', 'events', 'settings'));
    }

    public function updateCommunicationSetup(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);

        $request->validate([
            'event' => 'required|string',
            'email_template' => 'nullable|string',
            'sms_template' => 'nullable|string',
            'whatsapp_template' => 'nullable|string',
        ]);

        // Check Permissions
        $canSendEmail = $school->hasPackagePermission('email.send');
        $canSendSms = $school->hasPackagePermission('sms.send');

        $setting = \App\Models\CommunicationSetting::where('school_id', $schoolId)
                    ->where('event', $request->event)
                    ->firstOrFail();

        $setting->update([
            'email_enabled' => $canSendEmail ? $request->has('email_enabled') : false,
            'sms_enabled' => $canSendSms ? $request->has('sms_enabled') : false,
            'whatsapp_enabled' => $canSendSms ? $request->has('whatsapp_enabled') : false,
            'email_template' => $request->email_template,
            'sms_template' => $request->sms_template,
            'whatsapp_template' => $request->whatsapp_template,
        ]);

        return response()->json(['success' => true, 'message' => 'Communication settings updated successfully!']);
    }
}
