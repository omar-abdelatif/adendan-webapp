<?php

namespace App\Services;

use App\Models\Due;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymobService {
    public function verifyHmac(array $data, string $receivedHmac): bool {
        $secret = config('services.paymob.hmac_secret');
        $fields = [
            (int) ($data['amount_cents'] ?? 0),
            $data['created_at'] ?? '',
            $data['currency'] ?? '',
            (int) ($data['error_occured'] ?? 0),
            (int) ($data['has_parent_transaction'] ?? 0),
            (int) ($data['id'] ?? 0),
            (int) ($data['integration_id'] ?? 0),
            (int) ($data['is_3d_secure'] ?? 0),
            (int) ($data['is_auth'] ?? 0),
            (int) ($data['is_capture'] ?? 0),
            (int) ($data['is_refunded'] ?? 0),
            (int) ($data['is_standalone_payment'] ?? 0),
            (int) ($data['is_voided'] ?? 0),
            (int) ($data['order']['id'] ?? 0),
            (int) ($data['owner'] ?? 0),
            (int) ($data['pending'] ?? 0),
            $data['source_data']['pan'] ?? '',
            $data['source_data']['sub_type'] ?? '',
            $data['source_data']['type'] ?? '',
            $data['success'] ? 'true' : 'false',
        ];
        $str = implode('', $fields);
        $hash = hash_hmac('sha512', $str, $secret);
        Log::info('HMAC Verification:', [
            'fields_string' => $str,
            'calculated_hash' => $hash,
            'received_hash' => $receivedHmac,
            'match' => $hash === $receivedHmac,
        ]);
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
