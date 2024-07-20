<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Donations;
use App\Models\Donators;
use App\Models\Olddelays;
use App\Models\OuterDonations;
use App\Models\SafeReports;
use App\Models\Subscribers;
use App\Models\TotalBank;
use App\Models\TotalSafe;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //! Subscriptions Reports
    public function index(Request $request)
    {
        $subscribers = Subscribers::with('subscriptions')->get();
        $count = $subscribers->count();
        $activeSubscribers = $subscribers->where('status', 1)->count();
        $nonActiveSubscribers = $subscribers->where('status', 0)->count();
        $pendingSubscribers = $subscribers->where('status', 2)->count();
        $subscriptions = $this->subscriptionFilter();
        $incomplete = $this->incomplete();
        return view('pages.reports.subscriptions', compact('subscribers', 'subscriptions', 'count', 'activeSubscribers', 'nonActiveSubscribers', 'pendingSubscribers', 'incomplete'));
    }
    public function subscriptionFilter()
    {
        $subscribers = Subscribers::with('subscriptions')->get();
        $subscriptions = [];
        foreach ($subscribers as $subscriber) {
            $subscriptions[] = $subscriber->subscriptions;
        }
        return $subscriptions;
    }
    //! Job Reports
    public function jobs(Request $request)
    {
        list($keyword, $jobs, $message) = $this->jobFilter($request);
        return view('pages.reports.jobs', compact('keyword', 'jobs', 'message'));
    }
    public function jobFilter(Request $request)
    {
        $keyword = $request->input('search');
        $jobs = collect();
        if ($keyword == "") {
            $message = "برجاء إدخال إسم وظيفة.";
        } else {
            $jobs = Subscribers::where('job', 'like', "%$keyword%")->get();
            if ($jobs->isEmpty()) {
                $message = 'لا توجد نتائج بحث عن "' . $keyword . '".';
            }
        }
        return [$keyword, $jobs, $message ?? null];
    }
    //! Ages Reports
    public function ages(Request $request)
    {
        list($ageKey, $ages, $message) = $this->ageFilter($request);
        return view('pages.reports.age', compact('ages', 'ageKey', 'message'));
    }
    public function ageFilter(Request $request)
    {
        $ageKey = $request->input('birthdate');
        $ages = collect();
        if ($ageKey == "") {
            $message = "برجاء إدخال تاريخ ميلاد صحيح";
        } else {
            $ages = Subscribers::where('birthdate', 'like', "%$ageKey%")->get();
            if ($ages->isEmpty()) {
                $message = 'لا توجد نتائج بحث عن "' . $ageKey . '".';
            }
        }
        return [$ageKey, $ages, $message ?? null];
    }
    //! Address Reports
    public function locations(Request $request)
    {
        list($locationKey, $locations, $message) = $this->locationFilter($request);
        return view('pages.reports.address', compact('locations', 'locationKey', 'message'));
    }
    public function locationFilter(Request $request)
    {
        $locationKey = $request->input('address');
        $locations = collect();
        if ($locationKey == "") {
            $message = "برجاء إدخال العنوان.";
        } else {
            $locations = Subscribers::where('address', 'like', "%$locationKey%")->get();
            if ($locations->isEmpty()) {
                $message = 'لا توجد نتائج بحث عن "' . $locationKey . '".';
            }
        }
        return  [$locationKey, $locations, $message ?? null];
    }
    //! Donations
    public function outerdonations()
    {
        $donators = OuterDonations::all();
        return view('pages.reports.donations', compact('donators'));
    }
    public function innerDonations()
    {
        $donations = Donations::get();
        $donationMoney = Donations::where('donation_type', 'مادي')->get();
        $donationDeathCar = Donations::where('other_donation', 'صيانة سيارة الموتى')->get();
        $donationDeathCarSum = $donationDeathCar->sum('amount');
        $donationTombs = Donations::where('other_donation', 'المقابر')->get();
        $donationTombsSum = $donationTombs->sum('amount');
        $donationHeadquarters = Donations::where('other_donation', 'صيانة المقر')->get();
        $donationHeadquartersSum = $donationHeadquarters->sum('amount');
        $donationAffiliate = Donations::where('other_donation', 'تبرع انتساب')->get();
        $donationAffiliateSum = $donationAffiliate->sum('amount');
        $donationDev = Donations::where('other_donation', 'تبرع تنمية')->get();
        $donationDevSum = $donationDev->sum('amount');
        return view('pages.reports.inner_donations', compact([
            'donations',
            'donationDeathCarSum',
            'donationTombsSum',
            'donationHeadquartersSum',
            'donationAffiliateSum',
            'donationDevSum'
        ]));
    }
    //! Indebtedness ( المديونية )
    public function indebtedness()
    {
        $debts = Subscribers::where('status', 0)->get();
        return view('pages.reports.indebtedness', compact('debts'));
    }
    //! Safe
    public function safe()
    {
        $safes = SafeReports::get();
        $totalSafe = TotalSafe::get();
        $donationsReports = SafeReports::whereIn('transaction_type', ['تبرعات', 'متأخرات التبرعات', 'تبرع جزئي', 'تبرع كلي'])->get();
        $sumDonations = $donationsReports->sum('amount');
        $subscriptionsReports = SafeReports::where('transaction_type', 'إشتراكات')->get();
        $sumSubscriptions = $subscriptionsReports->sum('amount');
        $safeAmounts = [];
        foreach ($totalSafe as $safe) {
            $safeAmounts[] = $safe->amount;
        }
        return view('pages.reports.safe', compact('safeAmounts', 'safes', 'sumDonations', 'sumSubscriptions'));
    }
    //! Bank
    public function bankTransactions()
    {
        $transactions = Bank::get();
        $totalBank = TotalBank::get();
        $bankAmount = [];
        foreach ($totalBank as $bank) {
            $bankAmount[] =  $bank->amount;
        }
        $amount = $transactions->sum('amount');
        return view('pages.reports.bank', compact('transactions', 'amount', 'bankAmount'));
    }
    //! Associates
    public function associates()
    {
        $associates = Subscribers::where('membership_type', 'إنتساب')->get();
        return view('pages.reports.associates', compact('associates'));
    }
    //! Subscribtions Old Delays
    public function search(Request $request)
    {
        $noOldDelays = 'لا توجد متأخرات';
        $locname = $request->locname;
        $amount = $request->amount;
        $optype = $request->optype;

        $query = Subscribers::select('subscribers.name', 'subscribers.address', 'subscribers.member_id')
            ->join('olddelays', 'subscribers.member_id', '=', 'olddelays.member_id')
            ->where('olddelays.old_delay_type', 'إشتراكات')
            ->selectRaw('olddelays.amount, olddelays.delay_amount, olddelays.delay_remaining');

        if (empty($amount)) {
            $queryResult = $query->get();
            return view('pages.reports.sub_old_delays', compact('queryResult', 'noOldDelays'));
        } else {
            if ($amount) {
                $delays = $query->where('olddelays.amount', $optype, $amount)->get();
                return view('pages.reports.sub_old_delays', compact('delays', 'noOldDelays'));
            }
        }
    }
    //! Incomplete
    public function incomplete()
    {
        $incompleteSSN = Subscribers::where('mobile_no', 0)->get();
        dd($incompleteSSN);
    }
}
