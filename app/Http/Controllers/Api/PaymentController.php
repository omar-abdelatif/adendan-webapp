<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Services\EgyptLinxSmsService;
use App\Services\PaymobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller {
    public function __construct(private PaymobService $paymobService, protected EgyptLinxSmsService $egyptLinkService) {}
    public function callback(Request $request) {
        Log::info('=== CALLBACK DEBUG ===');
        $allData = $request->all();
        Log::info('Full request:', $allData);
        // $hmac = $request->query('hmac');
        $type = $request->input('type');
        $obj = $request->input('obj');
        if ($type !== 'TRANSACTION' || !is_array($obj)) {
            Log::error('Invalid structure', ['type' => $type]);
            return response()->json(['message' => 'بيانات غير صحيحة'], 400);
        }
        $merchantOrderId = $obj['order']['merchant_order_id'] ?? null;
        $orderId = $obj['order']['id'] ?? null;
        $transactionId = $obj['id'] ?? null;
        $amountCents = $obj['amount_cents'] ?? 0;
        $success = $obj['success'] ?? false;
        Log::info('Extracted data:', [
            'merchant_order_id' => $merchantOrderId,
            'success' => $success ? 'yes' : 'no',
        ]);
        if (!$merchantOrderId) {
            Log::error('merchant_order_id is NULL');
            return response()->json(['message' => 'بيانات ناقصة'], 400);
        }
        if (!$success) {
            Log::error('Payment not successful');
            return response()->json(['message' => 'فشل الدفع'], 400);
        }
        // ✅ تحقق من الـ HMAC (من $obj مش من $data)
        // if (!$hmac || !$this->paymobService->verifyHmac($obj, $hmac)) {
        //     Log::error('HMAC verification failed');
        //     return response()->json(['message' => 'بيانات غير صحيحة (فشل التشفير)'], 400);
        // }
        $userData = explode('-', $merchantOrderId);
        if (count($userData) < 2) {
            Log::error('Invalid merchant_order_id format', ['value' => $merchantOrderId]);
            return response()->json(['message' => 'بيانات غير صحيحة'], 400);
        }
        $memberId = (int) $userData[0];
        $item = trim($userData[1]);
        $amount = $amountCents / 100;
        $subscriptionDate = now();
        $transactionMethod = $userData[2];
        $mobileNumber = (int) $userData[4];
        $paymentMethod = $obj['source_data']['sub_type'] ?? 'wallet';
        Log::info('Processing transaction:', [
            'member_id' => $memberId,
            'item' => $item,
            'amount' => $amount,
            'method' => $paymentMethod,
        ]);
        DB::transaction(function () use ($memberId, $amount, $item, $paymentMethod, $transactionId, $orderId, $transactionMethod, $subscriptionDate, $mobileNumber) {
            $paymentCat = $item === 'رسائل' ? 'كلي' : $this->paymobService->calculatePaymentCat($amount, $memberId, $item);
            if ($item === 'رسائل') {
                $transaction = $this->createTransaction($memberId, $amount, $subscriptionDate, $paymentMethod, $paymentCat, $item, $orderId, $transactionMethod);
                $transaction->update([
                    'paymob_transaction_id' => $transactionId,
                    'paymob_status' => 'paid',
                ]);
                $this->egyptLinkService->storeOrUpdateSmsSubscriber($memberId, $mobileNumber, $subscriptionDate);
            } else {
                $transaction = $this->createTransaction($memberId, $amount, $subscriptionDate, $paymentMethod, $paymentCat, $item, $orderId, $transactionMethod);
                $transaction->update([
                    'paymob_transaction_id' => $transactionId,
                    'paymob_status' => 'paid',
                ]);
                $this->deductDue($transaction);
            }
            Log::info('Transaction completed:', ['id' => $transaction->id]);
        });
        return response()->json(['message' => 'تم الدفع بنجاح']);
    }
    private function deductDue(PaymentTransaction $transaction): void {
        $this->paymobService->deductDue($transaction);
    }
    private function createTransaction(int $memberId, int $amount, $paymentDate, string $paymentMethod, string $paymentCat, string $item, ?string $paymobIntentionId = null, string $transactionType): PaymentTransaction {
        return paymentTransaction(memberId: $memberId, amount: $amount, paymentDate: $paymentDate, paymentMethod: $paymentMethod, paymentCategory: $paymentCat, transactionType: $transactionType, transactionCategory: 'ايداع', item: $item, inv: 0, paymobIntentionId: $paymobIntentionId, paymobStatus: 'pending', transactionMethod: 'دفع اونلاين',);
    }
}
