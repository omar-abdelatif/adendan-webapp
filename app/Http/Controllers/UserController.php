<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.users.profile', compact('users'));
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
            'role' => 'required'
        ]);
        try {
            $user = User::create($validator);
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
        return view('pages.users.index', compact('users'));
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
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
            $user = $user->update($request->all());
            if ($user) {
                $notificationSuccess = [
                    'message' => 'تم تعديل المستخدم بنجاح',
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
}
