<?php

namespace App\Http\Controllers\Frontend\News;

use App\Models\News;
use Jorenvh\Share\Share;
use App\Models\NewsVideos;
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
        if (!$news) {
            abort(404);
        }
        $newsID = $news->id;
        if ($news->img && is_file(public_path('assets/images/news-imgs/' . $news->img))) {
            $imagePath = public_path('assets/images/news-imgs/' . $news->img);
            // [$width, $height] = getimagesize($imagePath);
            [$width, $height] = getimagesize(public_path('assets/images/news-imgs/' . $news->img));
            $ratio = $width / $height;
            $news->is_landscape = $ratio > 1.5;
            $news->is_portrait = $ratio < 1;
            $news->is_square = $ratio == 1;
            $imageUrl = asset('assets/images/news-imgs/' . $news->img);
        } else {
            $news->is_landscape = null;
            $imageUrl = 'https://adendan.com/assets/frontend/images/bg/news/death/0205f1b1728e6eacf3e5935c553516b8.jpg';
        }
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
    public function socialWidget() {
        $shareComponent = app(Share::class)->currentPage()->facebook()->whatsapp()->telegram();
        return $shareComponent;
    }
}