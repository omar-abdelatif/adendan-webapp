<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestDonations;
use App\Models\Donations;
use App\Models\Subscribers;
use Illuminate\Http\Request;

class DonationsController extends Controller
{
    public function index($id)
    {
        $subscriber = Subscribers::find($id);
        if ($subscriber) {
            $donations = $subscriber->donations;
            return view('pages.donations.donation_history', compact('subscriber', 'donations'));
        }
    }
    public function storeDonations(RequestDonations $request)
    {
        $validated = $request->validated();
        $subscribers = Subscribers::where('member_id', $request['member_id'])->first();
        if ($subscribers) {
            $store = Donations::create([
                'member_id' => $request['member_id'],
                'amount' => $request['amount'],
                'invoice_no' => $request['invoice_no'],
                'donation_duration' => $request['donation_duration'],
                'donation_type' => $request['donation_type'],
                'other_donation' => $request['other_donation'],
                'donation_destination' => $request['donation_destination'],
                'subscribers_id' => $subscribers->id,
            ]);
            if ($store) {
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
}
