<?php

namespace App\Http\Controllers;

use App\Imports\ImportSubscribersDues;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DueController extends Controller {
    function __construct(){
        $this->middleware('permission:المديونيات');
    }
    public function subscriberDues(Request $request) {
        $request->validate([
            'import-dues' => 'required|mimes:xlsx,xls',
        ]);
        Excel::import(new ImportSubscribersDues, $request->file('import-dues'), null, \Maatwebsite\Excel\Excel::XLSX);
        $notificationSuccess = [
            'message' => "تم الاستيراد بنجاح",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notificationSuccess);
    }
}
