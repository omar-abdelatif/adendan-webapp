@php
    use Carbon\Carbon;
    $today = Carbon::today();
@endphp
@extends('frontend.layouts.master')
@section('title')
    الإستعلامات
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">الإستعلامات</li>
@endsection
@section('site_styles')
    <style>
        .form-label {
            padding: 10px 20px;
            border: 2px solid #004080;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            min-width: 80px;
            display: inline-block;
            transition: all 0.3s;
        }

        .form-label:hover{
            background-color: #004080;
            color: white;
            transition: all 0.3s;
        }
        input[type="radio"]:checked + .form-label {
            background-color: #004080;
            color: white;
        }

        input[type="radio"]:checked:disabled + .form-label, input[type="radio"]:disabled + .form-label {
            background-color: #004080;
            color: white;
            opacity: 0.5;
            cursor: not-allowed;
        }
        input[type="number"]:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
@endsection
@section('site')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @php
                toastrError($error);
            @endphp
        @endforeach
    @endif
    <section class="inquiries">
        <div class="tabs">
            <ul class="nav nav-pills justify-content-center w-100" id="unique-donation-tabs" role="tablist" aria-label="أنواع فرص التبرع" data-a11y="parent">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active px-5 fs-4 py-2 w-100" id="pills-subscription-tab" data-bs-toggle="pill" href="#subscription-tab" role="tab" aria-controls="subscription-tab" aria-selected="true" data-a11y="child">
                        <i class="fa-regular fa-book"></i>
                        الإشتراكات
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link px-5 fs-4 py-2 w-100" id="pills-tomb" data-tab="tomb" data-bs-toggle="pill" href="#tomb" role="tab" aria-controls="tomb" aria-selected="false" data-a11y="child">
                        <i class="fa-solid fa-tombstone-blank"></i>
                        المقابر
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link px-5 fs-4 py-2 w-100" id="pills-wedding" data-tab="wedding" data-bs-toggle="pill" href="#wedding" role="tab" aria-controls="wedding" aria-selected="false" data-a11y="child">
                        <i class="fa-solid fa-rings-wedding"></i>
                        مواعيد الأفراح
                    </a>
                </li>
            </ul>
        </div>
        <div class="tabs-body mb-5">
            <div class="tab-content bg-smoke-white-3 py-4" id="unique-donation-tabContent">
                <div class="tab-pane fade show active" id="subscription-tab" role="tabpanel" aria-labelledby="pills-subscription-tab">
                    <div class="container">
                        <div class="row mb-0 mb-sm-4 justify-content-center tanfeeth-cards cards-wrapper" role="region">
                            <div class="col-lg-12">
                                <div class="search-form">
                                    <form action="{{route('site.result')}}" method="post" class="my-5 w-50 mx-auto">
                                        @csrf
                                        <input type="number" name="ssn" id="ssn" class="form-control border-3 border-primary text-center fw-bold" placeholder="البحث بالرقم القومي">
                                        <button type="submit" class="btn btn-secondary rounded-pill w-100 mt-3 fw-bold fs-5">بحث</button>
                                    </form>
                                </div>
                                @php
                                    $member = session('member');
                                    $searched = session('searched');
                                    $emptyMessage = session('empty_message');
                                    $emptyMessage2 = session('empty_message2');
                                    $link_title = session('link_title');
                                    $link = session('link');
                                    $delays = session('delays');
                                    $oldDelays = session('oldDelays');
                                    $noOldDelays = session('noOldDelays');
                                    $noDelays = session('noDelays');
                                    $donationOlddelays = session('donationOlddelays');
                                    $donationDelays = session('donationDelays')
                                @endphp
                                @if ($searched)
                                    @if ($member)
                                        <div class="card border-0 mx-auto">
                                            <div class="card-header p-3 d-flex subscriber_details align-items-center justify-content-evenly bg-secondary">
                                                <p class="text-white mb-2 fs-5">الإسم: {{$member->name}}</p>
                                                <p class="text-white mb-2 fs-5">رقم العضوية: {{$member->member_id}}</p>
                                                <p class="text-white mb-2 fs-5">
                                                    حالة الإشتراك:
                                                    @if ($member->status === 1)
                                                        <span class="text-white bg-primary rounded-pill px-3 py-1">الإشتراك مفعل</span>
                                                    @elseif ($member->status === 0)
                                                        <span class="text-white bg-danger rounded-pill px-3 py-1">الإشتراك غير مفعل</span>
                                                    @elseif($member->status === 2)
                                                        <span class="text-white bg-dark rounded-pill px-3 py-1">المشترك متوفي</span>
                                                    @else
                                                        <span class="text-dark bg-warning rounded-pill px-3 py-1">الإشتراك معلق</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="card-body bg-light">
                                                <div class="card-content">
                                                    <div class="row align-items-center justify-content-evenly">
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="delays justify-content-center">
                                                                <div class="delays-content d-flex justify-content-center flex-column align-items-center">
                                                                    @if (count($member->delays) >= 1)
                                                                        @foreach ($delays as $delay)
                                                                            <div class="w-100 border-1 border-dark ms-1 rounded-3">
                                                                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                    <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                        <img width="80" height="80" src="https://img.icons8.com/plasticine/80/cash--v2.png" alt="cash--v2"/>
                                                                                        م.إشتراك السنة الحالية
                                                                                    </h4>
                                                                                    <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                        <div class="col-lg-3 p-1 py-2">
                                                                                            <div class="text-center">
                                                                                                <h4 role="presentation">
                                                                                                    <span class="h6 text-green total-current-subscription-amount fw-light d-block" data-total-current-subscription-amount="{{$delay->yearly_cost}}">المبلغ السنوي</span>
                                                                                                    {{$delay->yearly_cost}}
                                                                                                    ج.م
                                                                                                </h4>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-3 p-1 py-2">
                                                                                            <div class="text-center">
                                                                                                <h4 role="presentation">
                                                                                                    <span class="h6 text-green fw-light d-block">السنة</span>
                                                                                                    {{$delay->year}}
                                                                                                </h4>
                                                                                            </div>
                                                                                        </div>
                                                                                        @if ($delay->paied == null || $delay->remaing == null)
                                                                                            <div class="col-lg-3 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h4 role="presentation">
                                                                                                        <span class="h6 text-green fw-light d-block">المدفوع</span>
                                                                                                        لا يوجد
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-3 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h3 role="presentation">
                                                                                                        <span class="h6 text-green fw-light d-block">المتبقي</span>
                                                                                                        لا يوجد
                                                                                                    </h3>
                                                                                                </div>
                                                                                            </div>
                                                                                        @else
                                                                                            <div class="col-lg-3 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h4 role="presentation">
                                                                                                        <span class="h6 text-green fw-light d-block">المدفوع</span>
                                                                                                        {{$delay->paied}} ج.م
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-3 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h3 role="presentation">
                                                                                                        <span class="h6 text-green fw-light d-block current-subscription-remaining-amount" data-current-subscription-remaining-amount="{{$delay->remaing}}">المتبقي</span>
                                                                                                        {{$delay->remaing}} ج.م
                                                                                                    </h3>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div class="w-100 border-1 border-dark ms-1 rounded-3">
                                                                            <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                    <img width="80" height="80" src="https://img.icons8.com/plasticine/80/cash--v2.png" alt="cash--v2"/>
                                                                                    مديونية الإشتراك السنوي
                                                                                </h4>
                                                                                <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                    <p class="mb-0 text-center empty-msg fw-bold fs-3">{{$noDelays}}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="old-delays">
                                                                <div class="old-content">
                                                                    <div class="row justify-content-center g-0">
                                                                        @if (count($oldDelays) >= 1)
                                                                            <div class="w-100 border-1 border-dark rounded-3">
                                                                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                    <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                        <img width="80" height="80" src="https://img.icons8.com/external-kmg-design-outline-color-kmg-design/80/external-document-folder-and-document-kmg-design-outline-color-kmg-design.png" alt="external-document-folder-and-document-kmg-design-outline-color-kmg-design"/>
                                                                                        متأخرات الإشتراكات
                                                                                    </h4>
                                                                                    <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                        @foreach ($oldDelays as $delay)
                                                                                            <div class="col-lg-4 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h4 role="presentation">
                                                                                                        <span class="h6 text-green total-subscription-oldDelay-amount fw-light d-block" data-total-subscription-olddelay-amount="{{$delay->amount}}">المبلغ المطلوب</span>
                                                                                                        {{$delay->amount}} ج.م
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                            @if ($delay->delay_amount == null || $delay->delay_remaining == null)
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h4 role="presentation">
                                                                                                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                                                                                                            لا يوجد
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h3 role="presentation">
                                                                                                            <span class="h6 text-green fw-light d-block">المتبقي</span>
                                                                                                            لا يوجد
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @else
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h4 role="presentation">
                                                                                                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                                                                                                            {{$delay->delay_amount}} ج.م
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h3 role="presentation">
                                                                                                            <span class="h6 text-green oldDelay-remaining-subscription-amount fw-light d-block" data-olddelay-subscription-remaining-amount="{{$delay->delay_remaining}}">المتبقي</span>
                                                                                                            {{$delay->delay_remaining}} ج.م
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="w-100 border-1 border-dark ms-1 rounded-3">
                                                                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                    <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                        <img width="80" height="80" src="https://img.icons8.com/external-kmg-design-outline-color-kmg-design/80/external-document-folder-and-document-kmg-design-outline-color-kmg-design.png" alt="external-document-folder-and-document-kmg-design-outline-color-kmg-design"/>
                                                                                        متأخرات الإشتراكات
                                                                                    </h4>
                                                                                    <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                        <p class="mb-0 text-center fs-3 fw-bold empty-msg">{{$noOldDelays}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="delay-donaion">
                                                                <div class="delay-donaiton-content">
                                                                    <div class="row justify-content-center g-0">
                                                                        @if (count($donationDelays) > 0)
                                                                            <div class="w-100 border-1 border-dark rounded-3">
                                                                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                    <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                        <img width="64" height="64" src="https://img.icons8.com/external-those-icons-lineal-color-those-icons/64/external-donate-money-currency-those-icons-lineal-color-those-icons.png" alt="external-donate-money-currency-those-icons-lineal-color-those-icons"/>
                                                                                        مديونية التبرعات
                                                                                    </h4>
                                                                                    <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                        @foreach ($donationDelays as $delay)
                                                                                            <div class="col-lg-4 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h4 role="presentation">
                                                                                                        <span class="h6 text-green fw-light total-current-donation-amount d-block" data-total-current-donation-amount="{{$delay->delay_amount}}">المبلغ المطلوب</span>
                                                                                                        {{$delay->delay_amount}}
                                                                                                        ج.م
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-4 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h4 role="presentation">
                                                                                                        <span class="h6 text-green fw-light d-block">المدفوع</span>
                                                                                                        {{$delay->amount_paied}}
                                                                                                        ج.م
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-4 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h4 role="presentation">
                                                                                                        <span class="h6 text-green fw-light current-donations-remaining-amount d-block" data-current-donations-remaining-amount="{{$delay->amount_remaining}}">المتبقي</span>
                                                                                                        {{$delay->amount_remaining}}
                                                                                                        ج.م
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="w-100 border-1 border-dark ms-1 rounded-3">
                                                                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                    <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                        <img width="64" height="64" src="https://img.icons8.com/external-those-icons-lineal-color-those-icons/64/external-donate-money-currency-those-icons-lineal-color-those-icons.png" alt="external-donate-money-currency-those-icons-lineal-color-those-icons"/>
                                                                                        مديونية التبرعات
                                                                                    </h4>
                                                                                    <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                        <h3 class="text-center mb-0">لا توجد مديونية تبرعات</h3>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="old-donations">
                                                                <div class="old-donation-content">
                                                                    <div class="row justify-content-center g-0">
                                                                        @if (count($donationOlddelays) > 0)
                                                                            <div class="w-100 border-1 border-dark rounded-3">
                                                                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                    <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                        <img width="64" height="64" src="https://img.icons8.com/external-justicon-lineal-color-justicon/64/external-donation-economy-and-currency-justicon-lineal-color-justicon.png" alt="external-donation-economy-and-currency-justicon-lineal-color-justicon"/>
                                                                                        متأخرات التبرعات
                                                                                    </h4>
                                                                                    <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                        @foreach ($donationOlddelays as $delay)
                                                                                            <div class="col-lg-4 p-1 py-2">
                                                                                                <div class="text-center">
                                                                                                    <h4 role="presentation">
                                                                                                        <span class="h6 text-green total-donation-oldDelay-amount fw-light d-block" data-total-donation-olddelay-amount="{{$delay->amount}}">المبلغ المطلوب</span>
                                                                                                        {{$delay->amount}} ج.م
                                                                                                    </h4>
                                                                                                </div>
                                                                                            </div>
                                                                                            @if ($delay->delay_amount == null && $delay->delay_remaining == null)
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h4 role="presentation">
                                                                                                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                                                                                                            لا يوجد
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h3 role="presentation">
                                                                                                            <span class="h6 text-green fw-light d-block">المتبقي</span>
                                                                                                            لا يوجد
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @else
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h4 role="presentation">
                                                                                                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                                                                                                            {{$delay->delay_amount}} ج.م
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-4 p-1 py-2">
                                                                                                    <div class="text-center">
                                                                                                        <h3 role="presentation">
                                                                                                            <span class="h6 text-green oldDelay-donations-remaining-amount fw-light d-block" data-olddelay-donations-remaining-amount="{{$delay->delay_remaining}}">المتبقي</span>
                                                                                                            {{$delay->delay_remaining}} ج.م
                                                                                                        </h3>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="w-100 border-1 border-dark ms-1 rounded-3">
                                                                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                                                    <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                                                        <img width="65" height="65" src="https://img.icons8.com/fluency/65/add-dollar.png" alt="add-dollar"/>
                                                                                        متأخرات التبرعات
                                                                                    </h4>
                                                                                    <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">
                                                                                        <p class="mb-0 text-center fs-3 fw-bold empty-msg">لا توجد متأخرات تبرعات</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
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
                                @else
                                    <div class="message-data text-center">
                                        <h1 class="text-center my-3">{{$emptyMessage}}</h1>
                                        <p class="mb-3 fs-6 fw-bold text-center">{{$emptyMessage2}}</p>
                                        <a class="fw-bold" href="{{$link}}" target="blank">{{$link_title}}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tomb" role="tabpanel" aria-labelledby="pills-tomb">
                    <div class="container">
                        <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                            <div class="col-lg-12">
                                @if(count($tombsByRegion) > 0)
                                @foreach ($tombsByRegion as $region => $tombs)
                                    <div class="card position-relative border-secondary border-2 p-4 w-100 mb-5">
                                        <div class="card-header text-center bg-secondary py-2 px-4 rounded-pill w-25 ms-5 position-absolute top--20px">
                                            <h3 class="mb-0 font-weight-bold text-center text-white">مقابر {{$region}}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-center align-items-center">
                                                @foreach ($tombs as $tomb)
                                                    <div class="col-lg-4 div col-md-6">
                                                        <div class="tomb-item p-3 rounded bg-secondary mb-3">
                                                            <div class="tomb-item-title">
                                                                <h4 class="text-center text-white">{{$tomb->title}}</h4>
                                                            </div>
                                                                <div class="guard-tomb-data mb-3 mt-3 text-center text-white">
                                                                    <p class="fw-bold">
                                                                        إسم التربي:
                                                                        <span class="ms-1">{{$tomb->tomb_guard_name}}</span>
                                                                    </p>
                                                                    <p class="mb-0 fw-bold">
                                                                        رقم المحمول:
                                                                        <span class="ms-1">{{$tomb->tomb_guard_number}}</span>
                                                                    </p>
                                                                </div>
                                                            <div class="tomb-item-body mt-3 w-100 text-center">
                                                                <a href="{{$tomb->location}}" class="rounded-pill bg-smoke-white text-secondary px-4 fs-5 py-1" target="blank">
                                                                    <b>الموقع</b>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                    <div class="message-data text-center">
                                        <h1 class="text-center my-3">لا توجد مقابر مسجلة حاليا</h1>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="wedding" role="tabpanel" aria-labelledby="pills-wedding">
                    <div class="container-fluid">
                        <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                            <div class="col-lg-12">
                                <div class="wedding-cards">
                                    @if (count($weddingsByMonth) > 0)
                                        @foreach ($weddingsByMonth as $month => $weddings)
                                            <div class="card card-shadow position-relative border-2 border-secondary rounded mt-5 p-4 w-100">
                                                <div class="card-header bg-secondary position-absolute rounded-pill w-25 top--20px">
                                                    <h4 class="text-center text-white">أفراح شهر {{ $month }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped align-middle table-borderless rounded table-hover mt-3 text-center">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th>اليوم</th>
                                                                    <th>تاريخ المناسبة</th>
                                                                    <th>إسم العريس</th>
                                                                    <th>والد العروس</th>
                                                                    <th>المكان</th>
                                                                    <th>من الساعة</th>
                                                                    <th>الى الساعة</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($weddings->filter(function($wed) use ($today) { return Carbon::parse($wed->date)->startOfDay()->gte($today); })->sortBy('date') as $wed)
                                                                    <tr>
                                                                        <td>{{$wed->day}}</td>
                                                                        <td>{{$wed->date}}</td>
                                                                        <td>{{$wed->groom_name}}</td>
                                                                        <td>كريمة/{{$wed->pride_father_name}}</td>
                                                                        <td>{{$wed->address}}</td>
                                                                        <td dir="ltr">{{ $wed->from_time ? $wed->from_time : 'لم يحدد بعد' }}</td>
                                                                        <td dir="ltr">{{ $wed->to_time ? $wed->to_time : 'لم يحدد بعد' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">
                                                <h1 class="text-center">لا توجد مناسبات حاليا</h1>
                                            </td>
                                        </tr>
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
