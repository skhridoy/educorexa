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
        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        // ৩. আপনার কনসেপ্ট অনুযায়ী এমপ্লয়িদের (HR, Marketing, etc.) এক্সেস দিন
        // আমরা এখানে চেক করছি রোলটির role_type 'employee' কি না
        $role = $user->roles()->first(); 
        if ($role && $role->role_type === 'employee') {
            return $next($request);
        }

        // ৪. যদি কোনোটিই না হয় (যেমন স্কুলের টিচার/স্টুডেন্ট ভুল করে ঢুকলে)
        Auth::logout(); // সিকিউরিটির জন্য সেশন ক্লিয়ার করে দেওয়া ভালো
        abort(403, 'Unauthorized access to Central Admin Panel.');
    }
}