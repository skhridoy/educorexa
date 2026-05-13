<?php

namespace App\Mail;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfessionalEmailDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $emailAddress;
    public $password;
    public $smtpDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(School $school, $emailAddress, $password)
    {
        $this->school = $school;
        $this->emailAddress = $emailAddress;
        $this->password = $password;
        
        // Construct SMTP details based on common cPanel patterns
        // Host is usually mail.domain.com
        $domain = explode('@', $emailAddress)[1];
        
        $this->smtpDetails = [
            'host' => 'mail.' . $domain,
            'port' => 465,
            'encryption' => 'ssl',
            'username' => $emailAddress,
            'password' => $password,
            'mailer' => 'smtp'
        ];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Professional Email Account Created - ' . $this->school->name)
                    ->view('emails.professional_email_details')
                    ->with([
                        'school' => $this->school,
                        'emailAddress' => $this->emailAddress,
                        'password' => $this->password,
                        'smtpDetails' => $this->smtpDetails,
                    ]);
    }
}
