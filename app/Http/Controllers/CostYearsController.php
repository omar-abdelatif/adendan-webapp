<?php

namespace App\Http\Controllers;

use App\Http\Requests\CostYearsRequest;
use App\Models\CostYears;
use Illuminate\Http\Request;

class CostYearsController extends Controller
{
    function __construct(){
        $this->middleware('permission:الاشتراك السنوي');
    }
    public function index()
    {
        $years = CostYears::all();
        return view('pages.cost_years', compact('years'));
    }
    public function storeYears(CostYearsRequest $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $store = CostYears::create($validated);
            if ($store) {
                $notificationSuccess = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => 'success'
                ];
                return back()->with($notificationSuccess);
            } else {
                return back()->withErrors($validated);
            }
        }
    }
    public function removeYear($id)
    {
        $year = CostYears::find($id);
        if ($year) {
            $delete = $year->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors('حدث خطأ ما');
    }
    public function updateYear(Request $request)
    {
        $id = $request->id;
        $years = CostYears::find($id);
        if ($years) {
            $update = $years->update($request->all());
            if ($update) {
                $notificationSuccess = [
                    'message' => "تم التعديل بنجاح",
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return  redirect()->back()->withErrors("حدث خطأ ما");
    }
}
