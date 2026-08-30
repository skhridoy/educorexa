<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Illuminate\Auth\AuthenticationException; // এই লাইনটি যোগ করুন
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException; // এই লাইনটিও যোগ করুন

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        $middleware->alias([
            'identify.school' => \App\Http\Middleware\IdentifySchool::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'is_student' => \App\Http\Middleware\IsStudent::class,
            'is_teacher' => \App\Http\Middleware\IsTeacher::class,
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
            'school_package' => \App\Http\Middleware\CheckSchoolPackage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    
    $exceptions->render(function (AuthenticationException $e, $request) {
        // যদি রিকোয়েস্টটি সাবডোমেইন (Tenant) থেকে আসে
        if ($request->route() && $request->route()->hasParameter('tenant')) {
            return redirect()->guest(route('school.login.form', ['tenant' => $request->route()->parameter('tenant')]));
        }
        
        // সুপার অ্যাডমিন বা মেইন ডোমেইনের জন্য
        return redirect()->guest(route('login.form'));
    });

    $exceptions->render(function (AccessDeniedHttpException $e, $request) {
        if (!auth()->check()) {
            if ($request->route() && $request->route()->hasParameter('tenant')) {
                return redirect()->guest(route('school.login.form', ['tenant' => $request->route()->parameter('tenant')]));
            }
            return redirect()->guest(route('login.form'));
        }
    });
})->create();