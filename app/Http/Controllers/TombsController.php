<?php

namespace App\Http\Controllers;

use App\Http\Requests\TombRequest;
use App\Models\Tombs;
use Illuminate\Http\Request;

class TombsController extends Controller
{
    function __construct(){
        $this->middleware('permission:المقابر');
    }
    public function index()
    {
        $tombs = Tombs::all();
        return view('pages.tombs', compact('tombs'));
    }
    public function storeTomb(TombRequest $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $store = Tombs::create($validated);
            if ($store) {
                $notificationSuccess = [
                    'message' => 'تم الإضافة بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors($validated);
    }
    public function deleteTomb($id)
    {
        $tomb = Tombs::findOrFail($id);
        if ($tomb) {
            $delete = $tomb->delete();
            if ($delete) {
                $notificationSuccess = [
                    "message" => "تم الحذف بنجاح",
                    "alert-type" => "success"
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        $notificationError = [
            "type" => "error",
            "message" => "لم يتم الحذف"
        ];
        return redirect()->back()->with($notificationError);
    }
    public function updateTomb(Request $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $id = $request->id;
            $tomb = Tombs::findOrFail($id);
            if ($tomb) {
                $update = $tomb->update($request->all());
                if ($update) {
                    $notificationSuccess = [
                        'message' => 'تم التعديل بنجاح',
                        'alert-type' => 'success',
                    ];
                    return redirect()->back()->with($notificationSuccess);
                }
            }
        }
        return redirect()->back()->withErrors($validated);
    }
}
