<?php

namespace App\Http\Controllers;

use App\Http\Requests\MiscellaneousRequest;
use App\Models\Miscellaneous;
use Illuminate\Http\Request;

class MiscellaneousController extends Controller
{
    public function index()
    {
        $miscellaneous = Miscellaneous::all();
        return view('pages.miscellaneous', compact('miscellaneous'));
    }
    public function storeMiscellaneous(MiscellaneousRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('invoice_img')) {
            $imageFile = $request->file('invoice_img');
            $imagename = time() . '.' . $imageFile->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/miscellaneous/');
            $imageFile->move($destinationPath, $imagename);
            $store = Miscellaneous::create([
                'category' => $validated['category'],
                'amount' => $validated['amount'],
                'invoice_img' => $imagename,
                'other_category' => $validated['other_category'],
            ]);
        } else {
            $store = Miscellaneous::create([
                'category' => $validated['category'],
                'amount' => $validated['amount'],
                'other_category' => $validated['other_category'],
            ]);
        }
        if ($store) {
            $notificationSuccess = [
                'message' => 'تم الإضافة بنجاح',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notificationSuccess);
        }
        return redirect()->back()->with($validated);
    }
    public function deleteMiscellaneous($id)
    {
        $misc = Miscellaneous::find($id);
        if ($misc) {
            if ($misc->invoice_img !== null) {
                $oldPath = public_path('assets/images/miscellaneous/' . $misc->invoice_img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $delete = $misc->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => 'تم الحذف بنجاح!',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors('حدث خطأ');
    }
    public function updateMiscellaneous(MiscellaneousRequest $request)
    {
        $id = $request->id;
        $misc = Miscellaneous::find($id);
        if ($misc) {
            //! Remove Old Image
            if ($request->hasFile('invoice_img') && $misc->invoice_img !== null) {
                $oldPath = public_path('assets/images/miscellaneous/' . $misc->invoice_img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Insert New Image
            if ($request->hasFile('invoice_img')) {
                $imageFile = $request->file('invoice_img');
                $imagename = time() . '.' . $imageFile->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/miscellaneous');
                $imageFile->move($destinationPath, $imagename);
                $misc->invoice_img = $imagename;
            }
            $update = $misc->update([
                'category' => $request->category,
                'other_category' => $request->other_category,
                'amount' => $request->amount
            ]);
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم التحديث بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors('حدث خطأ ما');
    }
}
