<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SearchedData;
use Illuminate\Http\Request;
use App\Models\Subscribers;

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
            if (empty($data)) {
                return response()->json(['status' => false, 'message' => 'لا توجد بيانات لتحديثها'], 400);
            }
            $update = $member->update($data);
            if ($update) {
                $approvedMember = SearchedData::where('member_id', $member->member_id)->first();
                if ($approvedMember) {
                    $this->delete($approvedMember->id);
                }
                return response()->json([
                    'status'  => true,
                    'message' => 'تم تحديث البيانات بنجاح',
                    'id'      => $approvedMember->id ?? null
                ]);
            }
        }
    }
    public function delete($id) {
        return SearchedData::findOrFail($id)->delete();
    }
}