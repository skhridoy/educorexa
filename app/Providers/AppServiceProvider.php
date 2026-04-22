<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\School;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // 
    }

    public function boot(): void
    {
        // 🔹 এখানে $this->registerPolicies() রাখা যাবে না। 
        // সরাসরি Gate::before ব্যবহার করুন।
        Gate::before(function ($user, $ability) {
            return $user->role === 'super_admin' ? true : null;
        });

        Route::model('school', School::class);
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $tenant = Request::route('tenant');
            $school = School::where('slug', $tenant)->first();
            $view->with('school', $school);
        });

        if (!app()->runningInConsole() && Schema::hasTable('site_settings')) {
            $setting = SiteSetting::first() ?? new SiteSetting([
                'site_name' => 'EduCorexa',
                'footer_text' => 'All Rights Reserved'
            ]);
            View::share('setting', $setting);
        }
    }
}