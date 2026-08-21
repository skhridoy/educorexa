<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            $host = $request->getHost();
            $mainDomain = config('app.main_domain', 'schoolerp.test');

            // ১. সুপার এডমিন বা সেন্ট্রাল ম্যানেজমেন্ট চেক
            if ($request->is('super-admin') || $request->is('super-admin/*') || $request->is('manage/*') || $host === $mainDomain || $host === 'www.' . $mainDomain) {
                return route('login.form');
            }

            // ২. টেন্যান্ট চেক (সাবডোমেইন বা রুট প্যারামিটার থেকে)
            $tenant = $request->route('tenant');
            if (!$tenant && str_contains($host, '.' . $mainDomain)) {
                $tenant = str_replace('.' . $mainDomain, '', $host);
            }

            if ($tenant && !in_array($tenant, ['www', $mainDomain])) {
                return route('school.login.form', ['tenant' => $tenant]);
            }

            return route('login.form'); // ডিফল্ট সুপার এডমিন লগইন
        }
        
        return null;
    }
}