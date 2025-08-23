<?php

namespace App\Http\Controllers;

use App\Models\SearchedData;
use App\Models\Subscribers;
use Illuminate\Http\Request;

class SubscriberDataController extends Controller {
    public function approve(Request $request){
        $member = Subscribers::where('member_id', $request->member_id)->first();
        if ($member) {
            $data = [];
            if (!empty($request->ssn)) {
                $data['ssn'] = $request->ssn;
            }
            if (!empty($request->birthdate)) {
                $data['birthdate'] = $request->birthdate;
            }
            if (!empty($request->address)) {
                $data['address'] = $request->address;
            }
            if (!empty($request->mobile_no)) {
                $data['mobile_no'] = $request->mobile_no;
            }
            if (!empty($data)) {
                $update = $member->update($data);
                if ($update) {
                    $approvedMember = SearchedData::where('member_id', $member->member_id)->first();
                    if ($approvedMember) {
                        $approvedMember->delete();
                    }
                    return response()->json([
                        'status' => true,
                        'message' => 'تم تحديث البيانات بنجاح',
                        'id' => $approvedMember->id ?? null
                    ]);
                }
            }
            return response()->json(['status' => false, 'message' => 'لا توجد بيانات لتحديثها'], 400);
        }
        return response()->json(['status' => false, 'message' => 'العضو غير موجود'], 404);
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