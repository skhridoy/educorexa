<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

trait SchoolMailConfig
{
    /**
     * Dynamically set mail configuration for a school.
     */
    protected function setMailConfig($school)
    {
        if (!$school) {
            return;
        }

        // Priority for From Address: pro_email_address -> mail_from_address -> school primary email -> default config
        $fromAddress = $school->pro_email_address ?: ($school->mail_from_address ?: ($school->email ?: config('mail.from.address')));
        $fromName = $school->mail_from_name ?: ($school->name ?: config('mail.from.name'));

        // If school has custom SMTP configured
        if ($school->mail_host) {
            $encryption = $school->mail_encryption;
            
            // Port 465 usually requires SSL
            if ($school->mail_port == 465 && (empty($encryption) || $encryption == 'none')) {
                $encryption = 'ssl';
            }

            Config::set('mail.default', $school->mail_mailer ?? 'smtp');
            Config::set('mail.mailers.smtp.host', $school->mail_host);
            Config::set('mail.mailers.smtp.port', $school->mail_port ?? 587);
            Config::set('mail.mailers.smtp.encryption', $encryption ?? 'tls');
            Config::set('mail.mailers.smtp.username', $school->mail_username);
            Config::set('mail.mailers.smtp.password', $school->mail_password);
            Config::set('mail.from.address', $fromAddress);
            Config::set('mail.from.name', $fromName);

            // Purge the mailer to apply new config
            Mail::purge('smtp');
        } else {
            Config::set('mail.from.address', $fromAddress);
            Config::set('mail.from.name', $fromName);
        }
    }
}
