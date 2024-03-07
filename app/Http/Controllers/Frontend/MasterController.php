<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    public function index()
    {
        $latest = News::latest()->take(10)->get();
        $news = News::latest()->get();
        $generalnews = $news->where('category', 'أخبار عامة')->take(8);
        $generalnewscount = $news->where('category', 'أخبار عامة')->count();
        $culturenews = $news->where('category', 'أخبار ثقافية')->take(8);
        $culturenewscount = $news->where('category', 'أخبار ثقافية')->count();
        $deathnews = $news->where('category', 'عزاء')->take(8);
        $deathnewscount = $news->where('category', 'عزاء')->count();
        $weddingnews = $news->where('category', 'أفراح')->take(8);
        $weddingnewscount = $news->where('category', 'أفراح')->count();
        $sportnews = $news->where('category', 'أخبار رياضية')->take(8);
        $sportnewscount = $news->where('category', 'أخبار رياضية')->count();
        return view('frontend.master', compact([
            'latest',
            'generalnews',
            'generalnewscount',
            'culturenews',
            'culturenewscount',
            'deathnews',
            'deathnewscount',
            'weddingnews',
            'weddingnewscount',
            'sportnews',
            'sportnewscount',
        ]));
    }
    
}
