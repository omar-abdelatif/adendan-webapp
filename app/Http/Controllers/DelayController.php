<?php

namespace App\Http\Controllers;

use App\Http\Requests\DelayRequest;
use App\Models\Delay;
use App\Models\Subscribers;
use Illuminate\Http\Request;

class DelayController extends Controller
{
    // public function index($id)
    // {
    //     return view('pages.delays.delays');
    // }
    public function storeDelays(DelayRequest $request)
    {
        $validated = $request->validated();
        $subscriber = Subscribers::where('member_id', $request['member_id'])->first();
        // dd($subscriber->id);
        if ($validated) {
            $store = Delay::create([
                'member_id' => $request['member_id'],
                'amount' => $request['amount'],
                'delay_period' => $request['delay_period'],
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
    // public function delate($id)
    // {
    // }
    // public function update(Request $request)
    // {
    // }
}
