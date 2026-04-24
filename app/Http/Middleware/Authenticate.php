<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // ১. সুপার এডমিন চেক
            if ($request->is('super-admin') || $request->is('super-admin/*')) {
                return route('login.form');
            }

            // ২. টেন্যান্ট চেক (সাবডোমেইন বা রুট প্যারামিটার থেকে)
            $tenant = $request->route('tenant') ?? explode('.', $request->getHost())[0];

            // যদি টেন্যান্ট প্যারামিটার থাকে বা সাবডোমেইন হিসেবে থাকে
            if ($tenant && !in_array($tenant, ['www', 'educorexa.com'])) {
                return route('school.login.form', ['tenant' => $tenant]);
            }

            return route('login.form'); // ডিফল্ট সুপার এডমিন লগইন
        }
        
        return null;
    }
}