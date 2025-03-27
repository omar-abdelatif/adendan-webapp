<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestDonators;
use App\Models\Donators;
use App\Models\Subscribers;
use Illuminate\Http\Request;

class DonatorsController extends Controller
{
    function __construct(){
        $this->middleware('permission:المتبرعين');
    }
    public function index()
    {
        $subscribers = Subscribers::all();
        $allDonators = Donators::all();
        return view('pages.donations.donators', compact('allDonators', 'subscribers'));
    }
    public function storeDonator(RequestDonators $request)
    {
        $validated = $request->validated();
        if ($validated) {
            $store = Donators::create($request->all());
            if ($store) {
                $notificationSuccess = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => "success"
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        $notificationError = [
            'message' => 'حدث خطأ... برجاء المحاولة مره اخرى',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationError);
    }
    public function removeDonator($id)
    {
        $donator = Donators::find($id);
        if ($donator) {
            $outerDonations = $donator->outerdonations;
            $remove = $donator->delete();
            if ($outerDonations) {
                foreach ($outerDonations as $item) {
                    $item->delete();
                }
            }
            if ($remove) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجاح!",
                    'alert-type' => "success"
                ];
                return back()->with($notificationSuccess);
            }
        }
        $notificationError = [
            'message' => 'لم يتم العثور على البيانات',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationError);
    }
    public function donatorUpdate(RequestDonators $request)
    {
        $id = $request->id;
        $donator = Donators::find($id);
        if ($donator) {
            $update = $donator->update($request->all());
            if ($update) {
                $donator->outerDonations()->update(['name' => $request->name]);
                $notificationSuccess = [
                    'message' => "تم التحديث بنجاح!",
                    'alert-type' => "success"
                ];
                return back()->with($notificationSuccess);
            }
        }
        $notificationError = [
            'message' => 'حدث خطأ أثناء التحديث',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notificationError);
    }
}
