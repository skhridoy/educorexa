<?php

namespace App\Services;

use App\Models\InboundMessage;
use App\Models\School;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InboundMailService
{
    public function isAuthorized(array $payload, ?string $providedSecret): bool
    {
        $recipient = $this->firstAddress($payload['recipient'] ?? $payload['to'] ?? null);
        if (!$recipient || !$providedSecret) {
            return false;
        }

        $school = School::whereRaw('LOWER(email) = ?', [strtolower($recipient)])
            ->orWhereRaw('LOWER(pro_email_address) = ?', [strtolower($recipient)])->first();
        $mainEmail = SiteSetting::query()->value('email');
        $setting = $school ?: ($mainEmail && strtolower($mainEmail) === strtolower($recipient) ? SiteSetting::first() : null);

        if (!$setting || !$setting->inbound_webhook_enabled || !$setting->inbound_webhook_secret) {
            return false;
        }

        return hash_equals($setting->inbound_webhook_secret, $providedSecret);
    }

    public function store(array $payload): ?InboundMessage
    {
        $recipient = $this->firstAddress($payload['recipient'] ?? $payload['to'] ?? null);
        $sender = $this->parseAddress($payload['sender'] ?? $payload['from'] ?? null);

        if (!$recipient || !$sender['email']) {
            return null;
        }

        $school = School::whereRaw('LOWER(email) = ?', [strtolower($recipient)])
            ->orWhereRaw('LOWER(pro_email_address) = ?', [strtolower($recipient)])->first();
        $mainEmail = SiteSetting::query()->value('email');
        $isMain = $mainEmail && strtolower($mainEmail) === strtolower($recipient);

        if (!$school && !$isMain) {
            return null;
        }

        $messageId = trim($payload['message_id'] ?? $payload['Message-Id'] ?? '') ?: null;
        if ($messageId && InboundMessage::where('message_id', $messageId)->exists()) {
            return InboundMessage::where('message_id', $messageId)->first();
        }

        return DB::transaction(fn () => InboundMessage::create([
            'school_id' => $school?->id,
            'mailbox_type' => $school ? 'school' : 'main',
            'recipient_email' => $recipient,
            'message_id' => $messageId ?: (string) Str::uuid(),
            'sender_name' => $sender['name'],
            'sender_email' => $sender['email'],
            'subject' => $payload['subject'] ?? null,
            'body_text' => $payload['body_text'] ?? $payload['body-plain'] ?? null,
            'body_html' => $payload['body_html'] ?? $payload['body-html'] ?? null,
            'headers' => $payload['headers'] ?? null,
            'received_at' => $payload['received_at'] ?? now(),
        ]));
    }

    private function firstAddress($value): ?string
    {
        if (is_array($value)) {
            $value = $value[0] ?? null;
        }
        if (!$value || !preg_match('/<([^>]+)>|([\w.+-]+@[\w.-]+\.[A-Za-z]{2,})/', $value, $matches)) {
            return null;
        }
        return strtolower(trim($matches[1] ?? $matches[2]));
    }

    private function parseAddress($value): array
    {
        $value = is_array($value) ? ($value[0] ?? '') : (string) $value;
        preg_match('/^(.*?)\s*<([^>]+)>$/', trim($value), $matches);
        return [
            'name' => isset($matches[1]) ? trim($matches[1], " \"'") : null,
            'email' => $this->firstAddress($value),
        ];
    }
}
