<?php

namespace App\Http\Controllers;

use App\Http\Requests\OuterDonationsRequest;
use App\Models\Donators;
use App\Models\OuterDonations;
use Illuminate\Http\Request;

class OuterDonationsController extends Controller
{
    public function index($id)
    {
        $donators = Donators::find($id);
        if ($donators) {
            $outerdonations = $donators->outerdonations;
            return view('pages.donations.outer_donations_history', compact('donators', 'outerdonations'));
        }
    }
    public function storeOuterDonations(OuterDonationsRequest $request)
    {
        $validated = $request->validated();
        $donators = Donators::where('id', $request['id'])->first();
        if ($validated) {
            $store = OuterDonations::create([
                'name' => $request['name'],
                'donator_type' => $request['donator_type'],
                'invoice_id' => $request['invoice_id'],
                'amount' => $request['amount'],
                'duration' => $request['duration'],
                'donation_destination' => $request['donation_destination'],
                'donators_id' => $donators->id,
            ]);
            if ($store) {
                $notificationSuccess = [
                    'message' => 'تم الإضافة بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->route('outer_donations.history', $donators->id)->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors($validated);
    }
    public function removeOuterDonations($id)
    {
        $outer = OuterDonations::find($id);
        if ($outer) {
            $delete = $outer->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => 'تم الحذف بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors('حدث خطأ أثناء الحذف');
    }
    public function updateOuterDonations(OuterDonationsRequest $request)
    {
        $validated = $request->validated();
        $id = $request->id;
        $outer = OuterDonations::find($id);
        if ($outer) {
            $update = $outer->update($request->all());
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم التعديل بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors($validated);
    }
}