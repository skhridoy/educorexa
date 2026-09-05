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

        // Check Package Permissions
        if (!$school->hasPackagePermission('email.send') && ($request->filled('mail_host') || $request->filled('mail_username') || $request->filled('mail_password'))) {
            return back()->with('error', 'ইমেইল ও কাস্টম SMTP সেটআপ সুবিধাটি প্রিমিয়াম প্যাকেজে অন্তর্ভুক্ত। দয়া করে প্রিমিয়াম প্যাকেজ চালু করুন।');
        }

        if (!$school->hasPackagePermission('whatsapp.send') && ($request->filled('whatsapp_api_key') || $request->filled('whatsapp_api_instance_id'))) {
            return back()->with('error', 'WhatsApp গেটওয়ে সেটআপ সুবিধাটি প্রিমিয়াম প্যাকেজে অন্তর্ভুক্ত। দয়া করে প্রিমিয়াম প্যাকেজ চালু করুন।');
        }

        if (!$school->hasPackagePermission('sms.send') && ($request->filled('sms_api_provider') || $request->filled('sms_api_url') || $request->filled('sms_api_key'))) {
            return back()->with('error', 'SMS গেটওয়ে সেটআপ সুবিধাটি প্রিমিয়াম প্যাকেজে অন্তর্ভুক্ত। দয়া করে প্রিমিয়াম প্যাকেজ চালু করুন।');
        }

        $request->validate([
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'whatsapp_api_key' => 'nullable|string',
            'sms_api_provider' => 'nullable|in:generic,bulksmsbd,sslwireless',
            'sms_api_url' => 'nullable|url|max:255',
            'sms_api_key' => 'nullable|string',
            'sms_api_secret' => 'nullable|string',
            'sms_sender_id' => 'nullable|string|max:50',
            'inbound_webhook_secret' => 'nullable|string|max:255',
            'imap_host' => 'nullable|string|max:255',
            'imap_port' => 'nullable|integer|min:1|max:65535',
            'imap_username' => 'nullable|email|max:255',
            'imap_password' => 'nullable|string',
            'imap_encryption' => 'nullable|in:ssl,tls,none',
            'imap_folder' => 'nullable|string|max:100',
        ]);

        $school->update($request->only([
            'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 
            'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name',
            'whatsapp_api_provider', 'whatsapp_api_key', 'whatsapp_api_instance_id'
            , 'sms_api_provider', 'sms_api_url', 'sms_api_key', 'sms_api_secret', 'sms_sender_id'
            , 'imap_host', 'imap_port', 'imap_username', 'imap_encryption', 'imap_folder'
        ]));

        if ($request->filled('imap_password')) {
            $school->imap_password = $request->imap_password;
        }
        $school->imap_enabled = $request->boolean('imap_enabled');
        $school->imap_port = $request->imap_port ?: 993;
        $school->imap_encryption = $request->imap_encryption ?: 'ssl';
        $school->imap_folder = $request->imap_folder ?: 'INBOX';

        if ($request->filled('inbound_webhook_secret')) {
            $school->inbound_webhook_secret = $request->inbound_webhook_secret;
        }
        $school->inbound_webhook_enabled = $request->boolean('inbound_webhook_enabled');
        $school->save();

        return back()->with('success', 'API settings updated successfully!');
    }

    public function requestProfessionalEmail(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $school = School::findOrFail($schoolId);

        if (!$school->hasPackagePermission('email.send')) {
            return back()->with('error', 'প্রফেশনাল ডোমেন ইমেইল সুবিধাটি প্রিমিয়াম প্যাকেজে অন্তর্ভুক্ত। দয়া করে প্রিমিয়াম প্যাকেজ চালু করুন।');
        }

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
            ],
            'result_published' => [
                'title' => 'Exam Result Published',
                'icon' => 'fa-graduation-cap',
                'color' => 'success',
                'description' => 'Notify guardians when an exam result is published.',
                'variables' => ['[student_name]', '[exam_name]', '[school_name]'],
                'defaults' => [
                    'email' => "Dear [student_name],\n\nThe result for [exam_name] has been published. Please check the student portal.\n\nRegards,\n[school_name]",
                    'sms' => "Result for [exam_name] of [student_name] has been published. Please check the portal. - [school_name]",
                    'whatsapp' => "Dear [student_name],\nThe result for [exam_name] has been published. Please check the portal.\n- [school_name]"
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
        $canSendWhatsapp = $school->hasPackagePermission('whatsapp.send');

        $setting = \App\Models\CommunicationSetting::where('school_id', $schoolId)
                    ->where('event', $request->event)
                    ->firstOrFail();

        $setting->update([
            'email_enabled' => $canSendEmail ? $request->has('email_enabled') : false,
            'sms_enabled' => $canSendSms ? $request->has('sms_enabled') : false,
            'whatsapp_enabled' => $canSendWhatsapp ? $request->has('whatsapp_enabled') : false,
            'email_template' => $request->email_template,
            'sms_template' => $request->sms_template,
            'whatsapp_template' => $request->whatsapp_template,
        ]);

        return response()->json(['success' => true, 'message' => 'Communication settings updated successfully!']);
    }
}
