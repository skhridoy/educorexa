<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {

        if (auth()->check() && auth()->user()->role === 'teacher') {
            return $next($request);
        }

        return redirect()->route('school.login.form', ['tenant' => $request->route('tenant')])
                        ->with('error', 'আপনার এই পেজ দেখার অনুমতি নেই।');
    }
}
