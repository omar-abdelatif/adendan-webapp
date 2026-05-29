<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller {
    private array $categoryMap = [
        'subscription_due' => 'مستحقات إشتراك',
        'donation_due'      => 'مستحقات تبرعات',
    ];

    public function checkingOut(Request $request): JsonResponse {
        $request->validate([
            'pay_type'       => 'required|in:subscription,subscription_due,donation_due',
            'online_payment' => 'required|in:wallet,card',
            'amount'         => 'required|numeric|min:1',
            'member_name'    => 'required|string',
            'phone_number'   => 'required|numeric',
            "member_id"      => 'required|numeric',
            'item'           => 'required|string',
        ]);
        $category = $this->categoryMap[$request->pay_type] ?? $request->pay_type;
        return app(PaymentController::class)->sendPayment(memberId: (int) $request->member_id, amount: (int) $request->amount, memberName: $request->member_name, phone: (int) $request->phone_number, category: $category, paymentMethod: $request->online_payment, item: $request->item,);
    }
}
