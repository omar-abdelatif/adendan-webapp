@extends('layouts.master')
@section('title', 'سجل النشاطات')
@section('breadcrumb-title')
    <h3>سجل النشاطات</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">سجل النشاطات</li>
@endsection
@section('script')
    <script src="{{asset('assets/js/ajax_requests.js')}}"></script>
@endsection
@section('content')
    <section class="activity-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="activity-table" class="table table-striped table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>الوصف</th>
                                            <th>بواسطة</th>
                                            <th>تم الإنشاء في</th>
                                            <th>تم التحديث في</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activities as $activity)
                                            <tr>
                                                <td>{{$activity->description}}</td>
                                                <td>{{ $activity->customCauser->name }}</td>
                                                <td>{{$activity->created_at->format('Y-m-d H:i:s')}}</td>
                                                <td>{{$activity->updated_at->format('Y-m-d H:i:s')}}</td>
                                                <td>
                                                    @if ($activity->event === 'updated')
                                                        <button type="button" class="btn btn-success px-2 py-1" data-bs-toggle="modal" data-bs-target="#show_{{$activity->id}}">
                                                            <i class="fa-regular fa-eye fs-6"></i>
                                                        </button>
                                                        <div class="modal fade" id="show_{{$activity->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header align-content-center">
                                                                        <h1 class="modal-title fs-5 text-white mb-0" id="exampleModalLabel">تفاصيل التحديث</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @php
                                                                            $data = json_decode($activity->properties, true);
                                                                        @endphp
                                                                        <div class="row align-items-center justify-content-center">
                                                                            @foreach ($data as $section => $properties)
                                                                                <div class="col-lg-6 col-sm-12">
                                                                                    <div class="modal-title">
                                                                                        <h5 class="fs-5">{{ $section }}</h5>
                                                                                    </div>
                                                                                    <div class="card py-3">
                                                                                        <div class="card-body">
                                                                                            @foreach ($properties as $property => $value)
                                                                                                <p>
                                                                                                    <span class="fs-5 fw-bold">{{ $property }}:</span>
                                                                                                    <span class="fs-6">{{$value ? $value : "لا يـــوجد"}}</span>
                                                                                                </p>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="fw-bold">-</span>
                                                    @endif
                                                </td>
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
    </section>
@endsection
