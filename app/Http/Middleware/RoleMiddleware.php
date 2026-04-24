<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // ১. যদি ইউজার লগইন করা না থাকে
        if (!Auth::check()) {
            if ($request->is('super-admin') || $request->is('super-admin/*')) {
                return redirect()->route('login.form'); // মেইন লগইন
            }

            if ($request->route('tenant')) {
                return redirect()->route('school.login.form', ['tenant' => $request->route('tenant')]);
            }

            return redirect('/');
        }

        // ২. টেন্যান্ট সিকিউরিটি চেক (খুবই গুরুত্বপূর্ণ)
        // নিশ্চিত করা যে স্কুলের স্টাফ শুধু তার নিজের স্কুলের স্লাগেই এক্সেস পাচ্ছে
        $routeTenant = $request->route('tenant');
        if ($routeTenant && $user->school) {
            if ($user->school->slug !== $routeTenant && !$user->hasRole('super_admin')) {
                Auth::logout();
                return redirect()->route('school.login.form', ['tenant' => $routeTenant])
                                 ->withErrors(['email' => 'আপনি এই স্কুলের মেম্বার নন।']);
            }
        }

        // ৩. Spatie Role Check
        // আপনার সিস্টেমে একাধিক রোল থাকতে পারে, তাই hasAnyRole ব্যবহার করা ভালো
        if (!$user->hasAnyRole($roles)) {
            abort(403, 'আপনার এই পেজে প্রবেশের অনুমতি নেই।');
        }

        return $next($request);
    }
}