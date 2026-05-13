@extends('layouts.master')
@section('title', 'الرسائل')
@section('breadcrumb-title')
    <h3>الرسائل</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">الرئيسية</li>
    <li class="breadcrumb-item active">الرسائل</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_new">إضافة مشتركين بالجملة</button>
    <div class="modal fade" id="add_new" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة مشتركين بالجملة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('sms.bulkstore')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="import-subscriber" accept=".xlsx, .xls">
                        </div>
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">تسجيل البيانات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#send_msg">إرسال رسالة</button>
    <div class="modal fade" id="send_msg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إرسال رسالة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('sms.storeMsg')}}" id="smsForm" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="msg_content" class="text-muted">محتوى الرسالة</label>
                            <textarea name="content" class="form-control text-light" dir="rtl" id="msg_content" rows="5" placeholder="محتوى الرسالة" required></textarea>
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
    <a href="{{route('sms.createNew')}}" class="btn btn-success ms-2">اضافة مشترك</a>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/3d-fluent/100/user-2.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">عدد الاعضاء المشتركين:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted"> {{$members}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/3d-fluent/100/user-2.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">عدد الغير الاعضاء المشتركين:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted"> {{$nonMembers}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/color/80/money-transfer.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">المبلغ المحصل:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted"> {{$totalAmount}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-resposive">
                            <table class="table display align-middle text-center table-hover" id="table2" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-center">الرسالة</th>
                                        <th class="text-center">حالة الاشتراك</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sms as $item)
                                        <tr>
                                            <td class="text-center">{{$item->message}}</td>
                                            <td class="text-center">{{$item->sent_status}}</td>
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
