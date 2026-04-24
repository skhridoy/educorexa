<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsTeacher
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $tenant = $request->route('tenant');

        // ১. ইউজার লগইন করা আছে কি না এবং স্প্যাটি অনুযায়ী টিচার কি না
        if ($user && $user->hasRole('teacher')) {
            
            // ২. সিকিউরিটি চেক: টিচারটি কি বর্তমান স্কুলের (Tenant) মেম্বার?
            // এটি নিশ্চিত করবে যে স্কুল-এ এর টিচার স্কুল-বি এর ইউআরএল-এ ঢুকতে পারবে না।
            if ($user->school && $user->school->slug === $tenant) {
                return $next($request);
            }
        }

        // ৩. অনুমতি না থাকলে রিডাইরেক্ট
        return redirect()->route('school.login.form', ['tenant' => $tenant])
                         ->with('error', 'আপনার এই পেজে ঢোকার অনুমতি নেই।');
    }
}