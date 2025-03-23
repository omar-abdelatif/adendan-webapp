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

    // public function sendPayment($amount, $member_name, $iframe_id_or_wallet_no, $payment_type, $integration_id): RedirectResponse {
    //     $response = Http::withoutVerifying()->withHeaders([
    //         'content-type' => 'application/json',
    //     ])->post("https://accept.paymobsolutions.com/api/auth/tokens", [
    //         "api_key" => env('PAYMOB_API_KEY'),
    //     ]);
    //     $json = $response->json();

    //     if (!isset($json['token'])) {
    //         return redirect()->route('site.search')->with([
    //             'message' => 'فشل في الحصول على التوكن',
    //             'alert-type' => 'error'
    //         ]);
    //     }
    //     //! Send Request Data
    //     $response_final = Http::withoutVerifying()->withHeaders([
    //         'content-type' => 'application/json',
    //     ])->post("https://accept.paymobsolutions.com/api/ecommerce/orders", [
    //         "auth_token" => $json['token'],
    //         "delivery_needed" => false,
    //         "amount_cents" => $amount * 100,
    //     ]);
    //     $json_final = $response_final->json();

    //     if (!isset($json_final['id'])) {
    //         return redirect()->route('site.search')->with([
    //             'message' => 'فشل في إنشاء الطلب',
    //             'alert-type' => 'error'
    //         ]);
    //     }
    //     //! Convert Member Name Into From String To Array
    //     $member = $member_name;
    //     $nameParts = explode(" ", $member);
    //     $first_name = $nameParts[0] . (isset($nameParts[1]) ? " " . $nameParts[1] : "");
    //     $last_name = $nameParts[2] ?? "N/A";
    //     //! Send Member Data
    //     $response_final_final = Http::withoutVerifying()->withHeaders([
    //         'content-type' => 'application/json',
    //     ])->post('https://accept.paymobsolutions.com/api/acceptance/payment_keys', [
    //         "auth_token" => $json['token'],
    //         "expiration" => 36000,
    //         "amount_cents" => $json_final['amount_cents'],
    //         "order_id" => $json_final['id'],
    //         "billing_data" => [
    //             "first_name" => $first_name,
    //             "last_name" => $last_name,
    //             "phone_number" => $iframe_id_or_wallet_no,
    //             "email" => "N/A",
    //             "city" => "Cairo",
    //             "country" => "Egypt",
    //             "address" => "Cairo",
    //             "apartment" => "N/A",
    //             "floor" => "Cairo",
    //             "state" => "Cairo",
    //             "postal_code" => "N/A",
    //             "shipping_method" => "N/A",
    //             "building" => "N/A",
    //             "street" => "N/A",
    //         ],
    //         "currency" => "EGP",
    //         "integration_id" => $integration_id,
    //     ]);
    //     $json_final_final = $response_final_final->json();
    //     if (!isset($json_final_final['token'])) {
    //         return redirect()->route('site.search')->with([
    //             'message' => 'فشل في إنشاء مفتاح الدفع',
    //             'alert-type' => 'error'
    //         ]);
    //     }

    //     if ($payment_type === "e-wallet") {
    //         $response_wallet = Http::withoutVerifying()->withHeaders([
    //             'content-type' => 'application/json',
    //         ])->post('https://accept.paymob.com/api/acceptance/payments/pay', [
    //             "source" => [
    //                 'identifier' => $iframe_id_or_wallet_no,
    //                 'owner_name' => $member_name,
    //                 'subtype' => 'WALLET',
    //             ],
    //             "payment_token" => $json_final_final['token'],
    //         ]);
    //         $response_wallet_json = $response_wallet->json();
    //         if (isset($response_wallet_json['redirect_url'])) {
    //             return redirect($response_wallet_json['redirect_url']);
    //         }
    //         return redirect()->route('site.search')->with([
    //             'message' => 'فشل في الحصول على رابط الدفع',
    //             'alert-type' => 'error'
    //         ]);
    //     } else if ($payment_type === "online-card") {
    //         return redirect('https://accept.paymobsolutions.com/api/acceptance/iframes/' . $iframe_id_or_wallet_no . '?payment_token=' . $json_final_final['token']);
    //     }
    //     //! Default return in case no condition matches
    //     return redirect()->route('site.search')->with([
    //         'message' => 'نوع الدفع غير معروف',
    //         'alert-type' => 'error'
    //     ]);
    // }



    public function sendPayment($amount=null, $member_name=null, $mobile_phone=null, $payment_type=null) {
        $nameParts = explode(" ", trim($member_name));
        $first_name = $nameParts[0] ?? "N/A";
        $last_name = isset($nameParts[1]) ? $nameParts[1] : "N/A";

        $response = Http::withoutVerifying()->withHeaders([
            "Authorization" => env('PAYMOB_SK'), // ✅ هنا بنستخدم التوكين
        ])->post("https://accept.paymob.com/v1/intention/", [
            "amount" => $amount * 100,
            "currency" => "EGP",
            "payment_methods" => [4991600, 4991596],
            "billing_data" => [
                "first_name" => $first_name,
                "last_name" => $last_name,
                "phone_number" => $mobile_phone,
                "email" => "user@adendan.com"
            ],
            "integration_id" => ($payment_type === "e-wallet") ? env('PAYMOB_INTEGRATION_WALLET_ID') : env('PAYMOB_INTEGRATION_CARD_ID'),
        ])->json();

        // dd($response);

        if (isset($response['client_secret'])) {
            return redirect('https://accept.paymob.com/unifiedcheckout/?publicKey=' . env('PAYMOB_PK') . '&clientSecret=' . $response['client_secret']); // 🔄 تحويل المستخدم إلى صفحة الدفع
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