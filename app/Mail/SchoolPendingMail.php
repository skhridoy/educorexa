<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolPendingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $school;

    public function __construct($school)
    {
        $this->school = $school;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'আপনার রেজিস্ট্রেশন সফলভাবে গ্রহণ করা হয়েছে - EduCorexa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'super.emails.school_pending', // ফোল্ডার পাথ সঠিক আছে কি না আবার চেক করুন
        );
    }

    public function attachments(): array
    {
        return [];
    }
}