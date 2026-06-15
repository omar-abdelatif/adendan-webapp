<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Services\Api\AuthService;
use App\Services\PaymobService;
// use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller {
    public function __construct(private PaymobService $paymobService, protected AuthService $authedService) {}
    // public function callback(Request $request): JsonResponse {
    //     Log::info('=== CALLBACK DEBUG ===');
    //     $hmac = $request->query('hmac');
    //     $type = $request->input('type');
    //     $obj = $request->input('obj');
    //     if ($type !== 'TRANSACTION' || !is_array($obj)) {
    //         Log::error('Invalid structure', ['type' => $type]);
    //         return response()->json(['message' => 'بيانات غير صحيحة'], 400);
    //     }
    //     $merchantOrderId = $obj['order']['merchant_order_id'] ?? null;
    //     $success = $obj['success'] ?? false;

    //     if (!$merchantOrderId) {
    //         Log::error('merchant_order_id is NULL');
    //         return response()->json(['message' => 'بيانات ناقصة'], 400);
    //     }

    //     if (!$hmac || !$this->paymobService->verifyHmac($obj, $hmac)) {
    //         Log::error('HMAC verification failed');
    //         return response()->json(['message' => 'بيانات غير صحيحة'], 400);
    //     }

    //     if (!$success) {
    //         Log::error('Payment not successful');
    //         return response()->json(['message' => 'فشل الدفع'], 400);
    //     }
    //     $data = $request->query();
    //     $merchantOrderId = $request->query('merchant_order_id');
    //     $userData = explode('-', $merchantOrderId, 2);
    //     if (count($userData) < 2) {
    //         Log::error('Invalid merchant_order_id format', ['value' => $merchantOrderId]);
    //         return response()->json(['message' => 'بيانات غير صحيحة'], 400);
    //     }
    //     $memberId = $userData[0];
    //     $item = trim($userData[1]);
    //     $amount = $data['amount_cents'] / 100;
    //     $paymentMethod = $obj['source_data']['sub_type'] ?? 'wallet';
    //     Log::info('Parsed:', [
    //         'hmac_present' => $hmac ? 'yes' : 'no',
    //         'type' => $type,
    //         'has_obj' => is_array($obj),
    //     ]);
    //     Log::info('Extracted data:', [
    //         'merchant_order_id' => $merchantOrderId,
    //         'success' => $success,
    //     ]);
    //     Log::info('Processing transaction:', [
    //         'member_id' => $memberId,
    //         'item' => $item,
    //         'amount' => $amount,
    //     ]);
    //     if (!$hmac || !$this->paymobService->verifyHmac($data, $hmac)) {
    //         return response()->json(['message' => 'بيانات غير صحيحة'], 400);
    //     }
    //     if (($data['success'] ?? '') === "true") {
    //         $paymentCat = $this->paymobService->calculatePaymentCat($amount, $memberId, $item);
    //         DB::transaction(function () use ($obj, $data, $memberId, $amount, $paymentCat, $item, $paymentMethod) {
    //             $transaction = $this->createTransaction($memberId, $amount, now(), $paymentMethod, $paymentCat, $item, $data['order']);
    //             $transaction->update([
    //                 'paymob_transaction_id' => $data['id'],
    //                 'paymob_status'         => 'paid',
    //             ]);
    //             $this->deductDue($transaction);
    //             Log::info('Transaction completed:', ['id' => $transaction->id]);
    //         });
    //         return response()->json(['message' => 'تم الدفع بنجاح']);
    //     }
    //     return response()->json(['message' => 'فشل الدفع'], 400);
    // }
    // public function callback(Request $request) {
    //     Log::info('=== CALLBACK DEBUG ===');
    //     $data = $request->all();
    //     $hmac = $request->query('hmac');
    //     $type = $request->input('type');
    //     $obj = $request->input('obj');

    //     $merchantOrderId = $data['merchant_order_id'] ?? null;
    //     $orderId         = $data['order'] ?? null;
    //     $transactionId   = $data['id'] ?? null;
    //     $amountCents     = $data['amount_cents'] ?? 0;
    //     $success         = ($data['success'] ?? 'false') === 'true';
    //     Log::info('Extracted data:', [
    //         'merchant_order_id' => $merchantOrderId,
    //         'success'           => $success ? 'yes' : 'no',
    //     ]);
    //     if (!$merchantOrderId) {
    //         Log::error('merchant_order_id is NULL');
    //         return response()->json(['message' => 'بيانات ناقصة'], 400);
    //     }
    //     if (!$success) {
    //         Log::error('Payment not successful');
    //         return response()->json(['message' => 'فشل الدفع'], 400);
    //     }
    //     if (!$hmac || !$this->paymobService->verifyHmac($data, $hmac)) {
    //         Log::error('HMAC verification failed');
    //         return response()->json(['message' => 'بيانات غير صحيحة (فشل التشفير)'], 400);
    //     }
    //     $userData = explode('-', $merchantOrderId, 2);
    //     if (count($userData) < 2) {
    //         Log::error('Invalid merchant_order_id format', ['value' => $merchantOrderId]);
    //         return response()->json(['message' => 'بيانات غير صحيحة'], 400);
    //     }
    //     $memberId      = (int) $userData[0];
    //     $item          = trim($userData[1]);
    //     $amount        = $amountCents / 100;
    //     $paymentMethod = $data['source_data_sub_type'] ?? 'wallet';
    //     Log::info('Processing transaction:', [
    //         'member_id' => $memberId,
    //         'item'      => $item,
    //         'amount'    => $amount,
    //         'method'    => $paymentMethod,
    //     ]);
    //     DB::transaction(function () use ($memberId, $amount, $item, $paymentMethod, $transactionId, $orderId) {
    //         $paymentCat = $this->paymobService->calculatePaymentCat($amount, $memberId, $item);
    //         $transaction = $this->createTransaction($memberId, $amount, now(), $paymentMethod, $paymentCat, $item, $orderId);
    //         $transaction->update([
    //             'paymob_transaction_id' => $transactionId,
    //             'paymob_status'         => 'paid',
    //         ]);
    //         $this->deductDue($transaction);
    //         Log::info('Transaction completed:', ['id' => $transaction->id]);
    //     });
    //     return response()->json(['message' => 'تم الدفع بنجاح']);
    // }
    public function callback(Request $request)
    {
        Log::info('=== CALLBACK DEBUG ===');

        // ✅ الـ data الكاملة
        $allData = $request->all();
        Log::info('Full request:', $allData);

        // ✅ اقرأ من الـ nested structure
        $hmac = $request->query('hmac');
        $type = $request->input('type');
        $obj = $request->input('obj');

        // تحقق من الـ structure
        if ($type !== 'TRANSACTION' || !is_array($obj)) {
            Log::error('Invalid structure', ['type' => $type]);
            return response()->json(['message' => 'بيانات غير صحيحة'], 400);
        }

        // ✅ اقرأ من $obj (مش $data)
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

        $userData = explode('-', $merchantOrderId, 2);

        if (count($userData) < 2) {
            Log::error('Invalid merchant_order_id format', ['value' => $merchantOrderId]);
            return response()->json(['message' => 'بيانات غير صحيحة'], 400);
        }

        $memberId = (int) $userData[0];
        $item = trim($userData[1]);
        $amount = $amountCents / 100;
        $paymentMethod = $obj['source_data']['sub_type'] ?? 'wallet';

        Log::info('Processing transaction:', [
            'member_id' => $memberId,
            'item' => $item,
            'amount' => $amount,
            'method' => $paymentMethod,
        ]);

        DB::transaction(function () use ($memberId, $amount, $item, $paymentMethod, $transactionId, $orderId) {
            $paymentCat = $this->paymobService->calculatePaymentCat($amount, $memberId, $item);

            $transaction = $this->createTransaction(
                $memberId,
                $amount,
                now(),
                $paymentMethod,
                $paymentCat,
                $item,
                $orderId
            );

            $transaction->update([
                'paymob_transaction_id' => $transactionId,
                'paymob_status' => 'paid',
            ]);

            $this->deductDue($transaction);

            Log::info('Transaction completed:', ['id' => $transaction->id]);
        });

        return response()->json(['message' => 'تم الدفع بنجاح']);
    }
    private function deductDue(PaymentTransaction $transaction): void {
        $this->paymobService->deductDue($transaction);
    }
    private function createTransaction(int $memberId, int $amount, $paymentDate, string $paymentMethod, string $paymentCat, string $item, ?string $paymobIntentionId = null): PaymentTransaction {
        return paymentTransaction($memberId, $amount, $paymentDate, $paymentMethod, $paymentCat, 'دفع اونلاين', 'ايداع', $item, null, $paymobIntentionId, 'pending');
    }
}
