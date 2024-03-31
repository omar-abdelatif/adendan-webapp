<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\SafeReports;
use App\Models\TotalBank;
use App\Models\TotalSafe;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer',
            'proof_img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);
        $totalSafe = TotalSafe::where('id', 1)->first();
        $totalBank = TotalBank::where('id', 1)->first();
        if ($validated) {
            if ($request->hasFile('proof_img')) {
                $imagefile = $request->file('proof_img');
                $imagename = time() . '.' . $imagefile->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/withdraws');
                $imagefile->move($destinationPath, $imagename);
                $store = SafeReports::create([
                    'member_id' => '-',
                    'proof_img' => $imagename,
                    'amount' =>  $validated['amount'],
                    'transaction_type' => 'بنك/سحب',
                ]);
            }
            if ($store) {
                $newAmount = $totalSafe->amount - $validated['amount'];
                $totalSafe->update(['amount' => $newAmount]);
                $newBank = $totalBank->amount + $validated['amount'];
                $totalBank->update(['amount' => $newBank]);
                Bank::create([
                    'amount' =>  $newBank,
                    'transaction_type' => 'إيداع',
                    'proof_img' => $imagename,
                ]);
                $notificationSuccess = [
                    'message' => 'تم السحب',
                    "alert-type" => "success",
                ];
                return back()->with($notificationSuccess);
            }
        }
        return back()->withErrors($validated);
    }
    public function bankWithdraw(Request $request)
    {
        $totalSafe = TotalSafe::where('id', 1)->first();
        $totalBank = TotalBank::where('id', 1)->first();
        $validated = $request->validate([
            'amount' => 'required',
            'proof_img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);
        if ($validated) {
            if ($request->hasFile('proof_img')) {
                $imagefile = $request->file('proof_img');
                $extention = time() . "." . $imagefile->extension();
                $destinationPath = public_path('assets/images/withdraws');
                $imagefile->move($destinationPath, $extention);
                $store = Bank::create([
                    'proof_img' => $extention,
                    'amount' =>  $validated['amount'],
                    'transaction_type' => 'سحب',
                ]);
                if ($store) {
                    $newAmount = $totalSafe->amount + $validated['amount'];
                    $totalSafe->update(['amount' => $newAmount]);
                    $newBank =  $totalBank->amount - $validated['amount'];
                    $totalBank->update(['amount' => $newBank]);
                    SafeReports::create([
                        'member_id' => '-',
                        'amount' => $validated['amount'],
                        'proof_img' => $extention,
                        'transaction_type' => 'بنك/إيداع'
                    ]);
                    $notificationSuccess = [
                        'message' => 'تم السحب',
                        "alert-type" => "success",
                    ];
                    return redirect()->back()->with($notificationSuccess);
                }
            }
        }
    }
}
