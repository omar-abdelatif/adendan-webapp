<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;
use App\Imports\WeddingImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\WeddingRequest;

class WeddingController extends Controller
{
    function __construct(){
        $this->middleware('permission:الافراح');
    }
    public function index()
    {
        $weddings = Wedding::all();
        return view('pages.weddings', compact('weddings'));
    }
    public function weddingStore(WeddingRequest $request)
    {
        $validated = $request->validated();
        $fromTime = $request['from_time'];
        $toTime = $request['to_time'];
        $fromTime12 = date("g:i A", strtotime($fromTime));
        $toTime12 = date("g:i A", strtotime($toTime));
        $store = Wedding::create([
            'day' => $request['day'],
            'date' => $request['date'],
            'groom_name' => $request['groom_name'],
            'pride_father_name' => $request['pride_father_name'],
            'address' => $request['address'],
            'from_time' => $fromTime12,
            'to_time' => $toTime12,
        ]);
        if ($store) {
            $notificationSuccess = [
                'message' => 'تم الإضافة بنجاح',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notificationSuccess);
        }
        return redirect()->back()->withErrors($validated);
    }
    public function weddingRemove($id)
    {
        $removeWedding = Wedding::findOrFail($id);
        if ($removeWedding) {
            $delete = $removeWedding->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجااح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors('خطأ أثناء الحذف');
    }
    public function weddingUpdate(Request $request)
    {
        $id = $request->id;
        $removeWedding = Wedding::findOrFail($id);
        if ($removeWedding) {
            $fromTime = $request['from_time'];
            $toTime = $request['to_time'];
            $fromTime12 = date("g:i A", strtotime($fromTime));
            $toTime12 = date("g:i A", strtotime($toTime));
            if ($request->filled('from_time')) {
                $removeWedding->from_time = $fromTime12;
            }

            if ($request->filled('to_time')) {
                $removeWedding->to_time = $toTime12;
            }
            $update = $removeWedding->update([
                'day' => $request['day'],
                'date' => $request['date'],
                'groom_name' => $request['groom_name'],
                'pride_father_name' => $request['pride_father_name'],
                'address' => $request['address'],
            ]);
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم التحديث بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
    public function uploadBulkWedding(Request $request)
    {
        $request->validate([
            'import' => 'required|file|mimes:xlsx,xls',
        ]);
        $import = Excel::import(new WeddingImport, $request['import'], null, \Maatwebsite\Excel\Excel::XLSX);
        if ($import) {
            $notificationSuccess = [
                'message' => 'تم رفع البيانات بنجاح',
                'alert-type' => 'success'
            ];
        }
        return redirect()->back()->with($notificationSuccess);
    }
}
