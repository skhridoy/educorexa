<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $school;

    public function __construct($subject, $message, $school)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->school = $school;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.newsletter');
    }
}