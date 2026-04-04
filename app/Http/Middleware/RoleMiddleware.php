<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 🔹 যদি user logged in না থাকে
        if (!Auth::check()) {

            // Super Admin Domain
            if ($request->is('super-admin') || $request->is('super-admin/*')) {
                return redirect()->route('super.login.form');
            }

            // School Subdomain
            if ($request->route('tenant')) {
                return redirect()->route('school.login.form', [
                    'tenant' => $request->route('tenant')
                ]);
            }

            return redirect('/');
        }

        // 🔹 Role check
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
