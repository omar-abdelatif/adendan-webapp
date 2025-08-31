@extends('layouts.master')
@section('title', 'الصلاحيات')
@section('breadcrumb-title')
    <h3>الصلاحيات</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href="{{route('home')}}">الرئيسية</a>
    </li>
    <li class="breadcrumb-item active">الصلاحيات</li>
@endsection
@section('modals')
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newtestmonials">إضافة صلاحية جديدة</button>
    <div class="modal fade" id="newtestmonials" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-muted fs-5" id="exampleModalLabel">إضافة صلاحية جديدة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('permissions.store')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label text-muted">إسم الصلاحية</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="إسم الصلاحية">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <section class="permissions-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" id="table" data-page-length="25">
                                    <thead>
                                        <tr>
                                            <th>إسم الصلاحية</th>
                                            <th>الإجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->name }}</td>
                                                <td>
                                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#updatepermission{{$permission->id}}">
                                                        <i class="fa-solid fa-pen text-warning fs-5"></i>
                                                    </button>
                                                    <div class="modal fade" id="updatepermission{{$permission->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title text-muted fs-5" id="exampleModalLabel">تعديل صلاحية {{$permission->name}}</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('permissions.update')}}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$permission->id}}">
                                                                        <div class="form-group">
                                                                            <label for="permission" class="form-label text-muted">إسم الصلاحية</label>
                                                                            <input type="text" id="permission" class="form-control" name="name" value="{{$permission->name}}">
                                                                        </div>
                                                                        <div class="form-group mt-3">
                                                                            <button class="btn btn-primary w-100" type="submit">تأكيد</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn" data-bs-toggle="modal" data-bs-target="#deletepermission{{$permission->id}}">
                                                        <i class="fa-solid fa-trash text-danger fs-5"></i>
                                                    </button>
                                                    <div class="modal fade" id="deletepermission{{$permission->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">حذف صلاحية {{$permission->name}}</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('permissions.destroy', $permission->id)}}" method="get">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <h1 class="text-center">هل انت متأكد ؟</h1>
                                                                        </div>
                                                                        <div class="form-group mt-3">
                                                                            <button class="btn btn-primary w-100" type="submit">تأكيد</button>
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
    </section>
@endsection