<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\SMSService;
use App\Http\Controllers\Controller;
use App\Services\EgyptLinxSmsService;

class SMSController extends Controller {
    public function __construct(protected EgyptLinxSmsService $egyptLinkService, protected SMSService $smsService) {}
    public function getUserSmsPaymentHistory(Request $request){
        $user = $request->user();
        $history = $user->paymentTransactions()->where('item','رسائل')->get();
        return response()->json([
            'success' => true,
            'data' => $history,
        ]);
    }
    public function paySmsSubscription(Request $request) {
        $user = $request->user();
        $userMemberId = $user->member_id;
        $mobileNumber = $user->mobile_no;
        $paymentMethod = $request->payment_method;
        $amount = $this->egyptLinkService->smsFees();
        $subscriptionDate = now();
        $this->egyptLinkService->storeOrUpdateSmsSubscriber($userMemberId, $mobileNumber, $amount, $subscriptionDate);
        $transaction = $user->paymentTransactions()->create([
            'amount' => $amount,
            'item' => 'رسائل',
            'payment_cat' => 'دفع اولاين',
            'payment_date' => now(),
            'inv_no' => 0,
            'transaction_type' => 'اشتراك',
            'payment_method' => $paymentMethod,
            'transaction_cat' => 'ايداع',
            'paymob_status' => 'pending',
        ]);
        return response()->json([
            'success' => true,
            'message' => 'تم دفع اشتراك الرسائل بنجاح',
            'transaction' => $transaction,
        ]);
    }
    public function getSmsStatus(Request $request) {
        $user = $request->user();
        $memberId = $user->member_id;
        $smsStatus = $this->smsService->getSmsStatus($memberId);
        if ($smsStatus === false) {
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد اشتراك لهذا العضو',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'sms_status' => $smsStatus,
        ]);
    }
    public function renewSms(Request $request) {
        $user = $request->user();
        $userMemberId = $user->member_id;
        $amount = $this->egyptLinkService->smsFees();
        $paymentMethod = $request->payment_method;
        $subscriptionDate = now();
        $this->egyptLinkService->renewSmsSubscription($userMemberId, $amount, $subscriptionDate);
        $transaction = $user->paymentTransactions()->create([
            'amount' => $amount,
            'item' => 'تجديد الرسائل',
            'payment_cat' => 'تجديد اولاين',
            'payment_date' => now(),
            'inv_no' => 0,
            'transaction_type' => 'تجديد اشتراك',
            'payment_method' => $paymentMethod,
            'transaction_cat' => 'ايداع',
            'paymob_status' => 'pending',
        ]);
        return response()->json([
            'success' => true,
            'message' => 'تم تجديد اشتراك الرسائل بنجاح',
            'transaction' => $transaction,
        ]);
    }
    public function getSmsFees() {
        $fees = $this->egyptLinkService->smsFees();
        return response()->json([
            'success' => true,
            'fees' => $fees,
        ]);
    }
}
