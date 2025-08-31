@extends('layouts.master')
@section('title', 'كل المستخدمين')
@section('breadcrumb-title')
    <h3>كل المستخدمين</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل المستخدمين</li>
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة مستخدم جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة مستخدم جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('user.store')}} method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title" class="text-muted">إسم المستخدم</label>
                                    <input type="text" class="form-control text-muted" name="name"  placeholder="إسم المستخدم" id="userName" required autocomplete="false">
                                    <p class="required d-none text-danger mb-0" id="userNameReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="userNameMsg">يجب ان يكون اسم اللجنة باللغة العربية ولا يقل عن 10 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-muted">البريد الإلكتروني</label>
                                    <input type="email" class="form-control text-muted" name="email" placeholder="البريد الإلكتروني" id="userEmail" required>
                                    <p class="required d-none text-danger mb-0" id="emailReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="emailMsg">يجب ان يكتب الاسم باللغة العربية ولا يقل عن 3 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-muted">كلمة السر</label>
                                    <input type="password" class="form-control text-muted" name="password" id="password" placeholder="كلمة السر">
                                    <p class="required d-none text-danger mb-0" id="passReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="passMsg">يجب ان يكتب الاسم باللغة العربية ولا يقل عن 3 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-muted">دور المستخدم</label>
                                    <select name="role" class="form-select text-muted" id="role">
                                        <option selected disabled>الدور</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->name}}">{{$role->name}}</option>
                                            @endforeach
                                    </select>
                                    <p class="required d-none text-danger mb-0" id="roleReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="roleMsg">يجب ان يكتب الاسم باللغة العربية ولا يقل عن 3 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="permissions" class="form-label text-muted">صلاحيات المستخدم</label>
                                    <select name="permission" id="pemissions" class="form-select text-muted js-example-rtl" multiple data-placeholder="-- صلاحيات المستخدم --">
                                        @foreach ($permissions as $permission)
                                            <option value="{{$permission->name}}">{{$permission->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                    <button type="submit" role="button" id="userSubmit" class="btn btn-primary">تأكيد</button>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-hovered text-muted align-middle text-center" data-order='[[0,"asc"]]' data-page-length="10">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">إسم المستخدم</th>
                                        <th class="text-center">البريد الإلكتروني</th>
                                        <th class="text-center">الدور</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $user->name }}</td>
                                            <td class="text-center">{{ $user->email }}</td>
                                            <td class="text-center">
                                                @foreach ($user->roles as $role)
                                                    {{$role->name}}
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#editing_{{$user->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editing_{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">تعديل لجنة {{$user->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('newuser.update')}} method="post">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <input type="hidden" name="id" value={{$user->id}} >
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-muted">إسم المستخدم</label>
                                                                                <input type="text" class="form-control text-muted" name="name" value="{{$user->name}}" placeholder="إسم المستخدم" id="userName" required autocomplete="false">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">البريد الإلكتروني</label>
                                                                                <input type="email" class="form-control text-muted" value="{{$user->email}}" name="email" placeholder="البريد الإلكتروني" id="userEmail" required>
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">كلمة السر</label>
                                                                                <input type="password" class="form-control text-muted" name="password" id="password" placeholder="كلمة السر">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">دور المستخدم</label>
                                                                                <select name="role" class="form-select" id="role">
                                                                                    <option selected disabled>-- دور المستخدم --</option>
                                                                                    @foreach($roles as $role)
                                                                                        <option value="{{$role->name}}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{$role->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="permissions" class="form-label text-muted">صلاحيات المستخدم</label>
                                                                                <select name="permission[]" id="permissions" class="form-select text-muted js-example-rtl" multiple data-placeholder="-- صلاحيات المستخدم --">
                                                                                    @foreach ($permissions as $permission)
                                                                                        <option value="{{$permission->name}}" 
                                                                                            {{ isset($usersPermissions[$user->id]) && in_array($permission->id, $usersPermissions[$user->id]) ? 'selected' : '' }}>
                                                                                            {{$permission->name}}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                <button type="submit" role="button" id="userSubmit" class="btn btn-primary">تأكيد</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- ! Delete ! --}}
                                                <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$user->id}}">
                                                    <i class="icofont icofont-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">جار حذف اللجنة {{$user->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('user.delete', $user->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h3 class="text-muted my-2">هل أنت متأكد من الحذف</h3>
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
@endsection
