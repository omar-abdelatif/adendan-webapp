<?php

namespace App\Http\Controllers;

use App\Models\TotalBank;
use App\Models\TotalSafe;
use Illuminate\Http\Request;

class WithdrawController extends Controller {
    function __construct(){
        $this->middleware('permission:التقارير');
    }
    public function withdraw(Request $request) {
        $totalSafe = TotalSafe::first();
        $totalBank = TotalBank::first();
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
                $store = paymentTransaction(0, $validated['amount'], new \DateTime($request->transaction_date), 'كاش', 'خزنة/سحب', 'تحويلات', 'سحب', $imagename, '');
                if ($store) {
                    $newAmount = $totalSafe->amount - $validated['amount'];
                    $totalSafe->update(['amount' => $newAmount]);
                    $newBank = $totalBank->amount + $validated['amount'];
                    $totalBank->update(['amount' => $newBank]);
                    paymentTransaction(0, $validated['amount'], new \DateTime($request->transaction_date), 'كاش', 'خزنة/سحب', 'تحويلات', 'ايداع', $imagename, '');
                    paymentTransaction(0, $validated['amount'], new \DateTime($request->transaction_date), 'كاش', 'تحويلات', 'خزنة/سحب', 'سحب', $imagename, '');
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
    public function bankWithdraw(Request $request) {
        $totalSafe = TotalSafe::first();
        $totalBank = TotalBank::first();
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
                $store = paymentTransaction(0, $validated['amount'], new \DateTime($request->payment_date), 'كاش', 'بنك/سحب', 'تحويلات', 'سحب', $extention, '');
                if ($store) {
                    $newAmount = $totalSafe->amount + $validated['amount'];
                    $totalSafe->update(['amount' => $newAmount]);
                    $newBank =  $totalBank->amount - $validated['amount'];
                    $totalBank->update(['amount' => $newBank]);
                    paymentTransaction(0, $validated['amount'], new \DateTime($request->payment_date), 'كاش', 'خزنة/إيداع', 'تحويلات', 'ايداع', $extention, '');
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
