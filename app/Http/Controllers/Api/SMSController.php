<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SMSController extends Controller {
    public function getUserSmsPaymentHistory(Request $request){
        $user = $request->user();
        $history = $user->paymentTransactions()->where('item','رسائل')->get();
        return response()->json([
            'success' => true,
            'data' => $history,
        ]);
    }
}
