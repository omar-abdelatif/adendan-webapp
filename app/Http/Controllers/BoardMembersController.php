<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardMembersRequest;
use App\Models\BoardMembers;
use Illuminate\Http\Request;

class BoardMembersController extends Controller
{
    function __construct(){
        $this->middleware('permission:مجلس الادارة');
    }
    public function index()
    {
        $members = BoardMembers::all();
        return view('pages.board_members', compact('members'));
    }
    public function storeMember(Request $request)
    {
        $validated = $request->validated();
        if ($validated) {
            if ($request->hasFile('img')) {
                $imagefile = $request->file('img');
                $imagename = time() . '.' . $imagefile->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/border-photos');
                $imagefile->move($destinationPath, $imagename);
            }
            $borders = BoardMembers::create([
                "name" => $validated['name'],
                "phone_number" => $validated['phone_number'],
                "position" => $validated['position'],
                "img" => $imagename,
            ]);
            if ($borders) {
                $notification = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        }
        return redirect()->back()->withErrors($validated);
    }
    public function deleteMember($id)
    {
        $member = BoardMembers::findOrFail($id);
        if ($member) {
            if ($member->img !== null) {
                $oldPath = public_path('assets/images/border-photos/' . $member->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $delete = $member->delete();
                if ($delete) {
                    $notificationSuccess = [
                        'message' => "تم الحذف بنجااح",
                        'alert-type' => 'success'
                    ];
                    return redirect()->back()->with($notificationSuccess);
                }
                $notificationError = [
                    'message' => "خطأ أثناء الحذف",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($notificationError);
            }
        }
        return redirect()->back()->withErrors('خطأ أثناء الحذف');
    }
    public function updateMember(Request $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $id = $request->id;
            $border = BoardMembers::find($id);
            if ($border) {
                //! Delete Old Img
                if ($request->hasFile('img') && $border->img !== null) {
                    $oldPath = public_path('assets/images/border-photos/' . $border->img);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                //! Insert New Image
                if ($request->hasFile('img')) {
                    $imagefile = $request->file('img');
                    $imagename = time() . '.' . $imagefile->getClientOriginalExtension();
                    $destinationPath = public_path('assets/images/border-photos');
                    $imagefile->move($destinationPath, $imagename);
                    $border->img = $imagename;
                }
                $update = $border->update([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'position' => $request->position,
                ]);
                if ($update) {
                    $notification = [
                        'message' => "تم التحديث بنجاح",
                        'alert-type' => 'success'
                    ];
                    return redirect()->back()->with($notification);
                }
            }
            return redirect()->back()->withErrors($validated);
        }
    }
}
