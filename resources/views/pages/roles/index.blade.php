@extends('layouts.master')
@section('title', 'الأدوار')
@section('breadcrumb-title')
    <h3>الأدوار</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href="{{route('home')}}">الرئيسية</a>
    </li>
    <li class="breadcrumb-item active">الأدوار</li>
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
@endsection
@section('modals')
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newrole">إضافة دور جديد</button>
    <div class="modal fade" id="newrole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">إضافة دور جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('roles.store')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">إسم الدور</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="إسم الدور">
                        </div>
                        <div class="form-group mb-3">
                            <label for="permissions" class="form-label">الصلاحيات</label>
                            <select name="permissions[]" id="permissions" class="form-select js-example-rtl" multiple data-placeholder="-- الصلاحيات --">
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->name}}">{{$permission->name}}</option>
                                @endforeach
                            </select>
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
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @php
                flasherError($error);
            @endphp
        @endforeach
    @endif
    <section class="roles-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle" id="table" data-page-length="10">
                                    <thead>
                                        <tr>
                                            <th>إسم الدور</th>
                                            <th>الإجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{$role->name}}</td>
                                                <td>
                                                    {{-- ! Edit Role ! --}}
                                                    <a class="btn fs-4" data-bs-toggle="modal" href="#updaterole{{$role->id}}">
                                                        <i class="fa-duotone fa-solid fa-pen-to-square text-warning fs-5"></i>
                                                    </a>
                                                    <div class="modal fade" id="updaterole{{$role->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">حذف الدور {{$role->name}}</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('roles.update') }}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$role->id}}">
                                                                        <div class="form-group mb-3">
                                                                            <label for="name" class="form-label">إسم الدور</label>
                                                                            <input type="text" name="name" id="name" value="{{$role->name}}" class="form-control">
                                                                        </div>
                                                                        <div class="form-group mb-3">
                                                                            <label for="permission" class="form-label">صلاحيات الدور</label>
                                                                            <select name="permissions[]" id="permissions_{{$role->id}}" class="form-control js-example-rtl" multiple data-placeholder="-- صلاحيات الدور --">
                                                                                @foreach($permissions as $permission)
                                                                                    <option value="{{ $permission->name }}" 
                                                                                        {{ isset($rolePermissions[$role->id]) && in_array($permission->id, $rolePermissions[$role->id]) ? 'selected' : '' }}>
                                                                                        {{ $permission->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
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
                                                    {{-- ! Delete ! --}}
                                                    <a class="btn fs-4" data-bs-toggle="modal" href="#deleterole{{$role->id}}">
                                                        <i class="fa-solid fa-trash text-danger fs-5"></i>
                                                    </a>
                                                    <div class="modal fade" id="deleterole{{$role->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">حذف الدور {{$role->name}}</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('roles.destroy', $role->id) }}" method="get">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <h1 class="text-center">هل انت متأكد ؟</h1>
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