<?php

namespace App\Http\Controllers;

use App\Models\SpatieActivityLog;

class ActivityController extends Controller {
    function __construct() {
        $this->middleware('permission:سجل النشاطات');
    }
    public function index() {
        $activities = SpatieActivityLog::latest()->get();
        return view('pages.activity.index', compact('activities'));
    }
}
