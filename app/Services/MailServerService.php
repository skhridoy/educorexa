<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailServerService
{
    protected $host;
    protected $username;
    protected $apiToken;

    public function __construct()
    {
        $this->host = config('services.cpanel.host');
        $this->username = config('services.cpanel.username');
        $this->apiToken = config('services.cpanel.api_token');
    }

    /**
     * Create a new email account on the server.
     */
    public function createEmailAccount($email, $password, $quota = 500)
    {
        // If API details are not provided, return a mock success for testing
        if (!$this->host || !$this->apiToken) {
            Log::warning("MailServerService: API details not configured. Simulating success for $email.");
            return [
                'success' => true,
                'message' => 'Simulated account creation successful (API not configured).',
                'data' => [
                    'email' => $email,
                    'password' => $password,
                ]
            ];
        }

        try {
            // Split email to get user and domain
            list($user, $domain) = explode('@', $email);

            // cPanel UAPI: Email::add_pop
            $response = Http::withHeaders([
                'Authorization' => "cpanel " . $this->username . ":" . $this->apiToken,
            ])->get($this->host . "/execute/Email/add_pop", [
                'email'    => $user,
                'password' => $password,
                'domain'   => $domain,
                'quota'    => $quota,
            ]);

            if ($response->successful() && isset($response->json()['status']) && $response->json()['status'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Email account created successfully on cPanel.',
                    'data'    => $response->json()['data']
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['errors'][0] ?? 'Unknown error from cPanel API.',
            ];

        } catch (\Exception $e) {
            Log::error("MailServerService Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to connect to the mail server.',
            ];
        }
    }
}
