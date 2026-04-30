<?php

namespace App\Http\Controllers;

use App\Models\Delay;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionsController extends Controller {
    function __construct() {
        $this->middleware('permission:الاشتراكات');
    }
    public function index(int $subscriberId) {
        $subscriber = Subscribers::find($subscriberId);
        $subscriptions = $subscriber->paymentTransactions;
        $subDue = $subscriber->dues()->where('transaction_type', 'إشتراك')->get();
        $totalSubscriptionAmount = $subDue->sum('amount_remaining');
        $donDue = $subscriber->dues()->where('transaction_type', 'تبرعات')->get();
        $totalDonationAmount = $donDue->sum('total_amount');
        return view('pages.subscriptions.subscriptions_details', compact('subscriber', 'subscriptions', 'subDue', 'donDue', 'totalSubscriptionAmount', 'totalDonationAmount'));
    }
    public function storeSubscription(SubscriptionRequest $request) {
        $validated = $request->validated();
        if ($validated) {
            $subscriber = Subscribers::where('member_id', $validated['member_id'])->first();
            $oldDelays = Delay::where('member_id', $validated['member_id'])->first();
            if ($subscriber) {
                $store = Subscriptions::create([
                    'member_id' => $request['member_id'],
                    'subscription_cost' => $request['subscription_cost'],
                    'invoice_no' => $request['invoice_no'],
                    'period' => $oldDelays->year,
                    'delays' => $request['delays'],
                    'payment_type' => $request['payment_type'],
                    'payment_date' => $request['payment_date'],
                    'delays_period' => $request['delays_period'],
                    'subscribers_id' => $subscriber->id,
                ]);
                if ($store) {
                    $subscriber->update(['status' => 1]);
                    $oldDelays->delete();
                    $notificationSuccess = [
                        "message" => "تم الإضافة بنجاح",
                        "alert-type" => "success"
                    ];
                    return redirect()->back()->with($notificationSuccess);
                }
            }
        }
        return redirect()->back()->withErrors($validated);
    }
    public function destroyingSubscription(int $id) {
        $subscription = Subscriptions::find($id);
        if ($subscription) {
            $delete = $subscription->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        $notificationErrors = [
            'message' => "هذا العنصر غير موجود",
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationErrors);
    }
    public function updatingSubscription(Request $request) {
        $id = $request->id;
        $subscription = Subscriptions::find($id);
        if ($subscription) {
            $update = $subscription->update($request->all());
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم تحديث الإشتراك',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        $notificationError = [
            'message' => 'حدث خطأ... برجاء المحاولة مره اخرى',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationError);
    }
}
