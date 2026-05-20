<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EgyptLinxSmsService {
    private string $provider;
    private string $password;
    private string $sender;
    private string $baseUrl = 'https://bulk.egypt-linx.com/api';
    public function __construct() {
        $this->provider = config('services.egyptlinx.provider');
        $this->password  = config('services.egyptlinx.password');
        $this->sender    = config('services.egyptlinx.sender');
    }
    public function calculateSmsCount(string $message): int {
        $length = mb_strlen($message);
        if ($length <= 70) return 1;
        if ($length <= 134) return 2;
        if ($length <= 201) return 3;
        if ($length <= 268) return 4;
        if ($length <= 335) return 5;
        return ceil(($length - 70) / 67) + 1;
    }
    public function sendArabic(array $numbers, string $message) {
        $results = [];
        foreach ($numbers as $number) {
            $response = Http::get($this->baseUrl, [
                'Provider' => $this->provider,
                'Password' => $this->password,
                'Sender'   => $this->sender,
                'Number'   => $number,
                'Binary'   => '00',
                'Code'     => $message,
            ]);
            $results[] = [
                'number' => $number,
                'success' => $response->successful(),
                'response' => $response->body(),
                'status' => $response->status(),
            ];
        }
        return $results;
    }
    public function getBalance(): int|float {
        $response = Http::get($this->baseUrl . '/Balance', [
            'Provider' => $this->provider,
            'Password' => $this->password,
        ]);
        return $response->successful() ? (float) $response->body() : 0;
    }
    public function checkBalance(int $balance, int $totalNeeded) {
        if ($balance < $totalNeeded) {
            return response()->json([
                'error'        => true,
                'message'      => "الرصيد لا يكفي، الرصيد الحالي: {$balance} رسالة، المطلوب: {$totalNeeded} رسالة",
                'balance'      => $balance,
                'total_needed' => $totalNeeded,
            ], 422);
        }
    }
}
