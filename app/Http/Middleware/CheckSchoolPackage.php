<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolPackage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();

        // If user is not logged in or doesn't belong to a school, let other middleware handle it
        if (!$user || !$user->school_id) {
            return $next($request);
        }

        $school = $user->school;

        if (!$school) {
            return $next($request);
        }

        // If it's a super admin, they might have access to everything, 
        // but we should still respect the school instance context if applicable.
        if ($user->hasRole('super_admin')) {
            return $next($request);
        }

        if (!$school->hasActiveSubscription()) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Your subscription is inactive. Please complete payment to continue.'
                ], 402);
            }

            return redirect()->route('school.pricing', ['tenant' => $school->slug])
                ->with('error', 'Your trial or subscription has ended. Please complete payment to continue.');
        }

        // Check if the school's package has the required permission
        if (!$school->hasPackagePermission($permission)) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Your current package does not support this feature. Please upgrade.'
                ], 403);
            }

            return redirect()->route('school.dashboard')
                ->with('error', 'Your current package does not support this feature. Please upgrade to access it.');
        }

        return $next($request);
    }
}
