<?php

namespace App\Services;

use App\Models\SMSMSGS;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class SMSService {
    private string $tokenId;
    private string $tokenSecret;
    private string $baseUrl;

    public function __construct() {
        $this->tokenId     = config('services.bulksms.token_id');
        $this->tokenSecret = config('services.bulksms.secret');
        $this->baseUrl     = config('services.bulksms.url');
    }
    public function sendMessage(string|array $recipients, string $message): array {
        if (is_array($recipients)) {
            $body = collect($recipients)->map(fn($number) => [
                'to'   => (string) $number,
                'body' => $message,
                'from' => 'adendan',
                'encoding'     => 'UNICODE',
                'routingGroup' => 'ECONOMY',
            ])->toArray();
        } else {
            $body = [
                'to'   => $recipients,
                'body' => $message,
                'from' => 'adendan',
                'encoding'     => 'UNICODE',
            ];
        }
        try {
            $response = Http::withBasicAuth($this->tokenId, $this->tokenSecret)->post("{$this->baseUrl}/messages", $body);
            $result = $response->json();
            $this->storeSms($message, $result->message);
            $response->throw();
            return ['success' => true, 'data' => $response->json()];
        } catch (RequestException $e) {
            return [
                'success' => false,
                'error'   => $e->response->json() ?? $e->getMessage(),
            ];
        }
    }
    private function storeSms (string $content, string $status) :void {
        SMSMSGS::create([
            'sent_status' => $status,
            'message' => $content,
        ]);
    }
}
