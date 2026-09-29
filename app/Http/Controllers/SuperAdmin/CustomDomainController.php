<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class CustomDomainController extends Controller
{
    /**
     * সব Domain রিকোয়েস্ট তালিকা (Super Admin)
     */
    public function index(Request $request)
    {
        $query = School::query()
            ->whereNotNull('custom_domain')
            ->where('custom_domain_status', '!=', 'none')
            ->with(['admin', 'subscriptionPackage']);

        // ফিল্টার
        if ($request->filled('status')) {
            $query->where('custom_domain_status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('custom_domain', 'like', '%' . $request->search . '%');
            });
        }

        $schools = $query->latest('updated_at')->paginate(15)->withQueryString();

        $stats = [
            'pending'  => School::where('custom_domain_status', 'pending')->count(),
            'verified' => School::where('custom_domain_status', 'verified')->count(),
            'rejected' => School::where('custom_domain_status', 'rejected')->count(),
            'disabled' => School::where('custom_domain_status', 'disabled')->count(),
        ];

        return view('super.custom-domain.index', compact('schools', 'stats'));
    }

    /**
     * একটি Domain রিকোয়েস্ট Approve করো (১ বছর মেয়াদ সহ)
     */
    public function approve(Request $request, School $school)
    {
        if (!in_array($school->custom_domain_status, ['pending', 'disabled'])) {
            return back()->with('error', 'শুধুমাত্র Pending বা Disabled রিকোয়েস্ট Approve/Enable করা যাবে।');
        }

        // If re-enabling a disabled domain, preserve the old expiry if still in the future
        $isReEnable = $school->custom_domain_status === 'disabled';
        $expiresAt = ($isReEnable && $school->custom_domain_expires_at && $school->custom_domain_expires_at->isFuture())
            ? $school->custom_domain_expires_at
            : now()->addYear();

        $school->update([
            'custom_domain_status'         => 'verified',
            'custom_domain_verified_at'    => now(),
            'custom_domain_expires_at'     => $expiresAt,
            'custom_domain_payment_status' => 'paid',
            'custom_domain_ssl_status'     => 'active',
            'custom_domain_reject_reason'  => null,
        ]);

        // School Admin-কে নোটিফিকেশন
        $schoolAdmin = $school->admin;
        if ($schoolAdmin) {
            $schoolAdmin->notify(new \App\Notifications\CustomDomainStatusChanged($school, 'verified'));
        }

        $label = $isReEnable ? 'পুনরায় সক্রিয়' : 'Approve';
        return back()->with('success', '"' . $school->custom_domain . '" ডোমেইন সফলভাবে ' . $label . ' করা হয়েছে (মেয়াদ: ' . $expiresAt->format('d M, Y') . ' পর্যন্ত)।');
    }

    /**
     * ডোমেইনের মেয়াদ ১ বছর বৃদ্ধি (Renew / Extend 1 Year)
     */
    public function extend(School $school)
    {
        $currentExpiry = $school->custom_domain_expires_at && $school->custom_domain_expires_at->isFuture() 
            ? $school->custom_domain_expires_at 
            : now();

        $newExpiry = $currentExpiry->copy()->addYear();

        $school->update([
            'custom_domain_expires_at'     => $newExpiry,
            'custom_domain_payment_status' => 'paid',
            'custom_domain_status'         => 'verified',
        ]);

        return back()->with('success', '"' . $school->custom_domain . '" ডোমেইনের মেয়াদ ' . $newExpiry->format('d M, Y') . ' পর্যন্ত ১ বছর বাড়ানো হয়েছে।');
    }

    /**
     * একটি Domain রিকোয়েস্ট Reject করো
     */
    public function reject(Request $request, School $school)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:500',
        ], [
            'reject_reason.required' => 'Reject কারণ দেওয়া আবশ্যক।',
        ]);

        $school->update([
            'custom_domain_status'        => 'rejected',
            'custom_domain_reject_reason' => $request->reject_reason,
            'custom_domain_verified_at'   => null,
            'custom_domain_ssl_status'    => null,
        ]);

        // School Admin-কে নোটিফিকেশন
        $schoolAdmin = $school->admin;
        if ($schoolAdmin) {
            $schoolAdmin->notify(new \App\Notifications\CustomDomainStatusChanged($school, 'rejected'));
        }

        return back()->with('success', '"' . $school->custom_domain . '" ডোমেইন রিকোয়েস্ট Reject করা হয়েছে।');
    }

    /**
     * Verified Domain Disable করো (সাবডোমেইনে ফলব্যাক হবে)
     */
    public function disable(School $school)
    {
        if ($school->custom_domain_status !== 'verified') {
            return back()->with('error', 'শুধুমাত্র Verified ডোমেইন Disable করা যাবে।');
        }

        $school->update([
            'custom_domain_status'     => 'disabled',
            'custom_domain_ssl_status' => null,
            // expiry ধরে রাখুন যাতে পরে re-enable করলে পুরনো মেয়াদ বজায় থাকে
        ]);

        // School Admin-কে নোটিফিকেশন
        $schoolAdmin = $school->admin;
        if ($schoolAdmin) {
            $schoolAdmin->notify(new \App\Notifications\CustomDomainStatusChanged($school, 'disabled'));
        }

        return back()->with('success', '"' . $school->custom_domain . '" ডোমেইন Disable করা হয়েছে। স্কুল এখন সাবডোমেইন (' . $school->slug . '.' . config('app.main_domain', 'educorexa.com') . ') থেকে অ্যাক্সেসযোগ্য।');
    }

    /**
     * Disabled Domain পুনরায় Enable করো
     */
    public function enable(School $school)
    {
        if ($school->custom_domain_status !== 'disabled') {
            return back()->with('error', 'শুধুমাত্র Disabled ডোমেইন Enable করা যাবে।');
        }

        // পুরানো মেয়াদ ভবিষ্যতে থাকলে সেটা রাখুন, অন্যথায় ১ বছর বাড়ান
        $expiresAt = ($school->custom_domain_expires_at && $school->custom_domain_expires_at->isFuture())
            ? $school->custom_domain_expires_at
            : now()->addYear();

        $school->update([
            'custom_domain_status'      => 'verified',
            'custom_domain_ssl_status'  => 'active',
            'custom_domain_expires_at'  => $expiresAt,
            'custom_domain_verified_at' => now(),
        ]);

        // School Admin-কে নোটিফিকেশন
        $schoolAdmin = $school->admin;
        if ($schoolAdmin) {
            $schoolAdmin->notify(new \App\Notifications\CustomDomainStatusChanged($school, 'verified'));
        }

        return back()->with('success', '"' . $school->custom_domain . '" ডোমেইন পুনরায় সক্রিয় করা হয়েছে (মেয়াদ: ' . $expiresAt->format('d M, Y') . ' পর্যন্ত)।');
    }

    /**
     * Domain সম্পূর্ণ রিসেট করো (Super Admin force remove)
     */
    public function reset(School $school)
    {
        $oldDomain = $school->custom_domain;

        $school->update([
            'custom_domain'               => null,
            'custom_domain_status'        => 'none',
            'custom_domain_reject_reason' => null,
            'custom_domain_verified_at'   => null,
            'custom_domain_ssl_status'    => null,
        ]);

        return back()->with('success', '"' . $oldDomain . '" ডোমেইন সম্পূর্ণ রিসেট করা হয়েছে।');
    }

    /**
     * Check DNS resolution for a school custom domain (Super Admin live check)
     */
    public function checkDns(School $school)
    {
        $domain = $school->custom_domain;
        if (!$domain) {
            return response()->json(['success' => false, 'message' => 'No custom domain set for this school.'], 422);
        }

        $domain = strtolower(trim($domain));
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
            'school_name'   => $school->name,
            'domain'        => $domain,
            'server_ip'     => $serverIp,
            'main_domain'   => $mainDomain,
            'resolved_ips'  => $resolvedIps,
            'cname_targets' => $cnameTargets,
            'is_configured' => $isConfigured,
            'message'       => $isConfigured 
                ? 'DNS records match server IP (' . $serverIp . ') or CNAME target.' 
                : 'DNS does not point to target server IP (' . $serverIp . ').'
        ]);
    }
}
