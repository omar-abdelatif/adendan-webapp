<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\SafeReports;
use App\Models\TotalBank;
use App\Models\TotalSafe;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    function __construct(){
        $this->middleware('permission:التقارير');
    }
    public function withdraw(Request $request)
    {
        $totalSafe = TotalSafe::findOrFail(1);
        $totalBank = TotalBank::findOrFail(1);
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'proof_img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [
            'amount.min' => 'المبلغ المطلوب للسحب غير متاح، الرجاء كتابة مبلغ متاح',
            'amount.required' => 'يجب إدخال المبلغ',
            'proof_img.required' => 'يجب ارفاق صورة الإثبات',
            'proof_img.image' => 'يجب ان يكون الملف من نوع صورة',
            'proof_img.mimes' => 'يجب ان يكون الملف من نوع :values',
            'proof_img.max' => 'يجب ان لا يتعدى حجم الصورة عن :max',
        ]);
        if ($validated) {
            if ($validated['amount'] > $totalSafe->amount) {
                return back()->withErrors([
                    'amount' => 'المبلغ الذي أدخلته غير متوفر. الرجاء إدخال مبلغ أقل والمحاولة مرة أخرى.',
                ]);
            }
            if ($request->hasFile('proof_img')) {
                $imagefile = $request->file('proof_img');
                $imagename = time() . '.' . $imagefile->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/withdraws');
                $imagefile->move($destinationPath, $imagename);
                $store = SafeReports::create([
                    'member_id' => '-',
                    'proof_img' => $imagename,
                    'amount' => $validated['amount'],
                    'payment_date' => $request->transaction_date,
                    'transaction_type' => 'خزنة/سحب',
                ]);
                if ($store) {
                    $newAmount = $totalSafe->amount - $validated['amount'];
                    $totalSafe->update(['amount' => $newAmount]);
                    $newBank = $totalBank->amount + $validated['amount'];
                    $totalBank->update(['amount' => $newBank]);
                    Bank::create([
                        'amount' => $validated['amount'],
                        'transaction_type' => 'بنك/ايداع',
                        'transaction_date' => $request->transaction_date,
                        'proof_img' => $imagename,
                    ]);
                    $notificationSuccess = [
                        'message' => 'تم السحب',
                        'alert-type' => 'success',
                    ];
                    return back()->with($notificationSuccess);
                }
            } else {
                return back()->withErrors(['proof_img' => 'الرجاء اختيار صورة.']);
            }
        }
        return back()->withErrors($validated);
    }
    public function bankWithdraw(Request $request)
    {
        $totalSafe = TotalSafe::findOrFail(1);
        $totalBank = TotalBank::findOrFail(1);
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'proof_img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [
            'amount.min' => 'المبلغ المطلوب للسحب غير متاح، الرجاء كتابة مبلغ متاح',
            'amount.required' => 'يجب إدخال المبلغ',
            'proof_img.required' => 'يجب ارفاق صورة الإثبات',
            'proof_img.image' => 'يجب ان يكون الملف من نوع صورة',
            'proof_img.mimes' => 'يجب ان يكون الملف من نوع :values',
            'proof_img.max' => 'يجب ان لا يتعدى حجم الصورة عن :max',
        ]);
        if ($validated) {
            if ($validated['amount'] > $totalBank->amount) {
                return back()->withErrors([
                    'amount' => 'المبلغ الذي أدخلته غير متوفر. الرجاء إدخال مبلغ أقل والمحاولة مرة أخرى.',
                ]);
            }
            if ($request->hasFile('proof_img')) {
                $imagefile = $request->file('proof_img');
                $extention = time() . "." . $imagefile->extension();
                $destinationPath = public_path('assets/images/withdraws');
                $imagefile->move($destinationPath, $extention);
                $store = Bank::create([
                    'proof_img' => $extention,
                    'amount' =>  $validated['amount'],
                    'transaction_date' => $request->payment_date,
                    'transaction_type' => 'بنك/سحب',
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
                        'payment_date' => $request->payment_date,
                        'transaction_type' => 'خزنة/إيداع'
                    ]);
                    $notificationSuccess = [
                        'message' => 'تم السحب',
                        "alert-type" => "success",
                    ];
                    return redirect()->back()->with($notificationSuccess);
                }
            }
        }
        return back()->withErrors($validated);
    }
}