<?php

namespace App\Http\Controllers;

use App\Models\Donations;
use App\Models\TotalSafe;
use App\Models\SafeReports;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Models\DonationDelay;
use App\Http\Requests\RequestDonations;
use App\Models\Olddelays;

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
                $totalSafe->update([
                    'amount' => $sumAmount,
                ]);
                $notificationSuccess = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->route('donations.showAll', $subscribers->id)->with($notificationSuccess);
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
                return redirect()->route('subscriber.all')->with($notificationSuccess);
            }
            $notificationErrors = [
                'message' => "هذا العنصر غير موجود",
                'alert-type' => 'error'
            ];
            return redirect()->route('subscriber.all')->with($notificationErrors);
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
    public function donationsOnSubscribers(Request $request)
    {
        $validated = $request->validate([
            'donation_type' => 'required',
            'delay_amount' => 'required'
        ]);
        if ($validated) {
            $subscribers = Subscribers::all();
            foreach ($subscribers as $subscriber) {
                $delays = DonationDelay::create([
                    'member_id' => $subscriber->member_id,
                    'donation_type' => $request->donation_type,
                    'payment_type' => 'مادي',
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
}
