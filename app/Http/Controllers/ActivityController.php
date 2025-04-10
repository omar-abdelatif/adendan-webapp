<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:سجل النشاطات');
    }
    public function index()
    {
        $activities = Activity::latest()->get();
        return view('pages.activity.index', compact('activities'));
    }
}
