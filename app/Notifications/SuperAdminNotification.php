<?php 

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SuperAdminNotification extends Notification
{
    use Queueable;
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->details['message'],
            'icon'    => $this->details['icon'] ?? 'bell',
            'link'    => $this->details['link'] ?? '#',
        ];
    }
}