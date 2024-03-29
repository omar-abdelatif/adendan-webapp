@extends('frontend.layouts.master')
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{$news->title}}</li>
@endsection
@section('meta')
    <meta property="og:title" content="{{$news->title}}">
    <meta property="og:description" content="{{$news->description}}">
    <meta property="og:image" content="{{ asset('assets/images/news-imgs/'.$news->img ) }}">
@endsection
@section('site')
    <section class="news-details my-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card card-shadow border-rounded mb-5">
                        <div class="position-relative overflow-hidden center-items-vertically details-image" style="width: 100%">
                            @if ($news->category === 'عزاء')
                                <img loading="lazy" class="rounded-5 w-100" src={{asset('assets/frontend/images/bg/news/death/download.jpeg')}} alt="{{$news->title}}">
                            @else
                                <img loading="lazy" class="rounded-5 w-100" src="{{$news->img ? asset('assets/images/news-imgs/'.$news->img ): 'https://placehold.co/150'}}" alt="{{$news->title}}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-6">
                    <div class="details">
                        <div class="title">
                            <h3 class="title">{{$news->title}}</h3>
                        </div>
                        <div class="description mt-3">
                            <p class="mb-0">{{$news->description}}</p>
                        </div>
                        <div class="meta mt-5">
                            <div class="social-sharing d-flex align-items-center justify-content-center">
                                <span class="text-primary fw-bold rounded-pill border border-2 border-primary px-3 py-2">
                                    <i class="fa-solid fa-share-nodes"></i>
                                    مشاركة
                                </span>
                                {!! $socialShare !!}
                            </div>
                        </div>
                    </div>
                </div>
                @if ($news->category === 'عزاء')
                    <div class="col-12 d-none">
                        <div class="media">
                            <div class="separator position-relative">
                                <p class="mb-0 fs-3 p-3 mx-auto text-center text-primary position-absolute rounded fw-bold bg-light w-50">ميديا الخبر</p>
                                <hr />
                            </div>
                            <div class="media-body mt-5 pt-5">
                                <div class="tabs">
                                    <ul class="nav nav-pills justify-content-center" id="unique-donation-tabs" role="tablist" aria-label="أنواع فرص التبرع" data-a11y="parent">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-images-tab" data-bs-toggle="pill" href="#images-tab" role="tab" aria-controls="images-tab" aria-selected="true" data-a11y="child">
                                                <i class="bi bi-images"></i>
                                                الصور
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-tab="videos-news" id="pills-videos-news" data-bs-toggle="pill" href="#videos-news" role="tab" aria-controls="videos-news" aria-selected="false" data-a11y="child">
                                                <i class="bi bi-newspaper"></i>
                                                الفيديوهات
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tabs-body">
                                    <div class="tab-content bg-smoke-white-3 py-4" id="unique-donation-tabContent">
                                        <div class="tab-pane fade show active" id="images-tab" role="tabpanel" aria-labelledby="pills-images-tab">
                                            <div class="container">
                                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper">
                                                    <div class="col-lg-12">
                                                        <div class="images-media p-5 mt-5">
                                                            <div class="row">
                                                                @if ($news->category === 'عزاء' || $countThumbsImgs < 1)
                                                                    <div class="col-12">
                                                                        <h1 class="text-center my-5">لا يوجد صور لهذا الخبر</h1>
                                                                    </div>
                                                                @else
                                                                    @foreach ($thumbsImgs as $thumb)
                                                                        <div class="col-lg-3 col-md-6">
                                                                            <div class="images-item overflow-hidden rounded mb-3">
                                                                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#show_thumbs_{{$thumb->id}}">
                                                                                    <img src={{asset('assets/images/news-imgs/news-thumbnails/'.$thumb->thumbnail)}} alt="image" width="100%">
                                                                                </button>
                                                                                <div class="modal fade" id="show_thumbs_{{$thumb->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-lg">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header justify-content-between">
                                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">إظهار الصورة رقم  {{$thumb->thumbnail}}</h1>
                                                                                                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="image-thumb">
                                                                                                    <img src={{asset('assets/images/news-imgs/news-thumbnails/'.$thumb->thumbnail)}} class="w-100" alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="videos-news" role="tabpanel" aria-labelledby="pills-videos-news">
                                            <div class="container">
                                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper">
                                                    @if ($countVideos > 0)
                                                        @foreach ($videoLinks as $video)
                                                            <div class="col-lg-6 col-sm-12">
                                                                <div class="video-item overflow-hidden w-100 d-block text-center rounded-5">
                                                                    <iframe width="100%" height="550" src="https://www.youtube.com/embed/{{$video}}" title="{{$video}}" frameborder="0" allow="encrypted-media; gyroscope;" allowfullscreen></iframe>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <h1 class="text-center my-5">لا توجد فيديوهات في هذه المناسبة</h1>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <div class="media mt-5">
                            <div class="separator position-relative">
                                <p class="mb-0 fs-3 p-3 mx-auto text-center text-primary position-absolute rounded fw-bold bg-light w-50">ميديا الخبر</p>
                                <hr />
                            </div>
                            <div class="media-body mt-5 pt-5">
                                <div class="tabs">
                                    <ul class="nav nav-pills justify-content-center" id="unique-donation-tabs" role="tablist" aria-label="أنواع فرص التبرع" data-a11y="parent">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-images-tab" data-bs-toggle="pill" href="#images-tab" role="tab" aria-controls="images-tab" aria-selected="true" data-a11y="child">
                                                <i class="bi bi-images"></i>
                                                الصور
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-tab="videos-news" id="pills-videos-news" data-bs-toggle="pill" href="#videos-news" role="tab" aria-controls="videos-news" aria-selected="false" data-a11y="child">
                                                <i class="bi bi-newspaper"></i>
                                                الفيديوهات
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tabs-body">
                                    <div class="tab-content bg-smoke-white-3 py-4" id="unique-donation-tabContent">
                                        <div class="tab-pane fade show active" id="images-tab" role="tabpanel" aria-labelledby="pills-images-tab">
                                            <div class="container">
                                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper">
                                                    <div class="col-lg-12">
                                                        <div class="images-media p-5 mt-5">
                                                            <div class="row">
                                                                @if ($news->category === 'عزاء' || $countThumbsImgs < 1)
                                                                    <div class="col-12">
                                                                        <h1 class="text-center my-5">لا يوجد صور لهذا الخبر</h1>
                                                                    </div>
                                                                @else
                                                                    @foreach ($thumbsImgs as $thumb)
                                                                        <div class="col-lg-3 col-md-6">
                                                                            <div class="images-item overflow-hidden rounded mb-3">
                                                                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#show_thumbs_{{$thumb->id}}">
                                                                                    <img src={{asset('assets/images/news-imgs/news-thumbnails/'.$thumb->thumbnail)}} alt="image" width="100%">
                                                                                </button>
                                                                                <div class="modal fade" id="show_thumbs_{{$thumb->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-lg">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header justify-content-between">
                                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">إظهار الصورة رقم  {{$thumb->thumbnail}}</h1>
                                                                                                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="image-thumb">
                                                                                                    <img src={{asset('assets/images/news-imgs/news-thumbnails/'.$thumb->thumbnail)}} class="w-100" alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="videos-news" role="tabpanel" aria-labelledby="pills-videos-news">
                                            <div class="container">
                                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper">
                                                    @if ($countVideos > 0)
                                                        @foreach ($videoLinks as $video)
                                                            <div class="col-lg-6 col-sm-12">
                                                                <div class="video-item overflow-hidden w-100 d-block text-center rounded-5">
                                                                    <iframe width="100%" height="550" src="https://www.youtube.com/embed/{{$video}}" title="{{$video}}" frameborder="0" allow="encrypted-media; gyroscope;" allowfullscreen></iframe>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <h1 class="text-center my-5">لا توجد فيديوهات في هذه المناسبة</h1>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
