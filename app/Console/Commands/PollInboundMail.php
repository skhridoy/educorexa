<?php

namespace App\Console\Commands;

use App\Services\ImapMailService;
use Illuminate\Console\Command;

class PollInboundMail extends Command
{
    protected $signature = 'inbound-mail:poll';
    protected $description = 'Fetch configured school and company inboxes over IMAP';

    public function handle(ImapMailService $service): int
    {
        $result = $service->pollAll();
        $this->info("Imported {$result['main']} company and {$result['schools']} school emails.");
        if ($result['errors']) {
            $this->warn("{$result['errors']} mailbox connection(s) failed. Check the application log.");
        }
        return self::SUCCESS;
    }
}
