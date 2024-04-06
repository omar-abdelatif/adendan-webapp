@extends('frontend.layouts.master')
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">الإستعلامات</li>
@endsection
@section('site')
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
                        <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                            <div class="col-lg-12">
                                <div class="search-form">
                                    <form action="{{route('site.result')}}" method="post" class="my-5 w-50 mx-auto">
                                        @csrf
                                        <input type="number" name="ssn" id="ssn" class="form-control border border-3 border-primary text-center fw-bold" placeholder="البحث بالرقم القومي">
                                        <button type="submit" class="btn btn-secondary rounded-pill w-100 mt-3 fw-bold fs-5">بحث</button>
                                    </form>
                                </div>
                                @php
                                    $member = session('member');
                                    $searched = session('searched');
                                    $emptyMessage = session('empty_message');
                                    $validSsn = session('valid_message');
                                @endphp
                                @if ($searched)
                                    @if ($member)
                                        <div class="card border-0 w-75 mx-auto">
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
                                                <div class="card-title my-3">
                                                    <h3 class="text-center fw-bold">المديونيات و المتأخرات</h3>
                                                </div>
                                                <div class="card-content d-flex">
                                                    @if ($member->delays !== null)
                                                        @foreach ($member->delays as $delay)
                                                            <div class="delay-item rounded-2 p-2 ms-3 mb-2 border border-2 border-primary w-100">
                                                                <p class="mb-0 text-center">السنة: {{$delay->year}}</p>
                                                                <p class="mb-0 text-center">الإشتراك السنوية: {{$delay->yearly_cost}} ج.م</p>
                                                                @if ($delay->paied == null || $delay->remaing == null)
                                                                    <p class="mb-0 text-center">المبلغ المدفوع: لا يوجد</p>
                                                                    <p class="mb-0 text-center">المبلغ المتبقي: لا يوجد</p>
                                                                @else
                                                                    <p class="mb-0 text-center">المبلغ المدفوع: {{$delay->paied}} ج.م</p>
                                                                    <p class="mb-0 text-center">المبلغ المتبقي: {{$delay->remaing}} ج.م</p>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @if ($validSsn)
                                            <h1 class="text-center my-3">{{ $validSsn }}</h1>
                                        @endif
                                    @endif
                                @else
                                    <h1 class="text-center my-3">{{$emptyMessage}}</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tomb" role="tabpanel" aria-labelledby="pills-tomb">
                    <div class="container">
                        <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                            <div class="col-lg-12">
                                @foreach ($tombsByRegion as $region => $tombs)
                                    <div class="card position-relative border border-secondary border-2 mt-5 p-4 w-100">
                                        <div class="card-header text-center bg-secondary py-2 px-4 rounded-pill w-25 ms-5 position-absolute top--20px">
                                            <h3 class="mb-0 font-weight-bold text-center text-white">مقابر {{$region}}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row justify-content-center align-items-center">
                                                @foreach ($tombs as $tomb)
                                                    <div class="col-lg-4 div col-md-6">
                                                        <div class="tomb-item p-3 rounded bg-secondary mb-3 mt-3">
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
                                                                <a href="{{$tomb->location}}" class="rounded-pill bg-smoke-white text-secondary px-4 fs-5 py-1">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="wedding" role="tabpanel" aria-labelledby="pills-wedding">
                    <div class="container">
                        <div class="row mb-0 mb-sm-4 tanfeeth-cards cards-wrapper" role="region">
                            <div class="col-lg-12">
                                <div class="wedding-cards">
                                    @foreach ($weddingsByMonth as $month => $weddings)
                                        <div class="card card-shadow position-relative border border-2 border-secondary rounded mt-5 p-4 w-100">
                                            <div class="card-header bg-secondary position-absolute rounded-pill w-25 top--20px">
                                                <h4 class="text-center text-white">أفراح شهر {{ $month }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive overflow-hidden">
                                                    <table class="table table-striped table-borderless rounded table-hover text-right mt-3 text-center">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th>عنوان الخبر</th>
                                                                <th>التاريخ</th>
                                                                <th>التفاصيل</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($weddings as $wed)
                                                                <tr>
                                                                    <td>{{$wed->title}}</td>
                                                                    <td>{{$wed->date}}</td>
                                                                    <td>
                                                                        <a href="{{route('site.weddingDetails', $wed->id)}}" class="btn btn-success text-white">
                                                                            <i class="fa-regular fa-eye"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
