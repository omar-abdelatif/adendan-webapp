<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Delay;
use App\Models\CostYears;
use App\Models\TotalSafe;
use App\Models\SafeReports;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Imports\SubscribersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\SubscriberRequest;

class SubscribersController extends Controller
{
    public function index()
    {
        $years = CostYears::all();
        $halfDelay = $this->insertHalfDelay();
        $value = $this->getSubscriptionValue();
        $cost = $value[0];
        $year = $value[1];
        $currentSubCost = $cost / 12 * $halfDelay;
        $subs = Subscribers::get();
        $members = Subscribers::with('delays')->get();
        $newMemberId = count($subs) > 0 ? Subscribers::orderBy('member_id', 'desc')->first()->member_id + 1 : null;
        return view('pages.subscribers.subscribers', compact('members', 'years', 'halfDelay', 'cost', 'year', 'currentSubCost', 'newMemberId', 'subs'));
    }
    public function storeSubs(SubscriberRequest $request)
    {
        $validatedData = $request->validate([
            'ssn' => 'required|digits:14',
            'mobile_no' => 'required|digits:11',
        ], [
            'ssn.required' => 'حقل الرقم القومي مطلوب.',
            'ssn.digits' => 'يجب ألا يزيد الرقم القومي عن :digits رقم.',
            'mobile_no.required' => 'حقل رقم الهاتف مطلوب.',
            'mobile_no.digits' => 'يجب ألا يزيد رقم الهاتف عن :digits رقم.',
        ]);
        $value = $this->getSubscriptionValue();
        $cost = $value[0];
        $year = $value[1];
        if ($request->hasFile('id_img') || $request->hasFile('img')) {
            //! ID Image
            $filename = $request->file('id_img');
            $idImg = time() . '.' . $filename->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/subscribers/id/');
            $filename->move($destinationPath, $idImg);
            //! Personal Image
            $filename = $request->file('img');
            $pImg = time() . '.' . $filename->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/subscribers/avatar/');
            $filename->move($destinationPath, $pImg);
        }
        //! Insert The Subscriber
        $store = Subscribers::create([
            'member_id' => $request['member_id'],
            'nickname' => $request['nickname'],
            'name' => $request['name'],
            'ssn' => $request['ssn'],
            'address' => $request['address'],
            'birthdate' => $request['birthdate'],
            'mobile_no' => $request['mobile_no'],
            'job' => $request['job'],
            'job_tel' => $request['job_tel'],
            'home_tel' => $request['home_tel'],
            'job_address' => $request['job_address'],
            'job_destination' => $request['job_destination'],
            'martial_status' => $request['martial_status'],
            'membership_type' => $request['membership_type'],
            'educational_qualification' => $request['educational_qualification'],
            'qualification_date' => $request['qualification_date'],
            'img' => $pImg ?? null,
            'id_img' => $idImg ?? null,
            'status' => 1
        ]);
        if ($store) {
            $subscriberId = $store->id;
            Subscriptions::create([
                'member_id' => $request->member_id,
                'subscription_cost' => $cost + 50,
                'invoice_no' => $request->invoice_no,
                'period' => $year,
                'payment_type' => 'إشتراك',
                'subscribers_id' => $subscriberId
            ]);
            $this->safeInsert($request);
            $notificationSuccess = [
                "message" => "تم الإضافة بنجاح",
                "alert-type" => "success",
            ];
            return redirect()->back()->with($notificationSuccess);
        } else {
            return redirect()->back()->withErrors($validatedData);
        }
    }
    public function destroy($id)
    {
        $member = Subscribers::find($id);
        if ($member) {
            //! Single Image
            if ($member->id_img !== null) {
                $oldPath = public_path('assets/images/subscribers/avatar/' . $member->id_img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Delays
            $delays = Delay::where('subscribers_id', $member->id)->first();
            if ($delays != null) {
                $delays->delete();
            }
            $delete = $member->delete();
            if ($delete) {
                $notification = [
                    'message' => "تم الحذف بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        }
    }
    public function subscriberDetails($id)
    {
        $subscriber = Subscribers::find($id);
        if ($subscriber) {
            return view('pages.subscribers.update_subscriber', compact('subscriber'));
        }
    }
    public function update(SubscriberRequest $request)
    {
        $validatedData = $request->validated();
        $id = $request->id;
        $member = Subscribers::findOrFail($id);
        if ($member) {
            //! Remove Personal Image
            if ($request->hasFile('img') && $member->img !== null) {
                $oldPath = public_path('assets/images/subscribers/avatar/' . $member->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Remove ID Image
            if ($request->hasFile('id_img') && $member->id_img !== null) {
                $oldPath = public_path('assets/images/subscribers/id/' . $member->id_img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Upload Personal Image
            if ($request->hasFile('img')) {
                $filename = $request->file('img');
                $pImg = time() . '.' . $filename->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/subscribers/avatar/');
                $filename->move($destinationPath, $pImg);
                $member->img = $pImg;
            }
            //! Update ID Image
            if ($request->hasFile('id_img')) {
                $filename = $request->file('id_img');
                $idImg = time() . '.' . $filename->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/subscribers/id/');
                $filename->move($destinationPath, $idImg);
                $member->id_img = $idImg;
            }
            //! Update Rest Data
            $update = $member->update([
                'member_id' => $request['member_id'],
                'nickname' => $request['nickname'],
                'name' => $request['name'],
                'ssn' => $request['ssn'],
                'address' => $request['address'],
                'birthdate' => $request['birthdate'],
                'mobile_no' => $request['mobile_no'],
                'job' => $request['job'],
                'job_tel' => $request['job_tel'],
                'home_tel' => $request['home_tel'],
                'job_address' => $request['job_address'],
                'job_destination' => $request['job_destination'],
                'martial_status' => $request['martial_status'],
                'membership_type' => $request['membership_type'],
                'educational_qualification' => $request['educational_qualification'],
                'qualification_date' => $request['qualification_date'],
            ]);
            if ($request->status) {
                $member->update(['status' => 2]);
            } else {
                $member->update(['status' => 1]);
            }
            if ($update) {
                $notificationSuccess = [
                    'message' => "تم التعديل بنجاح",
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors($validatedData);
    }
    public function bulkUpload(Request $request)
    {
        $validated = $request->validate([
            'import' => 'required|mimes:xlsx,xls',
        ]);
        if ($validated) {
            $import = Excel::import(new SubscribersImport, $request['import'], null, \Maatwebsite\Excel\Excel::XLSX);
            if ($import) {
                $notificationSuccess = [
                    'message' => "تم الاستيراد بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors($validated);
    }
    public function insertHalfDelay()
    {
        $currentDate = Carbon::now()->startOfMonth();
        $june30 = Carbon::create($currentDate->year, 6, 30, 0, 0, 0);
        if ($currentDate > $june30) {
            $newJune30 = Carbon::create($currentDate->year + 1, 7, 1, 0, 0, 0);
            $differenceInMonths = $currentDate->diffInMonths($newJune30);
            return $differenceInMonths;
        } else {
            $differenceInMonths = $currentDate->diffInMonths($june30);
            return $differenceInMonths;
        }
    }
    function getSubscriptionValue()
    {
        $currentDate = Carbon::now();
        $june30 = Carbon::create($currentDate->year, 6, 30, 0, 0, 0);
        if ($currentDate->gt($june30)) {
            $nextYear = $currentDate->copy()->addYear()->year;
            $yearlyCost = CostYears::where('year', $nextYear)->first();
            $costYearly = $yearlyCost->cost;
            return [$costYearly, $nextYear];
        } else {
            $yearlyCost = CostYears::where('year', $currentDate->year)->first();
            $costYearly = $yearlyCost->cost;
            return [$costYearly, $currentDate->year];
        }
    }
    function safeInsert(Request $request)
    {
        $value = $this->getSubscriptionValue();
        $cost = $value[0];
        $totalSafe = TotalSafe::where('id', 1)->first();
        $sumAmount = $totalSafe->amount + $cost;
        $totalSafe->update([
            'amount' => $sumAmount,
        ]);
        $return =  SafeReports::create([
            'member_id' => $request->member_id,
            'transaction_type' => 'إشتراكات',
            'amount' => $cost,
            'proof_img' => '-',
        ]);
        return $return;
    }
}
