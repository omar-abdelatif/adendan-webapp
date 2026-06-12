<?php

namespace App\Services;

use App\Models\Due;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymobService {
    private string $secretKey;
    private string $publicKey;
    private string $intentionUrl;
    private array  $integrations;
    public function __construct() {
        $this->secretKey    = config('services.paymob.secret');
        $this->publicKey    = config('services.paymob.public');
        $this->intentionUrl = config('services.paymob.intention_url');
        $this->integrations = [
            'card'   => (int) config('services.paymob.card_integration_id'),
            'wallet' => (int) config('services.paymob.wallet_integration_id'),
        ];
    }
    public function createIntention(int $amount, string $category, string $firstName, string $lastName, string $phone,): string {
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $this->secretKey,
            'Content-Type'  => 'application/json',
        ])->post($this->intentionUrl, [
            'amount'          => $amount * 100,
            'currency'        => 'EGP',
            'payment_methods' => array_values($this->integrations),
            'items'           => [[
                'name'        => $category,
                'amount'      => $amount * 100,
                'quantity'    => 1,
                'description' => $category,
            ]],
            'billing_data'    => [
                'first_name'   => $firstName ?: 'NA',
                'last_name'    => $lastName  ?: 'NA',
                'phone_number' => $phone,
                'email'        => 'user@adendan.com',
            ],
        ]);
        if (!$response->successful()) {
            Log::error('Paymob intention failed', ['body' => $response->body()]);
            throw new \Exception('Paymob Error: ' . $response->body());
        }
        $responseData = $response->json();
        return $responseData['client_secret'];
    }
    public function getCheckoutUrl(string $clientSecret): string {
        return 'https://accept.paymob.com/unifiedcheckout/?publicKey=' . $this->publicKey . '&clientSecret=' . $clientSecret;
    }
    public function verifyHmac(array $data, string $receivedHmac): bool {
        $secret = config('services.paymob.hmac_secret');
        $fields = [
            $data['amount_cents'],
            $data['created_at'],
            $data['currency'],
            $data['error_occured'],
            $data['has_parent_transaction'],
            $data['id'],
            $data['integration_id'],
            $data['is_3d_secure'],
            $data['is_auth'],
            $data['is_capture'],
            $data['is_refunded'],
            $data['is_standalone_payment'],
            $data['is_voided'],
            $data['order'],
            $data['owner'],
            $data['pending'],
            $data['source_data_pan'],
            $data['source_data_sub_type'],
            $data['source_data_type'],
            $data['success'],
        ];
        $str = implode('', $fields);
        $hash = hash_hmac('sha512', $str, $secret);
        return $hash === $receivedHmac;
    }
    public function deductDue(PaymentTransaction $transaction): void {
        $due = Due::where('member_id', $transaction->member_id)->where('item', $transaction->item)->first();
        if (!$due) {
            throw new \Exception("لا يوجد مستحق لهذا العضو");
        }
        DB::transaction(function () use ($due, $transaction) {
            $currentRemaining = $due->amount_remaining ?? $due->total_amount;
            $newAmountRemaining = max(0, $currentRemaining - $transaction->amount);
            if ($newAmountRemaining === 0) {
                $due->delete();
            } else {
                $due->update([
                    'amount_paid'      => $due->amount_paid + $transaction->amount,
                    'amount_remaining' => $newAmountRemaining,
                ]);
            }
        });
    }
    public function calculatePaymentCat(int $amount ,int $memberId, string $item): string {
        $due = Due::where('member_id', $memberId)->where('item', $item)->first();
        if (!$due) {
            throw new \Exception("لا يوجد مستحق لهذا العضو");
        }
        $remaining = $due->amount_remaining ?? $due->total_amount;
        $paymentCat = $amount >= $remaining ? 'كلي' : 'جزئي';
        return $paymentCat;
    }
}
