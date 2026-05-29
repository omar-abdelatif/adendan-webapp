<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Services\PaymobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    public function __construct(private PaymobService $paymobService) {}
    public function sendPayment(int $memberId, int $amount, string $memberName, int $phone, string $category, string $paymentMethod, string $item): JsonResponse {
        $nameParts  = explode(' ', trim($memberName));
        $firstName  = $nameParts[0] ?? 'NA';
        $lastName   = $nameParts[1] ?? 'NA';
        try {
            $intention = $this->paymobService->createIntention( amount: $amount, category: $category, firstName: $firstName, lastName: $lastName, phone: $phone );
            paymentTransaction($memberId, $amount, now(), $paymentMethod, $category, 'دفع اونلاين', 'ايداع', $item, null, $intention['intention_order_id'], 'pending',);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'alert-type' => 'error',
            ], 500);
        }
        return response()->json([
            'client_secret' => $intention['client_secret'],
            'message'    => 'تم الدفع بنجاح',
            'alert-type' => 'success',
            'checkout_url' => $this->paymobService->getCheckoutUrl($intention['client_secret']),
        ]);
    }
    public function callback(Request $request): JsonResponse {
        $hmac = $request->query('hmac');
        $data = $request->query();
        if (!$hmac || !$this->paymobService->verifyHmac($data, $hmac)) {
            return response()->json([
                'message'    => 'بيانات الدفع غير صحيحة',
                'alert-type' => 'error',
            ], 400);
        } else if (($data['success'] ?? '') === "true") {
            $transaction = PaymentTransaction::where('paymob_intention_id', $data['order'])->where('paymob_status', 'pending')->first();
            if ($transaction) {
                $transaction->update([
                    'paymob_transaction_id' => $data['id'],
                    'paymob_status'         => 'paid',
                ]);
                $this->paymobService->deductDue($transaction);
            }
            return response()->json([
                'message'    => 'تم الدفع بنجاح',
                'alert-type' => 'success',
            ]);
        }
        return response()->json([
            'message'    => 'حدث خطأ أثناء الدفع، يرجى المحاولة مرة أخرى',
            'alert-type' => 'danger',
        ], 500);
    }
    public function deductDue(Request $request, int $transactionId) {
        $user = $request->user();
        $memberId = $user->member_id;
        $this->createTransaction($transactionId, $memberId, $request->amount, now(), 'دفع اونلاين', 'دفع مستحق', null);
        $this->paymobService->deductDue($transactionId);
        return response()->json([
            'message'    => 'تم خصم المستحق بنجاح',
            'alert-type' => 'success',
        ]);
    }
    private function createTransaction(int $memberId, int $amount, $paymentDate, string $paymentMethod, string $paymentCat, string $item, ?string $paymobIntentionId = null): PaymentTransaction {
        return paymentTransaction($memberId, $amount, now(), $paymentMethod, $paymentCat, 'دفع اونلاين', 'ايداع', $item, null, $paymobIntentionId, 'pending');
    }
}
