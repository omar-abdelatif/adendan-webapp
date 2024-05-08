@extends('frontend.layouts.master')
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">حرف و خدمات</li>
@endsection
@section('site_styles')
    <link rel="stylesheet" href={{asset('assets/frontend/css/cards.css')}}>
@endsection
@section('site')
    <section class="workers">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="services-title">
                    <h4 class="bg-primary p-3 rounded text-white w-25 mx-auto text-center">حرف و خدمات</h4>
                </div>
                <div class="services body mt-5">
                    <div class="tabs">
                        <ul class="nav nav-pills justify-content-center" id="unique-donation-tabs" role="tablist" aria-label="أنواع فرص التبرع" data-a11y="parent">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-carpenter-tab" data-bs-toggle="pill" href="#carpenter-tab" role="tab" aria-controls="carpenter-tab" aria-selected="true" data-a11y="child">
                                    <i class="bi bi-newspaper"></i>
                                    نجارة
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-tab="painter" id="pills-painter" data-bs-toggle="pill" href="#painter" role="tab" aria-controls="culture-news" aria-selected="false" data-a11y="child">
                                    <i class="bi bi-newspaper"></i>
                                    نقاشة
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-tab="electric-tab" id="pills-electric-tab" data-bs-toggle="pill" href="#electric-tab" role="tab" aria-controls="electric-tab" aria-selected="false" data-a11y="child">
                                    <i class="bi bi-newspaper"></i>
                                    كهرباء
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-plumber-tab" data-bs-toggle="pill" href="#plumber-tab" role="tab" aria-controls="plumber-tab" aria-selected="false" data-a11y="child">
                                    <i class="bi bi-newspaper"></i>
                                    سباكة
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-tab="other-tab" id="pills-other-tab" data-bs-toggle="pill" href="#other-tab" role="tab" aria-controls="other-tab" aria-selected="false" data-a11y="child">
                                    <i class="bi bi-newspaper"></i>
                                    أخرى
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content bg-smoke-white-3 py-4" id="unique-donation-tabContent">
                        <div class="tab-pane fade show active" id="carpenter-tab" role="tabpanel" aria-labelledby="pills-carpenter-tab">
                            <div class="container">
                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                                    @if ($carpenterCount >= 1)
                                        @foreach ($carpenter as $gn)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card card-shadow overflow-hidden border-rounded border border-2 border-primary mb-4 mt-5">
                                                    <div class="card-body">
                                                        <div class="card-image text-center">
                                                            <img width="80" height="80" src="https://img.icons8.com/external-microdots-premium-microdot-graphic/80/external-carpenter-interior-homedecor-vol4-microdots-premium-microdot-graphic.png" alt="external-carpenter-interior-homedecor-vol4-microdots-premium-microdot-graphic"/>
                                                        </div>
                                                        <div class="text-details p-3 w-100">
                                                            <div class="title mb-3 d-flex align-items-center justify-content-center">
                                                                <h4 class="mb-0">الإسم: {{$gn->name}}</h4>
                                                            </div>
                                                            <div class="mobile d-flex align-items-center justify-content-center">
                                                                <h5 class="mb-0">رقم التلفون: {{$gn->phone_number}}</h5>
                                                            </div>
                                                            <div class="location mt-3 text-center">
                                                                <h4 class="mb-0">السكن: {{$gn->location}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h1 class="text-center mb-0 my-3">لا يوجد حرفي في هذا القسم حاليا</h1>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="painter" role="tabpanel" aria-labelledby="pills-painter">
                            <div class="container">
                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                                    @if ($painterCount >= 1)
                                        @foreach ($painter as $cn)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card card-shadow overflow-hidden border border-2 border-primary border-rounded mb-4 mt-5">
                                                    <div class="card-body">
                                                        <div class="card-image text-center">
                                                            <img width="80" height="80" src="https://img.icons8.com/external-filled-outline-design-circle/80/external-Roll-Brush-real-estate-filled-outline-design-circle.png" alt="external-Roll-Brush-real-estate-filled-outline-design-circle"/>
                                                        </div>
                                                        <div class="text-details p-3 w-100">
                                                            <div class="title mb-3 d-flex align-items-center justify-content-center">
                                                                <h4 class="mb-0">الإسم: {{$cn->name}}</h4>
                                                            </div>
                                                            <div class="mobile d-flex align-items-center justify-content-center">
                                                                <h5 class="mb-0">رقم التلفون: {{$cn->phone_number}}</h5>
                                                            </div>
                                                            <div class="location mt-3 text-center">
                                                                <h4 class="mb-0">السكن: {{$cn->location}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h1 class="text-center mb-0 my-3">لا يوجد حرفي في هذا القسم حاليا</h1>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="electric-tab" role="tabpanel" aria-labelledby="pills-electric-tab">
                            <div class="container">
                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                                    @if ($electricCount >= 1)
                                        @foreach ($electric as $dn)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card card-shadow overflow-hidden border border-2 border-primary border-rounded mb-4 mt-5">
                                                    <div class="card-body">
                                                        <div class="card-image text-center">
                                                            <img width="80" height="80" src="https://img.icons8.com/external-others-phat-plus/80/external-electric-electric-vehicles-color-line-others-phat-plus-11.png" alt="external-electric-electric-vehicles-color-line-others-phat-plus-11"/>
                                                        </div>
                                                        <div class="text-details p-3 w-100">
                                                            <div class="title mb-3 d-flex align-items-center justify-content-center">
                                                                <h4 class="mb-0">الإسم: {{$dn->name}}</h4>
                                                            </div>
                                                            <div class="mobile d-flex align-items-center justify-content-center">
                                                                <h5 class="mb-0">رقم التلفون: {{$dn->phone_number}}</h5>
                                                            </div>
                                                            <div class="location mt-3 text-center">
                                                                <h4 class="mb-0">السكن: {{$dn->location}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h1 class="text-center mb-0 my-3">لا يوجد حرفي في هذا القسم حاليا</h1>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="plumber-tab" role="tabpanel" aria-labelledby="pills-plumber-tab">
                            <div class="container">
                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                                    @if ($plumberCount >= 1)
                                        @foreach ($plumber as $wn)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card card-shadow overflow-hidden border border-2 border-primary border-rounded mb-4 mt-5">
                                                    <div class="card-body">
                                                        <div class="card-image text-center">
                                                            <img width="80" height="80" src="https://img.icons8.com/external-icongeek26-linear-colour-icongeek26/80/external-wrench-plumbing-icongeek26-linear-colour-icongeek26-1.png" alt="external-wrench-plumbing-icongeek26-linear-colour-icongeek26-1"/>
                                                        </div>
                                                        <div class="text-details p-3 w-100">
                                                            <div class="title mb-3 d-flex align-items-center justify-content-center">
                                                                <h4 class="mb-0">الإسم: {{$wn->name}}</h4>
                                                            </div>
                                                            <div class="mobile d-flex align-items-center justify-content-center">
                                                                <h5 class="mb-0">رقم التلفون: {{$wn->phone_number}}</h5>
                                                            </div>
                                                            <div class="location mt-3 text-center">
                                                                <h4 class="mb-0">السكن: {{$wn->location}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h1 class="text-center mb-0 my-3">لا يوجد حرفي في هذا القسم حاليا</h1>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="other-tab" role="tabpanel" aria-labelledby="pills-other-tab">
                            <div class="container">
                                <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                                    @if ($otherCount >= 1)
                                        @foreach ($other as $sn)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="card card-shadow overflow-hidden border border-2 border-primary border-rounded mb-4 mt-5">
                                                    <div class="card-body">
                                                        <div class="card-image text-center">
                                                            <img width="80" height="80" src="https://img.icons8.com/bubbles/80/question-mark.png" alt="question-mark"/>
                                                        </div>
                                                        <div class="text-details p-3 w-100">
                                                            <div class="title mb-3 d-flex align-items-center justify-content-center">
                                                                <h4 class="mb-0">الإسم: {{$sn->name}}</h4>
                                                            </div>
                                                            <div class="mobile d-flex align-items-center justify-content-center">
                                                                <h5 class="mb-0">رقم التلفون: {{$sn->phone_number}}</h5>
                                                            </div>
                                                            <div class="location mt-3 text-center">
                                                                <h4 class="mb-0">السكن: {{$sn->location}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h1 class="text-center mb-0 my-3">لا يوجد حرفي في هذا القسم حاليا</h1>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
