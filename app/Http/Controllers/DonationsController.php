<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestDonations;
use App\Models\Donations;
use App\Models\Due;
use App\Models\Subscribers;
use App\Models\TotalSafe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationsController extends Controller {
    function __construct(){
        $this->middleware('permission:التبرعات');
    }
    public function storeDonations(RequestDonations $request) {
        $validated = $request->validated();
        $subscriber = Subscribers::where('member_id', $validated['member_id'])->firstOrFail();
        try {
            DB::transaction(function () use ($validated, $subscriber) {
                createDonation($subscriber->member_id, $validated['invoice_no'], $validated['amount'], $validated['donation_type'], $validated['payment_date'], null, $validated['donation_category'], $subscriber->id);
                paymentTransaction($subscriber->member_id, $validated['amount'], new \DateTime($validated['payment_date']), 'كاش', 'تبرعات', 'تحويلات', 'ايداع', $validated['donation_type'], $validated['invoice_no']);
                TotalSafe::first()->increment('amount', $validated['amount']);
            });
            return redirect()->back()->with([
                'message'    => 'تم الإضافة بنجاح',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('donations.showAll', $subscriber->id)->withErrors(['error' => 'حدث خطأ أثناء الحفظ، يرجى المحاولة مرة أخرى']);
        }
    }
    public function removeDonation(int $id) {
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
    public function updateDonation(Request $request) {
        $id = $request->id;
        $donations = Donations::find($id);
        if ($donations) {
            $update = $donations->update($request);
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
    public function donationsOnSubscribers(Request $request) { //! تبرعات على الأعضاء
        $request->validate([
            'donation_type' => 'required',
            'delay_amount' => 'required'
        ]);
        if ($request->validated()) {
            $subscribers = Subscribers::all();
            foreach ($subscribers as $subscriber) {
                $delays = Due::create([
                    'member_id' => $subscriber->member_id,
                    'donation_type' => $request->donation_type,
                    'amount' => $request->amount,
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
        return redirect()->back()->withErrors($request->validated());
    }
    public function payDelayDonation(Request $request) {
        $request->validate([
            'amount'     => 'required',
            'invoice_no' => 'required|unique:donations,invoice_no',
        ]);
        $memberId      = $request->member_id;
        $subscriber    = Subscribers::where('member_id', $memberId)->firstOrFail();
        $donationDelay = Due::where('member_id', $memberId)->where('id', $request->id)->firstOrFail();
        $totalSafe     = TotalSafe::first();
        $totalAmount     = $donationDelay->delay_amount;
        $amountPaid      = (int) $request->amount;
        $amountPaidBefore = $donationDelay->amount_paied;
        $remainingAmount  = $donationDelay->amount_remaining;
        //! الـ amount الفعلي اللي هيتحفظ
        $effectiveAmount = match (true) {
            $amountPaid >= $totalAmount   => $totalAmount,
            $remainingAmount !== null && $amountPaid >= $remainingAmount => $remainingAmount,
            default => $amountPaid,
        };
        $isFullyPaid = $amountPaid >= ($remainingAmount ?? $totalAmount);
        try {
            DB::transaction(function () use ($request, $subscriber, $donationDelay, $totalSafe, $memberId, $effectiveAmount, $amountPaid, $amountPaidBefore, $remainingAmount, $isFullyPaid) {
                if ($isFullyPaid) {
                    $donationDelay->delete();
                } else {
                    $donationDelay->update([
                        'amount_paied'     => $amountPaid + ($amountPaidBefore ?? 0),
                        'amount_remaining' => ($remainingAmount ?? $donationDelay->delay_amount) - $amountPaid,
                    ]);
                }
                //! إنشاء التبرع
                createDonation($memberId, $request->invoice_no, $effectiveAmount, $request->donation_type, $request->payment_date, null, $request->donation_category, $subscriber->id);
                //! تسجيل المعاملة
                paymentTransaction($memberId, $effectiveAmount, new \DateTime($request->payment_date), 'كاش', 'تبرعات', 'تحويلات', 'ايداع', $request->donation_type, $request->invoice_no);
                //! تحديث الخزينة
                updateSafe($totalSafe, $effectiveAmount);
            });
            $message = $isFullyPaid ? 'تم دفع كل المبلغ' : 'تم دفع جزء من المبلغ';
            return back()->with([
                'message'    => $message,
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء الحفظ']);
        }
    }
}
