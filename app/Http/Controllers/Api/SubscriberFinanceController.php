<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriberFinanceController extends Controller {
    public function getUserSubscriptionPaymentHistory(Request $request) {
        $user = $request->user();
        $paymentHistory = $user->paymentTransactions()->where('transaction_type', 'اشتراك')->get();
        return response()->json([
            'success' => true,
            'data' => $paymentHistory,
        ]);
    }
    public function getUserDonationPaymentHistory(Request $request) {
        $user = $request->user();
        $paymentHistory = $user->paymentTransactions()->where('transaction_type', 'التبرعات')->get();
        return response()->json([
            'success' => true,
            'data' => $paymentHistory,
        ]);
    }
    public function getsubscriptionDues(Request $request) {
        $user = $request->user();
        $subscriptionDues = $user->dues()->where('transaction_type', 'إشتراك')->get();
        return response()->json([
            'success' => true,
            'data' => $subscriptionDues,
        ]);
    }
    public function getUserDonationDues(Request $request) {
        $user = $request->user();
        $donationDues = $user->dues()->where('transaction_type', 'تبرعات')->get();
        return response()->json([
            'success' => true,
            'data' => $donationDues,
        ]);
    }
}
