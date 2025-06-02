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
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_wedding">إضافة فرح جديد</button>
    <div class="modal fade" id="add_wedding" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                    <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <button type="button" class="btn btn-success ms-3" data-bs-toggle="modal" data-bs-target="#add_wedding_bulk">إضافة أفراح بالجملة</button> --}}
    <div class="modal fade" id="add_wedding_bulk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة فرح جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('weddings.bulk')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="excel_file" class="form-label text-center">ملف الإكسل</label>
                            <input type="file" name="import" class="form-control" id="excel_file" accept=".xlsx, .xls">
                        </div>
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">حفظ البيانات</button>
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
                            <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 1, "desc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-white text-center">اليوم</th>
                                        <th class="text-white text-center">تاريخ المناسبة</th>
                                        <th class="text-white text-center">إسم العريس</th>
                                        <th class="text-white text-center">والد العروس</th>
                                        <th class="text-white text-center">المكان</th>
                                        <th class="text-white text-center">من الساعة</th>
                                        <th class="text-white text-center">الى الساعة</th>
                                        <th class="text-white text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weddings as $wedding)
                                        <tr>
                                            <td class="text-white text-center">{{$wedding->day}}</td>
                                            <td class="text-white text-center">{{$wedding->date}}</td>
                                            <td class="text-white text-center">{{$wedding->groom_name}}</td>
                                            <td class="text-white text-center">{{$wedding->pride_father_name ? 'كريمة/'.$wedding->pride_father_name : '-'}}</td>
                                            <td class="text-white text-center">{{$wedding->address}}</td>
                                            <td class="text-white text-center" dir="ltr">{{$wedding->from_time}}</td>
                                            <td class="text-white text-center" dir="ltr">{{$wedding->to_time}}</td>
                                            <td class="text-white text-center" dir="ltr">
                                                {{-- ! Delete Wedding ! --}}
                                                <button type="button" class="btn btn-outline-danger text-muted px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$wedding->id}}">
                                                    <i class="icofont icofont-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$wedding->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">جار حذف اللجنة {{$wedding->name}}</h1>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{$user->role === 'admin' ? route('wedding.delete', $wedding->id) : route('mediaRole.weddings.delete', $wedding->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h3 class="text-muted my-2">هل أنت متأكد من الحذف</h3>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-start">
                                                                        <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- ! Update Wedding ! --}}
                                                <button type="button" class="btn btn-outline-warning text-muted px-2 py-1" data-bs-toggle="modal" data-bs-target="#update_wedding_{{$wedding->id}}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <div class="modal fade" id="update_wedding_{{$wedding->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header justify-content-between">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تعديل المناسبة</h1>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{$user->role === 'admin' ? route('weddings.update') : route('mediaRole.weddings.update')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$wedding->id}}">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="day" class="text-muted fw-bold">اليوم</label>
                                                                                <select name="day" class="form-select text-muted" id="day">
                                                                                    <option selected disabled>إختار اليوم</option>
                                                                                    <option value="السبت" {{$wedding->day === 'السبت' ? 'selected' : ''}}>السبت</option>
                                                                                    <option value="الأحد" {{$wedding->day === 'الأحد' ? 'selected' : ''}}>الأحد</option>
                                                                                    <option value="الأثنين" {{$wedding->day === 'الأثنين' ? 'selected' : ''}}>الأثنين</option>
                                                                                    <option value="الثلاثاء" {{$wedding->day === 'الثلاثاء' ? 'selected' : ''}}>الثلاثاء</option>
                                                                                    <option value="الأربعاء" {{$wedding->day === 'الأربعاء' ? 'selected' : ''}}>الأربعاء</option>
                                                                                    <option value="الخميس" {{$wedding->day === 'الخميس' ? 'selected' : ''}}>الخميس</option>
                                                                                    <option value="الجمعة" {{$wedding->day === 'الجمعة' ? 'selected' : ''}}>الجمعة</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="groom_name" class="text-muted">إسم العريس</label>
                                                                                <input type="text" name="groom_name" id="groom_name" value="{{$wedding->groom_name}}" placeholder="إسم العريس" class="form-control text-muted">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="pride_father_name" class="text-muted fw-bold">والد العروس</label>
                                                                                <input type="text" name="pride_father_name" id="pride_father_name" value="{{$wedding->pride_father_name}}" placeholder="والد العروس" class="form-control text-muted">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-muted fw-bold">تاريخ المناسبة</label>
                                                                                <input type="date" id="date" class="form-control text-muted" value="{{$wedding->date}}" name="date">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="address" class="text-muted">العنوان</label>
                                                                                <input type="text" class="form-control text-muted" id="address" value="{{$wedding->address}}" name="address" placeholder="العنوان">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-3">
                                                                                        <label for="to_time" class="text-muted">الى الساعة</label>
                                                                                        <input type="time" name="to_time" value="{{ $wedding->to_time }}" class="form-control text-muted">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-3">
                                                                                        <label for="from_time" class="text-muted">من الساعة</label>
                                                                                        <input type="time" name="from_time" value="{{ $wedding->from_time }}" class="form-control text-muted">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="modal-footer justify-content-start">
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
@endsection
