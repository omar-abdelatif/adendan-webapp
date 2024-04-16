<?php

namespace App\Http\Controllers;

use App\Models\Delay;
use App\Models\Olddelays;
use App\Models\TotalSafe;
use App\Models\SafeReports;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Http\Requests\DelayRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSubscribersDelays;

class DelayController extends Controller
{
    public function storeDelays(DelayRequest $request) //! Store Total Delay For Single Subscriber ( Debrecated )
    {
        $validated = $request->validated();
        $subscriber = Subscribers::where('member_id', $request['member_id'])->first();
        if ($validated) {
            $store = Delay::create([
                'member_id' => $request['member_id'],
                'amount' => $request['amount'],
                'delay_period' => $request['delay_period'],
                'payment_type' => 'متأخرات',
                'subscribers_id' => $subscriber->id,
            ]);
            if ($store) {
                $subscriber->update(['status' => 0]);
                $notificationSuccess = [
                    "message" => "نم إضافة المديونية على المشترك بنجاح",
                    "alert-type" => "success",
                ];
                return redirect()->route('subscriber.all')->with($notificationSuccess);
            }
        }
        return redirect()->route('subscriber.all')->withErrors($validated);
    }
    public function uploadDelays(Request $request) //! Add Subscriptions Delay For All Subscribers
    {
        $validated = $request->validate([
            'year' => 'required|unique:delays,year',
            'yearly_cost' => 'required'
        ]);
        if ($validated) {
            $subscribers = Subscribers::all();
            $delays = Delay::get();
            if ($request->year === $delays->year) {
                return back()->withErrors($validated);
            } else {
                foreach ($subscribers as $subscriber) {
                    $delays = Delay::create([
                        'member_id' => $subscriber->member_id,
                        'year' => $request->year,
                        'yearly_cost' => $request->yearly_cost,
                        'payment_type' => 'إشتراك',
                        'subscribers_id' => $subscriber->id
                    ]);
                }
                if ($delays) {
                    $notificationSuccess = [
                        "message" => "تم أضافة السنة المالية للمشتركين بنجاح",
                        "alert-type" => "success",
                    ];
                    return redirect()->back()->with($notificationSuccess);
                }
            }
        }
        return back()->withErrors($validated);
    }
    public function subscriberDelay(Request $request) //! Upload Bulk Delay For Subscriptions For Subscribers
    {
        $validated = $request->validate([
            'import-delay' => 'required|mimes:xlsx,xls',
        ]);
        if ($validated) {
            $importDelay = Excel::import(new ImportSubscribersDelays, $request->file('import-delay'), null, \Maatwebsite\Excel\Excel::XLSX);
            if ($importDelay) {
                $notificationSuccess = [
                    'message' => "تم الاستيراد بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->route('subscriber.all')->with($notificationSuccess);
            }
        }
        return redirect()->route('subscriber.all')->withErrors($validated);
    }
    public function paySubscription(Request $request) //! Pay Single Subscription Delay For Single Subscriber
    {
        $id = $request->id;
        $validated = $request->validate([
            'paied' => 'required',
            'invoice_no' => 'required|unique:subscriptions,invoice_no'
        ]);
        $delay = Delay::where('year', $request->year)->where('id', $id)->first();
        $subscribers = Subscribers::where('member_id', $request->member_id)->first();
        $totalSafe = TotalSafe::where('id', 1)->first();
        if ($validated) {
            $cost = $delay->yearly_cost;
            $paied = $request->paied;
            $baky = $delay->remaing;
            if ($paied >= $cost) {
                $delay->delete();
                $pay = Subscriptions::create([
                    'member_id' => $request->member_id,
                    'subscription_cost' => $request->paied,
                    'period' => $request->year,
                    'invoice_no' => $request->invoice_no,
                    'payment_type' => 'إشتراك كلي',
                    'subscribers_id' => $subscribers->id
                ]);
                if ($pay) {
                    SafeReports::create([
                        'member_id' => $subscribers->member_id,
                        'transaction_type' => 'إشتراكات',
                        'amount' => $request['paied'],
                    ]);
                    $sumAmount = $totalSafe->amount + $request->paied;
                    $totalSafe->update([
                        'amount' => $sumAmount,
                    ]);
                    $subscribers->update(['status' => 1]);
                    $notificationSuccess = [
                        'message' => 'تم دفع كل المبلغ',
                        'alert-type' => 'success'
                    ];
                    return back()->with($notificationSuccess);
                }
            } else {
                $payed = $delay->paied;
                $remain = $delay->remaing;
                if ($payed == null && $remain == null) {
                    $remainingAmount = $cost - $paied;
                    $update = $delay->update([
                        'paied' => $paied,
                        'remaing' => $remainingAmount,
                    ]);
                    if ($update) {
                        $subscribers->update(['status' => 3]);
                        Subscriptions::create([
                            'member_id' => $request->member_id,
                            'subscription_cost' => $request->paied,
                            'period' => $request->year,
                            'invoice_no' => $request->invoice_no,
                            'payment_type' => 'إشتراك جزئي',
                            'subscribers_id' => $subscribers->id
                        ]);
                        SafeReports::create([
                            'member_id' => $subscribers->member_id,
                            'transaction_type' => 'إشتراكات',
                            'amount' => $request['paied'],
                        ]);
                        $sumAmount = $totalSafe->amount + $request['paied'];
                        $totalSafe->update([
                            'amount' => $sumAmount,
                        ]);
                        $notificationSuccess = [
                            'message' => 'تم دفع جزء من المبلغ',
                            'alert-type' => 'success'
                        ];
                        return back()->with($notificationSuccess);
                    }
                } else {
                    if ($paied >= $remain) {
                        $delay->delete();
                        $pay = Subscriptions::create([
                            'member_id' => $request->member_id,
                            'subscription_cost' => $remain,
                            'period' => $request->year,
                            'invoice_no' => $request->invoice_no,
                            'payment_type' => 'إشتراك كلي',
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($pay) {
                            $subscribers->update(['status' => 1]);
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'إشتراكات',
                                'amount' => $request->paied,
                            ]);
                            $sumAmount = $totalSafe->amount + $request->paied;
                            $totalSafe->update([
                                'amount' => $sumAmount,
                            ]);
                            $notificationSuccess = [
                                'message' => 'تم دفع كل المبلغ',
                                'alert-type' => 'success'
                            ];
                            return back()->with($notificationSuccess);
                        }
                    } else {
                        $delay->update([
                            'paied' => $paied + $delay->paied,
                            'remaing' => $baky - $paied,
                        ]);
                        $pay = Subscriptions::create([
                            'member_id' => $request->member_id,
                            'subscription_cost' => $request->paied,
                            'period' => $request->year,
                            'invoice_no' => $request->invoice_no,
                            'payment_type' => 'إشتراك جزئي',
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($remain === 0) {
                            $delay->delete();
                        }
                        if ($pay) {
                            $subscribers->update(['status' => 1]);
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'إشتراكات',
                                'amount' => $request['paied'],
                            ]);
                            $sumAmount = $totalSafe->amount + $request['paied'];
                            $totalSafe->update([
                                'amount' => $sumAmount,
                            ]);
                            $notificationSuccess = [
                                'message' => 'تم دفع كل المبلغ',
                                'alert-type' => 'success'
                            ];
                            return back()->with($notificationSuccess);
                        }
                    }
                }
            }
        }
        return back()->withErrors($validated);
    }
    public function payOldDelay(Request $request) //! Pay Single Old Delay For Single Subscriber
    {
        $validated = $request->validate([
            'invoice_no' => 'required|unique:subscriptions,invoice_no',
            'olddelay' => 'required',
        ]);
        $oldDelay = Olddelays::where('member_id', $request->member_id)->where('id', $request->id)->first();
        $subscribers = Subscribers::where('member_id', $request->member_id)->first();
        $totalSafe = TotalSafe::where('id', 1)->first();
        if ($validated) {
            $amount = $oldDelay->amount;
            $requestAmount = $request->olddelay;
            if ($requestAmount >= $amount) {
                $oldDelay->delete();
                $store = Subscriptions::create([
                    'member_id' => $request->member_id,
                    'invoice_no' => $request->invoice_no,
                    'delays' => $requestAmount,
                    'payment_type' => 'متأخرات كلية',
                    'subscribers_id' => $subscribers->id
                ]);
                if ($store) {
                    SafeReports::create([
                        'member_id' => $subscribers->member_id,
                        'transaction_type' => 'متأخرات',
                        'amount' => $request['olddelay'],
                    ]);
                    $sumAmount = $totalSafe->amount + $request['olddelay'];
                    $totalSafe->update([
                        'amount' => $sumAmount,
                    ]);
                    $notificationSuccess = [
                        'message' => 'تم دفع كل المبلغ',
                        'alert-type' => 'success'
                    ];
                    return back()->with($notificationSuccess);
                }
            } else {
                $oldDelayRemaining = $oldDelay->delay_remaining;
                $oldDelayAmount = $oldDelay->delay_amount;
                $remainingDelays = $amount - $requestAmount;
                if ($oldDelayAmount == null && $oldDelayRemaining == null) {
                    $update = $oldDelay->update([
                        'delay_amount' => $requestAmount,
                        'delay_remaining' => $remainingDelays,
                    ]);
                    if ($update) {
                        Subscriptions::create([
                            'member_id' => $request->member_id,
                            'delays' => $requestAmount,
                            'invoice_no' => $request->invoice_no,
                            'payment_type' => 'متأخرات جزئي',
                            'subscribers_id' => $subscribers->id
                        ]);
                        SafeReports::create([
                            'member_id' => $subscribers->member_id,
                            'transaction_type' => 'متأخرات',
                            'amount' => $requestAmount,
                        ]);
                        $sumAmount = $totalSafe->amount + $requestAmount;
                        $totalSafe->update([
                            'amount' => $sumAmount,
                        ]);
                        $notificationSuccess = [
                            'message' => 'تم دفع جزء من المبلغ',
                            'alert-type' => 'success'
                        ];
                        return back()->with($notificationSuccess);
                    }
                } else {
                    if ($requestAmount >= $oldDelayRemaining) {
                        $oldDelay->delete();
                        $pay = Subscriptions::create([
                            'member_id' => $request->member_id,
                            'delays' => $oldDelayRemaining,
                            'invoice_no' => $request->invoice_no,
                            'payment_type' => 'متأخرات كلي',
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($pay) {
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'متأخرات',
                                'amount' => $requestAmount,
                            ]);
                            $sumAmount = $totalSafe->amount + $requestAmount;
                            $totalSafe->update([
                                'amount' => $sumAmount,
                            ]);
                            $notificationSuccess = [
                                'message' => 'تم دفع جزء من المبلغ',
                                'alert-type' => 'success'
                            ];
                            return back()->with($notificationSuccess);
                        }
                    } else {
                        $oldDelay->update([
                            'delay_amount' => $requestAmount +  $oldDelayAmount,
                            'delay_remaining' => $oldDelayRemaining - $requestAmount,
                        ]);
                        $pay = Subscriptions::create([
                            'member_id' => $request->member_id,
                            'delays' => $requestAmount,
                            'invoice_no' => $request->invoice_no,
                            'payment_type' => 'متأخرات جزئي',
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($oldDelayRemaining === 0) {
                            $oldDelay->delete();
                        }
                        if ($pay) {
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'متأخرات',
                                'amount' => $requestAmount,
                            ]);
                            $sumAmount = $totalSafe->amount + $requestAmount;
                            $totalSafe->update([
                                'amount' => $sumAmount,
                            ]);
                            $notificationSuccess = [
                                'message' => 'تم دفع جزء من المبلغ',
                                'alert-type' => 'success'
                            ];
                            return back()->with($notificationSuccess);
                        }
                    }
                }
            }
        }
        return back()->withErrors($validated);
    }
}
