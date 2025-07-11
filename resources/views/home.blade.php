@php
    $user = auth()->user();
@endphp
@extends('layouts.master')
@section('title', 'لوحة التحكم')
@section('breadcrumb-title')
    <h3>لوحة التحكم</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">لوحة التحكم</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-start">
            <div class="col-lg-6 box-col-6">
                <div class="card profile-box">
                    <div class="card-body">
                        <div class="media media-wrapper justify-content-between">
                            <div class="media-body">
                                <div class="greeting-user">
                                    <h5 class="f-w-600">
                                        مرحباً
                                        <span class="text-decoration-underline fw-bold mx-2">{{$user->name}}</span>
                                        في جمعية أدندان الخيرية
                                    </h5>
                                    <p>تأسست عام 1908م</p>
                                </div>
                            </div>
                        </div>
                        <div class="cartoon">
                            <img class="img-fluid" src="https://admin.pixelstrap.com/cuba/assets/images/dashboard/cartoon.svg" alt="vector women with leptop">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
