@extends('layouts.master')
@section('title', 'الملف الشخصي')
@section('breadcrumb-title')
    <h3>تعديل الملف الشخصي</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">الملف الشخصي</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 text-center">ملفي الشخصي</h4>
                        <div class="card-options">
                            <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse">
                                <i class="fe fe-chevron-up"></i>
                            </a>
                            <a class="card-options-remove" href="#" data-bs-toggle="card-remove">
                                <i class="fe fe-x"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <input type="hidden" name="id" value={{Auth::user()->id}}>
                            <div class="row mb-2">
                                <div class="profile-title">
                                    <div class="media flex-column align-items-center">
                                        <img class="img-70 rounded-circle" alt="{{Auth::user()->avatar}}" src="{{Auth::user()->avatar ? asset('assets/images/users/'.Auth::user()->name.'/'.Auth::user()->avatar) : 'https://www.pulsecarshalton.co.uk/wp-content/uploads/2016/08/jk-placeholder-image.jpg'}}">
                                        <div class="media-body text-center mt-2">
                                            <h5 class="mb-1">{{Auth::user()->name}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني:</label>
                                <input class="form-control text-secondary" type="email" name="email" value={{Auth::user()->email}} readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">كلمة السر:</label>
                                <input class="form-control" type="password" placeholder="New Password">
                            </div>
                            <div class="form-footer">
                                <button class="btn btn-primary btn-block" type="submit">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">تعديل الملف الشخصي</h4>
                        <div class="card-options">
                            <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse">
                                <i class="fe fe-chevron-up"></i>
                            </a>
                            <a class="card-options-remove" href="#" data-bs-toggle="card-remove">
                                <i class="fe fe-x"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value={{Auth::user()->id}}>
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">الإسم بالكامل:</label>
                                        <input class="form-control text-secondary" type="text" name="name" placeholder="Full Name" value="{{Auth::user()->name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">البريد الإلكتروني:</label>
                                        <input type="email" class="form-control text-secondary" name="email" value={{Auth::user()->email}}>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">الصورة:</label>
                                        <input type="file" name="avatar"  class="form-control" value="{{Auth::user()->avatar}}">
                                    </div>
                                </div>
                                <div class="card-footer text-end pb-0 ">
                                    <button class="btn btn-primary" type="submit">حفظ التعديل</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
