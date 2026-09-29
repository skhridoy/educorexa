<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\FrontendSection;

class SettingController extends Controller
{
    public function edit() {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('super.settings.edit', compact('setting'));
    }

    public function update(Request $request) {
        $setting = SiteSetting::first() ?? new SiteSetting();
        
        // à¦¸à¦¾à¦§à¦¾à¦°à¦£ à¦Ÿà§‡à¦•à§à¦¸à¦Ÿ à¦¡à¦¾à¦Ÿà¦¾ à¦†à¦ªà¦¡à§‡à¦Ÿ
        $setting->site_name = $request->site_name;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->footer_text = $request->footer_text;
        $setting->facebook_url = $request->facebook_url;
        $setting->twitter_url = $request->twitter_url;
        $setting->linkedin_url = $request->linkedin_url;
        $setting->instagram_url = $request->instagram_url;

        // --- à¦¨à¦¤à§à¦¨ SEO à¦¡à¦¾à¦Ÿà¦¾ à¦†à¦ªà¦¡à§‡à¦Ÿ ---
        $setting->meta_title = $request->meta_title;
        $setting->meta_description = $request->meta_description;
        $setting->meta_keywords = $request->meta_keywords;

        // à¦®à§‡à¦‡à¦¨ à¦ªà¦¾à¦¥ à¦¸à§‡à¦Ÿà¦†à¦ª
        $basePath = 'uploads/settings';

        // à§§. à¦²à§‹à¦—à§‹ à¦¹à§à¦¯à¦¾à¦¨à§à¦¡à§‡à¦²à¦¿à¦‚ (Wide Logo)
        if ($request->hasFile('logo_wide')) {
            $logoPath = public_path($basePath . '/logos');
            if (!file_exists($logoPath)) mkdir($logoPath, 0755, true);

            if ($setting->logo_wide && file_exists(public_path($setting->logo_wide))) {
                @unlink(public_path($setting->logo_wide));
            }

            $file = $request->file('logo_wide');
            $fileName = 'logo_wide_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($logoPath, $fileName);
            $setting->logo_wide = $basePath . '/logos/' . $fileName;
        }

        // à§¨. à¦¸à§à¦•à¦¯à¦¼à¦¾à¦° à¦²à§‹à¦—à§‹ à¦¹à§à¦¯à¦¾à¦¨à§à¦¡à§‡à¦²à¦¿à¦‚ (Square Logo)
        if ($request->hasFile('logo_square')) {
            $squarePath = public_path($basePath . '/logos_square');
            if (!file_exists($squarePath)) mkdir($squarePath, 0755, true);

            if ($setting->logo_square && file_exists(public_path($setting->logo_square))) {
                @unlink(public_path($setting->logo_square));
            }

            $file = $request->file('logo_square');
            $fileName = 'logo_sq_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($squarePath, $fileName);
            $setting->logo_square = $basePath . '/logos_square/' . $fileName;
        }

        // à§©. à¦«à§‡à¦­à¦¿à¦•à¦¨ à¦¹à§à¦¯à¦¾à¦¨à§à¦¡à§‡à¦²à¦¿à¦‚
        if ($request->hasFile('favicon')) {
            $favPath = public_path($basePath . '/favicons');
            if (!file_exists($favPath)) mkdir($favPath, 0755, true);

            if ($setting->favicon && file_exists(public_path($setting->favicon))) {
                @unlink(public_path($setting->favicon));
            }

            $file = $request->file('favicon');
            $fileName = 'fav_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($favPath, $fileName);
            $setting->favicon = $basePath . '/favicons/' . $fileName;
        }

        // à§ª. OG Image à¦¹à§à¦¯à¦¾à¦¨à§à¦¡à§‡à¦²à¦¿à¦‚ (SEO Social Preview)
        if ($request->hasFile('og_image')) {
            $seoPath = public_path($basePath . '/seo');
            if (!file_exists($seoPath)) mkdir($seoPath, 0755, true);

            if ($setting->og_image && file_exists(public_path($setting->og_image))) {
                @unlink(public_path($setting->og_image));
            }

            $file = $request->file('og_image');
            $fileName = 'seo_og_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($seoPath, $fileName);
            $setting->og_image = $basePath . '/seo/' . $fileName;
        }

        $setting->save();

        return back()->with('success', 'Site settings and SEO updated successfully!');
    }

