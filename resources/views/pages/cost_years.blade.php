@extends('layouts.master')
@section('title', 'التكلفة السنوية')
@section('breadcrumb-title')
    <h3>التكلفة السنوية</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">التكلفة السنوية</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة عام جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة عام جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('costyears.store')}} method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="text-muted">السنة</label>
                            <input type="number" class="form-control text-muted" name="year" placeholder="السنة">
                        </div>
                        <div class="form-group">
                            <label for="title" class="text-muted">المبلغ</label>
                            <input type="number" class="form-control text-muted" name="cost" placeholder="المبلغ">
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
@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center w-50 mx-auto rounded" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <section class="cost-years">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table" class="table display align-middle table-hover" data-order='[[ 0, "asc"]]' data-page-length="10">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">السنة</th>
                                            <th class="text-center">المبلغ</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i =1 ?>
                                        @foreach ($years as $year)
                                            <tr>
                                                <td class="text-center">{{$i++}}</td>
                                                <td class="text-center">{{$year->year}}</td>
                                                <td class="text-center">{{$year->cost}}</td>
                                                <td class="text-center">
                                                    {{-- ! Update ! --}}
                                                    <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#editing_{{$year->id}}">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                    <div class="modal fade" id="editing_{{$year->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">تعديل سنة {{$year->year}}</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action={{route('costyears.update')}} method="post">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <input type="hidden" name="id" value={{$year->id}} >
                                                                            <div class="col-lg-12">
                                                                                <div class="form-group mb-3">
                                                                                    <label for="year" class="text-muted">السنة</label>
                                                                                    <input type="number" name="year" value="{{$year->year}}" id="year" class="form-control text-muted">
                                                                                </div>
                                                                                <div class="form-group mb-3">
                                                                                    <label for="cost" class="text-muted">المبلغ</label>
                                                                                    <input type="number" name="cost" value="{{$year->cost}}" id="cost" class="form-control text-muted">
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
                                                    <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$year->id}}">
                                                        <i class="icofont icofont-trash"></i>
                                                    </button>
                                                    <div class="modal fade" id="deleting_{{$year->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">جار حذف السنة {{$year->year}}</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action={{route('costyears.remove', $year->id)}} method="get">
                                                                        @csrf
                                                                        <div class="form-title text-center">
                                                                            <h3 class="text-white my-2">هل أنت متأكد من الحذف</h3>
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
    </section>
@endsection
