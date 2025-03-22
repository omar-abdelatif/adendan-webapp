<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkingOut(Request $request){
        if ($request->pay_type === "subscription") {
            if ($request->online_payment === "e-wallet") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', env('PAYMOB_INTEGRATION_WALLET_ID'));
            } else if ($request->online_payment === "online-card") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, env('PAYMOB_INTEGRATION_CARD_IFRAME'), 'online-card', env('PAYMOB_INTEGRATION_CARD_ID'));
            }
        } else if ($request->pay_type === "subscription_delay") {
            if ($request->online_payment === "e-wallet") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', env('PAYMOB_INTEGRATION_WALLET_ID'));
            } else if ($request->online_payment === "online-card") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, env('PAYMOB_INTEGRATION_CARD_IFRAME'), 'online-card', env('PAYMOB_INTEGRATION_CARD_ID'));
            }
        } else if ($request->pay_type === "donation_delay") {
            if ($request->online_payment === "e-wallet") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', env('PAYMOB_INTEGRATION_WALLET_ID'));
            } else if ($request->online_payment === "online-card") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, env('PAYMOB_INTEGRATION_CARD_IFRAME'), 'online-card', env('PAYMOB_INTEGRATION_CARD_ID'));
            }
        } else if ($request->pay_type === "donation_debt") {
            if ($request->online_payment === "e-wallet") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', env('PAYMOB_INTEGRATION_WALLET_ID'));
            } else if ($request->online_payment === "online-card") {
                return (new PaymentController)->sendPayment($request->amount, $request->member_name, env('PAYMOB_INTEGRATION_CARD_IFRAME'), 'online-card', env('PAYMOB_INTEGRATION_CARD_ID'));
            }
        }
    }
    public function checkout(Request $request){
        if($request->success === "true"){
            return redirect()->route('site.search')->with([
                'message' => "تم الدفع بنجاح",
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('site.search')->with([
                'message' => "حدث خطأ أثناء الدفع, يرجى المحاولة مرة ثانية",
                'alert-type' => 'danger'
            ]);
        }
    }
}
