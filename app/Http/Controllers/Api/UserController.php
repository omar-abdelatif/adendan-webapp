<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserUpdateStaging;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller {
    public function updateUser(Request $request){
        $user = $request->user();
        $alreadyPending = UserUpdateStaging::where('member_id', $user->member_id)->exists();
        if ($alreadyPending) {
            return response()->json([
                'message' => 'تم تقديم طلب التعديل بالفعل، برجاء الانتظار حتى يتم معالجة الطلب.',
            ], 409);
        }
        $validatedData = $request->validate([
            'name'       => 'nullable|string|max:255',
            'address'    => 'nullable|string|max:255',
            'mobile_no'  => 'nullable|string|max:20',
            'ssn'        => 'nullable|string|max:11',
            'birth_date' => 'nullable|date',
            'job_title'  => 'nullable|string|max:255',
        ]);
        $birthdate = isset($validatedData['birth_date']) ? Carbon::parse($validatedData['birth_date'])->format('Y-m-d') : $user->birthdate;
        $data = [
            'member_id'  => $user->member_id,
            'name'       => $validatedData['name']       ?? $user->name,
            'address'    => $validatedData['address']     ?? $user->address,
            'mobile_no'  => $validatedData['mobile_no']   ?? $user->mobile_no,
            'ssn'        => $validatedData['ssn']         ?? $user->ssn,
            'birth_date' => $birthdate,
            'job_title'  => $validatedData['job_title']   ?? $user->job_title,
        ];
        $store = UserUpdateStaging::create($data);
        if($store){
            return response()->json([
                'message' => 'تم ارسال طلب التحديث، الطلب قيد المعالجة.',
                'data' => $store
            ], 200);
        }
        return response()->json([
            'data' => $validatedData,
        ], 500);
    }
    public function updateIsPending(Request $request) {
        $subscriber = UserUpdateStaging::where('member_id', $request->member_id)->exist();
        if($subscriber){
            return response()->json([
                'success' => true,
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }
}
