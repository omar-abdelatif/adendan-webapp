@extends('layouts.master')
@section('title', 'تقرير الخزنة')
@section('breadcrumb-title')
    <h3>تقرير الخزنة</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقرير الخزنة</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success px-2 py-1" data-bs-toggle="modal" data-bs-target="#withdraw">سحب الى البنك</button>
    <div class="modal fade" id="withdraw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-center mb-0">سحب مبلغ من الخزنة الى البنك</h3>
                </div>
                <div class="modal-body">
                    <form id="safeForm" action="{{route('withdraw')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="withdrawn_amount" class="text-muted">المبلغ المسحوب</label>
                                    <input type="text"  class="form-control text-muted"name="amount" id="withdrawn_amount" placeholder="المبلغ المسحوب" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="2" required>
                                    <p class="required d-none text-danger fw-bold" id="withdrawReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger fw-bold" id="withdrawMsg">يجب ان لا يكون الرقم المسحوب بالسالب و مكون من 2 رقم على الأقل</p>
                                </div>
                                <div class="form-group">
                                    <label for="proof_withdraw" class="text-muted">إثبات السحب</label>
                                    <input type="file" name="proof_img" id="proof_withdraw" class="form-control text-muted" accept="image/*" required>
                                    <p class="required d-none fw-bold text-danger mb-0" id="withdrawimgReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none fw-bold text-danger mb-0" id="withdrawimgExt">يجب ان يكون امتداد الصورة [ jpg, png, jpeg, webp ]</p>
                                    <p class="required d-none fw-bold text-danger mb-0" id="withdrawimgSize">يجب ان يكون حجم الصورة اقل من 2 ميجا</p>
                                </div>
                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" role="button" id="withdrawSubmit" class="btn btn-primary">تأكيد</button>
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
                <h3 class="light-card balance-card widget-hover w-50 mx-auto justify-content-center rounded-pill bg-primary mb-4">
                    <i class="fas fa-dollar-sign" style="font-size:30px;"></i>
                    تـقرير الـخزنه
                </h3>
            </div>
            <div class="col-xxl-6 col-xl-6 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="70" height="70" src="https://img.icons8.com/external-anggara-filled-outline-anggara-putra/70/external-loan-economy-anggara-filled-outline-anggara-putra.png" alt="external-loan-economy-anggara-filled-outline-anggara-putra" />
                            </div>
                            <h5>إجمالي التبـرعات</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{ number_format($sumDonations) }} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 box-col-12">
                <div class="card widget-1 ">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="70" height="70" src="https://img.icons8.com/bubbles/70/money-bag.png" alt="money-bag" />
                            </div>
                            <h5>إجمالي الإشـتـراكات</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{number_format($sumSubscriptions)}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-xl-12 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="70" height="70" src="https://img.icons8.com/plasticine/70/bank.png" alt="bank" />
                            </div>
                            <h5>إجمالـي الخـزنه الحـالي</h5>
                        </div>
                        <div class="font-Info">
                            @foreach ($safeAmounts as $safe)
                                <h5 class="mb-1">{{number_format($safe)}} ج.م</h5>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header p-3">
                        <h3 class="light-card balance-card widget-hover w-50 mx-auto justify-content-center rounded-pill bg-primary mb-0">
                            <i class="fas fa-exchange-alt" style="font-size:30px;"></i>
                            تـفاصيـل الـخزنـه
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle table-hover" id="table" data-order='[[1, "desc"], [2, "desc"]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <i class="fas fa-sort-numeric-up-alt pe-2"></i>
                                            رقم العضوية
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-calendar-week pe-2"></i>
                                            تـاريخ المـعامله
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-question-circle pe-2"></i>
                                            الـنوع
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-question-circle pe-2"></i>
                                            نوع المعامله
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-duotone fa-image pe-2"></i>
                                            مستند المعاملة
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-dollar-sign pe-2"></i>
                                            المبلغ
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($safes as $safe)
                                        <tr>
                                            <td class="text-center">{{$safe->member_id}}</td>
                                            <td class="text-center">{{$safe->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">{{$safe->transaction_type}}</td>
                                            <td class="text-center">
                                                @if ($safe->transaction_type === 'تبرعات' || $safe->transaction_type === 'إشتراكات' || $safe->transaction_type === 'متأخرات' || $safe->transaction_type === 'بنك/إيداع' || $safe->transaction_type === 'متأخرات التبرعات' || $safe->transaction_type === 'تبرع كلي' || $safe->transaction_type === 'تبرع جزئي'|| $safe->transaction_type === 'خزنة/إيداع')
                                                    <h3 class="badge rounded-pill badge-success" style="font-size: 13px;">إيداع</h3>
                                                @else
                                                    <h3 class="badge rounded-pill badge-danger" style="font-size: 13px;">سـحب</h3>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($safe->proof_img !== null)
                                                    <button type="button" class="btn btn-transparent" data-bs-target="#proof_{{$safe->id}}" data-bs-toggle="modal">
                                                        <img src="{{asset('assets/images/withdraws/'.$safe->proof_img)}}" width="70" class="rounded" alt="{{$safe->proof_img}}">
                                                    </button>
                                                    <div class="modal fade" id="proof_{{$safe->id}}"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-0">
                                                                    <img src="{{asset('assets/images/withdraws/'.$safe->proof_img)}}" class="rounded w-100" alt="{{$safe->proof_img}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <h6>{{$safe->amount}} ج.م</h6>
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
@endsection
