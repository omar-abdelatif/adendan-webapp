<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Tombs;
use App\Models\Wedding;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DonationDelay;
use App\Models\Olddelays;
use App\Models\SearchedData;

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
    public function getWeddingsByMonth()
    {
        $weddings = Wedding::all();
        $months = include(base_path('lang/ar/months.php'));
        $weddingsByMonth = $weddings->groupBy(function ($wedding) use ($months) {
            $englishMonth = Carbon::parse($wedding->date)->format('F');
            $arabicMonth = $months[$englishMonth]['name'];
            return $arabicMonth . ' ' . Carbon::parse($wedding->date)->format('Y');
        });
        $sortedMonths = $weddingsByMonth->sortKeys();
        return $sortedMonths;
    }
    public function result(Request $request)
    {
        $ssn = $request->input('ssn');
        $member = Subscribers::where('ssn', $ssn)->first();
        if (empty($ssn)) {
            return redirect()->route('site.search')->with('empty_message', 'برجاء إدخال رقم قومي صحيح');
        } elseif (!$member) {
            SearchedData::create(['searched_data' => $ssn]);
            return redirect()->route('site.search')->with('empty_message', 'برجاء إدخال رقم قومي صحيح او رقم المحمول');
        } else {
            if ($member) {
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
                    'donationDelays' => $donationDelays
                ]);
            }
        }
    }
    public function weddingDetails($id)
    {
        $page = Wedding::findOrFail($id);
        if ($page) {
            $socialShare = $this->socialWidget();
            return view('frontend.pages.wedding.details', compact('page', 'socialShare'));
        }
    }
    public function socialWidget()
    {
        $shareComponent = \Share::currentPage()->facebook()->whatsapp()->telegram();
        return $shareComponent;
    }
}
