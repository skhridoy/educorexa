<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TenantPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = $request->user();

        // Ensure user belongs to the same school
        if ($user->school_id != $request->school_id) {
            abort(403, 'Unauthorized school access.');
        }

        if (!$user->can($permission)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
