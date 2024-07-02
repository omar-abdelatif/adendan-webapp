@extends('frontend.layouts.master')
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href={{route('site.search')}}>الإستعلامات</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">تفاصيل الفرح</li>
@endsection
@section('meta')
    <meta property="og:title" content="{{$page->title}}">
    <meta property="og:description" content="{{$page->details}}">
    <meta property="og:image" content="{{ asset('assets/images/weddings/'.$page->img) }}">
@endsection
@section('site')
    <section class="weddings-details my-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card card-shadow border-rounded mb-5">
                        <div class="position-relative overflow-hidden center-items-vertically details-image" style="width: 100%">
                            @if ($page->img)
                                <img loading="lazy" width="720" height="300" class="rounded-5" src={{asset('assets/images/weddings/'.$page->img)}} alt="{{$page->title}}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-6">
                    <div class="details">
                        <div class="title">
                            <h3 class="title">{{$page->title}}</h3>
                        </div>
                        <div class="description mt-3">
                            <p class="mb-0">{{$page->details}}</p>
                        </div>
                    </div>
                    <div class="meta mt-5">
                        <div class="social-sharing d-flex align-items-center justify-content-center">
                            <span class="text-primary fw-bold rounded-pill border border-2 border-primary px-3 py-2">
                                <i class="fa-solid fa-share-nodes"></i>
                                مشاركة
                            </span>
                            {!! $socialShare !!}
                            <p class="copy mb-0" onclick="copyToClipboard()">
                                <img width="48" height="48" src="https://img.icons8.com/color/48/copy--v1.png" alt="copy--v1"/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
