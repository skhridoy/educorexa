<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request)
    {
        if (! $request->expectsJson()) {

            // Super Admin
            if ($request->is('super-admin') || $request->is('super-admin/*')) {
                return route('super.login.form');
            }

            // Tenant Subdomain
            if ($request->route('tenant')) {
                return route('school.login.form', [
                    'tenant' => $request->route('tenant')
                ]);
            }

            return '/';
        }
    }
}