@extends('frontend.layouts.master')
@section('title')
    مجلس الإداره
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">مجلس الإدارة</li>
@endsection
@section('site')
    <div class="section-borders bg-smoke-white py-5">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    @foreach ($boards as $border)
                        @if ($border->position === 'رئيس مجلس الإدارة')
                            <section class="py-5">
                                <div class="container">
                                    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-center justify-content-md-start">
                                        <img src="{{asset('assets/images/border-photos/'.$border->img)}}" class="rounded-5" width="500" alt="{{$border->name}}">
                                        <div class="d-flex flex-column ms-0 me-5 ms-md-5 mt-3 mt-md-0">
                                            <h2 class="text-primary-blue">
                                                <b>{{$border->position}}</b>
                                            </h2>
                                            <span class="text-primary-green fs-4 fw-bolder">أ/ {{$border->name}}</span>
                                            <span class=" mb-0 fs-5"><b dir="ltr">+{{$border->phone_number}}</b></span>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        @foreach ($boards as $border)
                            @if ($border->position !== 'رئيس مجلس الإدارة' && $border->position !== 'عضو مجلس الإدارة')
                                <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="border-item mb-5">
                                        <img src="{{asset('assets/images/border-photos/'.$border->img)}}" class="rounded-5 box-shadow" width="100%" alt="{{$border->name}}">
                                        <div class="position-relative text-center">
                                            <div class="w-100 position-absolute" style="right: 0; top: -40px;">
                                                <div class="d-flex flex-column text-white p-2 bg-secondary text-center mx-3 small">
                                                    <span class="font-semibold fs-5"> أ/ {{$border->name}}</span>
                                                    <span class="fs-6"><b>{{$border->position}}</b></span>
                                                    <span class="fs-6"><b dir="ltr">+{{$border->phone_number}}</b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        @foreach ($boards as $border)
                            @if ($border->position === 'عضو مجلس الإدارة')
                                <div class="col-lg-3 col-md-3 col-sm-6">
                                    <div class="border-item mt-5 mb-5">
                                        <img src="{{asset('assets/images/border-photos/'.$border->img)}}" class="rounded-5 box-shadow" width="100%" alt="{{$border->name}}">
                                        <div class="position-relative text-center">
                                            <div class="w-100 position-absolute" style="right: 0; top: -40px;">
                                                <div class="d-flex flex-column text-white p-2 bg-secondary text-center mx-3 small">
                                                    <span class="font-semibold fs-5"> أ/ {{$border->name}}</span>
                                                    <span class="fs-6"><b>{{$border->position}}</b></span>
                                                    <span class="fs-6"><b dir="ltr">+{{$border->phone_number}}</b></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
