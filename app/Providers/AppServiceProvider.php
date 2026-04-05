<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\School;
use \App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::model('school', School::class);
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            // ইউআরএল থেকে টেন্যান্ট স্লাগ নিয়ে স্কুল ডাটা খুঁজে বের করা
            $tenant = Request::route('tenant');
            $school = School::where('slug', $tenant)->first();
            
            $view->with('school', $school);
        });

        if (!app()->runningInConsole() && Schema::hasTable('site_settings')) {
            // যদি ডাটাবেজে ডাটা না থাকে তবে একটি খালি অবজেক্ট পাস করবে
            $setting = SiteSetting::first() ?? new SiteSetting([
                'site_name' => 'EduCorexa',
                'footer_text' => 'All Rights Reserved'
            ]);
            \View::share('setting', $setting);
        }
    }
    
}
