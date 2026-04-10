<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $loginUrl;

    public function __construct($school)
    {
        $this->school = $school;
        // আপনার কনফিগারেশন অনুযায়ী URL তৈরি
        $this->loginUrl = "http://" . $school->slug . ".educorexa.com/login";
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'অভিনন্দন! আপনার স্কুল অ্যাকাউন্টটি এখন সক্রিয় - EduCorexa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'super.emails.school_approve',
            with: [
                'school' => $this->school,
                'loginUrl' => $this->loginUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}