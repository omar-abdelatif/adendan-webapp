<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Due;
use App\Models\Subscribers;
use App\Models\TotalSafe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelayController extends Controller
{
    function __construct(){
        $this->middleware('permission:المديونيات');
    }
    public function uploadDelays(Request $request) {  //! Upload Yearly Delays on Subscribers
        $request->validate([
            'item' => 'required',
            'amount' => 'required'
        ]);
        $existingDelay = Due::where('item', $request->item)->first();
        if ($existingDelay) {
            return back()->withErrors('هذه السنة تم إصدار اشتراكاتها بالفعل');
        } else {
            $subscribers = Subscribers::where('status', '!=', 2)->get();
            foreach ($subscribers as $subscriber) {
                Due::create([
                    'member_id' => $subscriber->member_id,
                    'item' => $request->item,
                    'total_amount' => $request->amount,
                    'amount_remaining' => $request->amount,
                    'transaction_type' => 'إشتراك',
                ]);
            }
            $notificationSuccess = [
                "message" => "تم أضافة السنة المالية للمشتركين بنجاح",
                "alert-type" => "success",
            ];
            return redirect()->back()->with($notificationSuccess);
        }
    }
    public function paySubscription(Request $request) { //! Pay Single Subscription Delay For Single Subscriber
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
                $this->handleFullPayment($due, $subscriber, $totalSafe, $request, $remainingAmount, 'إشتراك');
                $message = 'تم دفع كل المبلغ';
            } else {
                $this->handlePartialPayment($due, $subscriber, $totalSafe, $request, $amountPaid, $totalCost);
                $message = 'تم دفع جزء من المبلغ';
            }
            return back()->with(['message' => $message, 'alert-type' => 'success']);
        });
    }
    private function handleFullPayment(object $due, object $subscriber, object $totalSafe, object $request, int $amount, string $transactionCat): void {
        $due->delete();
        $this->recordTransaction($request, $amount, 'كلي', $transactionCat);
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
        $this->recordTransaction($request, $amountPaid, 'جزئي', 'إشتراك');
        $this->updateTotalSafe($totalSafe, $amountPaid);
    }
    private function recordTransaction(object $request, int $amount, string $category, string $transactionCat): void {
        $transactionType = str_contains($request->item, 'تبرع') ? 'تبرعات' : 'إشتراك';
        paymentTransaction($request->member_id, $amount, $request->payment_date, $request->payment_method, $category, $transactionType, $transactionCat, $request->item, $request->inv_no);
    }
    private function updateTotalSafe(object $totalSafe, int $amount): void {
        $totalSafe->increment('amount', $amount);
    }
}
