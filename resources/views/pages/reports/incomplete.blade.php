@extends('layouts.master')
@section('title', 'تقارير النواقص')
@section('breadcrumb-title')
    <h3>تقارير النواقص</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير النواقص</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img text-center">
                            <img width="100" height="100" src="https://img.icons8.com/fluency/100/identity-theft.png" alt="identity-theft"/>
                        </div>
                        <div class="card-content text-center">
                            <h3 class="text-center text-decoration-underline mb-4">الرقم لقومي</h3>
                            <p class="mb-3 fw-bold">{{$incompleteSSNCount}}</p>
                            <button class="btn btn-primary fw-bold w-100 fs-5">المزيد</button>
                            <div class="fade modal"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img text-center">
                            <img width="100" height="100" src="https://img.icons8.com/fluency/100/google-pixel6.png" alt="google-pixel6"/>
                        </div>
                        <div class="card-content text-center">
                            <h3 class="text-center text-decoration-underline mb-4">رقم المحمول</h3>
                            <p class="mb-3 fw-bold">{{$incompleteMobileCount}}</p>
                            <button class="btn btn-primary fw-bold w-100 fs-5">المزيد</button>
                            <div class="fade modal"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-img text-center">
                            <img width="100" height="100" src="https://img.icons8.com/fluency/100/address-book-2.png" alt="address-book-2"/>
                        </div>
                        <div class="card-content text-center">
                            <h3 class="text-center text-decoration-underline mb-4">العنوان</h3>
                            <p class="mb-3 fw-bold">{{$incompleteAddressCount}}</p>
                            <button class="btn btn-primary fw-bold w-100 fs-5">المزيد</button>
                            <div class="fade modal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
