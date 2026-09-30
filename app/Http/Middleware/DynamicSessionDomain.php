<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DynamicSessionDomain
{
    /**
     * Handle an incoming request.
     * Ensure session cookies and stateful domain work properly across main domain, subdomains, and custom domains.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $host = strtolower($request->getHost());
        $dbMainDomain = \Illuminate\Support\Facades\Schema::hasTable('site_settings') 
            ? \App\Models\SiteSetting::value('main_domain') 
            : null;
        $mainDomain = strtolower($dbMainDomain ?: config('app.main_domain', 'educorexa.com'));
        if ($mainDomain === 'schoolerp.test' || empty($mainDomain)) {
            $mainDomain = 'educorexa.com';
        }

        $bareHost = preg_replace('/^www\./i', '', $host);
        $bareMainDomain = preg_replace('/^www\./i', '', $mainDomain);

        // ১. যদি এটি একদম মেইন ডোমেইন হয় (যেমন educorexa.com বা www.educorexa.com)
        if ($bareHost === $bareMainDomain) {
            config(['session.domain' => $bareMainDomain]);
        } 
        // ২. যদি এটি সাবডোমেইন হয় (যেমন school1.educorexa.com)
        elseif (str_ends_with($bareHost, '.' . $bareMainDomain)) {
            // সাবডোমেইনের সেশন কুকি ওই নির্দিষ্ট সাবডোমেইনে সীমাবদ্ধ রাখতে $host বা null দিন
            // এতে মেইন ডোমেইন ও সাবডোমেইনের সেশন কনফ্লিক্ট করবে না এবং 404 দেখাবে না
            config(['session.domain' => $host]);
        } 
        // ৩. যদি এটি কাস্টম ডোমেইন হয় (যেমন myschool.edu.bd)
        else {
            config(['session.domain' => null]);

            // Also append custom host to sanctum stateful domains if sanctum is used
            $stateful = config('sanctum.stateful', []);
            if (is_array($stateful) && !in_array($host, $stateful)) {
                $stateful[] = $host;
                config(['sanctum.sanctum.stateful' => $stateful]); // সঠিক কনফিগ কী বা ঠিক রাখা
            }
        }

        return $next($request);
    }
}