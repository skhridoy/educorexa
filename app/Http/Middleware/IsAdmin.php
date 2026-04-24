<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $tenant = $request->route('tenant');

        // ১. ইউজার লগইন আছে কি না এবং সে কি স্কুল অ্যাডমিন?
        // Spatie এর hasRole ব্যবহার করা হচ্ছে (আপনার সিডারের সাথে মিল রেখে)
        if ($user && $user->hasRole('school_admin')) {
            
            // ২. টেন্যান্ট প্রোটেকশন: 
            // নিশ্চিত করা যে এই অ্যাডমিন শুধুমাত্র তার নিজের স্কুলের স্লাগেই এক্সেস পাচ্ছে
            if ($user->school && $user->school->slug === $tenant) {
                return $next($request);
            }
        }

        // ৩. সুপার অ্যাডমিন কি এই পেজ দেখতে পারবে? 
        // যদি আপনি চান সুপার অ্যাডমিনও স্কুল অ্যাডমিনের পেজ দেখবে, তবে এই চেকটি যোগ করতে পারেন:
        if ($user && $user->hasRole('super_admin')) {
            return $next($request);
        }

        // ৪. অনুমতি না থাকলে রিডাইরেক্ট
        return redirect()->route('school.login.form', ['tenant' => $tenant])
                         ->with('error', 'আপনার এই পেজে প্রবেশের অনুমতি নেই।');
    }
}