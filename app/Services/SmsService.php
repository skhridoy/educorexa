<?php

namespace App\Services;

use App\Models\School;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(School $school, ?string $number, string $message): bool
    {
        if (!$school->hasPackagePermission('sms.send')) {
            Log::notice('SMS blocked because the school package does not include SMS', [
                'school_id' => $school->id,
            ]);
            return false;
        }

        $number = $this->normalizeNumber($number);

        if (!$number || !$school->sms_api_provider || !$school->sms_api_url || !$school->sms_api_key) {
            return false;
        }

        try {
            $response = match (strtolower($school->sms_api_provider)) {
                'bulksmsbd' => Http::asForm()->post($school->sms_api_url, [
                    'api_key' => $school->sms_api_key,
                    'senderid' => $school->sms_sender_id,
                    'number' => $number,
                    'message' => $message,
                ]),
                'sslwireless' => Http::asForm()->post($school->sms_api_url, [
                    'api_token' => $school->sms_api_key,
                    'sid' => $school->sms_sender_id,
                    'msisdn' => $number,
                    'sms' => $message,
                    'csms_id' => (string) str()->uuid(),
                ]),
                default => Http::withToken($school->sms_api_key)->post($school->sms_api_url, [
                    'to' => $number,
                    'message' => $message,
                    'sender_id' => $school->sms_sender_id,
                    'api_secret' => $school->sms_api_secret,
                ]),
            };

            if ($response->successful()) {
                return true;
            }

            Log::warning('SMS provider rejected message', [
                'school_id' => $school->id,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        } catch (\Throwable $exception) {
            Log::error('SMS sending failed', [
                'school_id' => $school->id,
                'message' => $exception->getMessage(),
            ]);
        }

        return false;
    }

    private function normalizeNumber(?string $number): ?string
    {
        if (!$number) {
            return null;
        }

        $number = preg_replace('/[^0-9+]/', '', $number);
        if (str_starts_with($number, '01') && strlen($number) === 11) {
            return '88' . $number;
        }

        return ltrim($number, '+');
    }
}
