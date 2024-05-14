@extends('layouts.master')
@section('title', 'كل التبرعات')
@section('breadcrumb-title')
    <h3>كل التبرعات الخاصة بالمتبرع {{$subscriber->name}}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">
        <a href="{{route('donators.all')}}">كل المتبرعين</a>
    </li>
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
                    <h2 class="text-center text-decoration-underline">كل التبرعات و المديونيات السابقة للعضو {{$subscriber->name}}</h2>
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
                                    <h6 class="mb-0">مديونية التبرعات</h6>
                                </div>
                            </div>
                        </a>
                        <a class="nav-link w-25 text-center rounded-pill py-3 btn btn-outline-primary" id="old-delays-tab" data-bs-toggle="pill" href="#old-delays" role="tab" aria-controls="old-delays" aria-selected="true">
                            <div class="cart-options d-flex justify-content-center align-items-center h-100">
                                <div class="stroke-icon-wizard me-2">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <div class="cart-options-content">
                                    <h6 class="mb-0">متأخرات التبرعات</h6>
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
                                                    <table class="table display table-hover align-middle text-center text-muted" id="table" data-order='[[5, "dec"]]' data-page-length=10>
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">رقم الإيصال</th>
                                                                <th class="text-center">المبلغ</th>
                                                                <th class="text-center">نوع التبرع</th>
                                                                <th class="text-center">أخرى</th>
                                                                <th class="text-center">جهة التبرع</th>
                                                                <th class="text-center">تاريخ المعاملة</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($donations as $donation)
                                                                <tr>
                                                                    <td>{{$donation->invoice_no}}</td>
                                                                    <td>{{$donation->amount}}</td>
                                                                    <td>{{$donation->donation_type}}</td>
                                                                    <td>
                                                                        @if ($donation->donation_type == 'أخرى')
                                                                            {{$donation->other_donation}}
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($donation->donation_type == 'مادي')
                                                                            {{$donation->donation_category}}
                                                                        @else
                                                                            <span class="fw-bold">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$donation->created_at->format('Y-m-d')}}</td>
                                                                    <td>
                                                                        <div class="btn-group" role="group">
                                                                            <button class="btn btn-success rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                            </button>
                                                                            <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">
                                                                                {{-- ! Edit ! --}}
                                                                                <button type="button" class="btn btn-warning text-white px-2 py-1" data-bs-toggle="modal" data-bs-target="#update_donation_{{$donation->id}}">
                                                                                    <i class="fa-solid fa-pen"></i>
                                                                                </button>
                                                                                {{-- ! Delete ! --}}
                                                                                <button type="button" class="btn btn-danger text-white px-2 py-1" data-bs-toggle="modal" data-bs-target="#delete_donation_{{$donation->id}}">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- ! Edit Modal ! --}}
                                                                        <div class="modal fade" id="update_donation_{{$donation->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تحديث التبرع {{$donation->name}}</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form action="{{route('donations.update')}}" method="post">
                                                                                            @csrf
                                                                                            <input type="hidden" name="id" value={{$donation->id}}>
                                                                                            <div class="row">
                                                                                                <div class="col-lg-12">
                                                                                                    <div class="form-group">
                                                                                                        <label for="title" class="text-white">رقم العضوية</label>
                                                                                                        <input type="number" class="form-control text-muted" name="member_id" value="{{$donation->member_id}}" readonly>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="title" class="text-white">رقم الإيصال</label>
                                                                                                        <input type="number" class="form-control text-muted" name="invoice_no" value="{{$donation->invoice_no}}">
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="title" class="text-muted">المبلغ</label>
                                                                                                        <input type="number" class="form-control text-muted" name="amount" value="{{$donation->amount}}">
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="donation_type" class="text-muted">نوع التبرع</label>
                                                                                                        <select name="donation_type" class="form-select" id="donation_type">
                                                                                                            <option value="مادي" {{$donation->donation_type == '' ? 'selected' : 'مادي'}}>مادي</option>
                                                                                                            <option value="أخرى" id="other_donation" {{$donation->donation_type == 'أخرى' ? 'selected' : ''}}>أخرى</option>
                                                                                                        </select>
                                                                                                        @if ($donation->donation_type == 'أخرى')
                                                                                                            <input type="text" class="form-control mt-3" placeholder="نوع التبرع الأخر" value="{{$donation->other_donation}}" name="other_donation">
                                                                                                        @else
                                                                                                            <input type="text" class="form-control d-none" placeholder="نوع التبرع الأخر" name="other_donation">
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="donation_destination" class="text-muted">جهة التبرع</label>
                                                                                                        <input type="text" class="form-control" placeholder="جهة التبرع" value="{{$donation->donation_destination}}" name="donation_destination">
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <label for="donation_duration" class="text-muted">مدة التبرع</label>
                                                                                                        <input type="text" class="form-control" placeholder="المده" id="donation_duration" value="{{$donation->donation_duration}}" name="donation_duration">
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
                                                                        {{-- ! Delete Modal ! --}}
                                                                        <div class="modal fade" id="delete_donation_{{$donation->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف التبرع {{$donation->name}}</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form action={{route('donation.remove', $donation->id)}} method="get">
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
                        </div>
                        <div class="tab-pane fade show" id="debts" role="tabpanel" aria-labelledby="debts-tab">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table id="table34" class="table text-muted display align-middle table-hover text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">تصنيف التبرع</th>
                                                            <th class="text-center">مبلغ المديونية</th>
                                                            <th class="text-center">المبلغ المدفوع</th>
                                                            <th class="text-center">المبلغ المتبقي</th>
                                                            <th class="text-center">تاريخ المعاملة</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=1 ?>
                                                        @foreach ($delayDonation as $delay)
                                                            <tr>
                                                                <td class="text-center">{{$delay->donation_type}}</td>
                                                                <td class="text-center">{{$delay->delay_amount}}</td>
                                                                @if ($delay->amount_remaining == null && $delay->amount_paied == null)
                                                                    <td class="text-center">
                                                                        <span class="fw-bold">-</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="fw-bold">-</span>
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">{{$delay->amount_paied}}</td>
                                                                    <td class="text-center">{{$delay->amount_remaining}}</td>
                                                                @endif
                                                                <td class="text-center">{{$delay->created_at->format('Y-m-d')}}</td>
                                                                <td class="text-center">
                                                                    <button class="btn bg-secondary" type="button" data-bs-target="#oldDdonationPayment_{{$delay->id}}" data-bs-toggle="modal">
                                                                        <i class="fa-solid fa-dollar-sign"></i>
                                                                    </button>
                                                                    <div class="fade modal" tabindex="-1" id="oldDdonationPayment_{{$delay->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">تسديد مديونية تبرع للعضو {{$subscriber->name}} and {{$delay->id}}</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    {{-- <form action="{{route('pay.delayDonation')}}" method="post">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <input type="hidden" name="id" value="{{$delay->id}}"/>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="member_id" class="text-muted">رقم العضوية</label>
                                                                                                    <input type="text" class="form-control text-muted" name="member_id" value="{{$delay->member_id}}" placeholder="نوع التبرع" id="member_id" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="donation_type" class="text-muted">نوع التبرع</label>
                                                                                                    <input type="text" class="form-control text-muted" name="donation_type" value="مادي" placeholder="نوع التبرع" id="donation_type" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="donation_category" class="text-muted">تصنيف التبرع</label>
                                                                                                    <input type="text" class="form-control text-muted" name="donation_category" value="{{$delay->donation_type}}" placeholder="نوع التبرع" id="donation_category" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                                                                                    <input type="number" name="invoice_no" id="invoice_no" class="form-control text-muted" placeholder="رقم الإيصال">
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="amount" class="text-muted">المبلغ المدفوع</label>
                                                                                                    <input type="number" name="amount" id="amount" class="form-control text-muted" placeholder="المبلغ المدفوع">
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                                                    <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form> --}}
                                                                                    <form action="{{route('pay.delayDonation')}}" method="post" data-paydonation-id="{{$delay->id}}">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <input type="hidden" name="id" value="{{$delay->id}}"/>
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="member_id" class="text-muted">رقم العضوية</label>
                                                                                                    <input type="text" class="form-control text-muted" name="member_id" value="{{$delay->member_id}}" placeholder="رقم العضوية" id="member_id" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="donation_type" class="text-muted">نوع التبرع</label>
                                                                                                    <input type="text" class="form-control text-muted" name="donation_type" value="مادي" placeholder="نوع التبرع" id="donation_type" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="donation_category" class="text-muted">تصنيف التبرع</label>
                                                                                                    <input type="text" class="form-control text-muted" name="donation_category" value="{{$delay->donation_type}}" placeholder="نوع التبرع" id="donation_category" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                                                                                    <input type="text" name="invoice_no" id="invoice_no" class="form-control text-muted" data-donationinv-id="{{$delay->id}}" placeholder="رقم الإيصال" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="5" required >
                                                                                                    <p class="required d-none text-danger mb-0 fw-bold donationInvReq" data-donationinv-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                    <p class="required d-none text-danger mb-0 fw-bold donationInvMsg" data-donationinv-id="{{$delay->id}}">يجب ان يكون رقم الايصال مكون من 5 ارقام</p>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="amount" class="text-muted">المبلغ المدفوع</label>
                                                                                                    <input type="text" name="amount" id="amount" class="form-control text-muted" placeholder="المبلغ المدفوع" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="2" maxlength="5" data-donationamount-id={{$delay->id}} required>
                                                                                                    <p class="required d-none text-danger mb-0 fw-bold donationAmountReq" data-donationamount-id="{{$delay->id}}">هذا الحقل مطلوب</p>
                                                                                                    <p class="required d-none text-danger mb-0 fw-bold donationAmountMsg" data-donationamount-id="{{$delay->id}}">يجب ان يكون المبلغ مكون من 5 ارقام</p>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                                                    <button type="submit" data-donationSubmitForm-id="{{$delay->id}}" role="button" class="btn btn-primary">تأكيد</button>
                                                                                                </div>
                                                                                            </div>
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
                                                <table id="table35" class="table display align-middle table-hover text-center text-muted" data-order='[[0,"asc"]]' data-page-length="10">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">المبلغ الإجمالي</th>
                                                            <th class="text-center">المبلغ المطلوب الإجمالي</th>
                                                            <th class="text-center">المبلغ المتبقي</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1 ?>
                                                        @foreach ($oldDelayDonations as $delay)
                                                            <tr>
                                                                <td class="text-center">{{$i++}}</td>
                                                                <td class="text-center">{{$delay->amount}}</td>
                                                                <td class="text-center">{{$delay->delay_amount}}</td>
                                                                <td class="text-center">{{$delay->delay_remaining}}</td>
                                                                <td class="text-center">
                                                                    <button class="btn bg-secondary" type="button" data-bs-target="#donationPayment_{{$delay->id}}" data-bs-toggle="modal">
                                                                        <i class="fa-solid fa-dollar-sign"></i>
                                                                    </button>
                                                                    <div class="fade modal" tabindex="-1" id="donationPayment_{{$delay->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">تسديد متأخرات تبرع للعضو {{$subscriber->name}}</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{route('pay.oldDonation')}}" method="post">
                                                                                        @csrf
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="member_id" class="text-muted">ؤقم العضوية</label>
                                                                                                    <input type="text" class="form-control text-muted" name="member_id" value="{{$delay->member_id}}" placeholder="نوع التبرع" id="member_id" readonly>
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                                                                                    <input type="number" name="invoice_no" id="invoice_no" class="form-control text-muted" placeholder="رقم الإيصال">
                                                                                                </div>
                                                                                                <div class="form-group mt-3">
                                                                                                    <label for="amount" class="text-muted">المبلغ المدفوع</label>
                                                                                                    <input type="number" name="amount" id="amount" class="form-control text-muted" placeholder="المبلغ المدفوع">
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
