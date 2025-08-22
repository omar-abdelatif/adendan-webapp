<?php

namespace App\Http\Controllers;

use App\Models\SearchedData;
use App\Models\Subscribers;
use Illuminate\Http\Request;

class SubscriberDataController extends Controller {
    public function approve(Request $request){
        dd($request->all());
        $subscriber = Subscribers::where('member_id', $request->member_id)->first();
    }
    public function delete($id){
        $item = SearchedData::findOrFail($id);
        if($item){
            $delete = $item->delete();
            if($delete){
                $notificationSuccess = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => "success"
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
}