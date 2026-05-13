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

            $responseData = $response->json() ?? [];

            if ($response->successful() && isset($responseData['status']) && $responseData['status'] == 1) {
                return [
                    'success' => true,
                    'message' => 'Email account created successfully on cPanel.',
                    'data'    => $responseData['data'] ?? []
                ];
            }

            $errorMessage = $responseData['errors'][0] ?? 'Unknown error from cPanel API. Check your CPANEL_HOST or API credentials.';
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

        $responseData = $response->json() ?? [];
        if ($response->successful() && isset($responseData['status']) && $responseData['status'] == 1) {
            $domains = $responseData['data']['main_domain'] ?? [];
            $addonDomains = $responseData['data']['addon_domains'] ?? [];
            $subDomains = $responseData['data']['sub_domains'] ?? [];
            
            $allDomains = array_merge([$responseData['data']['main_domain'] ?? ''], $addonDomains, $subDomains);
            
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
                'dir'                   => 'public_html', // Point to main app directory for multi-tenant routing
                'disallowdot'           => 1,
            ]);

            $addResponseData = $addResponse->json() ?? [];
            if ($addResponse->successful() && isset($addResponseData['status']) && $addResponseData['status'] == 1) {
                return ['success' => true, 'message' => 'Subdomain created successfully.'];
            }
            
            $error = $addResponseData['errors'][0] ?? 'Failed to create subdomain. Response may not be JSON.';
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

            $responseData = $response->json() ?? [];
            if ($response->successful()) {
                $status = $responseData['status'] ?? 0;
                $errors = $responseData['errors'] ?? [];
                
                if ($status == 1) {
                    return ['success' => true, 'message' => 'Email account deleted successfully.'];
                }

                $errorMsg = $errors[0] ?? 'Unknown error from cPanel API.';
                
                // If the email account doesn't exist, treat the deletion as successful
                if (str_contains($errorMsg, 'You do not have an email account named') || str_contains($errorMsg, 'You do not have a user named')) {
                    return ['success' => true, 'message' => 'Email account was already deleted or did not exist.'];
                }

                return [
                    'success' => false,
                    'message' => $errorMsg,
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid response from cPanel API.',
            ];

        } catch (\Exception $e) {
            Log::error("MailServerService Deletion Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Connection failed.'];
        }
    }
}
