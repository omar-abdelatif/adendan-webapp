@php
    $user = Auth::user();
@endphp
@extends('layouts.master')
@section('title', 'كل الأفراح')
@section('breadcrumb-title')
    <h3>كل الأفراح</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل الأفراح</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة فرح جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة فرح جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{$user->role === 'admin' ? route('weddings.store') : route('mediaRole.weddings.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="day" class="text-muted fw-bold">اليوم</label>
                                    <select name="day" class="form-select text-muted" id="day">
                                        <option selected disabled>إختار اليوم</option>
                                        <option value="السبت">السبت</option>
                                        <option value="الأحد">الأحد</option>
                                        <option value="الأثنين">الأثنين</option>
                                        <option value="الثلاثاء">الثلاثاء</option>
                                        <option value="الأربعاء">الأربعاء</option>
                                        <option value="الخميس">الخميس</option>
                                        <option value="الجمعة">الجمعة</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="groom_name" class="text-muted">إسم العريس</label>
                                    <input type="text" name="groom_name" id="groom_name" placeholder="إسم العريس" class="form-control text-muted">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pride_father_name" class="text-muted fw-bold">والد العروس</label>
                                    <input type="text" name="pride_father_name" id="pride_father_name" placeholder="والد العروس" class="form-control text-muted">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="text-muted fw-bold">تاريخ المناسبة</label>
                                    <input type="date" id="date" class="form-control text-muted" name="date">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address" class="text-muted">العنوان</label>
                                    <input type="text" class="form-control text-muted" id="address" name="address" placeholder="العنوان">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="from_time" class="text-muted">من الساعة</label>
                                            <input type="time" id="from_time" name="from_time" placeholder="HH:MM" class="form-control text-muted">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="to_time" class="text-muted">الى الساعة</label>
                                            <input type="time" id="to_time" name="to_time" placeholder="HH:MM" class="form-control text-muted">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div id="error" class="alert alert-danger rounded w-50 mx-auto text-center">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-white text-center">#</th>
                                        <th class="text-white text-center">اليوم</th>
                                        <th class="text-white text-center">تاريخ المناسبة</th>
                                        <th class="text-white text-center">إسم العريس</th>
                                        <th class="text-white text-center">والد العروس</th>
                                        <th class="text-white text-center">المكان</th>
                                        <th class="text-white text-center">من الساعة</th>
                                        <th class="text-white text-center">الى الساعة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weddings as $wedding)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td class="text-white text-center">{{$wedding->day}}</td>
                                            <td class="text-white text-center">{{$wedding->date}}</td>
                                            <td class="text-white text-center">{{$wedding->groom_name}}</td>
                                            <td class="text-white text-center">كريمة/{{$wedding->pride_father_name}}</td>
                                            <td class="text-white text-center">{{$wedding->address}}</td>
                                            <td class="text-white text-center" dir="ltr">{{$wedding->from_time}}</td>
                                            <td class="text-white text-center" dir="ltr">{{$wedding->to_time}}</td>
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
