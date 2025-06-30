<?php

namespace App\Http\Controllers\Frontend\News;

use App\Models\News;
use Jorenvh\Share\Share;
use App\Models\NewsVideos;
use Illuminate\Http\Request;
use App\Models\NewsThumbnail;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $generalnews = News::where('category', 'أخبار عامة')->paginate(12);
        $generalnewscount = $generalnews->count();
        $culturenews = News::where('category', 'أخبار ثقافية')->paginate(12);
        $culturenewscount = $culturenews->count();
        $deathnews = News::where('category', 'عزاء')->paginate(12);
        $deathnewscount = $deathnews->count();
        $weddingnews = News::where('category', 'أفراح')->paginate(12);
        $weddingnewscount = $weddingnews->count();
        $sportnews = News::where('category', 'أخبار رياضية')->paginate(12);
        $sportnewscount = $sportnews->count();
        return view('frontend.pages.news.all_news', compact([
            'generalnews',
            'generalnewscount',
            'culturenews',
            'culturenewscount',
            'deathnews',
            'deathnewscount',
            'weddingnews',
            'weddingnewscount',
            'sportnews',
            'sportnewscount'
        ]));
    }
    function extractVideoCode($url)
    {
        $youTubePos = strpos($url, 'youtu.be/');
        if ($youTubePos !== false) {
            $videoCode = substr($url, $youTubePos + strlen('youtu.be/'));
            return $videoCode;
        }
        return null;
    }
    public function newsDetails($slug)
    {
        $news = News::where('slug', $slug)->first();
        $newsID = $news->id;
        if ($news) {
            $thumbsImgs = NewsThumbnail::where('news_id', $newsID)->get();
            $countThumbsImgs = $thumbsImgs->count();
            $thumbVideos = NewsVideos::where('news_id', $newsID)->get();
            $countVideos = $thumbVideos->count();
            $socialShare = $this->socialWidget();
            $videoLinks = [];
            foreach ($thumbVideos as $video) {
                $videoUrl = $video->url;
                $videoCode = $this->extractVideoCode($videoUrl);
                $videoLinks[] = $videoCode;
            }
            return view('frontend.pages.news.single_news', compact('news', 'thumbsImgs', 'countThumbsImgs', 'countVideos', 'videoLinks', 'socialShare'));
        }
    }
    public function socialWidget()
    {
        $shareComponent = app(Share::class)->currentPage()->facebook()->whatsapp()->telegram();
        return $shareComponent;
    }
}
