<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\PaymobService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{

    protected $paymobService;

    public function __construct(PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function sendPayment($amount=null, $member_name=null, $mobile_phone=null, $payment_type=null, $payment_category=null) {
        $nameParts = explode(" ", trim($member_name));
        $first_name = $nameParts[0] ?? "N/A";
        $last_name = isset($nameParts[1]) ? $nameParts[1] : "N/A";
        $response = Http::withoutVerifying()->withHeaders([
            "Authorization" => env('PAYMOB_SK'),
        ])->post("https://accept.paymob.com/v1/intention/", [
            "amount" => $amount * 100,
            "currency" => "EGP",
            "payment_methods" => [4991600, 4991596],
            "items" => [
                [
                    "name" => $payment_category,
                    "amount" => $amount * 100,
                    "quantity" => 1,
                    "description" => $payment_category
                ]
            ],
            "billing_data" => [
                "first_name" => $first_name,
                "last_name" => $last_name,
                "phone_number" => $mobile_phone,
                "email" => "user@adendan.com"
            ],
        ])->json();
        if (isset($response['client_secret'])) {
            return redirect('https://accept.paymob.com/unifiedcheckout/?publicKey=' . env('PAYMOB_PK') . '&clientSecret=' . $response['client_secret']);
        }
        return redirect()->back()->with([
            'message' => 'فشل في إنشاء الدفع، حاول مرة أخرى',
            'alert-type' => 'error'
        ]);
    }

    public function callback(Request $request): RedirectResponse {
        if ($request->success === "true") {
            return (new CheckoutController)->checkout($request);
        }
        $notification = [
            'message' => "بيانات الدفع غير صحيحة",
            'alert-type' => 'error'
        ];
        return redirect()->route('site.search')->with($notification);
    }
}