<?php

namespace App\Http\Controllers;

use App\Models\Subscribers;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //! Subscriptions Reports
    public function index(Request $request)
    {
        $subscribers = Subscribers::with('subscriptions')->get();
        $subscriptions = $this->subscriptionFilter();
        return view('pages.reports.subscriptions', compact('subscribers', 'subscriptions'));
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
        if ($keyword === '') {
            $message = 'Please enter a valid job name.';
        } else {
            $jobs = Subscribers::where('job', 'like', "%$keyword%")->get();
            if ($jobs->isEmpty()) {
                $message = 'No results found for "' . $keyword . '".';
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
}
