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
@section('site')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center w-50 mx-auto rounded" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
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
                                    <form id="searchBySsnForm" method="post" class="my-5 w-50 mx-auto">
                                        @csrf
                                        <input type="number" name="ssn" id="ssn" class="form-control border-3 border-primary text-center fw-bold" placeholder="البحث بالرقم القومي">
                                        <small class="form-text text-danger text-center w-100">
                                            برجاء إدخال <strong>الرقم القومي</strong> لإتمام عملية البحث.
                                        </small>
                                        <button type="submit" class="btn btn-secondary rounded-pill w-100 mt-3 fw-bold fs-5">بحث</button>
                                    </form>
                                </div>
                                <div id="searchResult"></div>
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