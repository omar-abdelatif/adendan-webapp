@extends('layouts.master')
@section('title', 'تقارير الوظائف')
@section('breadcrumb-title')
    <h3>تقارير الوظائف</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير الوظائف</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="job-filter mb-5 text-center">
                            <form action="{{route('reports.jobs')}}" method="get">
                                @csrf
                                <div class="d-flex align-items-center justify-content-center">
                                    <input type="search" name="search" placeholder="بحث بالوظيفة" class="form-control w-50 text-center text-white">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <div class="searchResultTitle text-center mb-5">
                                @if (isset($keyword) && $jobs->isNotEmpty())
                                    <h1>نتائج البحث عن "{{ $keyword }}"</h1>
                                @else
                                    <h1>{{ $message }}</h1>
                                @endif
                            </div>
                            @if (isset($keyword) && $jobs->isNotEmpty())
                                <table class="table display align-middle text-center table-hover" id="table2" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                    <thead>
                                        <tr>
                                            <th class="text-white text-center">إسم المشترك</th>
                                            <th class="text-white text-center">الرقم القومي</th>
                                            <th class="text-white text-center">رقم المحمول</th>
                                            <th class="text-white text-center">الوظيفة</th>
                                            <th class="text-white text-center">مكان السكن</th>
                                            <th class="text-white text-center">حالة الإشتراك</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobs as $item)
                                            <tr>
                                                <td class="text-center text-white">{{$item->name}}</td>
                                                <td class="text-center text-white">{{$item->ssn}}</td>
                                                <td class="text-center text-white">{{$item->mobile_no}}</td>
                                                <td class="text-center text-white">{{$item->job}}</td>
                                                <td class="text-center text-white">{{$item->address}}</td>
                                                <td class="text-center text-white">
                                                    @if($item->status == 1)
                                                        <span class="badge rounded-pill badge-success">الإشتراك مفعل</span>
                                                    @else
                                                        <span class="badge rounded-pill badge-danger">الإشتراك غير مفعل</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <table class="table display align-middle text-center table-hover" id="table2" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-white text-center">إسم المشترك</th>
                                            <th class="text-white text-center">الرقم القومي</th>
                                            <th class="text-white text-center">رقم المحمول</th>
                                            <th class="text-white text-center">الوظيفة</th>
                                            <th class="text-white text-center">مكان السكن</th>
                                            <th class="text-white text-center">حالة الإشتراك</th>
                                        </tr>
                                    </thead>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

