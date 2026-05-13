<?php

namespace App\Http\Controllers;

use App\Models\SMSMSGS;
use App\Models\Subscribers;
use App\Services\SMSService;
use Illuminate\Http\Request;
use App\Models\SMSSubscribers;
use App\Models\PaymentTransaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSmsSubscribers;

class SMSController extends Controller {
    public function __construct(protected SMSService $sms) {}
    public function index(){
        $sms = SMSMSGS::all();
        $totalAmount = PaymentTransaction::where('item','رسائل')->sum('amount');
        $nonMembers = SMSSubscribers::where('member_id', null)->count();
        $members    = SMSSubscribers::where('member_id', '!=', null)->count();
        return view('pages.sms.index', compact('sms', 'totalAmount', 'nonMembers', 'members'));
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
            SMSSubscribers::create([
                'member_id' => $request->member_id ?? null,
                'mobile_no' => $request->mobile_no,
                'amount' => $request->amount,
                'subscription_start_date' => now(),
                'subscription_expiry_date' => now()->copy()->addYear(),
                'active_sms' => 1,
            ]);
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
        $smsSubscription->update([
            'active_sms' => 1
        ]);
        paymentTransaction($request->member_id ?? null, $request->amount, now()->format('Y-m-d'), 'كاش', 'كلي', 'تجديد', 'ايداع', 'رسائل', $request->inv_no);
        $notificationSuccess = [
            'message' => "تم الاستيراد بنجاح",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notificationSuccess);
    }
    public function sendMsg(Request $request) {
        $recipients = SMSSubscribers::pluck('mobile_no')->toArray();
        $result = $this->sms->sendMessage($recipients, $request->content);
        if (!$result['success']) {
            return response()->json([
                'message' => 'SMS failed',
                'errors'  => $result['error']
            ], 500);
        }
        return response()->json([
            'message' => 'Sent successfully',
            'data'    => $result['data']
        ]);
    }
}
