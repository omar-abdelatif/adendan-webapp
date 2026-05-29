@extends('layouts.master')
@section('title', 'الرسائل')
@section('breadcrumb-title')
    <h3>الرسائل</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">الرئيسية</li>
    <li class="breadcrumb-item">
        <a href="{{route('sms.index')}}">الرسائل</a>
    </li>
    <li class="breadcrumb-item active">مشترك جديد</li>
@endsection
@section('script')
    <script src="{{asset('assets/js/sms.js')}}"></script>
@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mx-auto w-50 text-center" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <div class="container-fluid">
        <div class="col-12">
            <div class="tabs mb-4">
                <div class="nav nav-pills horizontal-options shipping-options justify-content-center" id="cart-options-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="non-member-tab" data-bs-toggle="pill" href="#non-member" role="tab" aria-controls="non-member" aria-selected="true">
                        <div class="cart-options d-flex justify-content-center align-items-center h-100">
                            <div class="stroke-icon-wizard me-2">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="cart-options-content">
                                <h6 class="mb-0">تسجيل الغير اعضاء</h6>
                            </div>
                        </div>
                    </a>
                    <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="members-tab" data-bs-toggle="pill" href="#members" role="tab" aria-controls="members" aria-selected="true">
                        <div class="cart-options d-flex justify-content-center align-items-center h-100">
                            <div class="stroke-icon-wizard me-2">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="cart-options-content">
                                <h6 class="mb-0">تسجيل الاعضاء</h6>
                            </div>
                        </div>
                    </a>
                    <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="renew-tab" data-bs-toggle="pill" href="#renew" role="tab" aria-controls="renew" aria-selected="true">
                        <div class="cart-options d-flex justify-content-center align-items-center h-100">
                            <div class="stroke-icon-wizard me-2">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="cart-options-content">
                                <h6 class="mb-0">تجديد الاشتراك</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="tabs-content">
                <div class="tab-content dark-field shipping-content" id="cart-options-tabContent">
                    <div class="tab-pane fade active show" id="non-member" role="tabpanel" aria-labelledby="non-member-tab">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{route('sms.storeSubscriber')}}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="mobile_no" class="form-label text-muted">رقم المحمول</label>
                                                    <input type="number" name="mobile_no" id="mobile_no" class="form-control" required>
                                                </div>
                                                <div class="modal-footer mt-4">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                    <button type="submit" role="button" id="associateSubmit" class="btn btn-primary">تأكيد</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="members" role="tabpanel" aria-labelledby="members-tab">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table display align-middle text-center table-hover" id="table2" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-muted text-center">رقم العضوية</th>
                                                            <th class="text-muted text-center">الاسم</th>
                                                            <th class="text-muted text-center">رقم المحمول</th>
                                                            <th class="text-muted text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subscribers as $subscriber)
                                                            <tr>
                                                                <td class="text-center">{{$subscriber->member_id}}</td>
                                                                <td class="text-center">{{$subscriber->name}}</td>
                                                                <td class="text-center">{{$subscriber->mobile_no}}</td>
                                                                <td class="text-center">
                                                                    <a type="button" class="btn btn-success ms-2" data-bs-toggle="modal" title="اضافة عضو" href="#renew_{{$subscriber->member_id}}">
                                                                        <i class="fa-solid fa-plus"></i>
                                                                    </a>
                                                                    <div class="modal fade" id="renew_{{$subscriber->member_id}}" tabindex="-1" aria-labelledby="renewLabel{{$subscriber->member_id}}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5 text-muted" id="renew_{{$subscriber->member_id}}">اشتراك عضو</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{route('sms.storeSubscriber')}}" method="post">
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label for="amount_{{$subscriber->id}}" class="form-label text-muted">رقم العضوية</label>
                                                                                            <input type="number" id="amount_{{$subscriber->id}}" class="form-control" name="member_id" value="{{$subscriber->member_id}}" readonly>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="amount_{{$subscriber->id}}" class="form-label text-muted">رقم المحمول</label>
                                                                                            <input type="number" id="amount_{{$subscriber->id}}" class="form-control" name="mobile_no" value="{{$subscriber->mobile_no}}" readonly>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                            <button type="submit" role="button" id="associateSubmit" class="btn btn-primary">تأكيد</button>
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
                    <div class="tab-pane fade show" id="renew" role="tabpanel" aria-labelledby="renew-tab">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table display align-middle text-center table-hover" id="table3" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-muted text-center">رقم العضوية</th>
                                                            <th class="text-muted text-center">رقم المحمول</th>
                                                            <th class="text-muted text-center">حالة الاشتراك</th>
                                                            <th class="text-muted text-center">نهاية الاشتراك</th>
                                                            <th class="text-muted text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subscribed as $subscriber)
                                                            <tr>
                                                                <td class="text-center">{{$subscriber->member_id}}</td>
                                                                <td class="text-center">{{$subscriber->mobile_no}}</td>
                                                                <td class="text-center">
                                                                    @if ($subscriber->active_sms === 1)
                                                                        <span class="badge badge-light-success">نشط</span>
                                                                    @else
                                                                        <span class="badge badge-light-danger">غير نشط</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">{{$subscriber->subscription_expiry_date}}</td>
                                                                <td class="text-center">
                                                                    @if ($subscriber->active_sms === 0)
                                                                        <button type="button" class="btn btn-success ms-2 renew" data-renew-url="{{ route('sms.renew', ['id' => $subscriber->id]) }}" data-member-id="{{$subscriber->member_id}}" data-subscriber-id="{{$subscriber->id}}" title="تجديد الاشتراك">
                                                                            <i class="fa-solid fa-arrow-rotate-right"></i>
                                                                        </button>
                                                                    @else
                                                                        <span class="text-center font-bold">-</span>
                                                                    @endif
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
