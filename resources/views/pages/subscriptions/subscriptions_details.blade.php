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
                                    <h6 class="mb-0">مديونية الإشتراك</h6>
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
                        {{-- <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="donation-history-tab" data-bs-toggle="pill" href="#donation-history" role="tab" aria-controls="donation-history" aria-selected="true">
                            <div class="cart-options d-flex justify-content-center align-items-center h-100">
                                <div class="stroke-icon-wizard me-2">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="cart-options-content">
                                    <h6 class="mb-0">التبرعات السابقة</h6>
                                </div>
                            </div>
                        </a> --}}
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
                                                                <th class="text-white text-center">رقم الإيصال</th>
                                                                <th class="text-white text-center">نوع الدفع</th>
                                                                <th class="text-white text-center">قيمة الإشتراك</th>
                                                                <th class="text-white text-center">تاريخ الدفع</th>
                                                                <th class="text-white text-center">فترة الإشتراك</th>
                                                                <th class="text-white text-center">قيمة المديونية</th>
                                                                <th class="text-white text-center">فترة المديونية بالسنوات</th>
                                                                <th class="text-white text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1 ?>
                                                            @foreach ($subscriptions as $item)
                                                                <tr>
                                                                    <td class="text-white text-center">{{$item->invoice_no}}</td>
                                                                    <td class="text-white text-center">{{$item->payment_type}}</td>
                                                                    <td class="text-white text-center">
                                                                        @if ($item->subscription_cost)
                                                                            <span>{{$item->subscription_cost}}</span>
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-white text-center">{{$item->pay_date}}</td>
                                                                    <td class="text-white text-center">
                                                                        @if ($item->period)
                                                                            <span>{{$item->period}}</span>
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-white text-center">
                                                                        @if ($item->delays)
                                                                            <span>{{$item->delays}}</span>
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-white text-center">
                                                                        @if ($item->delays_period)
                                                                            <span>{{$item->delays_period}}</span>
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div class="btn-group" role="group">
                                                                            <button class="btn btn-success rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                            </button>
                                                                            <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">
                                                                                {{-- ! Delete ! --}}
                                                                                <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$item->id}}">
                                                                                    <i class="icofont icofont-trash"></i>
                                                                                </button>
                                                                                {{-- ! Updating ! --}}
                                                                                {{-- <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#updating_{{$item->id}}">
                                                                                    <i class="icofont icofont-ui-edit"></i>
                                                                                </button> --}}
                                                                            </div>
                                                                        </div>
                                                                        {{-- ! Delete ! --}}
                                                                        <div class="modal fade" id="deleting_{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف إشتراك العضو {{$subscriber->name}}</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form action={{route('subscription.destroy', $item->id)}} method="get">
                                                                                            @csrf
                                                                                            <div class="form-title text-center">
                                                                                                <h1 class="text-white">هل أنت متأكد أنك تريد حذف</h1>
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
                                                                        {{-- ! Updating ! --}}
                                                                        {{-- <div class="modal fade" id="updating_{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">جار تحديث إشتراك العضو {{$item->name}}</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form action={{route('subscription.update')}} method="post">
                                                                                            @csrf
                                                                                            <input type="hidden" name="id" value="{{$item->id}}">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="title" class="text-white">رقم العضوية</label>
                                                                                                        <input type="number" class="form-control text-white" value="{{$subscriber->member_id}}" name="member_id" placeholder="رقم العضوية" readonly>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="" class="text-white">نوع المدفوعات</label>
                                                                                                        <select name="payment_type" class="form-select">
                                                                                                            <option value="إشتراك" {{$item->payment_type === 'إشتراك' ? 'selected' : ''}}>إشتراك</option>
                                                                                                            <option value="مديونية" {{$item->payment_type === 'مديونية' ? 'selected' : ''}}>مديونية</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="title" class="text-white">رقم الإيصال</label>
                                                                                                        <input type="number" class="form-control text-white" name="invoice_no" value="{{$item->invoice_no}}" placeholder="رقم الإيضال">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="title" class="text-white">تاريخ الدفع</label>
                                                                                                        <input type="date" class="form-control text-white" name="pay_date" value="{{$item->pay_date}}" placeholder="تاريخ الدفع">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="title" class="text-white">مبلغ إشتراك</label>
                                                                                                        <input type="number" class="form-control text-white" name="subscription_cost" value="{{$item->subscription_cost}}" placeholder="أدخل مبلغ الإشتراك">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group mb-3">
                                                                                                        <label for="title" class="text-white">مدة الإشتراك</label>
                                                                                                        <input type="text" class="form-control text-white" min="2000" max="3000" name="period" value="{{$item->period}}" placeholder="مدة الإشتراك">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group">
                                                                                                        <label for="delays" class="text-white">مبلغ المديونية</label>
                                                                                                        <input type="number" id="delays" class="form-control text-white" name="delays" value="{{$item->delays}}" placeholder="أدخل مبلغ المديونية">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-6">
                                                                                                    <div class="form-group">
                                                                                                        <label for="delay_period" class="text-white">مدة المديونية</label>
                                                                                                        <input type="number" id="delay_period" name="delays_period" class="form-control text-white" value="{{$item->delays_period}}" placeholder="مدة المديونية">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-12">
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
                                                                        </div> --}}
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
                                                <table id="table33" class="table display align-middle table-hover text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">رقم العضوية</th>
                                                            <th class="text-center">فترة الإشتراك</th>
                                                            <th class="text-center">المبلغ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($delays as $delay)
                                                            @if ($delay->payment_type == 'إشتراك')
                                                                <tr>
                                                                    <td class="text-center">{{$delay->member_id}}</td>
                                                                    <td class="text-center">{{$delay->year}}</td>
                                                                    <td class="text-center">{{$delay->yearly_cost}}</td>
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
                        <div class="tab-pane fade show" id="old-delays" role="tabpanel" aria-labelledby="old-delays-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="table34" class="table display align-middle table-hover text-center text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">رقم العضوية</th>
                                                            <th class="text-center">الفترة الزمنية</th>
                                                            <th class="text-center">المبلغ الإجمالي</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($delays as $delay)
                                                            @if ($delay->payment_type === 'متأخرات')
                                                                <tr>
                                                                    <td>{{$delay->member_id}}</td>
                                                                    <td>{{$delay->delay_period}}</td>
                                                                    <td>{{$delay->amount}}</td>
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
                        {{-- <div class="tab-pane fade show" id="donation-history" role="tabpanel" aria-labelledby="donation-history-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="table10" class="table display align-middle table-hover text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th class="text-center">إسم المتبرع</th>
                                                                <th class="text-center">رقم التلفون</th>
                                                                <th class="text-center">نوع التبرع</th>
                                                                <th class="text-center">رقم الإيصال</th>
                                                                <th class="text-center">المبلغ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=1 ?>
                                                            @foreach ($donations as $donation)
                                                                <tr>
                                                                    <td class="text-center">{{$i++}}</td>
                                                                    <td class="text-center">{{$subscriber->name}}</td>
                                                                    <td class="text-center">{{$subscriber->mobile_no}}</td>
                                                                    <td class="text-center"></td>
                                                                    <td class="text-center">{{$donation->invoice_no}}</td>
                                                                    <td class="text-center">{{$donation->amount}}</td>
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
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
