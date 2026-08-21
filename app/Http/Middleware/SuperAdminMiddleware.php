<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // ১. ইউজার লগইন করা আছে কি না চেক করুন
        if (!Auth::check()) {
            return redirect()->route('login.form'); // আপনার মেইন ডোমেইন লগইন রাউট
        }

        $user = Auth::user();

        // ২. সুপার অ্যাডমিন হলে সরাসরি এক্সেস দিন
        if ($user->hasRole('super_admin') || $user->role === 'super_admin') {
            return $next($request);
        }

        // ৩. আপনার কনসেপ্ট অনুযায়ী এমপ্লয়িদের (HR, Marketing, etc.) এক্সেস দিন
        // আমরা এখানে চেক করছি রোলটির role_type 'employee' কি না
        $role = $user->roles()->first(); 
        if ($role && $role->role_type === 'employee') {
            return $next($request);
        }

        // ৪. যদি স্কুলের ইউজার (school_admin, teacher, student) হয়, তবে তাদের স্কুল প্যানেলে রিডাইরেক্ট করুন
        if ($user->hasRole('school_admin') || $user->role === 'school_admin') {
            $tenant = $user->school?->slug;
            if ($tenant) {
                return redirect()->route('school.dashboard', ['tenant' => $tenant])
                    ->with('error', 'আপনার সেন্ট্রাল সুপার এডমিন প্যানেলে প্রবেশের অনুমতি নেই।');
            }
        } elseif ($user->hasRole('teacher') || $user->role === 'teacher') {
            $tenant = $user->school?->slug;
            if ($tenant) {
                return redirect()->route('teacher.dashboard', ['tenant' => $tenant]);
            }
        } elseif ($user->hasRole('student') || $user->role === 'student') {
            $tenant = $user->school?->slug;
            if ($tenant) {
                return redirect()->route('student.dashboard', ['tenant' => $tenant]);
            }
        }

        // ৫. যদি কোনোটিই না হয় (সিকিউরিটির জন্য সেশন ক্লিয়ার করে দেওয়া)
        Auth::logout();
        abort(403, 'Unauthorized access to Central Admin Panel.');
    }
}