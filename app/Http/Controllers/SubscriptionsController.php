<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Delay;
use App\Models\Subscribers;
use App\Models\Subscriptions;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index($subscriberId)
    {
        $subscriber = Subscribers::find($subscriberId);
        if ($subscriber) {
            $subscriptions = $subscriber->subscriptions;
            return view('pages.subscriptions.subscriptions_details', compact('subscriber', 'subscriptions'));
        }
    }
    public function storeSubscription(SubscriptionRequest $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $subscriber = Subscribers::where('member_id', $validated['member_id'])->first();
            $delays = Delay::where('member_id', $validated['member_id'])->first();
            if ($subscriber) {
                $store = Subscriptions::create([
                    'member_id' => $request['member_id'],
                    'subscription_cost' => $request['subscription_cost'],
                    'invoice_no' => $request['invoice_no'],
                    'pay_date' => $request['pay_date'],
                    'period' => $request['period'],
                    'delays' => $request['delays'],
                    'payment_type' => $request['payment_type'],
                    'delays_period' => $request['delays_period'],
                    'subscribers_id' => $subscriber->id,
                ]);
                if ($store) {
                    $subscriber->update(['status' => 1]);
                    $delays->delete();
                    $notificationSuccess = [
                        "message" => "تم الإضافة بنجاح",
                        "alert-type" => "success"
                    ];
                    return redirect()->route('subscription.history', $subscriber->id)->with($notificationSuccess);
                }
            }
        }
        return redirect()->route('subscriber.all')->withErrors($validated);
    }
    public function destroyingSubscription($id)
    {
        $subscription = Subscriptions::find($id);
        if ($subscription) {
            $delete = $subscription->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->route('subscriber.all')->with($notificationSuccess);
            }
        }
        $notificationErrors = [
            'message' => "هذا العنصر غير موجود",
            'alert-type' => 'error'
        ];
        return redirect()->route('subscriber.all')->with($notificationErrors);
    }
    public function updatingSubscription(SubscriptionRequest $request)
    {
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
