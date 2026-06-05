<?php

namespace App\Http\Controllers;

use App\Models\Subscribers;
use App\Models\User;
use App\Models\UserUpdateStaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserController extends Controller {
    function __construct() {
        $this->middleware('permission:المستخدمين');
    }
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('pages.users.profile', compact('users', 'roles', 'permissions'));
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if ($user) {
            //! Remove Old Image
            if ($request->hasFile('avatar') && $user->avatar !== null) {
                $oldPath = public_path('assets/images/users/' . $user->avatar);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Upload New Image
            if ($request->file('avatar') && $request->file('avatar')->isValid()) {
                $upload = $request->file('avatar');
                $imageName = time() . '.' . $upload->getClientOriginalExtension();
                $destinationPath = 'assets/images/users/';
                $upload->move($destinationPath, $imageName);
                $user->avatar = $imageName;
            }
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $update = $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user->syncRoles($request->input('role'));
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم تحديث البيانات بنجاح',
                    'alert-type' => 'success',
                ];
                return redirect()->route('user.profile')->with($notificationSuccess);
            }
        }
        $notificationError = [
            'message' => 'خطأ في تحديث البيانات',
            'alert-type' => 'error'
        ];
        return redirect()->route('user.profile')->with($notificationError);
    }
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,name',
            'permission' => 'array'
        ]);
        try {
            $user = User::create([
                'name' => $validator['name'],
                'email' => $validator['email'],
                'password' => bcrypt($validator['password']),
            ]);
            $user->assignRole([$request->input('role')]);
            if ($request->has('permission')) {
                $user->givePermissionTo($request->input('permission'));
            }
            if ($user) {
                $notificationSuccess = [
                    'message' => 'تم إضافة المستخدم بنجاح',
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
            throw new \Exception('Failed to create user.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $notificationError = [
                'message' => 'خطأ في إضافة المستخدم: ' . $errorMessage,
                'alert-type' => 'error'
            ];
            return redirect()->back()->withErrors([$errorMessage])->with($notificationError);
        }
    }
    public function AllUsers()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        $usersPermissions = DB::table("model_has_permissions")->where("model_type", User::class)->select('model_id', 'permission_id')->get()->groupBy('model_id')->map(function ($permissions) {
            return $permissions->pluck('permission_id')->toArray();
        })->toArray();

        return view('pages.users.index', compact('users', 'roles', 'permissions', 'usersPermissions'));
    }
    public function destroy(int $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->syncPermissions([]);
            $user->syncRoles([]);
            $delete = $user->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => 'تم حذف المستخدم بنجاح',
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
    public function updateUser(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if ($user) {
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $update = $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user->syncRoles($request->input('role'));
            if ($request->has('permission')) {
                $user->syncPermissions($request->input('permission'));
            } else {
                $user->syncPermissions([]); // لو الصلاحيات فاضية، نزيل القديمة
            }
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم التعديل بنجاح',
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
    public function updateRequests() {
        $requests = UserUpdateStaging::select('id', 'member_id', 'name', 'address', 'mobile_no', 'ssn', 'job_title', 'birth_date', 'created_at')->get();
        return view('pages.api.users.users_update_request', compact('requests'));
    }
    public function updateRequest(Request $request) {
        $userMemberId = $request->member_id;
        $user = Subscribers::where('member_id', $userMemberId)->first();
        $user->update([
            'name' => $request->name,
            'address' => $request->address,
            'mobile_no' => $request->mobile_no,
            'ssn' => $request->ssn,
            'job' => $request->job_title,
            'birthdate' => $request->birthdate,
        ]);
        UserUpdateStaging::where('member_id', $userMemberId)->delete();
        return response()->json(['success' => true, 'message' => 'تم قبول طلب تحديث']);
    }
    public function declineUpdateRequest(int $id) {
        $stagingRequest = UserUpdateStaging::find($id);
        $stagingRequest->delete();
        return response()->json(['success' => true, 'title' => 'تم رفض طلب تحديث', 'message' => 'تم رفض طلب تحديث']);
    }
}
