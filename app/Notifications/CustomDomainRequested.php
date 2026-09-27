<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CustomDomainRequested extends Notification
{
    use Queueable;

    public function __construct(public School $school) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'icon'    => 'globe',
            'message' => '🌐 "' . $this->school->name . '" স্কুল থেকে কাস্টম ডোমেইন "' . $this->school->custom_domain . '" রিকোয়েস্ট এসেছে।',
            'link'    => route('super.custom-domain.index'),
        ];
    }
}
