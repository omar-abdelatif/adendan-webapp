<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    function __construct(){
        $this->middleware('permission:الادوار');
    }
    public function index(){
        $roles = Role::all();
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")->select('role_id', 'permission_id')->get()->groupBy('role_id')->map(function ($permissions) {
            return $permissions->pluck('permission_id')->toArray();
        })->toArray();
        return view('pages.roles.index', compact('roles', 'permissions', 'rolePermissions'));
    }
    public function store(Request $request){
        $validate = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
        if($validate){
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permissions'));
            if($role){
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
        $role = Role::findOrFail($id);
        if($role){
            $update = $role->update(['name' => $request->name]);
            $role->syncPermissions($request->input('permissions'));
            if ($update) {
                $notificationSuccess = [
                    'message' => "تم التعديل بنجاح",
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
    public function destroy($id) {
        $role = Role::find($id);
        if ($role) {
            $role->syncPermissions([]);
            $delete = $role->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجاح",
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
}
