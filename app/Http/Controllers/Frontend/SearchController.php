<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Tombs;
use App\Models\Wedding;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Olddelays;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class SearchController extends Controller
{
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
        if (empty($ssn) || !$member) {
            return redirect()->route('site.search')->with('empty_message', 'برجاء إدخال رقم قومي صحيح');
        } else {
            if ($member) {
                $subscription = $member->subscriptions;
                $delays = $member->delays;
                $oldDelays = Olddelays::where('member_id', $member->member_id)->first();
                return redirect()->route('site.search')->with([
                    'member' => $member,
                    'searched' => true,
                    'subscription' => $subscription,
                    'delays' => $delays,
                    'oldDelays' => $oldDelays
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
