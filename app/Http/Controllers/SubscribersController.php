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
use Yajra\DataTables\Facades\DataTables;

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
        $halfDelay = $this->insertHalfDelay();
        $currentSubCost = ($cost / 12) * $halfDelay;
        $totalNewSubCost = $currentSubCost + 50;
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
        $totalSafe = TotalSafe::where('id', 1)->first();
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
                'subscription_cost' => $totalNewSubCost,
                'invoice_no' => $request->invoice_no,
                'period' => $year,
                'payment_type' => 'إشتراك جديد',
                'subscribers_id' => $subscriberId
            ]);
            SafeReports::create([
                'member_id' => $request->member_id,
                'transaction_type' => 'إشتراك جديد',
                'amount' => $totalNewSubCost,
                'invoice_no' => $request->invoice_no,
            ]);
            $sumAmount = $totalSafe->amount + $totalNewSubCost;
            $totalSafe->update([
                'amount' => $sumAmount,
            ]);
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
        $validated = $request->validate(['import' => 'required|mimes:xlsx,xls']);
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
    public function getSubscribersData()
    {
        $subscribers = Subscribers::get();
        return DataTables::of($subscribers)->addColumn('Actions', function ($row) {
            $actions = '<div class="btn-group" role="group">
                <button class="btn btn-info rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">';
            if (auth()->user()->role === 'subscriptions') {
                $actions .= '<a class="btn btn-primary px-2 py-1 me-2" title="الإشتراكات السابقة" role="button" href="' . route('subscriptionRole.subscription.history', $row->id) . '"><i class="icofont icofont-eye"></i></a>
                    <a class="btn btn-warning px-2 py-1 me-2" title="تعديل البيانات" role="button" href="' . route('subscriptionRole.subscriber.details', $row->id) . '">
                        <i class="icofont icofont-ui-edit text-dark"></i>
                    </a>
                    <a href="' . route('subscriptionRole.donations.showAll', $row->id) . '" title="التبرعات السابقة" class="btn btn-primary px-2 py-1 me-2">
                        <i class="fa-solid fa-book-heart"></i>
                    </a>';
            } elseif (auth()->user()->role === 'admin') {
                $actions .= '<a class="btn btn-primary px-2 py-1 me-2" title="الإشتراكات السابقة" role="button" href="' . route('subscription.history', $row->id) . '"><i class="icofont icofont-eye"></i></a>
                    <a class="btn btn-warning px-2 py-1 me-2" title="تعديل البيانات" role="button" href="' . route('subscriber.details', $row->id) . '">
                        <i class="icofont icofont-ui-edit text-dark"></i>
                    </a>
                    <a href="' . route('donations.showAll', $row->id) . '" title="التبرعات السابقة" class="btn btn-primary px-2 py-1 me-2">
                        <i class="fa-solid fa-book-heart"></i>
                    </a>';
            }
            $actions .= '<button type="button" class="btn btn-info px-2 py-1 ms-0" title="تبرع جديد" data-bs-toggle="modal" data-bs-target="#newdonating_' . $row->id . '">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </button>';
            $actions .= '</div></div>';
            $donationModal = '<div class="modal fade" id="newdonating_' . $row->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تبرع من العضو ' . $row->name . '</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="' . route('donations.store') . '" method="post">';
                                $donationModal .= csrf_field();
                                $donationModal .= '<div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="member_id" class="text-muted text-right">رقم العضوية</label>
                                            <input type="number" name="member_id" id="member_id" class="form-control" value="' . $row->member_id . '" readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                            <input type="number" class="form-control" placeholder="رقم الإيصال" id="invoice_no" name="invoice_no">
                                        </div>
                                        <div class="form-group">
                                            <label for="donation_type" class="text-muted">نوع التبرع</label>
                                            <select name="donation_type" class="form-select" id="donation_type_' . $row->id . '" data-donation-id="' . $row->id . '">
                                                <option value="" selected disabled>نوع التبرع</option>
                                                <option value="مادي">مادي</option>
                                                <option value="أخرى" id="other_donation">أخرى</option>
                                            </select>
                                            <select name="donation_category" id="category-donation-type_' . $row->id . '" class="text-muted form-select mt-3 d-none" data-donation-id="' . $row->id . '" disabled>
                                                <option selected disabled>-- إختر نوع التبرع المادي --</option>
                                                <option value="تبرع تنمية">تبرع تنمية</option>
                                                <option value="تبرع إنتساب">تبرع إنتساب</option>
                                                <option value="مقابر قديمة">مقابر قديمة</option>
                                                <option value="ص.مقر">ص.مقر</option>
                                                <option value="ص.سيارة">ص.سيارة</option>
                                            </select>
                                            <input type="text" class="form-control mt-3 d-none" placeholder="نوع التبرع الأخر" data-donation-id="' . $row->id . '" id="otherDonation_' . $row->id . '" name="other_donation" disabled>
                                            <input type="number" class="form-control mt-3 d-none" placeholder="المبلغ" data-donation-id="' . $row->id . '" id="otherDonation_' . $row->id . '" name="amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-danger text-muted" data-bs-dismiss="modal">إغلاق</button>
                                    <button type="submit" role="button" class="btn btn-primary text-muted">تأكيد</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
            return $actions . $donationModal;
        })->rawColumns(['Actions'])->make(true);
    }
}
