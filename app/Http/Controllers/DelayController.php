<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Delay;
use App\Models\Due;
use App\Models\Olddelays;
use App\Models\PaymentTransaction;
use App\Models\SafeReports;
use App\Models\Subscribers;
use App\Models\TotalSafe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelayController extends Controller
{
    function __construct(){
        $this->middleware('permission:المديونيات');
    }
    public function uploadDelays(Request $request)
    {  //! Upload Yearly Delays on Subscribers
        $request->validate([
            'year' => 'required',
            'yearly_cost' => 'required'
        ]);
        $existingDelay = Due::where('item', $request->year)->first();
        if ($existingDelay) {
            return back()->withErrors('هذه السنة تم إصدار اشتراكاتها بالفعل');
        } else {
            $subscribers = Subscribers::where('status', '!=', 2)->get();
            foreach ($subscribers as $subscriber) {
                $currentDelay = Delay::where('member_id', $subscriber->member_id)->where('payment_type', 'إشتراك')->where('year', '<', $request->year)->orderBy('year', 'desc')->first();
                if ($currentDelay) {
                    $oldDelay = Olddelays::where('member_id', $subscriber->member_id)->first();
                    if ($oldDelay) {
                        if ($oldDelay->delay_remaining == NULL) {
                            $oldDelay->update([
                                'amount' => $oldDelay->amount + ($currentDelay->remaing ?? $request->yearly_cost)
                            ]);
                        } else {
                            $oldDelay->update([
                                'delay_remaining' => $oldDelay->delay_remaining + ($currentDelay->remaing ?? $request->yearly_cost)
                            ]);
                        }
                    } else {
                        Olddelays::create([
                            'amount' => $currentDelay->remaing ?? $request->yearly_cost,
                            'member_id' => $subscriber->member_id,
                            'old_delay_type' => 'إشتراكات'
                        ]);
                    }
                    $currentDelay->delete();
                }
                Delay::create([
                    'member_id' => $subscriber->member_id,
                    'year' => $request->year,
                    'yearly_cost' => $request->yearly_cost,
                    'payment_type' => 'إشتراك',
                    'subscribers_id' => $subscriber->id,
                ]);
            }
            $notificationSuccess = [
                "message" => "تم أضافة السنة المالية للمشتركين بنجاح",
                "alert-type" => "success",
            ];
            return redirect()->back()->with($notificationSuccess);
        }
    }
    public function paySubscription(Request $request)
    { //! Pay Single Subscription Delay For Single Subscriber
        $request->validate([
            'amount_paid'    => 'required|numeric|min:0',
            'inv_no'         => 'required|numeric|unique:payment_transactions,inv_no',
            'payment_method' => 'required|string',
        ]);
        return DB::transaction(function () use ($request) {
            $due        = Due::where('id', $request->id)->where('item', $request->item)->firstOrFail();
            $subscriber = Subscribers::where('member_id', $request->member_id)->firstOrFail();
            $totalSafe  = TotalSafe::findOrFail(1);
            $amountPaid      = (int) $request->amount_paid;
            $totalCost       = (int) $due->total_amount;
            $remainingAmount = (int) ($due->amount_remaining ?? $totalCost);
            $newPaid          = (int) ($due->amount_paid ?? 0) + $amountPaid;
            $isFullPayment = $newPaid >= $totalCost;
            if ($isFullPayment) {
                $this->handleFullPayment($due, $subscriber, $totalSafe, $request, $remainingAmount);
                $message = 'تم دفع كل المبلغ';
            } else {
                $this->handlePartialPayment($due, $subscriber, $totalSafe, $request, $amountPaid, $totalCost);
                $message = 'تم دفع جزء من المبلغ';
            }
            return back()->with(['message' => $message, 'alert-type' => 'success']);
        });
    }
    private function handleFullPayment(object $due, object $subscriber, object $totalSafe, object $request, int $amount): void {
        $due->delete();
        $this->recordTransaction($request, $amount, 'كلي');
        $this->recordSafeReport($subscriber->member_id, $request, $amount);
        $this->updateTotalSafe($totalSafe, $amount);
    }
    private function handlePartialPayment(object $due, object $subscriber, object $totalSafe, object $request, int $amountPaid, int $totalCost): void {
        $newPaid      = ((int) ($due->amount_paid ?? 0)) + $amountPaid;
        $newRemaining = $totalCost - $newPaid;
        $due->update([
            'amount_paid'      => $newPaid,
            'amount_remaining' => $newRemaining,
            'payment_date'     => $request->payment_date,
        ]);
        $this->recordTransaction($request, $amountPaid, 'جزئي');
        $this->recordSafeReport($subscriber->member_id, $request, $amountPaid);
        $this->updateTotalSafe($totalSafe, $amountPaid);
    }
    private function recordTransaction(object $request, int $amount, string $category): void {
        $transactionType = str_contains($request->item, 'تبرع') ? 'تبرعات' : 'إشتراك';
        PaymentTransaction::create([
            'member_id'      => $request->member_id,
            'amount'         => $amount,
            'item'           => $request->item,
            'inv_no'         => $request->inv_no,
            'payment_cat'    => $category,
            'payment_date'   => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_type' => $transactionType,
        ]);
    }
    private function recordSafeReport(string $memberId, object $request, int $amount): void {
        SafeReports::create([
            'member_id'        => $memberId,
            'transaction_type' => 'إشتراكات',
            'payment_date'     => $request->payment_date,
            'amount'           => $amount,
        ]);
    }
    private function updateTotalSafe(object $totalSafe, int $amount): void {
        $totalSafe->increment('amount', $amount);
    }
}
