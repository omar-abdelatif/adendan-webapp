<?php

namespace App\Http\Controllers;

use App\Http\Requests\TombRequest;
use App\Models\Tombs;
use Illuminate\Http\Request;

class TombsController extends Controller
{
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
                return redirect()->route('tomb.all')->with($notificationSuccess);
            }
        }
        return redirect()->route('tomb.all')->withErrors($validated);
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
                return redirect()->route('tomb.all')->with($notificationSuccess);
            }
        }
        $notificationError = [
            "type" => "error",
            "message" => "لم يتم الحذف"
        ];
        return redirect()->route('tomb.all')->with($notificationError);
    }
    public function updateTomb(TombRequest $request)
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
                    return redirect()->route('tomb.all')->with($notificationSuccess);
                }
            }
        }
        return redirect()->route('tomb.all')->withErrors($validated);
    }
}
