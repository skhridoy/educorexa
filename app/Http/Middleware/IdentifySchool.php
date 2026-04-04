<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\School;

class IdentifySchool
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $mainDomain = config('app.main_domain', 'schoolerp.test');

        $subdomain = str_replace('.' . $mainDomain, '', $host);

        // ১. মেন ডোমেইন হলে এড়িয়ে যান (যেমন: schoolerp.test)
        if ($host === $mainDomain) {
            return $next($request);
        }

        // ২. স্কুল খুঁজুন
        $school = School::where('slug', $subdomain)->first();

        // ৩. স্কুল না থাকলে বা ইনঅ্যাক্টিভ হলে সুনির্দিষ্ট এরর দিন
        if (!$school) abort(404, 'School not found');
        
        if ($school->status !== 'approved' || !$school->is_active) {
            abort(403, 'This school is not approved or is currently inactive.');
        }

        // ৪. গ্লোবালি শেয়ার করুন
        app()->instance('currentSchool', $school);
        view()->share('currentSchool', $school);

        // ৫. রিকোয়েস্টে স্কুল আইডি ঢুকিয়ে দিন যাতে কন্ট্রোলারে $request->school_id পাওয়া যায়
        $request->merge(['school_id' => $school->id]);

        return $next($request);
    }
}
