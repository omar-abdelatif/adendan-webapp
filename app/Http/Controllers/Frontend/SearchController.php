<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Tombs;
use App\Models\Wedding;
use App\Models\Olddelays;
use App\Models\Subscribers;
use App\Models\SearchedData;
use Illuminate\Http\Request;
use App\Models\DonationDelay;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public $count;
    public function index()
    {
        $weddingsByMonth = $this->getWeddingsByMonth();
        $tombsByRegion = $this->getTombsByRegion();
        return view('frontend.pages.search', compact('tombsByRegion', 'weddingsByMonth'));
    }
    public function getTombsByRegion()
    {
        $distinctRegions = Tombs::distinct()->pluck('region');
        $tombsByRegion = [];
        foreach ($distinctRegions as $region) {
            $tombs = Tombs::where('region', $region)->get();
            $tombsByRegion[$region] = $tombs;
        }
        return $tombsByRegion;
    }
    public function getWeddingsByMonth() {
        $months = include(base_path('lang/ar/months.php'));
        $weddings = Wedding::whereDate('date', '>=', now())->get();
        $weddingsByMonth = $weddings->groupBy(function ($wedding) use ($months) {
            $englishMonth = \Carbon\Carbon::parse($wedding->date)->format('F');
            $arabicMonth = $months[$englishMonth]['name'];
            $year = \Carbon\Carbon::parse($wedding->date)->format('Y');
            return $arabicMonth . ' ' . $year;
        });
        $sortedMonths = $weddingsByMonth->sortBy(function ($weds, $monthName) {
            $firstDate = $weds->first()->date;
            return \Carbon\Carbon::parse($firstDate)->timestamp;
        });
        return $sortedMonths;
    }
    public function result(Request $request) {
        $ssn = $request->input('ssn');
        if (empty($ssn)) {
            return redirect()->route('site.search')->with('empty_message', 'برجاء إدخال بيانات صحيحة');
        }
        $member = Subscribers::where('mobile_no', $ssn)->orWhere('ssn', $ssn)->first();
        if (!$member) {
            return redirect()->route('site.search')->with([
                'empty_message' => 'الرقم القومي او رقم المحمول غير موجودين',
                'empty_message2' => 'برجاء ادخال البيانات لتحديثها من خلال الرابط التالي,',
                'link_title' => 'تحديث البيانات',
            ]);
        }
        $fields = [
            'name' => 'الاسم',
            'mobile_number' => 'رقم المحمول',
            'ssn' => 'الرقم القومي',
            'address' => 'العنوان',
            'birthdate' => 'تاريخ الميلاد'
        ];
        $missingFields = [];
        foreach ($fields as $key => $label) {
            if (is_null($member->$key) || $member->$key === 0) {
                $missingFields[$key] = $label;
            }
        }
        $noDelays = 'لا توجد مديونية إشتراكات';
        $noOldDelays = 'لا توجد متأخرات إشتراكات';
        $delays = $member->delays;
        $oldDelays = Olddelays::where('member_id', $member->member_id)->where('old_delay_type', 'إشتراكات')->get();
        $donationOlddelays = Olddelays::where('member_id', $member->member_id)->where('old_delay_type', 'تبرعات')->get();
        $donationDelays = DonationDelay::where('member_id', $member->member_id)->get();
        return redirect()->route('site.search')->with([
            'member' => $member,
            'searched' => true,
            'delays' => $delays,
            'oldDelays' => $oldDelays,
            'noDelays' => $noDelays,
            'noOldDelays' => $noOldDelays,
            'donationOlddelays' => $donationOlddelays,
            'donationDelays' => $donationDelays,
            'missingFields' => $missingFields,
        ]);
    }
    public function searechDetails($slug){
        $member = Subscribers::where('slug', $slug)->first();
        return view('frontend.pages.search_details.search-details', compact('member'));
    }
    public function storeMainMemberData(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable',
            'ssn' => ['nullable', 'regex:/^(2|3)[0-9]{13}$/'],
            'address' => 'nullable',
            'mobile_number' => 'nullable|numeric|digits:11',
            'birthdate' => 'nullable|date'
        ]);
        $store = SearchedData::create($validated);
        if ($store) {
            return response()->json(['status' => true, 'message' => 'سيقوم المختص بتحديث البيانات']);
        }
        return response()->json(['status' => false, 'message' => 'حدث خطأ ما'], 500);
    }
}