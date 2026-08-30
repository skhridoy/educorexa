<?php

namespace App\Mail;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class TeacherCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $teacher;
    public School $school;
    public string $password;
    public string $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($teacher, School $school, string $password = '12345678')
    {
        $this->teacher = $teacher;
        $this->school = $school;
        $this->password = $password;
        $this->loginUrl = route('login.form');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = $this->school->pro_email_address ?: ($this->school->mail_from_address ?: ($this->school->email ?: config('mail.from.address')));
        $fromName = $this->school->mail_from_name ?: ($this->school->name ?: config('mail.from.name'));

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Welcome to ' . $this->school->name . ' - Your Teacher Account Credentials',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.teacher_credentials',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
