<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CustomDomainStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public School $school,
        public string $status
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $statusText = match($this->status) {
            'verified' => '✅ Approved — আপনার কাস্টম ডোমেইন "' . $this->school->custom_domain . '" সক্রিয় করা হয়েছে।',
            'rejected' => '❌ Rejected — আপনার কাস্টম ডোমেইন "' . $this->school->custom_domain . '" Reject করা হয়েছে।',
            default    => 'ডোমেইন স্ট্যাটাস পরিবর্তন হয়েছে।',
        };

        return [
            'icon'    => 'globe',
            'message' => $statusText,
            'link'    => route('admin.school.domain', ['tenant' => $this->school->slug]),
        ];
    }
}
