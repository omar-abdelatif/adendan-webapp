@php
    $user = Auth::user();
@endphp
@extends('layouts.master')
@section('title', 'كل التبرعات')
@section('breadcrumb-title')
    <h3>كل التبرعات الخاصة بالمتبرع {{$donators->name}}</h3>
@endsection
@section('breadcrumb-items')
    @if ($user->role === 'subscriptions')
        <li class="breadcrumb-item">
            <a href="{{route('subscriptionRole.donators.all')}}">كل المتبرعين</a>
        </li>
    @else
        <li class="breadcrumb-item">
            <a href="{{route('donators.all')}}">كل المتبرعين</a>
        </li>
    @endif
    <li class="breadcrumb-item active">التبرعات السابقة</li>
@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center w-50 mx-auto rounded" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">التبرعات السابقة للمتبرع {{$donators->name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table display table-hover text-muted" data-order='[[1,"asc"]]' data-page-length=10>
                                <thead>
                                    <tr>
                                        <th class="text-center">إسم المتبرع</th>
                                        <th class="text-center">رقم الإيصال</th>
                                        <th class="text-center">المبلغ</th>
                                        <th class="text-center">نوع التبرع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($outerdonations as $donations)
                                        <tr>
                                            <td class="text-center">{{$donators->name}}</td>
                                            <td class="text-center">{{$donations->invoice_id}}</td>
                                            <td class="text-center">{{$donations->amount}}</td>
                                            <td class="text-center">{{$donations->donation_destination}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
