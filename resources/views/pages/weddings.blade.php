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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة فرح جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{$user->role === 'admin' ? route('weddings.store') : route('mediaRole.weddings.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title" class="text-white">عنوان الخبر</label>
                                    <input type="text" class="form-control text-white" name="title" placeholder="العنوان">
                                </div>
                                <div class="form-group">
                                    <label for="title" class="text-white">التفاصيل</label>
                                    <textarea name="details" class="form-control text-white" placeholder="التفاصيل" cols="30" rows="2"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="text-white">العنوان</label>
                                    <input type="text" class="form-control text-white" name="address" placeholder="العنوان">
                                </div>
                                <div class="form-group">
                                    <label for="title" class="text-white">موعد المناسبة</label>
                                    <input type="date" class="form-control text-white" name="date">
                                </div>
                                <div class="form-group mt-3">
                                    <label class="text-white">الموقع</label>
                                    <input type="text" name="location" placeholder="مكان المناسبة" class="form-control text-white">
                                </div>
                                <div class="form-group mt-3">
                                    <label class="text-white">الصورة</label>
                                    <input type="file" name="img" class="form-control text-white" accept="image/*">
                                </div>
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
                                        <th class="text-white text-center">عنوان الخبر</th>
                                        <th class="text-white text-center">موعد المناسبة</th>
                                        <th class="text-white text-center">موقع المناسبة</th>
                                        <th class="text-white text-center">الصورة</th>
                                        <th class="text-white text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weddings as $wedding)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td class="text-white text-center">{{$wedding->title}}</td>
                                            <td class="text-white text-center">{{$wedding->date}}</td>
                                            <td class="text-white text-center">{{$wedding->location}}</td>
                                            <td>
                                                <img src="{{asset('assets/images/weddings/'.$wedding->img)}}" alt="{{$wedding->img}}" width="50" class="rounded">
                                            </td>
                                            <td>
                                                {{-- !  Delete --}}
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleting_{{$wedding->id}}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$wedding->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف المناسبة {{$wedding->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{$user->role === 'admin' ? route('wedding.delete', $wedding->id) : route('mediaRole.weddings.delete', $wedding->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h1 class="text-white">هل أنت متأكد من الحذف</h1>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                        <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- !  Update --}}
                                                <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editingborder_{{$wedding->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editingborder_{{$wedding->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تحديث الحرفي {{$wedding->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{$user->role === 'admin' ? route('weddings.update') : route('mediaRole.weddings.update')}}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <input type="hidden" name="id" value="{{$wedding->id}}">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">عنوان الخبر</label>
                                                                                <input type="text" class="form-control text-white" value="{{$wedding->title}}" name="title" placeholder="العنوان">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">التفاصيل</label>
                                                                                <textarea name="details" class="form-control text-white" placeholder="التفاصيل" cols="30" rows="2">{{$wedding->details}}</textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">العنوان</label>
                                                                                <input type="text" class="form-control text-white" value="{{$wedding->address}}" name="address" placeholder="العنوان">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">موعد المناسبة</label>
                                                                                <input type="date" class="form-control text-white" name="date" value="{{$wedding->date}}">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label class="text-white">الموقع</label>
                                                                                <input type="text" name="location" placeholder="مكان المناسبة" class="form-control text-white" value="{{$wedding->location}}">
                                                                            </div>
                                                                            <div class="img-show">
                                                                                <img src={{asset('assets/images/weddings/'.$wedding->img)}} width="80" data-member-id="{{ $wedding->id }}" id="showImage_{{ $wedding->id }}" class="rounded" alt="">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label class="text-white">الصورة</label>
                                                                                <input type="file" name="img" class="form-control text-white" id="image" data-member-id="{{ $wedding->id }}" accept="image/*" value="{{$wedding->img}}">
                                                                            </div>
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
