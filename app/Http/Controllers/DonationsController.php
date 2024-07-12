<?php

namespace App\Http\Controllers;

use App\Models\Donations;
use App\Models\Olddelays;
use App\Models\TotalSafe;
use App\Models\SafeReports;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Models\DonationDelay;
use App\Http\Requests\RequestDonations;

class DonationsController extends Controller
{
    public function index($id)
    {
        $subscriber = Subscribers::find($id);
        if ($subscriber) {
            $donations = $subscriber->donations;
            $delayDonation = DonationDelay::where('member_id', $subscriber->member_id)->get();
            $oldDelayDonations = Olddelays::where('member_id', $subscriber->member_id)->where('old_delay_type', 'تبرعات')->get();
            return view('pages.donations.donation_history', compact('subscriber', 'donations', 'delayDonation', 'oldDelayDonations'));
        }
    }
    public function storeDonations(RequestDonations $request)
    {
        $validated = $request->validated();
        $subscribers = Subscribers::where('member_id', $request['member_id'])->first();
        $totalSafe = TotalSafe::where('id', 1)->first();
        if ($subscribers) {
            $store = Donations::create([
                'member_id' => $request['member_id'],
                'amount' => $request['amount'],
                'invoice_no' => $request['invoice_no'],
                'donation_type' => $request['donation_type'],
                'other_donation' => $request['other_donation'],
                'donation_category' => $request['donation_category'],
                'subscribers_id' => $subscribers->id,
            ]);
            if ($store) {
                SafeReports::create([
                    'member_id' => $subscribers->member_id,
                    'transaction_type' => 'تبرعات',
                    'amount' => $request['amount'],
                ]);
                $sumAmount = $totalSafe->amount + $request['amount'];
                $totalSafe->update(['amount' => $sumAmount]);
                $notificationSuccess = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->route('donations.showAll', $subscribers->id)->withErrors($validated);
    }
    public function removeDonation($id)
    {
        $donation = Donations::find($id);
        if ($donation) {
            $remove = $donation->delete();
            if ($remove) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجاح!",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
            $notificationErrors = [
                'message' => "هذا العنصر غير موجود",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notificationErrors);
        }
    }
    public function updateDonation(RequestDonations $request)
    {
        $id = $request->id;
        $donations = Donations::find($id);
        if ($donations) {
            $update = $donations->update($request->all());
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
    public function donationsOnSubscribers(Request $request) //! تبرعات على الأعضاء
    {
        $validated = $request->validate(['donation_category' => 'required',
            'delay_amount' => 'required'
        ]);
        if ($validated) {
            $subscribers = Subscribers::all();
            foreach ($subscribers as $subscriber) {
                $delays = DonationDelay::create([
                    'member_id' => $subscriber->member_id,
                    'donation_type' => 'أخرى',
                    'donation_category' => $request->category,
                    'payment_type' => 'تبرعات',
                    'delay_amount' => $request->delay_amount,
                ]);
            }
            if ($delays) {
                $notificationSuccess = [
                    "message" => "تم أضافة مديونية التبرعات للمشتركين بنجاح",
                    "alert-type" => "success",
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors($validated);
    }
    public function payOldDonation(Request $request) //! متأخرات التبرعات
    {
        $memberId = $request->member_id;
        $validated = $request->validate([
            'member_id' => 'required',
            'invoice_no' => 'required|unique:donations,invoice_no',
            'amount' => 'required'
        ]);
        if ($validated) {
            $oldDelay = Olddelays::where('member_id', $memberId)->where('old_delay_type', 'تبرعات')->first();
            $subscribers = Subscribers::where('member_id', $request->member_id)->first();
            $totalSafe = TotalSafe::where('id', 1)->first();
            $amount = $oldDelay->amount;
            $requestAmount = $request->amount;
            $amountPaied = $oldDelay->delay_amount;
            $remainingAmount = $oldDelay->delay_remaining;
            if ($requestAmount >= $amount) {
                $oldDelay->delete();
                $store = Donations::create([
                    'member_id' => $memberId,
                    'invoice_no' => $request->invoice_no,
                    'amount' => $amount,
                    'donation_type' => 'مادي',
                    'donation_category' => 'متأخرات التبرعات',
                    'subscribers_id' => $subscribers->id
                ]);
                if ($store) {
                    SafeReports::create([
                        'member_id' => $subscribers->member_id,
                        'transaction_type' => 'متأخرات التبرعات',
                        'amount' => $requestAmount,
                    ]);
                    $sumAmount = $totalSafe->amount + $requestAmount;
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
                $remainingDelays = $amount - $requestAmount;
                if ($amountPaied == null && $remainingAmount == null) {
                    $update = $oldDelay->update([
                        'delay_amount' => $requestAmount,
                        'delay_remaining' => $remainingDelays
                    ]);
                    if ($update) {
                        Donations::create([
                            'member_id' => $memberId,
                            'invoice_no' => $request->invoice_no,
                            'amount' => $requestAmount,
                            'donation_type' => 'مادي',
                            'donation_category' => 'متأخرات التبرعات',
                            'subscribers_id' => $subscribers->id
                        ]);
                        SafeReports::create([
                            'member_id' => $subscribers->member_id,
                            'transaction_type' => 'متأخرات التبرعات',
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
                    if ($requestAmount >= $remainingAmount) {
                        $oldDelay->delete();
                        $pay = Donations::create([
                            'member_id' => $memberId,
                            'invoice_no' => $request->invoice_no,
                            'amount' => $remainingAmount,
                            'donation_type' => 'مادي',
                            'donation_category' => 'متأخرات التبرعات',
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($pay) {
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'متأخرات التبرعات',
                                'amount' => $requestAmount,
                            ]);
                            $sumAmount = $totalSafe->amount + $requestAmount;
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
                        $oldDelay->update([
                            'delay_amount' => $requestAmount +  $amountPaied,
                            'delay_remaining' => $remainingAmount - $requestAmount,
                        ]);
                        $pay = Donations::create([
                            'member_id' => $memberId,
                            'invoice_no' => $request->invoice_no,
                            'amount' => $requestAmount,
                            'donation_type' => 'مادي',
                            'donation_category' => 'متأخرات التبرعات',
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($remainingAmount === 0) {
                            $oldDelay->delete();
                        }
                        if ($pay) {
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'متأخرات التبرعات',
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
    public function payDelayDonation(Request $request) //! مديونية التبرعات
    {
        $memberId = $request->member_id;
        $validated = $request->validate([
            'amount' => 'required',
            'invoice_no' => 'required|unique:donations,invoice_no'
        ]);
        $subscribers = Subscribers::where('member_id', $memberId)->first();
        $donationDelay = DonationDelay::where('member_id', $memberId)->where('id', $request->id)->first();
        $totalSafe = TotalSafe::where('id', 1)->first();
        if ($validated) {
            $totalAmount = $donationDelay->delay_amount;
            $amountPaied = $request->amount;
            if ($amountPaied == $totalAmount) {
                $donationDelay->delete();
                $pay = Donations::create([
                    'member_id' => $memberId,
                    'invoice_no' => $request->invoice_no,
                    'donation_type' => $request->donation_type,
                    'other_donation' => null,
                    'donation_category' => $request->donation_category,
                    'amount' => $amountPaied,
                    'subscribers_id' => $subscribers->id
                ]);
                if ($pay) {
                    SafeReports::create([
                        'member_id' => $memberId,
                        'transaction_type' => 'تبرع كلي',
                        'amount' => $amountPaied,
                    ]);
                    $sumAmount = $totalSafe->amount + $amountPaied;
                    $totalSafe->update([
                        'amount' => $sumAmount,
                    ]);
                    $notificationSuccess = [
                        'message' => 'تم دفع كل المبلغ',
                        'alert-type' => 'success'
                    ];
                    return back()->with($notificationSuccess);
                }
            } else if ($amountPaied > $totalAmount) {
                $donationDelay->delete();
                $pay = Donations::create([
                    'member_id' => $memberId,
                    'invoice_no' => $request->invoice_no,
                    'donation_type' => $request->donation_type,
                    'other_donation' => null,
                    'donation_category' => $request->donation_category,
                    'amount' => $totalAmount,
                    'subscribers_id' => $subscribers->id
                ]);
                if ($pay) {
                    SafeReports::create([
                        'member_id' => $memberId,
                        'transaction_type' => 'تبرع كلي',
                        'amount' => $totalAmount,
                    ]);
                    $sumAmount = $totalSafe->amount + $totalAmount;
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
                $paiedMoney = $donationDelay->amount_paied;
                $remainingAmount = $donationDelay->amount_remaining;
                if ($remainingAmount == null && $paiedMoney == null) {
                    $newRemain = $totalAmount - $amountPaied;
                    $update = $donationDelay->update([
                        'amount_paied' => $amountPaied,
                        'amount_remaining' => $newRemain
                    ]);
                    if ($update) {
                        Donations::create([
                            'member_id' => $request->member_id,
                            'invoice_no' => $request->invoice_no,
                            'amount' => $amountPaied,
                            'donation_type' => $request->donation_type,
                            'other_donation' => null,
                            'donation_category' => $request->donation_category,
                            'subscribers_id' => $subscribers->id
                        ]);
                        SafeReports::create([
                            'member_id' => $subscribers->member_id,
                            'transaction_type' => 'تبرع جزئي',
                            'amount' => $amountPaied,
                        ]);
                        $sumAmount = $totalSafe->amount + $amountPaied;
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
                    if ($amountPaied == $remainingAmount) {
                        $donationDelay->delete();
                        $pay = Donations::create([
                            'member_id' => $memberId,
                            'invoice_no' => $request->invoice_no,
                            'donation_type' => $request->donation_type,
                            'other_donation' => null,
                            'donation_category' => $request->donation_category,
                            'amount' => $amountPaied,
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($pay) {
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'تبرع كلي',
                                'amount' => $amountPaied,
                            ]);
                            $sumAmount = $totalSafe->amount + $amountPaied;
                            $totalSafe->update([
                                'amount' => $sumAmount,
                            ]);
                            $notificationSuccess = [
                                'message' => 'تم دفع كل المبلغ',
                                'alert-type' => 'success'
                            ];
                            return back()->with($notificationSuccess);
                        }
                    } else if ($amountPaied > $remainingAmount) {
                        $donationDelay->delete();
                        $pay = Donations::create([
                            'member_id' => $memberId,
                            'invoice_no' => $request->invoice_no,
                            'donation_type' => $request->donation_type,
                            'other_donation' => null,
                            'donation_category' => $request->donation_category,
                            'amount' => $remainingAmount,
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($pay) {
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'تبرع كلي',
                                'amount' => $remainingAmount,
                            ]);
                            $sumAmount = $totalSafe->amount + $remainingAmount;
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
                        $donationDelay->update([
                            'amount_paied' => $amountPaied + $paiedMoney,
                            'amount_remaining' => $remainingAmount - $amountPaied
                        ]);
                        $pay = Donations::create([
                            'member_id' => $memberId,
                            'invoice_no' => $request->invoice_no,
                            'donation_type' => $request->donation_type,
                            'other_donation' => null,
                            'donation_category' => $request->donation_category,
                            'amount' => $amountPaied,
                            'subscribers_id' => $subscribers->id
                        ]);
                        if ($remainingAmount === 0) {
                            $donationDelay->delete();
                        }
                        if ($pay) {
                            SafeReports::create([
                                'member_id' => $subscribers->member_id,
                                'transaction_type' => 'تبرع كلي',
                                'amount' => $amountPaied,
                            ]);
                            $sumAmount = $totalSafe->amount + $amountPaied;
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
}
