@extends('layouts.master')
@section('title', 'تقارير البنك')
@section('breadcrumb-title')
    <h3>تقارير البنك</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير البنك</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success px-2 py-1" data-bs-toggle="modal" data-bs-target="#withdraw">سحب الى الخزنة</button>
    <div class="modal fade" id="withdraw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-center mb-0">سحب مبلغ من البنك الى الخزنة</h3>
                </div>
                <div class="modal-body">
                    <form action="{{route('bank.withdraw')}}" method="post" enctype="multipart/form-data" id="BankForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="withdrawn_amount" class="text-muted">المبلغ المسحوب</label>
                                    <input type="text" name="amount" id="withdrawn_bank" placeholder="المبلغ المسحوب" class="form-control text-muted" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="2" required>
                                    <p class="required d-none text-danger mb-0 fw-bold" id="bankReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0 fw-bold" id="bankMsg">يجب ان لا يكون المبلغ اقل من 2 رقم و اكثر من 5 رقم</p>
                                </div>
                                <div class="form-group">
                                    <label for="proof_withdraw" class="text-muted">إثبات السحب</label>
                                    <input type="file" name="proof_img" id="proof_bank" class="form-control text-muted" accept="image/*" required>
                                    <p class="required d-none fw-bold text-danger mb-0" id="bankImgReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none fw-bold text-danger mb-0" id="bankImgExt">يجب ان يكون امتداد الصورة [ jpg, png, jpeg, webp ]</p>
                                    <p class="required d-none fw-bold text-danger mb-0" id="bankImgSize">يجب ان يكون حجم الصورة اقل من 2 ميجا</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" role="button" id="BankSubmit" class="btn btn-primary">تأكيد</button>
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
                    <h3 class="light-card balance-card mb-4 widget-hover w-50 mx-auto d-flex justify-content-center bg-primary rounded-pill">
                        <i class="fas fa-dollar-sign" style="font-size:30px;"></i>
                        تـقرير معاملات البنك
                    </h3>
                </div>
                <div class="col-xl-12 box-col-6">
                    <div class="card widget-1">
                        <div class="card-body align-items-center">
                            <div class="widget-content">
                                <div class="bg-round">
                                    <img width="70" height="70" src="https://img.icons8.com/color/70/money-transfer.png" alt="money-transfer" />
                                </div>
                                <div>
                                    <h5>المبلغ الحالي</h5>
                                </div>
                            </div>
                            <div class="font-Info">
                                @foreach ($bankAmount as $safe)
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
                                تـفاصيـل معاملات البنك
                            </h3>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle table-hover" id="table" data-order='[[0, "desc"], [1, "desc"]]' data-page-length='10'>
                                <thead>
                                    <th class="text-center">
                                        <i class="fas fa-calendar-week pe-2"></i>
                                        تـاريخ المـعامله
                                    </th>
                                    <th class="text-center">
                                        <i class="fas fa-question-circle pe-2"></i>
                                        توقيت المعامله
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
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $item)
                                        <tr>
                                            <td class="text-center">{{$item->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">{{$item->created_at->format('H:i')}}</td>
                                            <td class="text-center">
                                                @if ($item->transaction_type === 'بنك/ايداع' || $item->transaction_type === 'ايداع')
                                                    <span class="badge badge-success rounded-pill">إيداع</span>
                                                @else
                                                    <span class="badge badge-danger rounded-pill">سحب</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->proof_img !== null)
                                                    <button type="button" class="btn btn-transparent" data-bs-target="#proof_{{$item->id}}" data-bs-toggle="modal">
                                                        <img src="{{asset('assets/images/withdraws/'.$item->proof_img)}}" width="70" class="rounded" alt="{{$item->proof_img}}">
                                                    </button>
                                                    <div class="modal fade" id="proof_{{$item->id}}"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-0">
                                                                    <img src="{{asset('assets/images/withdraws/'.$item->proof_img)}}" class="rounded w-100" alt="{{$item->proof_img}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$item->amount}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
