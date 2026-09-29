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
        $mainDomain = strtolower(config('app.main_domain', 'schoolerp.test'));

        // If it's the main domain or a subdomain of the main domain:
        if ($host === $mainDomain || str_ends_with($host, '.' . $mainDomain)) {
            // Use wildcard main domain so sessions can persist across subdomains if configured
            $configuredDomain = config('session.domain') ?: ('.' . $mainDomain);
            config(['session.domain' => $configuredDomain]);
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
