<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        /*
         * A parent-domain cookie is sent to every subdomain. With the same
         * cookie name as a tenant's host-only cookie, Laravel can receive two
         * session IDs and load the wrong session after tenant login.
         */
        $baseCookie = env('SESSION_COOKIE', Str::slug((string) env('APP_NAME', 'laravel')) . '-session');

        config([
            'session.domain' => null,
            'session.cookie' => $baseCookie . '-' . Str::slug($host),
        ]);

        // Include a custom host when Sanctum's cookie-based API auth is used.
        $stateful = config('sanctum.stateful', []);
        if (is_array($stateful) && !in_array($host, $stateful, true)) {
            $stateful[] = $host;
            config(['sanctum.stateful' => $stateful]);
        }
        return $next($request);
    }
}