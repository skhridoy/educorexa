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

    // ═══════════════════════════════════════════════════
    // Custom Domain Management
    // ═══════════════════════════════════════════════════

    /**
     * Custom Domain সেটআপ পেজ দেখাও
     */
    public function domainSetup()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $school = \App\Models\School::with('subscriptionPackage')->findOrFail($schoolId);
        $setting = \App\Models\SiteSetting::first() ?? new \App\Models\SiteSetting();

        $isFeeIncluded = $school->isCustomDomainFeeIncluded();
        $yearlyFee = $school->getCustomDomainYearlyFee();

        return view('school.setting.domain', compact('school', 'setting', 'isFeeIncluded', 'yearlyFee'));
    }

    /**
     * Custom Domain সংযুক্ত করার রিকোয়েস্ট সাবমিট করো (পেমেন্ট তথ্য সহ)
     */
    public function submitDomainRequest(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $school = \App\Models\School::with('subscriptionPackage')->findOrFail($schoolId);

        // ইতিমধ্যে verified বা pending থাকলে নতুন রিকোয়েস্ট করা যাবে না
        if (in_array($school->custom_domain_status, ['verified', 'pending'])) {
            return back()->with('error', 'আপনার ডোমেইন রিকোয়েস্ট ইতিমধ্যে ' . $school->custom_domain_status . ' অবস্থায় আছে।');
        }

        // ডোমেইন ইনপুট স্যানিটাইজ করা (http://, https://, trailing slash সরানো)
        $cleanDomain = strtolower(trim($request->custom_domain ?? ''));
        $cleanDomain = preg_replace('#^https?://#i', '', $cleanDomain);
        $cleanDomain = preg_replace('#/.*$#', '', $cleanDomain);
        $request->merge(['custom_domain' => $cleanDomain]);

        $isFeeIncluded = $school->isCustomDomainFeeIncluded();
        $yearlyFee = $school->getCustomDomainYearlyFee();

        $validationRules = [
            'custom_domain' => [
                'required',
                'string',
                'max:253',
                'regex:/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/',
                \Illuminate\Validation\Rule::unique('schools', 'custom_domain')->ignore($school->id),
            ],
        ];

        $validationMessages = [
            'custom_domain.required' => 'ডোমেইন নাম আবশ্যক।',
            'custom_domain.regex'    => 'সঠিক ডোমেইন ফরম্যাট দিন (যেমন: school.example.com বা myschool.edu.bd)',
            'custom_domain.unique'   => 'এই ডোমেইনটি ইতিমধ্যে অন্য স্কুলে ব্যবহৃত হচ্ছে।',
        ];

        // যদি প্যাকেজে অন্তর্ভুক্ত না থাকে, তবে বাৎসরিক সার্ভার ফি পেমেন্ট তথ্য আবশ্যক
        if (!$isFeeIncluded && $yearlyFee > 0) {
            $validationRules['payment_method'] = 'required|in:bkash,nagad,bank';
            $validationRules['sender_number']  = 'required|string|max:50';
            $validationRules['trx_id']         = 'required|string|max:100';

            $validationMessages['payment_method.required'] = 'পেমেন্ট মেথড নির্বাচন করুন।';
            $validationMessages['payment_method.in']       = 'সঠিক পেমেন্ট মেথড নির্বাচন করুন (bKash, Nagad বা Bank)।';
            $validationMessages['sender_number.required']  = 'যে নম্বর বা অ্যাকাউন্ট থেকে পেমেন্ট করেছেন তা লিখুন।';
            $validationMessages['trx_id.required']         = 'TrxID / ট্রানজেকশন আইডি আবশ্যক।';
        }

        $request->validate($validationRules, $validationMessages);

        $domain = $cleanDomain;

        // মূল ডোমেইন (app.main_domain) ব্লক করো
        $mainDomain = config('app.main_domain');
        if ($domain === $mainDomain || str_ends_with($domain, '.' . $mainDomain)) {
            return back()->with('error', 'মূল সিস্টেম ডোমেইন বা সাবডোমেইন কাস্টম ডোমেইন হিসেবে ব্যবহার করা যাবে না।');
        }

        $updateData = [
            'custom_domain'               => $domain,
            'custom_domain_status'        => 'pending',
            'custom_domain_reject_reason' => null,
            'custom_domain_verified_at'   => null,
            'custom_domain_ssl_status'    => 'pending',
        ];

        if (!$isFeeIncluded && $yearlyFee > 0) {
            $updateData['custom_domain_payment_method'] = $request->payment_method;
            $updateData['custom_domain_payment_sender'] = $request->sender_number;
            $updateData['custom_domain_payment_trx_id'] = strtoupper(trim($request->trx_id));
            $updateData['custom_domain_payment_amount'] = $yearlyFee;
            $updateData['custom_domain_payment_status'] = 'pending';
        } else {
            $updateData['custom_domain_payment_method'] = 'package_included';
            $updateData['custom_domain_payment_sender'] = null;
            $updateData['custom_domain_payment_trx_id'] = 'PACKAGE_INCLUDED';
            $updateData['custom_domain_payment_amount'] = 0.00;
            $updateData['custom_domain_payment_status'] = 'paid';
        }

        $school->update($updateData);

        // Super Admin-কে নোটিফিকেশন
        $superAdmins = \App\Models\User::where('role', 'super_admin')->get();
        foreach ($superAdmins as $admin) {
            $admin->notify(new \App\Notifications\CustomDomainRequested($school));
        }

        $msg = $isFeeIncluded 
            ? 'কাস্টম ডোমেইন রিকোয়েস্ট সফলভাবে জমা হয়েছে! সুপার এডমিন শীঘ্রই রিভিউ করে সক্রিয় করবেন।' 
            : 'কাস্টম ডোমেইন রিকোয়েস্ট ও পেমেন্ট তথ্য সফলভাবে জমা হয়েছে! সুপার এডমিন পেমেন্ট যাচাই করে ডোমেইন সক্রিয় করবেন।';

        return back()->with('success', $msg);
    }

    /**
     * Pending বা rejected ডোমেইন রিকোয়েস্ট বাতিল করো (school admin)
     */
    public function cancelDomainRequest()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $school = \App\Models\School::findOrFail($schoolId);

        if ($school->custom_domain_status === 'verified') {
            return back()->with('error', 'ভেরিফাইড ডোমেইন বাতিল করতে সুপার এডমিনের সাথে যোগাযোগ করুন।');
        }

        $school->update([
            'custom_domain'                => null,
            'custom_domain_status'         => 'none',
            'custom_domain_reject_reason'  => null,
            'custom_domain_verified_at'    => null,
            'custom_domain_ssl_status'     => null,
            'custom_domain_payment_method' => null,
            'custom_domain_payment_sender' => null,
            'custom_domain_payment_trx_id' => null,
            'custom_domain_payment_amount' => null,
            'custom_domain_payment_status' => 'unpaid',
        ]);

        return back()->with('success', 'ডোমেইন রিকোয়েস্ট বাতিল করা হয়েছে।');
    }

    /**
     * DNS রেকর্ড চেক করো (School Admin লাইভ চেক)
     */
    public function checkDns(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;
        $school = \App\Models\School::findOrFail($schoolId);

        $domain = strtolower(trim($request->domain ?? ''));
        if (!$domain) {
            $domain = $school->custom_domain;
        }

        if (!$domain) {
            return response()->json(['success' => false, 'message' => 'কোনো ডোমেইন নির্ধারণ করা হয়নি।'], 422);
        }

        // Clean domain
        $domain = preg_replace('#^https?://#i', '', $domain);
        $domain = preg_replace('#/.*$#', '', $domain);

        $serverIp = config('app.server_ip') ?: '127.0.0.1';
        $mainDomain = config('app.main_domain', 'educorexa.com');

        $resolvedIps = [];
        $cnameTargets = [];

        // Fetch A records
        $recordsA = @dns_get_record($domain, DNS_A) ?: [];
        foreach ($recordsA as $rec) {
            if (!empty($rec['ip'])) {
                $resolvedIps[] = $rec['ip'];
            }
        }

        // Fetch CNAME records
        $recordsCname = @dns_get_record($domain, DNS_CNAME) ?: [];
        foreach ($recordsCname as $rec) {
            if (!empty($rec['target'])) {
                $cnameTargets[] = $rec['target'];
            }
        }

        // Fallback gethostbyname
        $directIp = @gethostbyname($domain);
        if ($directIp && $directIp !== $domain && !in_array($directIp, $resolvedIps)) {
            $resolvedIps[] = $directIp;
        }

        $isIpMatched = in_array($serverIp, $resolvedIps);
        $isCnameMatched = false;
        foreach ($cnameTargets as $target) {
            if (str_contains(strtolower($target), strtolower($mainDomain))) {
                $isCnameMatched = true;
                break;
            }
        }

        $isConfigured = $isIpMatched || $isCnameMatched;

        return response()->json([
            'success'       => true,
            'domain'        => $domain,
            'server_ip'     => $serverIp,
            'main_domain'   => $mainDomain,
            'resolved_ips'  => $resolvedIps,
            'cname_targets' => $cnameTargets,
            'is_configured' => $isConfigured,
            'message'       => $isConfigured
                ? '✅ চমৎকার! আপনার ডোমেইনটি সার্ভারের সাথে সফলভাবে সংযুক্ত হয়েছে।'
                : '⏳ এখনও DNS সার্ভারে পয়েন্ট করেনি। DNS আপডেটে সাধারণত ৫ মিনিট থেকে ২৪ ঘণ্টা সময় লাগতে পারে।'
        ]);
    }
}
