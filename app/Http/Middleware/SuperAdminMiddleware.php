<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            abort(403);
            return redirect()->route('super.login.form')->withErrors(['email' => 'Unauthorized']);
        }

        return $next($request);
    }
}

