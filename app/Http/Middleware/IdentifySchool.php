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
        $mainDomain = strtolower(config('app.main_domain', 'schoolerp.test'));

        // ২. মেইন ডোমেইন হলে এড়িয়ে যান
        if ($host === $mainDomain) {
            return $next($request);
        }

        $school = null;
        $isCustomDomain = false;

        // সাবডোমেইন চেক (যেমন: school1.schoolerp.test)
        if (str_ends_with($host, '.' . $mainDomain)) {
            $subdomain = str_replace('.' . $mainDomain, '', $host);
            // Handle possible www. prefix on subdomain
            $subdomain = preg_replace('/^www\./', '', $subdomain);
            $school = School::where('slug', $subdomain)->first();
        } else {
            // ৩. ভেরিফাইড কাস্টম ডোমেইন চেক (যেমন: myschool.edu.bd বা www.myschool.edu.bd)
            $bareHost = preg_replace('/^www\./', '', $host);
            $wwwHost = 'www.' . $bareHost;

            $school = School::whereIn('custom_domain', [$host, $bareHost, $wwwHost])
                ->where('custom_domain_status', 'verified')
                ->first();
            $isCustomDomain = true;

            // যদি কাস্টম ডোমেইন ভেরিফাইড না পাওয়া যায় কিন্তু পেন্ডিং/ডিজেবল্ড থাকে
            if (!$school) {
                $pendingOrOtherSchool = School::whereIn('custom_domain', [$host, $bareHost, $wwwHost])->first();
                if ($pendingOrOtherSchool) {
                    if ($pendingOrOtherSchool->custom_domain_status === 'pending') {
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
                    } elseif ($pendingOrOtherSchool->custom_domain_status === 'disabled') {
                        return response()->view('school.domain_status', [
                            'school'  => $pendingOrOtherSchool,
                            'status'  => 'disabled',
                            'message' => 'This custom domain is currently disabled.'
                        ], 503);
                    }
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