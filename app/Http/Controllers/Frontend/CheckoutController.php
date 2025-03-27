<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkingOut(Request $request){
        if ($request->pay_type === "subscription") {
            if ($request->online_payment === "e-wallet") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', 'إشتراك حالي');
            } else if ($request->online_payment === "online-card") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, 'online-card', $request->phone_number, 'إشتراك حالي');
            }
        } else if ($request->pay_type === "subscription_delay") {
            if ($request->online_payment === "e-wallet") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', 'متأخرات إشتراك');
            } else if ($request->online_payment === "online-card") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, 'online-card', $request->phone_number, 'متأخرات إشتراك');
            }
        } else if ($request->pay_type === "donation_delay") {
            if ($request->online_payment === "e-wallet") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', 'مديونية تبرعات');
            } else if ($request->online_payment === "online-card") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, 'online-card', $request->phone_number, 'مديونية تبرعات');
            }
        } else if ($request->pay_type === "donation_debt") {
            if ($request->online_payment === "e-wallet") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, $request->phone_number, 'e-wallet', 'متأخرات تبرعات');
            } else if ($request->online_payment === "online-card") {
                return app(PaymentController::class)->sendPayment($request->amount, $request->member_name, 'online-card', $request->phone_number, 'متأخرات تبرعات');
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
