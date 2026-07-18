<?php

namespace App\Http\Controllers;

use App\Imports\ImportSmsSubscribers;
use App\Models\PaymentTransaction;
use App\Models\SMSFEES;
use App\Models\SMSMSGS;
use App\Models\SMSSubscribers;
use App\Models\Subscribers;
use Maatwebsite\Excel\Excel;
use App\Services\EgyptLinxSmsService;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel as ImportExcel;

class SMSController extends Controller {
    public function __construct(protected SMSService $sms, protected EgyptLinxSmsService $egylinx) {}
    public function index(){
        $sms = SMSMSGS::all();
        $totalAmount = PaymentTransaction::where('item','رسائل')->sum('amount');
        $nonMembers = SMSSubscribers::where('member_id', null)->count();
        $members    = SMSSubscribers::where('member_id', '!=', null)->count();
        $fees = SMSFEES::latest()->first();
        return view('pages.sms.index', compact('sms', 'totalAmount', 'nonMembers', 'members', 'fees'));
    }
    public function updateSmsFees(Request $request){
        $fees = SMSFEES::first();
        $amount = (int) $request->amount;
        $this->sms->updateSmsFees($fees, $amount);
        $notificationSuccess = [
            'message' => "تم تحديث الرسوم بنجاح",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notificationSuccess);
    }
    public function createNewSub(){
        $subscribedMemberIds = SMSSubscribers::whereNotNull('member_id')->pluck('member_id');
        $subscribers = Subscribers::select('id', 'member_id', 'name', 'mobile_no')->where('status', '!=', 2)->where('mobile_no', '!=', 0)->whereNotIn('member_id', $subscribedMemberIds)->get();
        $subscribed = SMSSubscribers::get();
        return view('pages.sms.create_sub', compact('subscribed', 'subscribers'));
    }
    public function bulkStore(Request $request){
        $notificationResponse = null;
        try {
            $request->validate([
                'import-subscriber' => 'required|mimes:xlsx,xls'
            ]);
            ImportExcel::import(new ImportSmsSubscribers, $request['import-subscriber'], null, Excel::XLSX);
            $notificationResponse = [
                'message' => "تم الاستيراد بنجاح",
                'alert-type' => 'success'
            ];
        } catch (\Throwable $th) {
            $notificationResponse = [
                'message' => $th->getMessage(),
                'alert-type' => 'error'
            ];
        }
        return redirect()->back()->with($notificationResponse);
    }
    public function storeSubscriber(Request $request){
        $validated = $request->validate([
            'mobile_no' => 'required',
        ], [], [
            'mobile_no' => 'رقم المحمول',
        ]);
        if($validated) {
            $fees = SMSFEES::latest()->first();
            $this->egylinx->storeOrUpdateSmsSubscriber($request->member_id, $request->mobile_no, now());
            paymentTransaction($request->member_id ?? null, $fees->amount, now()->format('Y-m-d'), 'كاش', 'كلي', 'اشتراك', 'ايداع', 'رسائل', 0, null, null, 'المقر');
            $notificationSuccess = [
                'message' => "تم التسجيل بنجاح",
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notificationSuccess);
        }
        return back()->withErrors($validated);
    }
    public function ReNew(Request $request, int $id){
        $smsSubscription = SMSSubscribers::findOrFail($id);
        if ($smsSubscription) {
            $renewalAmount = $this->egylinx->smsFees();
            $smsSubscription->update([
                'subscription_start_date' => now(),
                'subscription_expiry_date' => $this->egylinx->getSmsExpiryDate(now()),
                'amount' => $renewalAmount,
                'active_sms' => true,
            ]);
            paymentTransaction($request->member_id ?? null, $renewalAmount, now()->format('Y-m-d'), 'كاش', 'كلي', 'تجديد', 'ايداع', 'رسائل', 0, null, null, 'المقر');
            return response()->json(['message' => 'تم التجديد بنجاح']);
        }
    }
    public function testSms(Request $request) {
        $recipients = SMSSubscribers::where('active_sms', 1)->pluck('mobile_no')->toArray();
        $message      = $request->content;
        $smsPerPerson = $this->egylinx->calculateSmsCount($message);
        $totalNeeded  = count($recipients) * $smsPerPerson;
        $balance      = $this->egylinx->getBalance();
        if ($balance < $totalNeeded) {
            return $this->egylinx->checkBalance($balance, $totalNeeded);
        }
        $results  = $this->egylinx->sendArabic($recipients, $message);
        $success = collect($results)->where('success', true)->count();
        $failed  = collect($results)->where('success', false)->values();
        return response()->json([
            'success_count' => $success,
            'failed_count'  => $failed->count(),
            'failed_numbers' => $failed->pluck('number')->toArray(),
        ]);
    }
    public function getBalance() {
        $balance = $this->egylinx->getBalance();
        return response()->json(['balance' => $balance]);
    }
    public function deleteSubscriber(int $id) {
        $this->sms->deleteSubscriber($id);
        $notificationSuccess = [
            'message' => "تم حذف المشترك بنجاح",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notificationSuccess);
    }
}
