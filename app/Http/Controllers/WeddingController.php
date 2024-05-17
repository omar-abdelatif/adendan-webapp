<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;
use App\Http\Requests\WeddingRequest;

class WeddingController extends Controller
{
    public function index()
    {
        $weddings = Wedding::all();
        return view('pages.weddings', compact('weddings'));
    }
    public function weddingStore(WeddingRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/weddings');
            $image->move($destinationPath, $imageName);
            $store = Wedding::create([
                'title' => $request['title'],
                'details' => $request['details'],
                'date' => $request['date'],
                'address' => $request['address'],
                'location' => $request['location'],
                'img' => $imageName
            ]);
        } else {
            $store = Wedding::create([
                'title' => $request['title'],
                'details' => $request['details'],
                'date' => $request['date'],
                'address' => $request['address'],
                'location' => $request['location'],
            ]);
        }
        if ($store) {
            $notificationSuccess = [
                'message' => 'تم الإضافة بنجاح',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notificationSuccess);
        }
        return redirect()->back()->withErrors($validated);
    }
    public function weddingRemove($id)
    {
        $removeWedding = Wedding::findOrFail($id);
        if ($removeWedding) {
            if ($removeWedding->img !== null) {
                $oldPath = public_path('assets/images/weddings/' . $removeWedding->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $delete = $removeWedding->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجااح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors('خطأ أثناء الحذف');
    }
    public function weddingUpdate(WeddingRequest $request)
    {
        $validated = $request->validated();
        $id = $request->id;
        $removeWedding = Wedding::findOrFail($id);
        if ($removeWedding) {
            //! Remove Old Image
            if ($request->hasFile('img') && $removeWedding->img !== null) {
                $oldPath = public_path('assets/images/weddings/' . $removeWedding->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Insert Old Images
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/weddings');
                $image->move($destinationPath, $imageName);
                $removeWedding->img = $imageName;
            }
            $update = $removeWedding->update([
                'title' => $request->title,
                'details' => $request->details,
                'date' => $request->date,
                'address' => $request->address,
                'location' => $request->location,
            ]);
            if ($update) {
                $notificationSuccess = [
                    'message' => 'تم التحديث بنجاح',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors($validated);
    }
}
