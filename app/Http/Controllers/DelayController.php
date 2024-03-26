<?php

namespace App\Http\Controllers;

use App\Models\Delay;
use App\Models\CostYears;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Http\Requests\DelayRequest;
use App\Imports\ImportSubscribersDelays;
use Maatwebsite\Excel\Facades\Excel;

class DelayController extends Controller
{
    public function storeDelays(DelayRequest $request)
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
    public function costByYear(Request $request)
    {
        $subscribers = Subscribers::all();
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
    public function subscriberDelay(Request $request)
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
}
