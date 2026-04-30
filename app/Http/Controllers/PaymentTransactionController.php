<?php

namespace App\Http\Controllers;

use App\Imports\PaymentTransactions;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentTransactionController extends Controller {
    public function import(Request $request) {
        $request->validate([
            'import-transactions' => 'required|mimes:xlsx,xls',
        ]);
        Excel::import(new PaymentTransactions, $request->file('import-transactions'), null, \Maatwebsite\Excel\Excel::XLSX);
        $notificationSuccess = [
            'message' => "تم الاستيراد بنجاح",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notificationSuccess);
    }
}
