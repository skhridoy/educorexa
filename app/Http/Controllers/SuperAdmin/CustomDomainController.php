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
        ];

        return view('super.custom-domain.index', compact('schools', 'stats'));
    }

    /**
     * একটি Domain রিকোয়েস্ট Approve করো (১ বছর মেয়াদ সহ)
     */
    public function approve(Request $request, School $school)
    {
        if ($school->custom_domain_status !== 'pending') {
            return back()->with('error', 'শুধুমাত্র Pending রিকোয়েস্ট Approve করা যাবে।');
        }

        $school->update([
            'custom_domain_status'         => 'verified',
            'custom_domain_verified_at'    => now(),
            'custom_domain_expires_at'     => now()->addYear(),
            'custom_domain_payment_status' => 'paid',
            'custom_domain_ssl_status'     => 'active',
            'custom_domain_reject_reason'  => null,
        ]);

        // School Admin-কে নোটিফিকেশন
        $schoolAdmin = $school->admin;
        if ($schoolAdmin) {
            $schoolAdmin->notify(new \App\Notifications\CustomDomainStatusChanged($school, 'verified'));
        }

        return back()->with('success', '"' . $school->custom_domain . '" ডোমেইন সফলভাবে Approve করা হয়েছে (মেয়াদ: ' . now()->addYear()->format('d M, Y') . ' পর্যন্ত)।');
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
     * Verified Domain Disable করো
     */
    public function disable(School $school)
    {
        if ($school->custom_domain_status !== 'verified') {
            return back()->with('error', 'শুধুমাত্র Verified ডোমেইন Disable করা যাবে।');
        }

        $school->update([
            'custom_domain_status'     => 'disabled',
            'custom_domain_ssl_status' => null,
        ]);

        return back()->with('success', '"' . $school->custom_domain . '" ডোমেইন Disable করা হয়েছে।');
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
