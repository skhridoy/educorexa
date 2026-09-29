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

        // ডাইনামিক গ্লোবাল ইমেইল কনফিগারেশন সেটআপ
        try {
            if (Schema::hasTable('site_settings')) {
                $setting = SiteSetting::first();
                if ($setting && $setting->mail_host) {
                    \Illuminate\Support\Facades\Config::set('mail.default', $setting->mail_mailer ?? 'smtp');
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.host', $setting->mail_host);
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.port', $setting->mail_port);
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.username', $setting->mail_username);
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.password', $setting->mail_password);
                    \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.encryption', $setting->mail_encryption);
                    \Illuminate\Support\Facades\Config::set('mail.from.address', $setting->mail_from_address);
                    \Illuminate\Support\Facades\Config::set('mail.from.name', $setting->mail_from_name);
                }
            }
        } catch (\Exception $e) {
            // ডাটাবেজ কানেকশন না থাকলে ইগনোর করবে
        }

        // ডাইনামিক URL ফরম্যাটিং: সাবডোমেইন ও কাস্টম ডোমেইন রুটের হোস্ট নিশ্চিত করা
        \Illuminate\Support\Facades\URL::formatHostUsing(function ($root, $route) {
            $parsed = parse_url($root);
            $host = $parsed['host'] ?? '';

            // যদি বর্তমান রিকোয়েস্ট ভেরিফাইড কাস্টম ডোমেইন থেকে আসে, তবে লিংকগুলো কাস্টম ডোমেইনেই রাখুন
            if (app()->bound('currentSchool')) {
                $currentSchool = app('currentSchool');
                $reqHost = request()->getHost();
                $bareReqHost = preg_replace('/^www\./i', '', $reqHost);
                $customDomain = $currentSchool->custom_domain;
                $bareCustom = $customDomain ? preg_replace('/^www\./i', '', $customDomain) : null;

                if ($currentSchool->hasVerifiedCustomDomain() && in_array($bareReqHost, array_filter([$customDomain, $bareCustom]))) {
                    $scheme = request()->isSecure() ? 'https://' : 'http://';
                    return preg_replace('#https?://[^/]+#i', $scheme . $reqHost, $root);
                }
            }

            // যদি হোস্ট একটি সাধারণ স্লাগ হয় (যেমন 'school1' যাতে ডট নেই) এবং লোকালহোস্ট না হয়
            if (!empty($host) && !str_contains($host, '.') && $host !== 'localhost') {
                $mainDomain = config('app.main_domain', 'educorexa.com');
                return str_replace($host, $host . '.' . $mainDomain, $root);
            }

            return $root;
        });

        // ভিউ কম্পোজার ব্যবহার করে সব ভিউতে ডাটা পাস করা
        View::composer('*', function ($view) {
            try {
                // ১. টেন্যান্ট বা স্কুলের ডাটা আনা (কাস্টম ডোমেইন বা সাবডোমেইন উভয় থেকেই)
                $school = app()->bound('currentSchool') ? app('currentSchool') : null;
                if (!$school) {
                    $tenant = Request::route('tenant');
                    if ($tenant) {
                        $bareTenant = preg_replace('/^www\./i', '', $tenant);
                        $school = School::where('slug', $tenant)
                            ->orWhere('custom_domain', $tenant)
                            ->orWhere('custom_domain', $bareTenant)
                            ->first();
                    }
                }
                
                // ২. সাইট সেটিংস ডাটা আনা
                $setting = null;
                if (Schema::hasTable('site_settings')) {
                    $setting = SiteSetting::first();
                }

                // যদি ডাটাবেজে সেটিংস না থাকে, তবে একটি ডিফল্ট অবজেক্ট দেওয়া
                if (!$setting) {
                    $setting = (object) [
                        'site_name' => 'EduCorexa',
                        'footer_text' => 'All Rights Reserved',
                        'favicon' => 'frontend/img/favicon.ico'
                    ];
                }

                $view->with([
                    'school' => $school,
                    'setting' => $setting
                ]);
            } catch (\Throwable $e) {
                // ডাটাবেজ বা এরর ভিউ রেন্ডারিংয়ের সময় যাতে ক্র্যাশ না করে
                $view->with([
                    'school' => null,
                    'setting' => (object) [
                        'site_name' => 'EduCorexa',
                        'footer_text' => 'All Rights Reserved',
                        'favicon' => 'frontend/img/favicon.ico'
                    ]
                ]);
            }
        });
    }
}