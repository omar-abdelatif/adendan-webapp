@extends('layouts.master')
@section('title', 'كل المستخدمين')
@section('breadcrumb-title')
    <h3>كل المستخدمين</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل المستخدمين</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة مستخدم جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة لجنة جديدة</h1>
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
                                        <option value="admin">Admin</option>
                                        <option value="subscription">Subscription</option>
                                        <option value="media">Media</option>
                                    </select>
                                    <p class="required d-none text-danger mb-0" id="roleReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="roleMsg">يجب ان يكتب الاسم باللغة العربية ولا يقل عن 3 احرف</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
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
                                            <td class="text-center">{{ $user->role }}</td>
                                            <td class="text-center">
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#editing_{{$user->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editing_{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة لجنة جديدة</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('association.update')}} method="post">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <input type="hidden" name="id" value={{$user->id}} >
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-muted">إسم اللجنة</label>
                                                                                <input type="text" class="form-control text-muted" name="name" value="{{$user->name}}" placeholder="إسم اللجنة">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">عن اللجنة</label>
                                                                                <textarea name="description" class="form-control text-muted" placeholder="عن اللجنة" cols="30" rows="3">{{$user->description}}</textarea>
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">رئيس اللجنة</label>
                                                                                <input type="text" class="form-control text-muted" name="boss" value="{{$user->boss}}" placeholder="رئيس الجمعية">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">مهام الجمعية</label>
                                                                                <input type="text" class="form-control text-muted" name="tasks" value="{{$user->tasks}}" placeholder="مهام الجمعية">
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
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إالغاء</button>
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
