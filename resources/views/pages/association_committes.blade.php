@extends('layouts.master')
@section('title', 'لجان الجميعة')
@section('breadcrumb-title')
    <h3>كل اللجان</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">اللجان</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة لجنة جديدة</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة لجنة جديدة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('association.store')}} method="post" id="associateForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title" class="text-muted">إسم اللجنة</label>
                                    <input type="text" class="form-control text-muted" name="name"  placeholder="إسم اللجنة" id="associateName" required>
                                    <p class="required d-none text-danger mb-0" id="associateNameReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="associateNameMsg">يجب ان يكون اسم اللجنة باللغة العربية ولا يقل عن 10 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-muted">عن اللجنة</label>
                                    <textarea name="description" class="form-control text-muted" placeholder="عن اللجنة" cols="30" rows="3"></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-muted">رئيس اللجنة</label>
                                    <input type="text" class="form-control text-muted" name="boss" placeholder="رئيس الجمعية" id="associateBoss" required>
                                    <p class="required d-none text-danger mb-0" id="bossReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="bossMsg">يجب ان يكتب الاسم باللغة العربية ولا يقل عن 3 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-muted">مهام الجمعية</label>
                                    <input type="text" class="form-control text-muted" name="tasks" placeholder="مهام الجمعية">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" role="button" id="associateSubmit" class="btn btn-primary">تأكيد</button>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display table-hover text-center align-middle" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">#</th>
                                        <th class="text-center">إسم اللجنة</th>
                                        <th class="text-center">رئيس اللجنة</th>
                                        <th class="text-center">مهام اللجنة</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $i = 1; ?>
                                    @foreach ($associations as $asso)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$asso->name}}</td>
                                            <td>{{$asso->boss}}</td>
                                            <td>{{$asso->tasks}}</td>
                                            <td>
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#editing_{{$asso->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editing_{{$asso->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <input type="hidden" name="id" value={{$asso->id}} >
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-muted">إسم اللجنة</label>
                                                                                <input type="text" class="form-control text-muted" name="name" value="{{$asso->name}}" placeholder="إسم اللجنة">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">عن اللجنة</label>
                                                                                <textarea name="description" class="form-control text-muted" placeholder="عن اللجنة" cols="30" rows="3">{{$asso->description}}</textarea>
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">رئيس اللجنة</label>
                                                                                <input type="text" class="form-control text-muted" name="boss" value="{{$asso->boss}}" placeholder="رئيس الجمعية">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">مهام الجمعية</label>
                                                                                <input type="text" class="form-control text-muted" name="tasks" value="{{$asso->tasks}}" placeholder="مهام الجمعية">
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
                                                <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$asso->id}}">
                                                    <i class="icofont icofont-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$asso->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">جار حذف اللجنة {{$asso->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('association.delete', $asso->id)}} method="get">
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
