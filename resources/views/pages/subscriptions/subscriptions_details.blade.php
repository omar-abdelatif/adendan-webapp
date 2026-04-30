@php
    $user = Auth::user();
@endphp
@extends('layouts.master')
@section('title', $subscriber->name)
@section('breadcrumb-title')
    <h3>كل الإشتراكات</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">
        <a href="{{route('subscriber.all')}}">كل المشتركين</a>
    </li>
    <li class="breadcrumb-item active">كل الإشتراكات</li>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="row align-items-center">
                    <div class="col-xl-8 box-col-8">
                        <div class="card widget-1">
                            <div class="card-body align-items-center">
                                <div class="widget-content">
                                    <div class="bg-round">
                                        <img width="100" height="100" src="https://img.icons8.com/3d-fluent/100/user-2.png" alt="user-2"/>
                                    </div>
                                    <div>
                                        <h5 class="text-muted fs-4">إسم العضو: {{$subscriber->name}}</h5>
                                    </div>
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
                                        <h5 class="text-muted fs-4">رقم العضوية: {{$subscriber->member_id}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 box-col-6">
                        <div class="card widget-1">
                            <div class="card-body align-items-center">
                                <div class="widget-content">
                                    <div class="bg-round">
                                        <img width="100" height="100" src="https://img.icons8.com/color/80/money-transfer.png" alt="user-2"/>
                                    </div>
                                    <div>
                                        <h5 class="text-muted fs-4">أجمالي مستحقات الإشتراك: </h5>
                                    </div>
                                </div>
                                <div class="font-Info">
                                    <h5 class="mb-1 text-muted">{{number_format($totalSubscriptionAmount)}} ج.م</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 box-col-6">
                        <div class="card widget-1">
                            <div class="card-body align-items-center">
                                <div class="widget-content">
                                    <div class="bg-round">
                                        <img width="100" height="100" src="https://img.icons8.com/color/80/money-transfer.png" alt="user-2"/>
                                    </div>
                                    <div>
                                        <h5 class="text-muted fs-4">قيمة مستحقات التبرعات: </h5>
                                    </div>
                                </div>
                                <div class="font-Info">
                                    <h5 class="mb-1 text-muted">{{number_format($totalDonationAmount)}} ج.م</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabs mb-4">
                    <div class="nav nav-pills horizontal-options shipping-options justify-content-center" id="cart-options-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="payment-history-tab" data-bs-toggle="pill" href="#payment-history" role="tab" aria-controls="payment-history" aria-selected="true">
                            <div class="cart-options d-flex justify-content-center align-items-center h-100">
                                <div class="stroke-icon-wizard me-2">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="cart-options-content">
                                    <h6 class="mb-0">مدفوعات سابقة</h6>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary mx-2" id="subscriptions-tab" data-bs-toggle="pill" href="#subscriptions" role="tab" aria-controls="subscriptions" aria-selected="false" tabindex="-1">
                            <div class="cart-options d-flex justify-content-center align-items-center h-100">
                                <div class="stroke-icon-wizard me-2">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="cart-options-content">
                                    <h6 class="mb-0">قيمة مستحقات الاشتراك</h6>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary mx-2" id="donations-tab" data-bs-toggle="pill" href="#donations" role="tab" aria-controls="donations" aria-selected="false" tabindex="-1">
                            <div class="cart-options d-flex justify-content-center align-items-center h-100">
                                <div class="stroke-icon-wizard me-2">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="cart-options-content">
                                    <h6 class="mb-0">قيمة مستحقات التبرعات</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="tabs-content">
                    <div class="tab-content dark-field shipping-content" id="cart-options-tabContent">
                        <div class="tab-pane fade active show" id="payment-history" role="tabpanel" aria-labelledby="payment-history-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                                        <thead>
                                                            <tr>
                                                                <th class="text-muted text-center">نوع المعاملة</th>
                                                                <th class="text-muted text-center">البند</th>
                                                                <th class="text-muted text-center">المبلغ المدفوع</th>
                                                                <th class="text-muted text-center">نوع الدفع</th>
                                                                <th class="text-muted text-center">تاريخ الدفع</th>
                                                                <th class="text-muted text-center">رقم الإيصال</th>
                                                                <th class="text-muted text-center">طريقة الدفع</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($subscriptions as $item)
                                                                <tr>
                                                                    <td class="text-muted text-center">{{$item->transaction_type}}</td>
                                                                    <td class="text-muted text-center">{{$item->item}}</td>
                                                                    <td class="text-muted text-center">
                                                                        @if ($item->amount)
                                                                            <span>{{$item->amount}}</span>
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-muted text-center">{{$item->payment_cat}}</td>
                                                                    <td class="text-muted text-center">{{$item->payment_date}}</td>
                                                                    <td class="text-muted text-center">{{$item->inv_no}}</td>
                                                                    <td class="text-muted text-center">{{$item->payment_method}}</td>
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
                        <div class="tab-pane fade show" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="table2" class="table display align-middle table-hover text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">البند</th>
                                                            <th class="text-center">المبلغ المطلوب</th>
                                                            <th class="text-center">المبلغ المدفوع</th>
                                                            <th class="text-center">المبلغ المتبقي</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subDue as $delay)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="text-center">{{$delay->item}}</td>
                                                                <td class="text-center">{{$delay->total_amount}}</td>
                                                                <td class="text-center">{{$delay->amount_paid}}</td>
                                                                <td class="text-center">{{$delay->amount_remaining}}</td>
                                                                <td class="text-center">
                                                                    <button class="btn btn-secondary" data-bs-toggle="modal" title="دفع الاشتراكات" data-bs-target="#payment_history_{{$delay->id}}">
                                                                        <i class="fa-solid fa-money-bill"></i>
                                                                    </button>
                                                                    <div class="modal fade" id="payment_history_{{$delay->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تسديد مديونية الإشتراك</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{route('subscription.pay')}}" method="post" id="delayForm" data-payDelay-id="{{$delay->id}}">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <input type="hidden" name="id" value="{{$delay->id}}"/>
                                                                                            <div class="col-12">
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="member_id" class="text-muted">رقم العضوية</label>
                                                                                                    <input type="number" class="text-muted form-control" id="member_id" name="member_id" value="{{$delay->member_id}}" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="item" class="text-muted">البند</label>
                                                                                                    <input type="text" class="form-control text-muted" id="item" name="item" value="{{$delay->item}}" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="invoice" class="text-muted">رقم الإيصال</label>
                                                                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="text-muted form-control" name="inv_no" id="invoice" maxlength="5" data-invoice-id="{{$delay->id}}" placeholder="رقم الإيصال" required>
                                                                                                    <p class="required d-none text-danger mb-0 invReq" id="invReq" data-invoice-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                    <p class="required d-none text-danger mb-0 invMsg" id="invMsg" data-invoice-id="{{$delay->id}}">يجب ان يكون رقم الإيصال مكون من 5 ارقام</p>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="paied" class="text-muted">المبلغ المدفوع</label>
                                                                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="text-muted form-control" name="amount_paid" minlength="2" maxlength="5" id="paied" data-delay-id="{{$delay->id}}" placeholder="المبلغ المدفوع" required>
                                                                                                    <p class="required d-none text-danger mb-0 payReq" data-delay-id="{{$delay->id}}" id="payReq">هذا الحقل مطلوب</p>
                                                                                                    <p class="required d-none text-danger mb-0 payMsg" data-delay-id="{{$delay->id}}" id="payMsg">يجب ان لا يقل المبلغ عن 2 رقم ولا يكون اكثر من 5 رقم</p>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="payment_date" class="text-muted">تاريخ الدفع</label>
                                                                                                    <input type="date" class="form-control text-muted" name="payment_date" id="payment_date">
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="payment_date" class="text-muted">طريقة الدفع</label>
                                                                                                    <select class="form-select text-muted" name="payment_method" id="payment_method">
                                                                                                        <option selected disabled>اختر طريقة الدفع</option>
                                                                                                        <option value="كاش">كاش</option>
                                                                                                        <option value="فيزا">فيزا</option>
                                                                                                        <option value="محفظة">محفظة</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                            <button type="submit" id="delaySubmit" role="button" data-DelaysForm-id = "{{$delay->id}}" class="btn btn-primary">تأكيد</button>
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
                        <div class="tab-pane fade show" id="donations" role="tabpanel" aria-labelledby="donations-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="table3" class="table display align-middle table-hover text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">البند</th>
                                                            <th class="text-center">المبلغ المطلوب</th>
                                                            <th class="text-center">المبلغ المدفوع</th>
                                                            <th class="text-center">المبلغ المتبقي</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($donDue as $donation)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="text-center">{{$donation->item}}</td>
                                                                <td class="text-center">{{$donation->total_amount}}</td>
                                                                <td class="text-center">{{$donation->amount_paid}}</td>
                                                                <td class="text-center">{{$donation->amount_remaining}}</td>
                                                                <td class="text-center">
                                                                    <button class="btn btn-secondary" data-bs-toggle="modal" title="دفع التبرعات" data-bs-target="#payment_history_{{$donation->id}}">
                                                                        <i class="fa-solid fa-money-bill"></i>
                                                                    </button>
                                                                    <div class="modal fade" id="payment_history_{{$donation->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تسديد مديونية التبرعات</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{route('subscription.pay')}}" method="post">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <input type="hidden" name="id" value="{{$donation->id}}"/>
                                                                                            <div class="col-12">
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="member_id" class="text-muted">رقم العضوية</label>
                                                                                                    <input type="number" class="text-muted form-control" id="member_id" name="member_id" value="{{$donation->member_id}}" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="item" class="text-muted">البند</label>
                                                                                                    <input type="text" class="form-control text-muted" id="item" name="item" value="{{$donation->item}}" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="invoice" class="text-muted">رقم الإيصال</label>
                                                                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="text-muted form-control" name="inv_no" id="invoice" maxlength="5" data-invoice-id="{{$donation->id}}" placeholder="رقم الإيصال" required>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="amount_paid" class="text-muted">المبلغ المدفوع</label>
                                                                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="text-muted form-control" name="amount_paid" minlength="2" maxlength="5" id="amount_paid" data-delay-id="{{$donation->id}}" placeholder="المبلغ المدفوع" required>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="payment_date" class="text-muted">تاريخ الدفع</label>
                                                                                                    <input type="date" class="form-control text-muted" name="payment_date" id="payment_date">
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="payment_date" class="text-muted">طريقة الدفع</label>
                                                                                                    <select class="form-select text-muted" name="payment_method" id="payment_method">
                                                                                                        <option selected disabled>اختر طريقة الدفع</option>
                                                                                                        <option value="كاش">كاش</option>
                                                                                                        <option value="فيزا">فيزا</option>
                                                                                                        <option value="محفظة">محفظة</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                            <button type="submit" id="delaySubmit" role="button" data-DelaysForm-id = "{{$donation->id}}" class="btn btn-primary">تأكيد</button>
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
