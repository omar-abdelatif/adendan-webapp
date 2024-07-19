@php
    $user = Auth::user();
@endphp
@extends('layouts.master')
@section('title', 'كل الحرفيين')
@section('breadcrumb-title')
    <h3>كل الحرفيين</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل الحرفيين</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة شخص جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة شخص جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{$user->role === 'admin' ? route('worker.store') : route('mediaRole.worker.store')}} method="post" id="workers">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title" class="text-white">إسم الشخص</label>
                                    <input type="text" id="worker_name" class="form-control text-muted" minlength="3" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" pattern="[\u0600-\u06FF\s]{3,}" name="name" placeholder="إسم الشخص" required>
                                    <p class="required d-none text-danger mb-0" id="nameReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="nameMsg">يجب ان يكون الاسم باللغة العربية و لا يقل عن 3 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-white">رقم الموبايل</label>
                                    <input type="text" id="worker_mob" class="form-control text-muted" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="phone_number" placeholder="رقم الموبايل" required>
                                    <p class="required d-none text-danger mb-0" id="mobReq">هذا الحقل  مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="mobCount">يجب ان يكون رقم الموبايل لا يقل عن 11 رقم</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-white">الحرفة</label>
                                    <select name="craft" class="form-select text-white" id="craftSelect" required>
                                        <option selected>الحرفة</option>
                                        <option value="نجار" class="option-control">نجار</option>
                                        <option value="نقاش" class="option-control">نقاش</option>
                                        <option value="سباك" class="option-control">سباك</option>
                                        <option value="كهربائي" class="option-control">كهربائي</option>
                                        <option value="أخرى" class="option-control">أخرى</option>
                                    </select>
                                    <p class="required d-none mb-0 text-danger" id="craftReq">يجب اختيار حرفة من القائمة</p>
                                    <input type="text" id="otherCategory" name="other_craft" class="form-control mt-3 text-white" placeholder="إسم الحرفة الأخرى أن وجد" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" pattern="[\u0600-\u06FF\s]{3,}" disabled>
                                    <p class="d-none mb-0 text-danger" id="otherReq">هذا الحقل مطلوب</p>
                                    <p class="d-none mb-0 text-danger" id="otherMsg">يجب ان يكون اسم الحرفة باللغة العربية و لا يقل عن 3 احرف</p>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="text-white">المنطقة</label>
                                    <input type="text" id="worker_location" name="location" minlength="5" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" pattern="[\u0600-\u06FF\s]{3,}" placeholder="منطقة السكن" class="form-control text-white" required>
                                    <p class="required d-none text-danger mb-0" id="locReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="locMsg">يجب ان يكون العنوان باللغة العربية</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" role="button" id="workerSubmit" class="btn btn-primary">تأكيد</button>
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
                            <table id="table" class="table display align-middle text-center table-hover" data-page-length="10" data-order='[[ 0, "asc" ]]'>
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">إسم الحرفي</th>
                                        <th class="text-center">رقم المحمول</th>
                                        <th class="text-center">إسم الحرفة</th>
                                        <th class="text-center">إسم الحرفة الأخرى</th>
                                        <th class="text-center">المنطقة</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ?>
                                    @foreach ($workers as $worker)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$worker->name}}</td>
                                            <td>{{$worker->phone_number}}</td>
                                            <td>{{$worker->craft}}</td>
                                            <td>
                                                @if ($worker->other_craft)
                                                    {{$worker->other_craft}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{$worker->location}}</td>
                                            <td>
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editingborder_{{$worker->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editingborder_{{$worker->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تحديث الحرفي {{$worker->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{$user->role === 'admin' ? route('worker.update') : route('mediaRole.worker.update')}} method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{$worker->id}}>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-white">إسم الحرفي</label>
                                                                                <input type="text" class="form-control text-center text-white" name="name" value="{{$worker->name}}">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-white">رقم المحمول</label>
                                                                                <input type="number" class="form-control text-center text-white" name="phone_number" value="{{$worker->phone_number}}">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-white">الحرفة</label>
                                                                                <select name="craft" class="form-select text-white" id="updateCraft" data-worker-id="{{$worker->id}}">
                                                                                    <option selected>إختر الحرفة</option>
                                                                                    <option value="نجار" {{$worker->craft === 'نجار' ? 'selected' : ''}} class="option-control">نجار</option>
                                                                                    <option value="نقاش" {{$worker->craft === 'نقاش' ? 'selected' : ''}} class="option-control">نقاش</option>
                                                                                    <option value="سباك" {{$worker->craft === 'سباك' ? 'selected' : ''}} class="option-control">سباك</option>
                                                                                    <option value="كهربائي" {{$worker->craft === 'كهربائي' ? 'selected' : ''}} class="option-control">كهربائي</option>
                                                                                    <option value="أخرى" {{$worker->craft === 'أخرى' ? 'selected' : ''}} class="option-control">أخرى</option>
                                                                                </select>
                                                                                @if ($worker->craft === 'أخرى')
                                                                                    <input type="text" name="other_craft" id="updaing_craft" class="form-control mt-3 text-white" placeholder="المهنة الأخرى" data-worker-id="{{$worker->id}}" value="{{$worker->other_craft}}">
                                                                                @else
                                                                                    <input type="text" name="other_craft" id="updaing_craft" class="form-control mt-3 text-white" placeholder="المهنة الأخرى" data-worker-id="{{$worker->id}}" disabled>
                                                                                @endif
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label class="text-white">المنطقة</label>
                                                                                <input type="text" name="location" placeholder="منطقة السكن" value="{{$worker->location}}" class="form-control text-white">
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
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleting_{{$worker->id}}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$worker->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف الحرفي {{$worker->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{$user->role === 'admin' ? route('worker.delete', $worker->id) : route('mediaRole.worker.delete', $worker->id)}} method="get">
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
