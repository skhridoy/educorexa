<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailServerService
{
    protected $host;
    protected $username;
    protected $apiToken;
    protected $rootDomain;

    public function __construct()
    {
        $this->host = config('services.cpanel.host');
        $this->username = config('services.cpanel.username');
        $this->apiToken = config('services.cpanel.api_token');
        $this->rootDomain = config('services.cpanel.root_domain', 'educorexa.com');
    }

    /**
     * Create a new email account on the server.
     */
    public function createEmailAccount($email, $password, $quota = 500)
    {
        if (!$this->host || !$this->apiToken) {
            Log::warning("MailServerService: API details not configured. Simulating success for $email.");
            return [
                'success' => true,
                'message' => 'Simulated account creation successful (API not configured).',
                'data' => ['email' => $email]
            ];
        }

        try {
            list($user, $domain) = explode('@', $email);

            // 1. Ensure the domain/subdomain exists in cPanel
            $domainCheck = $this->ensureDomainExists($domain);
            if (!$domainCheck['success']) {
                return $domainCheck;
            }

            // 2. cPanel UAPI: Email::add_pop
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => "cpanel " . $this->username . ":" . $this->apiToken,
            ])->get($this->host . "/execute/Email/add_pop", [
                'email'    => $user,
                'password' => $password,
                'domain'   => $domain,
                'quota'    => $quota,
            ]);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['status']) && $responseData['status'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Email account created successfully on cPanel.',
                    'data'    => $responseData['data'] ?? []
                ];
            }

            $errorMessage = $responseData['errors'][0] ?? 'Unknown error from cPanel API.';
            Log::error("cPanel Email Creation Failed: " . $errorMessage);

            return [
                'success' => false,
                'message' => $errorMessage,
            ];

        } catch (\Exception $e) {
            Log::error("MailServerService Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to connect to the mail server.',
            ];
        }
    }

    /**
     * Ensure the domain exists in the cPanel account.
     * If it's a subdomain and doesn't exist, try to add it.
     */
    protected function ensureDomainExists($domain)
    {
        // First, check if domain already exists
        $response = Http::withoutVerifying()->withHeaders([
            'Authorization' => "cpanel " . $this->username . ":" . $this->apiToken,
        ])->get($this->host . "/execute/DomainInfo/list_domains");

        if ($response->successful() && isset($response->json()['status']) && $response->json()['status'] == 1) {
            $domains = $response->json()['data']['main_domain'] ?? [];
            $addonDomains = $response->json()['data']['addon_domains'] ?? [];
            $subDomains = $response->json()['data']['sub_domains'] ?? [];
            
            $allDomains = array_merge([$response->json()['data']['main_domain'] ?? ''], $addonDomains, $subDomains);
            
            if (in_array($domain, $allDomains)) {
                return ['success' => true];
            }
        }

        // If not found and it's a subdomain of our root, try to add it
        if (str_ends_with($domain, '.' . $this->rootDomain)) {
            $sub = str_replace('.' . $this->rootDomain, '', $domain);
            
            Log::info("Attempting to add subdomain: $sub for domain: $this->rootDomain");
            
            $addResponse = Http::withoutVerifying()->withHeaders([
                'Authorization' => "cpanel " . $this->username . ":" . $this->apiToken,
            ])->get($this->host . "/execute/SubDomain/addsubdomain", [
                'domain'                => $sub,
                'rootdomain'            => $this->rootDomain,
                'dir'                   => 'public_html/' . $sub, // Standard directory
                'disallowdot'           => 1,
            ]);

            if ($addResponse->successful() && isset($addResponse->json()['status']) && $addResponse->json()['status'] == 1) {
                return ['success' => true, 'message' => 'Subdomain created successfully.'];
            }
            
            $error = $addResponse->json()['errors'][0] ?? 'Failed to create subdomain.';
            Log::error("Subdomain Creation Error: " . $error);
            return ['success' => false, 'message' => "Could not prepare domain: $error"];
        }

        return [
            'success' => false, 
            'message' => "Domain $domain not found on server and is not a valid subdomain of $this->rootDomain"
        ];
    }

    /**
     * Delete an email account from the server.
     */
    public function deleteEmailAccount($email)
    {
        if (!$this->host || !$this->apiToken) {
            Log::warning("MailServerService: API details not configured. Simulating success for deletion of $email.");
            return ['success' => true];
        }

        try {
            list($user, $domain) = explode('@', $email);

            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => "cpanel " . $this->username . ":" . $this->apiToken,
            ])->get($this->host . "/execute/Email/delete_pop", [
                'email'  => $user,
                'domain' => $domain,
            ]);

            if ($response->successful() && isset($response->json()['status']) && $response->json()['status'] == 1) {
                return ['success' => true, 'message' => 'Email account deleted successfully.'];
            }

            return [
                'success' => false,
                'message' => $response->json()['errors'][0] ?? 'Unknown error from cPanel API.',
            ];

        } catch (\Exception $e) {
            Log::error("MailServerService Deletion Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Connection failed.'];
        }
    }
}
