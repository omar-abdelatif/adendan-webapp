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
        return view('pages.users.index', compact('users'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);
        $user = User::create($validator);
        if ($user) {
            $notificationSuccess = [
                'message' => 'تم اضافة المستخدم بنجاح',
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($notificationSuccess);
        }
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessages = [];

            foreach ($errors->all() as $error) {
                $errorMessages[] = $error;
            }

            $notificationError = [
                'message' => 'خطأ في اضافة المستخدم: ' . implode(' ', $errorMessages),
                'alert-type' => 'error'
            ];

            return redirect()->back()->withErrors($validator)->with('notificationError', $notificationError);
        }
    }
}
