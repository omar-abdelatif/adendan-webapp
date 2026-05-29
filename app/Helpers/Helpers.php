<?php

use App\Models\Donations;
use App\Models\TotalSafe;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;

if (!function_exists('paymentTransaction')) {
    // function paymentTransaction(int $memberId = null, int $amount, $paymentDate, string $paymentMethod, string $paymentCategory, string $transactionType, string $transactionCategory, $item, $inv) {
    //     return PaymentTransaction::create([
    //         'item' => $item,
    //         'inv_no' => $inv,
    //         'amount' => $amount,
    //         'member_id' => $memberId ?? null,
    //         'payment_date' => $paymentDate,
    //         'payment_method' => $paymentMethod,
    //         'payment_cat' => $paymentCategory,
    //         'transaction_type' => $transactionType,
    //         'transaction_cat' => $transactionCategory,
    //     ]);
    // }
    function paymentTransaction(int $memberId = null, int $amount, $paymentDate, string $paymentMethod, string $paymentCategory, string $transactionType, string $transactionCategory, string $item, ?int $inv = null, string $paymobIntentionId = null, ?string $paymobStatus = null) {
        return PaymentTransaction::create([
            'item'                => $item,
            'inv_no'              => $inv,
            'amount'              => $amount,
            'member_id'           => $memberId ?? null,
            'payment_date'        => $paymentDate,
            'payment_method'      => $paymentMethod,
            'payment_cat'         => $paymentCategory,
            'transaction_type'    => $transactionType,
            'transaction_cat'     => $transactionCategory,
            'paymob_intention_id' => $paymobIntentionId,
            'paymob_status'       => $paymobStatus ?? null,
        ]);
    }
}
if(!function_exists('validateTransfer')){
    function validateTransfer(Request $request) :array {
        return $request->validate([
            'amount'    => 'required|integer|min:1',
            'proof_img' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [
            'amount'        => 'المبلغ',
            'proof_img' => 'صورة الاثبات',
        ]);
    }
}
if (!function_exists('handleImageUpload')) {
    function handleImageUpload(Request $request) :string {
        $file = $request->file('proof_img');
        $name = time() . '.' . $file->extension();
        $file->move(public_path('assets/images/withdraws'), $name);
        return $name;
    }
}
if (!function_exists('handleTransfer')) {
    function handleTransfer(array $validated, string $imagename, string $date, string $fromCat, string $toCat, object $fromTotal, object $toTotal): bool {
        try {
            DB::transaction(function () use ($validated, $imagename, $date, $fromCat, $toCat, $fromTotal, $toTotal) {
                paymentTransaction(0, $validated['amount'], new \DateTime($date), 'كاش', $fromCat, 'تحويلات', 'سحب', 'تحويلات', $imagename, null, 'paid');
                paymentTransaction(0, $validated['amount'], new \DateTime($date), 'كاش', $toCat, 'تحويلات', 'ايداع', 'تحويلات', $imagename, null, 'paid');
                $fromTotal->decrement('amount', $validated['amount']);
                $toTotal->increment('amount', $validated['amount']);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
if(!function_exists('updateSafe')){
    function updateSafe(TotalSafe $totalSafe, int $amount): void {
        $totalSafe->increment('amount', $amount);
    }
}
if(!function_exists('createDonation')){
    function createDonation(int $memberId, int $invNo, int $amount, string $donationType, string $paymentDate, string $otherDonation = null, string $donationCategory = null, int $subscribersId): void {
        Donations::create([
            'member_id' => $memberId,
            'invoice_no' => $invNo,
            'amount' => $amount,
            'donation_type' => $donationType,
            'payment_date' => $paymentDate,
            'other_donation' => $otherDonation,
            'donation_category' => $donationCategory,
            'subscribers_id' => $subscribersId
        ]);
    }
}
