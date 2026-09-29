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

        // If it's the main domain or a subdomain of the main domain:
        if ($bareHost === $bareMainDomain || str_ends_with($bareHost, '.' . $bareMainDomain)) {
            // Use wildcard main domain so sessions can persist across subdomains if configured
            $configuredDomain = config('session.domain');
            if (empty($configuredDomain) || str_contains($configuredDomain, $bareMainDomain)) {
                config(['session.domain' => '.' . $bareMainDomain]);
            }
        } else {
            // It's a custom domain (e.g. myschool.edu.bd or www.myschool.edu.bd)
            // Session cookie domain MUST be null so browser scopes the cookie to the exact custom host
            config(['session.domain' => null]);

            // Also append custom host to sanctum stateful domains if sanctum is used
            $stateful = config('sanctum.stateful', []);
            if (is_array($stateful) && !in_array($host, $stateful)) {
                $stateful[] = $host;
                config(['sanctum.stateful' => $stateful]);
            }
        }

        return $next($request);
    }
}
