@extends('layouts.master')
@section('title', 'كل المقابر')
@section('breadcrumb-title')
    <h3>كل المقابر</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل المقابر</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة مقبره جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة مقبره جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('tomb.store')}} method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title" class="text-white">إسم المقبره</label>
                                    <input type="text" class="form-control text-white" name="title" placeholder="إسم المقبره">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title" class="text-white">المنطقة</label>
                                    <select name="region" class="form-select text-white">
                                        <option selected>إختر المنطقة</option>
                                        <option value="أكتوبر" class="option-control">أكتوبر</option>
                                        <option value="الفيوم" class="option-control">الفيوم</option>
                                        <option value="15مايو" class="option-control">15مايو</option>
                                        <option value="القطامية" class="option-control">القطامية</option>
                                        <option value="الغفير" class="option-control">الغفير</option>
                                        <option value="زينهم" class="option-control">زينهم</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tomb_guard_name" class="text-white">إسم التربي</label>
                                    <input type="text" id="tomb_guard_name" class="form-control text-white" name="tomb_guard_name" placeholder="إسم التربي">
                                </div>
                                <div class="form-group">
                                    <label for="tomb_guard_number" class="text-white">رقم المحمول</label>
                                    <input type="number" id="tomb_guard_number" class="form-control text-white" name="tomb_guard_number" placeholder="رقم المحمول">
                                </div>
                                <div class="form-group mt-3">
                                    <label class="text-white">الموقع</label>
                                    <input type="text" name="location" placeholder="موقع المقبره" class="form-control text-white">
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
                            <?php $i = 1 ?>
                            <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <td class="text-center text-white">#</td>
                                        <td class="text-center text-white">إسم المقبره</td>
                                        <td class="text-center text-white">المنطقة</td>
                                        <td class="text-center text-white">إسم التربي</td>
                                        <td class="text-center text-white">رقم المحمول</td>
                                        <td class="text-center text-white">الموقع</td>
                                        <td class="text-center text-white">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tombs as $tomb)
                                        <tr>
                                            <td class="text-white">{{$i++}}</td>
                                            <td class="text-white">{{$tomb->title}}</td>
                                            <td class="text-white">{{$tomb->region}}</td>
                                            <td class="text-white">{{$tomb->tomb_guard_name}}</td>
                                            <td class="text-white">{{$tomb->tomb_guard_number}}</td>
                                            <td class="text-white">{{$tomb->location}}</td>
                                            <td>
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editingborder_{{$tomb->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editingborder_{{$tomb->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تحديث المقبره {{$tomb->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('tomb.update')}} method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{$tomb->id}}>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">إسم المقبره</label>
                                                                                <input type="text" class="form-control text-white" value="{{$tomb->title}}" name="title" placeholder="إسم المقبره">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-white">المنطقة</label>
                                                                                <select name="region" class="form-select text-white">
                                                                                    <option selected>إختر المنطقة</option>
                                                                                    <option value="أكتوبر" class="option-control" {{$tomb->region === 'أكتوبر' ? 'selected' : ''}}>أكتوبر</option>
                                                                                    <option value="الفيوم" class="option-control" {{$tomb->region === 'الفيوم' ? 'selected' : ''}}>الفيوم</option>
                                                                                    <option value="15مايو" class="option-control" {{$tomb->region === '15مايو' ? 'selected' : ''}}>15مايو</option>
                                                                                    <option value="القطامية" class="option-control" {{$tomb->region === 'القطامية' ? 'selected' : ''}}>القطامية</option>
                                                                                    <option value="الغفير" class="option-control" {{$tomb->region === 'الغفير' ? 'selected' : ''}}>الغفير</option>
                                                                                    <option value="زينهم" class="option-control" {{$tomb->region === 'زينهم' ? 'selected' : ''}}>زينهم</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="tomb_guard_name" class="text-white">إسم التربي</label>
                                                                                <input type="text" id="tomb_guard_name" class="form-control text-white" value="{{$tomb->tomb_guard_name}}" name="tomb_guard_name" placeholder="إسم التربي">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="tomb_guard_number" class="text-white">رقم المحمول</label>
                                                                                <input type="number" id="tomb_guard_number" class="form-control text-white" value="{{$tomb->tomb_guard_number}}" name="tomb_guard_number" placeholder="رقم المحمول">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label class="text-white">الموقع</label>
                                                                                <input type="text" name="location" value="{{$tomb->location}}" placeholder="موقع المقبره" class="form-control text-white">
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
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleting_{{$tomb->id}}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$tomb->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف المقبره {{$tomb->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('tomb.delete', $tomb->id)}} method="get">
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
