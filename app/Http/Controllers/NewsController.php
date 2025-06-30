<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsVideos;
use Illuminate\Http\Request;
use App\Models\NewsThumbnail;
use App\Http\Requests\NewsRequest;

class NewsController extends Controller
{
    function __construct(){
        $this->middleware('permission:الاخبار');
    }
    public function index()
    {
        $news = News::all();
        return view('pages.news.all', compact('news'));
    }
    public function storeNews(NewsRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('img')) {
            //! Single Image
            $imageFile = $request->file('img');
            $imagename = time() . '.' . $imageFile->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/news-imgs/');
            $imageFile->move($destinationPath, $imagename);
        }
        //! Store News
        $news = News::create([
            "title" => $request['title'],
            "description" => $request['description'],
            "category" => $request['category'],
            "img" => $imagename ?? null,
            "slug" => uniqid()
        ]);
        //! Get image Id
        $newsId = $news->id;
        //! Insert Single or Multi Urls
        $videoUrls = $request->input('url');
        if (!empty($videoUrls) && is_array($videoUrls)) {
            foreach ($videoUrls as $url) {
                if (!empty($url)) {
                    NewsVideos::create([
                        'url' => $url,
                        'news_id' => $newsId,
                    ]);
                }
            }
        }
        //! Inserting Multi Thumbnails
        $thumbfile = $request->file('thumbnail');
        if (is_array($thumbfile)) {
            foreach ($thumbfile as $value) {
                $thumbname = uniqid() . '.' . $value->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/news-imgs/news-thumbnails/');
                $value->move($destinationPath, $thumbname);
                NewsThumbnail::create([
                    'thumbnail' => $thumbname,
                    'news_id' => $newsId,
                ]);
            }
        }
        if ($news) {
            $notificationSuccess = [
                'message' => "تم الإضافة بنجاح",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($notificationSuccess);
        } else {
            return redirect()->back()->withErrors($validatedData);
        }
    }
    public function destroyNews($id)
    {
        $news = News::findOrFail($id);
        if ($news) {
            //! Single Image
            if ($news->img !== null) {
                $oldPath = public_path('assets/images/news-imgs/' . $news->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Thumbnails
            $newsThumbnails = NewsThumbnail::where('news_id', $news->id)->get();
            foreach ($newsThumbnails as $thumbnail) {
                $thumbPath = public_path('assets/images/news-thumbnails/' . $thumbnail->thumbnail);
                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }
                $thumbnail->delete();
            }
            $delete = $news->delete();
            if ($delete) {
                $notification = [
                    'message' => "تم الحذف بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notification);
            }
        }
    }
    public function updateNews(Request $request)
    {
        $id = $request->id;
        $news = News::find($id);
        if ($news) {
            //! Delete Old Image
            if ($request->hasFile('img') && $news->img !== null) {
                $oldPath = public_path('assets/images/news-imgs/' . $news->img);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            //! Insert New Image
            if ($request->hasFile('img')) {
                $imageFile = $request->file('img');
                $imagename = time() . '.' . $imageFile->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/news-imgs');
                $imageFile->move($destinationPath, $imagename);
                $news->img = $imagename;
            }
            //!upload Multi Images
            if ($request->hasFile('thumbnail')) {
                $images = $request->file('thumbnail');
                foreach ($images as $img) {
                    $imagename = uniqid() . '.' . $img->getClientOriginalExtension();
                    $destinationPath = public_path('assets/images/news-imgs/news-thumbnails');
                    $img->move($destinationPath, $imagename);
                    NewsThumbnail::create([
                        'thumbnail' => $imagename,
                        'news_id' => $news->id
                    ]);
                }
            }
            $update = $news->update([
                'title' => $request['title'],
                'description' => $request['description'],
                'category' => $request['category'],
            ]);
            if ($update) {
                $notificationSuccess = [
                    'message' => "تم الحديث بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
    }
    public function showThumbnails($id)
    {
        $news = News::findOrFail($id);
        if ($news) {
            $thumbnails = $news->thumbnails;
            $videos = $news->videos;
            $count = $thumbnails->count();
            $vidCount = $videos->count();
            return view('pages.news.single', compact('thumbnails', 'count', 'news', 'videos', 'vidCount'));
        }
    }
    public function deleteSingleImage($id)
    {
        $singleImg = NewsThumbnail::findOrFail($id);
        if ($singleImg) {
            $imagePath = public_path("assets/images/news-imgs/news-thumbnails/" . $singleImg->thumbnail);
            if ($imagePath) {
                unlink($imagePath);
                $deleted = $singleImg->delete();
                if ($deleted) {
                    $notificationSuccess = [
                        'message' => 'تم الحذف بنجاح',
                        'alert-type' => 'success'
                    ];
                    return redirect()->route('show.thumbs', $singleImg->news_id)->with($notificationSuccess);
                } else {
                    return redirect()->route('show.thumbs', $singleImg->news_id)->withErrors('حدث خطأ ما أثناء حذف السجل.');
                }
            }
        }
    }
    public function deleteVideo($id)
    {
        $video = NewsVideos::find($id);
        if ($video) {
            $delete = $video->delete();
            if ($delete) {
                $notificationSuccess = [
                    'message' => "تم الحذف بنجاح",
                    'alert-type' => 'success'
                ];
            }
            return redirect()->back()->with($notificationSuccess);
        }
    }
    public function updateVideo(Request $request)
    {
        $id = $request->id;
        $video = NewsVideos::find($id);
        if ($video) {
            $update = $video->update(['url' => $request->url]);
            if ($update) {
                $notificationSuccess = [
                    'message' => "تم الحديث بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($notificationSuccess);
            }
        }
        return redirect()->back()->withErrors('خطأ حدث أثناء التحديث');
    }
    public function storeVideo(Request $request, $id)
    {
        $validated = $request->validate([
            'url' => 'required'
        ]);
        $news = News::find($id);
        $newsId = $news->id;
        if ($news) {
            if ($request->url) {
                $videoUrls = $request->input('url');
                if ($videoUrls) {
                    foreach ($videoUrls as  $url) {
                        $store = NewsVideos::create([
                            'url' => $url,
                            'news_id' => $newsId,
                        ]);
                    }
                }
            }
            if ($store) {
                $notificationSuccess = [
                    'message' => "تم الإضافة بنجاح",
                    'alert-type' => 'success'
                ];
                return redirect()->route('show.thumbs', $news->id)->with($notificationSuccess);
            }
        }
        return redirect()->route('show.thumbs', $news->id)->withErrors($validated);
    }
}
