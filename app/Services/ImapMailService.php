<?php

namespace App\Services;

use App\Models\InboundMessage;
use App\Models\School;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;
use Webklex\PHPIMAP\ClientManager;

class ImapMailService
{
    public function poll(School|SiteSetting $mailbox): int
    {
        if (!$mailbox->imap_enabled || !$mailbox->imap_host || !$mailbox->imap_username || !$mailbox->imap_password) {
            return 0;
        }

        $client = (new ClientManager())->make([
            'host' => $mailbox->imap_host,
            'port' => (int) ($mailbox->imap_port ?: 993),
            'protocol' => 'imap',
            'encryption' => $mailbox->imap_encryption ?: 'ssl',
            'validate_cert' => true,
            'username' => $mailbox->imap_username,
            'password' => $mailbox->imap_password,
            'authentication' => null,
        ]);
        $client->connect();
        $folder = $client->getFolder($mailbox->imap_folder ?: 'INBOX');
        $count = 0;

        foreach ($folder->messages()->all()->leaveUnread()->get() as $mail) {
            $from = $mail->getFrom()->first();
            $recipient = $mailbox instanceof School
                ? ($mailbox->email ?: $mailbox->pro_email_address)
                : $mailbox->email;

            $stored = InboundMessage::firstOrCreate(
                ['message_id' => (string) ($mail->getMessageId()->first() ?: $mail->getUid())],
                [
                    'school_id' => $mailbox instanceof School ? $mailbox->id : null,
                    'mailbox_type' => $mailbox instanceof School ? 'school' : 'main',
                    'recipient_email' => $recipient,
                    'sender_name' => $from?->personal,
                    'sender_email' => $from?->mail ?: 'unknown@example.com',
                    'subject' => $mail->getSubject()->first(),
                    'body_text' => $mail->getTextBody(),
                    'body_html' => $mail->getHTMLBody(),
                    'received_at' => $mail->getDate()?->toDate(),
                ]
            );
            $count += $stored->wasRecentlyCreated ? 1 : 0;
        }

        $client->disconnect();
        return $count;
    }

    public function pollAll(): array
    {
        $result = ['main' => 0, 'schools' => 0, 'errors' => 0];
        $settings = SiteSetting::first();
        if ($settings?->imap_enabled) {
            try { $result['main'] = $this->poll($settings); } catch (\Throwable $exception) {
                $result['errors']++;
                Log::error('Company IMAP polling failed', ['message' => $exception->getMessage()]);
            }
        }

        School::where('imap_enabled', true)->cursor()->each(function (School $school) use (&$result) {
            try { $result['schools'] += $this->poll($school); } catch (\Throwable $exception) {
                $result['errors']++;
                Log::error('School IMAP polling failed', ['school_id' => $school->id, 'message' => $exception->getMessage()]);
            }
        });

        return $result;
    }
}
