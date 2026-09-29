<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\URL; // ১. URL ফাসাদ ইমপোর্ট করা জরুরি

class IdentifySchool
{
    public function handle(Request $request, Closure $next)
    {
        $host = strtolower($request->getHost());
        $dbMainDomain = \Illuminate\Support\Facades\Schema::hasTable('site_settings') 
            ? \App\Models\SiteSetting::value('main_domain') 
            : null;
        $mainDomain = strtolower($dbMainDomain ?: config('app.main_domain', 'educorexa.com'));
        if ($mainDomain === 'schoolerp.test' || empty($mainDomain)) {
            $mainDomain = 'educorexa.com';
        }

        $bareHost = preg_replace('/^www\./i', '', $host);
        $bareMainDomain = preg_replace('/^www\./i', '', $mainDomain);

        // ২. মেইন ডোমেইন (www সহ বা ছাড়া) হলে এড়িয়ে যান
        if ($bareHost === $bareMainDomain) {
            return $next($request);
        }

        $school = null;
        $isCustomDomain = false;

        // সাবডোমেইন চেক (যেমন: school1.educorexa.com)
        if (str_ends_with($bareHost, '.' . $bareMainDomain)) {
            $subdomain = str_replace('.' . $bareMainDomain, '', $bareHost);
            $subdomain = preg_replace('/^www\./i', '', $subdomain);
            $school = School::where('slug', $subdomain)->first();

            // যদি এই স্কুলের ভেরিফাইড কাস্টম ডোমেইন থাকে, তবে সাবডোমেইন থেকে কাস্টম ডোমেইনে রিডাইরেক্ট করুন!
            if ($school && $school->hasVerifiedCustomDomain()) {
                $targetDomain = preg_replace('#^https?://#i', '', $school->custom_domain);
                $targetDomain = rtrim($targetDomain, '/');
                $scheme = $request->isSecure() ? 'https://' : 'http://';
                return redirect()->away($scheme . $targetDomain . $request->getRequestUri(), 301);
            }
        } else {
            // ৩. ভেরিফাইড কাস্টম ডোমেইন চেক (যেমন: myschool.edu.bd বা www.myschool.edu.bd)
            $wwwHost = 'www.' . $bareHost;

            $school = School::where(function ($q) use ($host, $bareHost, $wwwHost) {
                $q->whereIn('custom_domain', [$host, $bareHost, $wwwHost])
                  ->orWhere('custom_domain', 'like', '%' . $bareHost . '%');
            })
            ->where('custom_domain_status', 'verified')
            ->first();
            $isCustomDomain = true;

            // যদি কাস্টম ডোমেইন ভেরিফাইড না পাওয়া যায় কিন্তু পেন্ডিং/ডিজেবল্ড/রিজেক্টেড থাকে
            if (!$school) {
                $pendingOrOtherSchool = School::where(function ($q) use ($host, $bareHost, $wwwHost) {
                    $q->whereIn('custom_domain', [$host, $bareHost, $wwwHost])
                      ->orWhere('custom_domain', 'like', '%' . $bareHost . '%');
                })->first();

                if ($pendingOrOtherSchool) {
                    if ($pendingOrOtherSchool->custom_domain_status === 'disabled') {
                        // Disabled হলে সরাসরি সাবডোমেইনে 301 Redirect করুন
                        $scheme = $request->isSecure() ? 'https://' : 'http://';
                        $subdomainUrl = $scheme . $pendingOrOtherSchool->slug . '.' . $bareMainDomain . $request->getRequestUri();
                        return redirect()->away($subdomainUrl, 301);
                    } elseif ($pendingOrOtherSchool->custom_domain_status === 'pending') {
                        return response()->view('school.domain_status', [
                            'school'  => $pendingOrOtherSchool,
                            'status'  => 'pending',
                            'message' => 'Custom domain setup is pending verification by Super Admin.'
                        ], 503);
                    } elseif ($pendingOrOtherSchool->custom_domain_status === 'rejected') {
                        return response()->view('school.domain_status', [
                            'school'  => $pendingOrOtherSchool,
                            'status'  => 'rejected',
                            'message' => 'Custom domain request was rejected: ' . ($pendingOrOtherSchool->custom_domain_reject_reason ?? 'Please contact administration.')
                        ], 503);
                    }
                }
            } else {
                // মেয়াদোত্তীর্ণ চেক — মেয়াদ শেষ হলেও সাবডোমেইনে Redirect করুন
                if ($school->isCustomDomainExpired()) {
                    $scheme = $request->isSecure() ? 'https://' : 'http://';
                    $subdomainUrl = $scheme . $school->slug . '.' . $bareMainDomain . $request->getRequestUri();
                    return redirect()->away($subdomainUrl, 302);
                }
            }
        }

        // ৪. স্কুল না থাকলে বা ইনঅ্যাক্টিভ হলে এরর দিন
        if (!$school) abort(404, 'School not found');
        
        if ($school->status !== 'approved' || !$school->is_active) {
            abort(403, 'This school is not approved or is currently inactive.');
        }

        // ৫. URL Default সেট করা
        if ($isCustomDomain) {
            URL::defaults(['tenant' => $host]);
        } else {
            URL::defaults(['tenant' => $school->slug]);
        }

        // ৬. গ্লোবালি শেয়ার করুন
        app()->instance('currentSchool', $school);
        view()->share('currentSchool', $school);

        // ৭. রিকোয়েস্টে স্কুল আইডি ঢুকিয়ে দিন
        $request->merge(['school_id' => $school->id]);

        // ৮. যদি ইউজার লগইন করা থাকে এবং school_id না থাকে (যেমন সুপার এডমিন)
        if (auth()->check() && empty(auth()->user()->school_id)) {
            auth()->user()->school_id = $school->id;
        }

        return $next($request);
    }
}