<?php

namespace App\Mail;

use App\Models\School;
use App\Models\SubscriptionPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PackageUpgraded extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $package;

    /**
     * Create a new message instance.
     */
    public function __construct(School $school, SubscriptionPackage $package)
    {
        $this->school = $school;
        $this->package = $package;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('School Subscription Upgraded - ' . config('app.name'))
                    ->view('emails.package_upgraded');
    }
}
