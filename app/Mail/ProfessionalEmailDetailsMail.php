<?php

namespace App\Mail;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfessionalEmailDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $schoolName;
    public $schoolSlug;
    public $emailAddress;
    public $password;
    public $smtpDetails;

    /**
     * Create a new message instance.
     */
    public function __construct($school, $emailAddress, $password)
    {
        $this->schoolName = $school->name;
        $this->schoolSlug = $school->slug;
        $this->emailAddress = $emailAddress;
        $this->password = $password;
        
        // Construct SMTP details based on common cPanel patterns
        // Host is usually mail.domain.com
        $domain = explode('@', $emailAddress)[1];
        
        $this->smtpDetails = [
            'host' => $domain,
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
        return $this->from('support@educorexa.com', config('app.name', 'EduCorexa Support'))
                    ->subject('Professional Email Account Created - ' . $this->schoolName)
                    ->view('emails.professional_email_details');
    }
}
