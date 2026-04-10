<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public function __construct($school) {
        $this->school = $school;
    }
    public function build() {
        return $this->subject('আপনার রেজিস্ট্রেশন সফলভাবে গ্রহণ করা হয়েছে - EduCorexa')
                    ->view('super.emails.school_pending');
    }
}
