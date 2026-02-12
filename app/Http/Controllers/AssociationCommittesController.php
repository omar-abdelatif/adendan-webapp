<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestsAssociationCommittes;
use App\Models\AssociationCommittes;
use Illuminate\Http\Request;

class AssociationCommittesController extends Controller
{
    function __construct(){
        $this->middleware('permission:اللجان');
    }
    public function index()
    {
        $associations = AssociationCommittes::all();
        return view('pages.association_committes', compact('associations'));
    }
    public  function store(RequestsAssociationCommittes $request)
    {
        $validateData = $request->validated();
        $store = AssociationCommittes::create($validateData);
        if ($store) {
            $notificationSuccess = [
                'message' => "تم الإضافة بنجاح",
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notificationSuccess);
        }
        $notificationError = [
            'message' => "حدث خطأ يرجى المحاولة مره أخرى",
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationError);
    }
    public function remove($id)
    {
        $remove = AssociationCommittes::findOrFail($id);
        if ($remove) {
            $delete = $remove->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => 'تم الحذف بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        $notificationError = [
            'message' => 'هناك خطأ ما يرجى المحاولة',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationError);
    }
    public function update(Request $request)
    {
        $validated = $request->validated();
        $id = $request->id;
        $committe = AssociationCommittes::findOrFail($id);
        if ($committe) {
            $update = $committe->update($validated);
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم التعديل بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            } else {
                $notificationError = [
                    'message' => 'حدث خطأ أثناء التعديل',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($notificationError);
            }
        }
        $notificationError = [
            'message' => 'حدث خطأ أثناء التعديل',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationError);
    }
}
