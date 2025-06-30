@php
    $user = Auth::user();
@endphp
@extends('layouts.master')
@section('title', 'الصور المصغرة')
@section('breadcrumb-title')
    <h3>كل الصور المصغرة</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a class="text-decoration-underline" href="{{route('news.all')}}">كل الاأخبار</a>
    </li>
    <li class="breadcrumb-item active">كل الصور المصغرة</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_news">إضافة فيديو جديد</button>
    <div class="modal fade" id="add_news" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة فيديو جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('video.store', $news->id)}} method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mt-3" id="inputs">
                                    <label for="" class="text-white mb-3">رابط الفيديو (إذا وجد ) </label>
                                    <a href="javascript:void(0)" class="btn btn-success px-2 py-1 addRow ms-2">+</a>
                                    <input type="text" name="url[]" class="form-control text-center text-white mb-4" placeholder="رابط الفيديو">
                                </div>
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
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="nav nav-pills horizontal-options shipping-options justify-content-center" id="cart-options-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active w-25 text-center rounded-pill py-3 btn btn-outline-primary me-2" id="bill-wizard-tab" data-bs-toggle="pill" href="#bill-wizard" role="tab" aria-controls="bill-wizard" aria-selected="true">
                        <div class="cart-options d-flex justify-content-center align-items-center h-100">
                            <div class="stroke-icon-wizard me-2">
                                <i class="fa-duotone fa-image fs-3"></i>
                            </div>
                            <div class="cart-options-content">
                                <h6 class="mb-0">الصورة المصغرة</h6>
                            </div>
                        </div>
                    </a>
                    <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="ship-wizard-tab" data-bs-toggle="pill" href="#ship-wizard" role="tab" aria-controls="ship-wizard" aria-selected="false" tabindex="-1">
                        <div class="cart-options d-flex justify-content-center align-items-center h-100">
                            <div class="stroke-icon-wizard me-2">
                                <i class="fa-duotone fa-film fs-3"></i>
                            </div>
                            <div class="cart-options-content">
                                <h6 class="mb-0">الفيديوهات</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="tab-content dark-field shipping-content" id="cart-options-tabContent">
                    <div class="tab-pane fade active show" id="bill-wizard" role="tabpanel" aria-labelledby="bill-wizard-tab">
                        <div class="container">
                            <div class="row justify-content-center align-items-center">
                                @if ($count > 0)
                                    @foreach ($thumbnails as $thumb)
                                        <div class="col-lg-3 col-md-6">
                                            <div class="mb-3 mt-5 text-center">
                                                <button type="button" class="btn btn-transparent border border-3 border-primary rounded text-dark" data-bs-toggle="modal" data-bs-target="#show_{{$thumb->id}}">
                                                    <img src="{{asset('assets/images/news-imgs/news-thumbnails/'.$thumb->thumbnail)}}" class="w-100" alt="{{$thumb->thumbnail}}">
                                                </button>
                                                <div class="modal fade" id="show_{{$thumb->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف صورة الخبر {{$news->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('thumbs.delete', $thumb->id)}} method="get">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <h1 class="text-center">متأكد من الحذف ؟</h1>
                                                                            </div>
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
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-lg-12">
                                        <div class="h-100 mt-5">
                                            <h1 class="mb-0 text-center">لا توجد صور مصغره لهذا الخبر</h1>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade shipping-wizard" id="ship-wizard" role="tabpanel" aria-labelledby="ship-wizard-tab">
                        <div class="card mt-5">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table id="table" class="table align-middle text-center table-hover display" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center text-white">#</th>
                                                            <th class="text-center text-white">رابط الفيديو</th>
                                                            <th class="text-center text-white">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1 ?>
                                                        @foreach ($videos as $vid)
                                                            <tr>
                                                                <td class="text-center text-white">{{$i++}}</td>
                                                                <td class="text-center text-white">
                                                                    <a href="{{$vid->url}}" target="blank">{{$vid->url}}</a>
                                                                </td>
                                                                <td class="text-center text-white">
                                                                    {{-- ! Update Video ! --}}
                                                                    <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#editing_{{$vid->id}}">
                                                                        <i class="fa-solid fa-pen"></i>
                                                                    </button>
                                                                    <div class="modal fade" id="editing_{{$vid->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تعديل خبر بعنوان {{$news->title}}</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action={{route('video.update')}} method="post">
                                                                                        @csrf
                                                                                        <input type="hidden" name="id" value={{$vid->id}}>
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="title" class="text-white">رابط الفيديو</label>
                                                                                                    <input type="text" class="form-control text-white" name="url" value="{{$vid->url}}" placeholder="عنوان الخبر">
                                                                                                </div>
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
                                                                    {{-- ! Delete Video ! --}}
                                                                    <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$vid->id}}">
                                                                        <i class="icofont icofont-trash"></i>
                                                                    </button>
                                                                    <div class="modal fade" id="deleting_{{$vid->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <form action={{route('video.delete', $vid->id)}} method="get">
                                                                                        @csrf
                                                                                        <div class="form-title text-center">
                                                                                            <h3 class="text-white my-2">هل أنت متأكد من الحذف</h3>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
