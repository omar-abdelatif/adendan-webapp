<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    function __construct(){
        $this->middleware('permission:الصلاحيات');
    }
    public function index(){
        $permissions = Permission::all();
        return view('pages.permissions.index', compact('permissions'));
    }
    public function store(Request $request){
        $validator = $request->validate([
            'name' => 'required',
        ]);
        if($validator){
            $store = Permission::create([
                'name' => $validator['name'],
            ]);
            if ($store) {
                $notificationSuccess = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => "success"
                ];
                return redirect()->back()->with($notificationSuccess);
            }
            $notificationError = [
                'message' => 'حدث خطأ... برجاء المحاولة مره اخرى',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notificationError);
        }
    }
    public function update(Request $request){
        $id = $request->id;
        $permission = Permission::findOrFail($id);
        if($permission){
            $update = $permission->update($request->all());
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم التعديل بنجاح',
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
    public function destroy($id){
        $permission = Permission::find($id);
        if($permission){
            $delete = $permission->delete();
            if($delete){
                $notificationSuccess = [
                    'message' => 'تم الحذف بنجاح',
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
}
