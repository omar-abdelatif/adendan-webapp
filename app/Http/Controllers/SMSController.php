<?php

namespace App\Http\Controllers;

use App\Imports\ImportSmsSubscribers;
use App\Models\PaymentTransaction;
use App\Models\SMSFEES;
use App\Models\SMSMSGS;
use App\Models\SMSSubscribers;
use App\Models\Subscribers;
use App\Services\EgyptLinxSmsService;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $subscribers = Subscribers::select('id','member_id', 'name', 'mobile_no')->where('status', '!=', 2)->get();
        $subscribed = SMSSubscribers::get();
        return view('pages.sms.create_sub', compact('subscribed', 'subscribers'));
    }
    public function bulkStore(Request $request){
        $request->validate([
            'import-subscriber' => 'required|mimes:xlsx,xls'
        ]);
        Excel::import(new ImportSmsSubscribers, $request['import-subscriber'], null, \Maatwebsite\Excel\Excel::XLSX);
        $notificationSuccess = [
            'message' => "تم الاستيراد بنجاح",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notificationSuccess);
    }
    public function storeSubscriber(Request $request){
        $validated = $request->validate([
            'member_id'=>'nullable',
            'mobile_no'=>'required',
            'amount' => 'required',
            'inv_no'=>'required',
        ],[],[
            'member_id' => 'رقم العضوية',
            'mobile_no' => 'رقم المحمول',
            'amount' => 'المبلغ',
            'inv_no' => 'رقم الايصال',
        ]);
        if($validated) {
            $this->egylinx->storeOrUpdateSmsSubscriber($request->member_id, $request->mobile_no, $request->amount, now());
            paymentTransaction($request->member_id ?? null, $request->amount, now()->format('Y-m-d'), 'كاش', 'كلي', 'اشتراك', 'ايداع', 'رسائل' ,$request->inv_no);
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
            paymentTransaction($request->member_id ?? null, $renewalAmount, now()->format('Y-m-d'), 'كاش', 'كلي', 'تجديد', 'ايداع', 'رسائل', $request->inv_no);
            return response()->json(['message' => 'تم التجديد بنجاح']);
        }
    }
    // public function sendMsg(Request $request) {
    //     $recipients = SMSSubscribers::pluck('mobile_no')->toArray();
    //     $result = $this->sms->sendMessage($recipients, $request->content);
    //     if (!$result['success']) {
    //         return response()->json([
    //             'message' => 'SMS failed',
    //             'errors'  => $result['error']
    //         ], 500);
    //     }
    //     return response()->json([
    //         'message' => 'Sent successfully',
    //         'data'    => $result['data']
    //     ]);
    // }
    public function testSms(Request $request) {
        $recipients = SMSSubscribers::pluck('mobile_no')->toArray();
        $message      = $request->content;
        $smsPerPerson = $this->egylinx->calculateSmsCount($message);
        $totalNeeded  = count($recipients) * $smsPerPerson;
        $balance      = $this->egylinx->getBalance();
        if ($balance < $totalNeeded) {
            return $this->egylinx->checkBalance($balance, $totalNeeded);
        }
        $results  = $this->egylinx->sendArabic($recipients, $request->content);
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
}