    public function toggleSection(Request $request) {
        // à¦¶à§à¦§à§à¦®à¦¾à¦¤à§à¦° à¦¸à§à¦ªà¦¾à¦° à¦à¦¡à¦®à¦¿à¦¨ à¦šà§‡à¦•
        if(auth()->user()->role !== 'super_admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $section = FrontendSection::findOrFail($request->id);
        $section->status = $request->status;
        $section->save();

        return response()->json(['success' => 'Status updated!']);
    }

    public function apiSetup() {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('super.settings.api_setup', compact('setting'));
    }

    public function updateApiSetup(Request $request) {
        $setting = SiteSetting::first() ?? new SiteSetting();

        $request->validate([
            'inbound_webhook_secret' => 'nullable|string|max:255',
            'imap_host' => 'nullable|string|max:255',
            'imap_port' => 'nullable|integer|min:1|max:65535',
            'imap_username' => 'nullable|email|max:255',
            'imap_password' => 'nullable|string',
            'imap_encryption' => 'nullable|in:ssl,tls,none',
            'imap_folder' => 'nullable|string|max:100',
        ]);
        
        // --- SMTP Data Update ---
        $setting->mail_mailer = $request->mail_mailer ?? 'smtp';
        $setting->mail_host = $request->mail_host;
        $setting->mail_port = $request->mail_port;
        $setting->mail_username = $request->mail_username;
        if ($request->filled('mail_password')) {
            $setting->mail_password = $request->mail_password;
        }
        $setting->mail_encryption = $request->mail_encryption;
        $setting->mail_from_address = $request->mail_from_address;
        $setting->mail_from_name = $request->mail_from_name;
        if ($request->filled('inbound_webhook_secret')) {
            $setting->inbound_webhook_secret = $request->inbound_webhook_secret;
        }
        $setting->inbound_webhook_enabled = $request->boolean('inbound_webhook_enabled');
        $setting->imap_enabled = $request->boolean('imap_enabled');
        $setting->imap_host = $request->imap_host;
        $setting->imap_port = $request->imap_port ?: 993;
        $setting->imap_username = $request->imap_username;
        $setting->imap_encryption = $request->imap_encryption ?: 'ssl';
        $setting->imap_folder = $request->imap_folder ?: 'INBOX';
        if ($request->filled('imap_password')) {
            $setting->imap_password = $request->imap_password;
        }

        $setting->save();

        return back()->with('success', 'API Settings updated successfully!');
    }

    public function paymentSetup()
    {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('super.settings.payment_setup', compact('setting'));
    }

    public function updatePaymentSetup(Request $request)
    {
        $setting = SiteSetting::first() ?? new SiteSetting();

        $validated = $request->validate([
            'payment_mode' => 'required|in:personal,merchant',
            'bkash_personal_number' => 'nullable|regex:/^01[3-9]\d{8}$/',
            'nagad_personal_number' => 'nullable|regex:/^01[3-9]\d{8}$/',
            'bkash_merchant_number' => 'nullable|regex:/^01[3-9]\d{8}$/',
            'bkash_merchant_id' => 'nullable|string|max:100',
            'bkash_api_key' => 'nullable|string|max:500',
            'bkash_api_secret' => 'nullable|string|max:500',
            'nagad_merchant_number' => 'nullable|regex:/^01[3-9]\d{8}$/',
            'nagad_merchant_id' => 'nullable|string|max:100',
            'nagad_api_key' => 'nullable|string|max:500',
            'nagad_api_secret' => 'nullable|string|max:500',
            'manual_payment_instructions' => 'nullable|string|max:2000',
        ]);

        foreach ($validated as $key => $value) {
            if (str_ends_with($key, '_api_key') || str_ends_with($key, '_api_secret')) {
                if ($value !== null && $value !== '') {
                    $setting->{$key} = $value;
                }
                continue;
            }
            $setting->{$key} = $value;
        }

        $setting->save();

        return back()->with('success', 'Payment setup updated successfully.');
    }

    /** Server IP ও Main Domain সেটিংস পেজ */
    public function domainSetup()
    {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('super.settings.domain_setup', compact('setting'));
    }

    /** Server IP ও Main Domain আপডেট */
    public function updateDomainSetup(Request $request)
    {
        $setting = SiteSetting::first() ?? new SiteSetting();

        $validated = $request->validate([
            'server_ip'                => ['nullable', 'string', 'max:45', 'regex:/^(\d{1,3}\.){3}\d{1,3}$|^[0-9a-fA-F:]+$/'],
            'main_domain'              => ['nullable', 'string', 'max:253', 'regex:/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/'],
            'custom_domain_yearly_fee' => ['nullable', 'numeric', 'min:0', 'max:999999'],
        ], [
            'server_ip.regex'                  => 'সঠিক IPv4 বা IPv6 ঠিকানা দিন।',
            'main_domain.regex'                => 'সঠিক ডোমেইন নাম দিন (যেমন: educorexa.com)।',
            'custom_domain_yearly_fee.numeric' => 'বাৎসরিক সার্ভার ফি সঠিক সংখ্যায় দিন।',
        ]);

        if (array_key_exists('server_ip', $validated)) {
            $setting->server_ip = $validated['server_ip'] ?: null;
        }
        if (array_key_exists('main_domain', $validated)) {
            $setting->main_domain = $validated['main_domain'] ?: null;
        }
        if (array_key_exists('custom_domain_yearly_fee', $validated)) {
            $setting->custom_domain_yearly_fee = $validated['custom_domain_yearly_fee'] !== null ? (float) $validated['custom_domain_yearly_fee'] : 1500.00;
        }

        $setting->save();

        $this->syncEnvFile([
            'SERVER_IP'   => $validated['server_ip'] ?? '',
            'MAIN_DOMAIN' => $validated['main_domain'] ?? '',
        ]);

        return back()->with('success', 'Domain & Server settings সফলভাবে আপডেট হয়েছে।');
    }

    /** .env ফাইলের নির্দিষ্ট key গুলো আপডেট করে */
    private function syncEnvFile(array $data): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return;
        }
        $content = file_get_contents($envPath);
        foreach ($data as $key => $value) {
            $value = trim($value);
            if (preg_match("/^{$key}=.*/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                $content .= "\n{$key}={$value}";
            }
        }
        file_put_contents($envPath, $content);
    }
}