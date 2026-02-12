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
                <div class="subs-title mb-5">
                    <h2 class="text-center text-decoration-underline">كل الإشتراكات و المديونيات السابقة للعضو {{$subscriber->name}}</h2>
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
                        <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary mx-2" id="debts-tab" data-bs-toggle="pill" href="#debts" role="tab" aria-controls="debts" aria-selected="false" tabindex="-1">
                            <div class="cart-options d-flex justify-content-center align-items-center h-100">
                                <div class="stroke-icon-wizard me-2">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="cart-options-content">
                                    <h6 class="mb-0">قيمة الإشتراك الحالي</h6>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="old-delays-tab" data-bs-toggle="pill" href="#old-delays" role="tab" aria-controls="old-delays" aria-selected="true">
                            <div class="cart-options d-flex justify-content-center align-items-center h-100">
                                <div class="stroke-icon-wizard me-2">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="cart-options-content">
                                    <h6 class="mb-0">متأخرات الإشتراك</h6>
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
                                                                <th class="text-muted text-center">قيمة الإشتراك المدفوع</th>
                                                                <th class="text-muted text-center">فترة الإشتراك</th>
                                                                <th class="text-muted text-center">نوع الدفع</th>
                                                                <th class="text-muted text-center">تاريخ الدفع</th>
                                                                <th class="text-muted text-center">رقم الإيصال</th>
                                                                <th class="text-muted text-center">قيمة المتأخرات المدفوعة</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1 ?>
                                                            @foreach ($subscriptions as $item)
                                                                <tr>
                                                                    <td class="text-muted text-center">
                                                                        @if ($item->subscription_cost)
                                                                            <span>{{$item->subscription_cost}}</span>
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-muted text-center">
                                                                        @if ($item->period)
                                                                            <span>{{$item->period}}</span>
                                                                        @else
                                                                        <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-muted text-center">{{$item->payment_type}}</td>
                                                                    <td class="text-muted text-center">{{$item->payment_date}}</td>
                                                                    <td class="text-muted text-center">{{$item->invoice_no}}</td>
                                                                    <td class="text-muted text-center">
                                                                        @if ($item->delays)
                                                                            <span>{{$item->delays}}</span>
                                                                        @else
                                                                            <span class="fw-bold">-</span>
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
                        <div class="tab-pane fade show" id="debts" role="tabpanel" aria-labelledby="debts-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="table2" class="table display align-middle table-hover text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">رقم العضوية</th>
                                                            <th class="text-center">فترة الإشتراك</th>
                                                            <th class="text-center">الإشتراك السنوي</th>
                                                            <th class="text-center">المبلغ المدفوع</th>
                                                            <th class="text-center">المبلغ المتبقي</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($delays as $delay)
                                                            <tr>
                                                                <td class="text-center">{{$delay->member_id}}</td>
                                                                <td class="text-center">{{$delay->year}}</td>
                                                                <td class="text-center">{{$delay->yearly_cost}}</td>
                                                                <td class="text-center">{{$delay->paied}}</td>
                                                                <td class="text-center">{{$delay->remaing}}</td>
                                                                <td class="text-center">
                                                                    <button class="btn btn-secondary" data-bs-toggle="modal" title="دفع المديونية" data-bs-target="#payment_history_{{$delay->id}}">
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
                                                                                                    <label for="year_cost" class="text-muted">سنة الدفع</label>
                                                                                                    <input type="number" class="form-control text-muted" id="year_cost" name="year" value="{{$delay->year}}" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="invoice" class="text-muted">رقم الإيصال</label>
                                                                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="text-muted form-control" name="invoice_no" id="invoice" maxlength="5" data-invoice-id="{{$delay->id}}" placeholder="رقم الإيصال" required>
                                                                                                    <p class="required d-none text-danger mb-0 invReq" id="invReq" data-invoice-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                    <p class="required d-none text-danger mb-0 invMsg" id="invMsg" data-invoice-id="{{$delay->id}}">يجب ان يكون رقم الإيصال مكون من 5 ارقام</p>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="paied" class="text-muted">المبلغ المدفوع</label>
                                                                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="text-muted form-control" name="paied" minlength="2" maxlength="5" id="paied" data-delay-id="{{$delay->id}}" placeholder="المبلغ المدفوع" required>
                                                                                                    <p class="required d-none text-danger mb-0 payReq" data-delay-id="{{$delay->id}}" id="payReq">هذا الحقل مطلوب</p>
                                                                                                    <p class="required d-none text-danger mb-0 payMsg" data-delay-id="{{$delay->id}}" id="payMsg">يجب ان لا يقل المبلغ عن 2 رقم ولا يكون اكثر من 5 رقم</p>
                                                                                                </div>
                                                                                                <div class="form-group mb-3">
                                                                                                    <label for="payment_date" class="text-muted">تاريخ الدفع</label>
                                                                                                    <input type="date" class="form-control text-muted" name="payment_date" id="payment_date">
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
                        <div class="tab-pane fade show" id="old-delays" role="tabpanel" aria-labelledby="old-delays-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="table3" class="table display align-middle table-hover text-center text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">رقم العضوية</th>
                                                            <th class="text-muted text-center">المبلغ الكلي</th>
                                                            <th class="text-muted text-center">المبلغ المدفوع</th>
                                                            <th class="text-center">المبلغ المتبقي</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($oldelays as $delay)
                                                            @if ($delay->delay_remaining === 0)
                                                                <tr class="">
                                                                    <td>{{$delay->member_id}}</td>
                                                                    <td>{{$delay->amount}}</td>
                                                                    @if ($delay->delay_amount == null && $delay->delay_remaining == null)
                                                                        <td>
                                                                            <span class="fw-bold">-</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="fw-bold">-</span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$delay->delay_amount}}</td>
                                                                        <td>{{$delay->delay_remaining}}</td>
                                                                    @endif
                                                                    <td>
                                                                        <button class="btn btn-secondary" title="دفع المتأخرات" data-bs-toggle="modal" data-bs-target="#pay_delay_{{$delay->id}}">
                                                                            <i class="fa-solid fa-money-bill"></i>
                                                                        </button>
                                                                        <div class="modal fade" id="pay_delay_{{$delay->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تسديد متأخرات الإشتراك</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form action="{{route('oldDelays.pay')}}" method="post" data-paymentForm-id="{{$delay->id}}">
                                                                                            @csrf
                                                                                            <div class="row">
                                                                                                <input type="hidden" name="id" value="{{$delay->id}}"/>
                                                                                                <div class="col-12">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="member_id" class="text-muted">رقم العضوية</label>
                                                                                                        <input type="number" class="text-muted form-control" id="member_id" name="member_id" value="{{$delay->member_id}}" readonly>
                                                                                                    </div>
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="invoice" class="text-muted">رقم الإيصال</label>
                                                                                                        <input type="text" class="text-muted form-control" name="invoice_no" oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="invoice" minlength="2" maxlength="5" placeholder="رقم الإيصال" data-inv-id="{{$delay->id}}" required>
                                                                                                        <p class="required d-none text-danger paymentInvReq" data-inv-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                        <p class="required d-none text-danger paymentInvMsg" data-inv-id="{{$delay->id}}">يجب ان يكون رقم الايصال مكون من 5 ارقام</p>
                                                                                                    </div>
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="olddelay" class="text-muted">المبلغ المدفوع</label>
                                                                                                        <input type="text" class="text-muted form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="2" maxlength="5" name="olddelay" id="olddelay" placeholder="المبلغ المدفوع من العضو" data-pay-id="{{$delay->id}}" required>
                                                                                                        <p class="required d-none text-danger paymentAmountReq" data-pay-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                        <p class="required d-none text-danger paymentAmountMsg" data-pay-id="{{$delay->id}}">يجب ان لا يقل المبلغ عن 2 رقم ولا يكون اكثر من 5 رقم</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                                    <button type="submit" role="button" data-PaymentSubmit-id="{{$delay->id}}" class="btn btn-primary">تأكيد</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td colspan="4">
                                                                        <h1 class="text-center">تم تسديد متأخرات الإشتراكات</h1>
                                                                    </td>
                                                                </tr> --}}
                                                            @else
                                                                <tr>
                                                                    <td>{{$delay->member_id}}</td>
                                                                    <td>{{$delay->amount}}</td>
                                                                    @if ($delay->delay_amount == null && $delay->delay_remaining == null)
                                                                        <td>
                                                                            <span class="fw-bold">-</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="fw-bold">-</span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$delay->delay_amount}}</td>
                                                                        <td>{{$delay->delay_remaining}}</td>
                                                                    @endif
                                                                    <td>
                                                                        <button class="btn btn-secondary" title="دفع المتأخرات" data-bs-toggle="modal" data-bs-target="#pay_delay_{{$delay->id}}">
                                                                            <i class="fa-solid fa-money-bill"></i>
                                                                        </button>
                                                                        <div class="modal fade" id="pay_delay_{{$delay->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تسديد متأخرات الإشتراك</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form action="{{route('oldDelays.pay')}}" method="post" data-paymentForm-id="{{$delay->id}}">
                                                                                            @csrf
                                                                                            <div class="row">
                                                                                                <input type="hidden" name="id" value="{{$delay->id}}"/>
                                                                                                <div class="col-12">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="member_id" class="text-muted">رقم العضوية</label>
                                                                                                        <input type="number" class="text-muted form-control" id="member_id" name="member_id" value="{{$delay->member_id}}" readonly>
                                                                                                    </div>
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="invoice" class="text-muted">رقم الإيصال</label>
                                                                                                        <input type="text" class="text-muted form-control" name="invoice_no" oninput="this.value = this.value.replace(/[^0-9]/g, '')" id="invoice" minlength="2" maxlength="5" placeholder="رقم الإيصال" data-inv-id="{{$delay->id}}" required>
                                                                                                        <p class="required d-none text-danger paymentInvReq" data-inv-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                        <p class="required d-none text-danger paymentInvMsg" data-inv-id="{{$delay->id}}">يجب ان يكون رقم الايصال مكون من 5 ارقام</p>
                                                                                                    </div>
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="olddelay" class="text-muted">المبلغ المدفوع</label>
                                                                                                        <input type="text" class="text-muted form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="2" maxlength="5" name="olddelay" id="olddelay" placeholder="المبلغ المدفوع من العضو" data-pay-id="{{$delay->id}}" required>
                                                                                                        <p class="required d-none text-danger paymentAmountReq" data-pay-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                        <p class="required d-none text-danger paymentAmountMsg" data-pay-id="{{$delay->id}}">يجب ان لا يقل المبلغ عن 2 رقم ولا يكون اكثر من 5 رقم</p>
                                                                                                    </div>
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="payment_date" class="text-muted">تاريخ الدفع</label>
                                                                                                        <input type="date" class="form-control text-muted" name="payment_date" id="payment_date">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                                    <button type="submit" role="button" data-PaymentSubmit-id="{{$delay->id}}" class="btn btn-primary">تأكيد</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif
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
