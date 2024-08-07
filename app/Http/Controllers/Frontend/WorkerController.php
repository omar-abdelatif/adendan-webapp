<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $carpenter = Worker::latest()->where('craft', 'نجار')->paginate(12);
        $carpenterCount = $carpenter->count();
        $painter = Worker::latest()->where('craft', 'نقاش')->paginate(12);
        $painterCount = $painter->count();
        $electric = Worker::latest()->where('craft', 'كهربائي')->paginate(12);
        $electricCount = $electric->count();
        $plumber = Worker::latest()->where('craft', 'سباك')->paginate(12);
        $plumberCount = $plumber->count();
        $tech = Worker::latest()->where('craft', 'فني')->paginate(12);
        $techCount = $tech->count();
        $other = Worker::latest()->where('craft', 'أخرى')->paginate(12);
        $otherCount = $other->count();
        return view('frontend.pages.workers', compact([
            'carpenter',
            'carpenterCount',
            'painter',
            'painterCount',
            'electric',
            'electricCount',
            'plumber',
            'plumberCount',
            'tech',
            'techCount',
            'other',
            'otherCount',
        ]));
    }
}
