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
        $host = $request->getHost();
        $mainDomain = config('app.main_domain', 'schoolerp.test');

        // ২. মেন ডোমেইন হলে এড়িয়ে যান
        if ($host === $mainDomain) {
            return $next($request);
        }

        $subdomain = str_replace('.' . $mainDomain, '', $host);

        // ৩. স্কুল খুঁজুন
        $school = School::where('slug', $subdomain)->first();

        // ৪. স্কুল না থাকলে বা ইনঅ্যাক্টিভ হলে এরর দিন
        if (!$school) abort(404, 'School not found');
        
        if ($school->status !== 'approved' || !$school->is_active) {
            abort(403, 'This school is not approved or is currently inactive.');
        }

        // ৫. URL Default সেট করা (এটি স্কুল পাওয়ার পর এবং $next এর আগে হতে হবে)
        // রাউট প্যারামিটার থেকে 'tenant' নিয়ে সেটি ডিফল্ট হিসেবে সেট করে দিন
        URL::defaults(['tenant' => $subdomain]);

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