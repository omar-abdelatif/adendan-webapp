<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Services\PaymobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller {
    public function __construct(private PaymobService $paymobService) {}
    // public function sendPayment(int $memberId, int $amount, string $memberName, int $phone, string $category, string $paymentMethod, string $item): JsonResponse {
    //     $nameParts  = explode(' ', trim($memberName));
    //     $firstName  = $nameParts[0] ?? 'NA';
    //     $lastName   = $nameParts[1] ?? 'NA';
    //     try {
    //         $intention = $this->paymobService->createIntention( amount: $amount, category: $category, firstName: $firstName, lastName: $lastName, phone: $phone );
    //         paymentTransaction($memberId, $amount, now(), $paymentMethod, $category, 'دفع اونلاين', 'ايداع', $item, null, $intention['intention_order_id'], 'pending');
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => $e->getMessage(),
    //             'alert-type' => 'error',
    //         ], 500);
    //     }
    //     return response()->json([
    //         'client_secret' => $intention['client_secret'],
    //         'message'    => 'تم الدفع بنجاح',
    //         'alert-type' => 'success',
    //         'checkout_url' => $this->paymobService->getCheckoutUrl($intention['client_secret']),
    //     ]);
    // }
    public function callback(Request $request): JsonResponse {
        Log::info('Paymob Callback', $request->all());
        $hmac = $request->query('hmac');
        $data = $request->query();
        if (!$hmac || !$this->paymobService->verifyHmac($data, $hmac)) {
            return response()->json(['message' => 'بيانات غير صحيحة'], 400);
        }
        if (($data['success'] ?? '') === "true") {
            DB::transaction(function () use ($data) {
                $transaction = $this->createTransaction($data['member_id'],$data['amount_cents'] / 100,now(),'دفع اونلاين',$data['payment_cat'],$data['item'],$data['order'],);
                $transaction->update([
                    'paymob_transaction_id' => $data['id'],
                    'paymob_status'         => 'paid',
                ]);
                $this->deductDue($transaction);
            });
            return response()->json(['message' => 'تم الدفع بنجاح']);
        }
        return response()->json(['message' => 'فشل الدفع'], 400);
    }
    public function initiatePayment(Request $request): JsonResponse {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'item'   => 'required|string',
            'payment_method' => 'required|string'
        ]);
        $user = $request->user();
        $userName = $user->name;
        $fName = explode(' ', $userName)[0] ?? 'NA';
        $lName = explode(' ', $userName)[1] ?? 'NA';
        $memberId = $user->member_id;
        try {
            $paymentCat = $this->paymobService->calculatePaymentCat($request->amount, $memberId, $request->item);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
        $clientSecret = $this->paymobService->createIntention($request->amount, $paymentCat, $fName, $lName, $user->mobile_no);
        return response()->json([
            'client_secret' => $clientSecret,
        ]);
    }
    private function deductDue(PaymentTransaction $transaction): void {
        $this->paymobService->deductDue($transaction);
    }
    private function createTransaction(int $memberId, int $amount, $paymentDate, string $paymentMethod, string $paymentCat, string $item, ?string $paymobIntentionId = null): PaymentTransaction {
        return paymentTransaction($memberId, $amount, now(), $paymentMethod, $paymentCat, 'دفع اونلاين', 'ايداع', $item, null, $paymobIntentionId, 'pending');
    }
}
