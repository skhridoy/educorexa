<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // ১. লগইন চেক
        if (!Auth::check()) {
            return redirect()->route('super.login.form');
        }

        $user = Auth::user();

        // ২. চেক করুন সে কি মেইন সুপার অ্যাডমিন নাকি এমপ্লয়ি
        // $user->role হলো আপনার users টেবিলের কলাম
        if ($user->role === 'super_admin' || $user->hasRole('HR') || $user->role === 'employee') {
            return $next($request);
        }

        // ৩. যদি কোনোটিই না হয় (যেমন student বা teacher ভুল করে এই লিঙ্কে আসলে)
        abort(403, 'Unauthorized access to Super Admin Panel.');
    }
}