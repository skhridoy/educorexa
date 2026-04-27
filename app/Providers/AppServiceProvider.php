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
        Gate::before(function ($user, $ability) {
            return $user->role === 'super_admin' ? true : null;
        });

        Route::model('school', School::class);
        Paginator::useBootstrap();

        // ভিউ কম্পোজার ব্যবহার করে সব ভিউতে ডাটা পাস করা
        View::composer('*', function ($view) {
            // ১. টেন্যান্ট বা স্কুলের ডাটা আনা
            $tenant = Request::route('tenant');
            $school = null;
            if ($tenant) {
                $school = School::where('slug', $tenant)->first();
            }
            
            // ২. সাইট সেটিংস ডাটা আনা (আপনার এই অংশটি এখন সব পেজে কাজ করবে)
            $setting = null;
            if (Schema::hasTable('site_settings')) {
                $setting = SiteSetting::first();
            }

            // যদি ডাটাবেজে সেটিংস না থাকে, তবে একটি ডিফল্ট অবজেক্ট দেওয়া
            if (!$setting) {
                $setting = (object) [
                    'site_name' => 'EduCorexa',
                    'footer_text' => 'All Rights Reserved',
                    'favicon' => 'frontend/img/favicon.ico' // ডিফল্ট পাথ
                ];
            }

            // ভিউতে ডাটা পাঠানো
            $view->with([
                'school' => $school,
                'setting' => $setting
            ]);
        });
    }
}