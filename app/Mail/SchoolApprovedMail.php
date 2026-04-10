<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SchoolApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $loginUrl;

    public function __construct($school)
    {
        $this->school = $school;
        // সাব-ডোমেইন বা স্ল্যাগ অনুযায়ী ইউআরএল
        $this->loginUrl = "http://" . $school->slug . ".educorexa.com/login";
    }

    public function build()
    {
        return $this->subject('অভিনন্দন! আপনার স্কুল অ্যাকাউন্টটি এখন সক্রিয় - EduCorexa')
                    ->view('super.emails.school_approved');
    }
}