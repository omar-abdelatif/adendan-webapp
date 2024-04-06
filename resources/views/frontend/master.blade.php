@extends('frontend.layouts.master')
@section('site_styles')
    <link rel="stylesheet" href={{asset('assets/frontend/css/cards.css')}}>
@endsection
@section('site')
    {{-- ! BackGroud Audio ! --}}
    <div class="audio-play">
        <audio autoplay id="audio-player" src="{{ asset('assets/melody/profet_mohamed.mp3') }}"></audio>
    </div>
    {{-- ! News Bar Section ! --}}
    <section class="new-bar">
        <div class="bn-breaking-news mb-3 border-0 bg-primary" id="newsTicker2">
            <div class="bn-label px-4 py-1">
                <h4 class="mb-0">الأخبار</h4>
            </div>
            <div class="bn-news bg-primary">
                <ul class="navbar-nav">
                    @foreach ($latest as $item)
                        <li>
                            <a href="{{route('site.single_news', $item->id)}}" class="text-white">{{$item->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    {{-- ! Hero Section ! --}}
    <section class="hero-section pb-5 position-relative">
        <div class="hero-background" style="background-image: url({{asset('assets/frontend/images/bg/hero/427496-1291632702.png')}})"></div>
    </section>
    {{-- ! News Section ! --}}
    <section class="news-section pb-5" aria-label="الأخبار">
        <div class="container section-title">
            <div class="line-with-words my-5">
                <div class="line me-5"></div>
                <h5 id="unique-donations-title" class="mb-0 title bg-primary text-white px-4 py-2 rounded" aria-level="2">الأخبار</h5>
                <div class="line ms-5"></div>
            </div>
        </div>
        <div>
            <ul class="nav nav-pills justify-content-center" id="unique-donation-tabs" role="tablist" aria-label="أنواع فرص التبرع" data-a11y="parent">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-general-tab" data-bs-toggle="pill" href="#general-tab" role="tab" aria-controls="general-tab" aria-selected="true" data-a11y="child">
                        <i class="bi bi-newspaper"></i>
                        أخبار عامة
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-tab="culture-news" id="pills-culture-news" data-bs-toggle="pill" href="#culture-news" role="tab" aria-controls="culture-news" aria-selected="false" data-a11y="child">
                        <i class="bi bi-newspaper"></i>
                        أخبار ثقافية و الفنية
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-tab="funeral-tab" id="pills-funeral-tab" data-bs-toggle="pill" href="#funeral-tab" role="tab" aria-controls="funeral-tab" aria-selected="false" data-a11y="child">
                        <i class="bi bi-newspaper"></i>
                        عزاء
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-wedding-tab" data-bs-toggle="pill" href="#wedding-tab" role="tab" aria-controls="wedding-tab" aria-selected="false" data-a11y="child">
                        <i class="bi bi-newspaper"></i>
                        افراح
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-tab="sports-tab" id="pills-sports-tab" data-bs-toggle="pill" href="#sports-tab" role="tab" aria-controls="sports-tab" aria-selected="false" data-a11y="child">
                        <i class="bi bi-newspaper"></i>
                        أخبار رياضية
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content bg-smoke-white-3 py-4" id="unique-donation-tabContent">
            <div class="tab-pane fade show active" id="general-tab" role="tabpanel" aria-labelledby="pills-general-tab">
                <div class="container">
                    <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                        @if ($generalnewscount > 0)
                            @foreach ($generalnews as $gn)
                                <div class="col-md-6 col-lg-3">
                                    <div class="card card-shadow overflow-hidden border-rounded mb-4 mt-5">
                                        <div class="card-image">
                                            <img src="{{ $gn->img ? asset('assets/images/news-imgs/'.$gn->img) : 'https://placehold.co/150'}}" alt="{{$gn->img}}">
                                            <div class="text-details p-3 w-100">
                                                <div class="title mb-3 text-center">
                                                    <h5 class="mb-0">{{$gn->title}}</h5>
                                                </div>
                                                <div class="meta d-flex align-items-center justify-content-around">
                                                    <div class="date">{{$gn->created_at->format('Y-m-d')}}</div>
                                                    <div class="category">{{$gn->category}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="more">
                                                <a href="{{route('site.single_news', $gn->id)}}" class="btn btn-success w-100">التفاصيل</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($generalnewscount >= 8)
                                <div class="text-center mb-sm-5 mt-5 MobileBtn">
                                    <a class="btn btn-primary-green rounded-pill px-5" aria-label="المزيد" href="{{route('site.news')}}">المزيد</a>
                                </div>
                            @endif
                        @else
                            <h1 class="text-center mb-0 my-3">لا توجد أخبار في هذا القسم حاليا</h1>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="culture-news" role="tabpanel" aria-labelledby="pills-culture-news">
                <div class="container">
                    <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                        @if ($culturenewscount > 0)
                            @foreach ($culturenews as $cn)
                                <div class="col-md-6 col-lg-3">
                                    <div class="card card-shadow overflow-hidden border-rounded mb-4 mt-5">
                                        <div class="card-image">
                                            <img src="{{asset('assets/images/news-imgs/'.$cn->img)}}" alt="{{$cn->img}}">
                                            <div class="text-details p-3 w-100">
                                                <div class="title mb-3 text-center">
                                                    <h5 class="mb-0">{{$cn->title}}</h5>
                                                </div>
                                                <div class="meta d-flex alicn-items-center justify-content-around">
                                                    <div class="date">{{$cn->created_at->format('Y-m-d')}}</div>
                                                    <div class="category">{{$cn->category}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="more">
                                                <a href="{{route('site.single_news', $cn->id)}}" class="btn btn-success w-100">التفاصيل</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($culturenewscount >= 8)
                                <div class="text-center mb-sm-5 mt-5 MobileBtn">
                                    <a class="btn btn-primary-green rounded-pill px-5" aria-label="المزيد" href="{{route('site.news')}}">المزيد</a>
                                </div>
                            @endif
                        @else
                            <h1 class="text-center mb-0 my-3">لا توجد أخبار في هذا القسم حاليا</h1>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="funeral-tab" role="tabpanel" aria-labelledby="pills-funeral-tab">
                <div class="container">
                    <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                        @if ($deathnewscount > 0)
                            @foreach ($deathnews as $dn)
                                <div class="col-lg-3 col-md-6">
                                    <div class="card card-shadow overflow-hidden border-rounded mb-4 mt-5">
                                        <div class="card-image">
                                            <img src="{{asset('assets/frontend/images/bg/news/death/0205f1b1728e6eacf3e5935c553516b8.jpg')}}" alt="{{$dn->title}}">
                                            <div class="text-details p-3 w-100">
                                                <a href="{{route('site.single_news', $dn->id)}}" class="nav-link text-center">
                                                    <h5 class="mb-0">{{$dn->title}}</h5>
                                                </a>
                                                <div class="meta my-3 d-flex alicn-items-center justify-content-around">
                                                    <div class="date">{{$dn->created_at->format('Y-m-d')}}</div>
                                                    <div class="category">{{$dn->category}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0 w-100">
                                            <div class="more">
                                                <a href={{route('site.single_news', $dn->id)}} class="btn w-100 btn-success">التفاصيل</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($deathnewscount >= 8)
                                <div class="text-center mb-sm-5 mt-5 MobileBtn">
                                    <a class="btn btn-primary-green rounded-pill px-5" aria-label="المزيد" href="{{route('site.news')}}">المزيد</a>
                                </div>
                            @endif
                        @else
                            <h1 class="text-center mb-0 my-3">لا توجد أخبار في هذا القسم حاليا</h1>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="wedding-tab" role="tabpanel" aria-labelledby="pills-wedding-tab">
                <div class="container">
                    <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                        @if ($weddingnewscount > 0)
                            @foreach ($weddingnews as $wn)
                                <div class="col-md-6 col-lg-3">
                                    <div class="card card-shadow overflow-hidden border-rounded mb-4 mt-5">
                                        <div class="card-image">
                                            <img src="{{asset('assets/images/news-imgs/'.$wn->img)}}" alt="{{$wn->img}}">
                                            <div class="text-details p-3 w-100">
                                                <div class="title mb-3 text-center">
                                                    <h5 class="mb-0">{{$wn->title}}</h5>
                                                </div>
                                                <div class="meta d-flex align-items-center justify-content-around">
                                                    <div class="date">{{$wn->created_at->format('Y-m-d')}}</div>
                                                    <div class="category">{{$wn->category}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="more">
                                                <a href="{{route('site.single_news', $wn->id)}}" class="btn btn-success w-100">التفاصيل</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($weddingnewscount >= 8)
                                <div class="text-center mb-sm-5 mt-5 MobileBtn">
                                    <a class="btn btn-primary-green rounded-pill px-5" aria-label="المزيد" href="{{route('site.news')}}">المزيد</a>
                                </div>
                            @endif
                        @else
                            <h1 class="text-center mb-0 my-3">لا توجد أخبار في هذا القسم حاليا</h1>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="sports-tab" role="tabpanel" aria-labelledby="pills-sports-tab">
                <div class="container">
                    <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                        @if ($sportnewscount > 0)
                            @foreach ($sportnews as $sn)
                                <div class="col-md-6 col-lg-3">
                                    <div class="card card-shadow overflow-hidden border-rounded mb-4 mt-5">
                                        <div class="card-image">
                                            <img src="{{asset('assets/images/news-imgs/'.$sn->img)}}" alt="{{$sn->img}}">
                                            <div class="text-details p-3 w-100">
                                                <div class="title mb-3 text-center">
                                                    <h5 class="mb-0">{{$sn->title}}</h5>
                                                </div>
                                                <div class="meta d-flex align-items-center justify-content-around">
                                                    <div class="date">{{$sn->created_at->format('Y-m-d')}}</div>
                                                    <div class="category">{{$sn->category}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="more">
                                                <a href="{{route('site.single_news', $sn->id)}}" class="btn btn-success w-100">التفاصيل</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if ($sportnewscount >= 8)
                                <div class="text-center mb-sm-5 mt-5 MobileBtn">
                                    <a class="btn btn-primary-green rounded-pill px-5" aria-label="المزيد" href="{{route('site.news')}}">المزيد</a>
                                </div>
                            @endif
                        @else
                            <h1 class="text-center mb-0 my-3">لا توجد أخبار في هذا القسم حاليا</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
