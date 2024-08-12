@extends('layouts.master')
@section('title', 'تقارير الإشتراكات')
@section('breadcrumb-title')
    <h3>تقارير الإشتراكات</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير الإشتراكات</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="light-card balance-card mb-4 widget-hover w-50 mx-auto d-flex justify-content-center bg-primary rounded-pill">
                    <i class="fas fa-dollar-sign" style="font-size:30px;"></i>
                    تـقرير الإشـتراكـات
                </h3>
            </div>
            <div class="col-xl-12 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="60" height="60" src="https://img.icons8.com/external-filled-outline-perfect-kalash/60/external-Group-corporate-development-filled-outline-perfect-kalash.png" alt="external-Group-corporate-development-filled-outline-perfect-kalash" />
                            </div>
                            <div>
                                <h5>عـدد الأعـضاء</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$count}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 box-col-12">
                <div class="card widget-1 ">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="80" height="80" src="https://img.icons8.com/dusk/80/average-2.png" alt="average-2" />
                            </div>
                            <div>
                                <h5>إجمالي متأخرات الإشتراكات السابقة</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$sumTotalOldDelaysSubscriptions}}  ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="80" height="80" src="https://img.icons8.com/color/80/money-transfer.png" alt="money-transfer" />
                            </div>
                            <div>
                                <h5>الـمحصـل ( المتأخرات )</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$sumDelayAmount}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="80" height="80" src="https://img.icons8.com/dusk/80/question-mark.png" alt="question-mark" />
                            </div>
                            <div>
                                <h5>المتبقي ( المتأخرات )</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$sumTotalOldDelaysSubscriptions - $sumDelayAmount}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="80" height="80" src="https://img.icons8.com/dusk/80/question-mark.png" alt="question-mark" />
                            </div>
                            <div>
                                <h5>إجمالي قيمة الإشتراك الحالي</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$sumTotalDelays}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="80" height="80" src="https://img.icons8.com/dusk/80/question-mark.png" alt="question-mark" />
                            </div>
                            <div>
                                <h5>المحصل ( قيمة الإشتراك )</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$sumDelayPaied}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 box-col-6">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="80" height="80" src="https://img.icons8.com/dusk/80/question-mark.png" alt="question-mark" />
                            </div>
                            <div>
                                <h5>المتبقي ( قيمة الإشتراك )</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$sumTotalDelays - $sumDelayPaied}} ج.م</h5>
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
                            تـفاصيـل مديونيه إشتراك الأعضاء
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <i class="fas fa-signature"></i>
                                            رقــم العـضويه
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-signature"></i>
                                            الأسـم
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-calendar-week"></i>
                                            رقـم الموبايل
                                        </th>
                                        <th class="text-center">
                                            <i class="fa-duotone fa-gear"></i>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscriber)
                                        <tr>
                                            <td class="text-center">{{$subscriber->member_id}}</td>
                                            <td class="text-center">{{$subscriber->name}}</td>
                                            <td class="text-center">{{$subscriber->mobile_no}}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success text-dark" data-bs-toggle="modal" data-bs-target="#subsc_{{$subscriber->id}}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                <div class="modal fade" id="subsc_{{$subscriber->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تفاصيل العضو {{$subscriber->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table class="table display align-middle text-center table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">قيمة الإشتراك</th>
                                                                                <th class="text-center">رقم الإيضال</th>
                                                                                <th class="text-center">تاريخ الدفع</th>
                                                                                <th class="text-center">فترة الإشتراك</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if ($subscriber->subscriptions->count())
                                                                                @foreach ($subscriber->subscriptions as $subscription)
                                                                                    <tr>
                                                                                        <td>{{$subscription->subscription_cost}}</td>
                                                                                        <td>{{$subscription->invoice_no}}</td>
                                                                                        <td>{{$subscription->created_at->format('Y-m-d')}}</td>
                                                                                        <td>{{$subscription->period}}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @else
                                                                            <tr>
                                                                                <div class="col-lg-12">
                                                                                    <td colspan="4">
                                                                                        <h1 class="text-center text-white">لا توجد إشتراكات سابقة لهذا المشترك</h1>
                                                                                    </td>
                                                                                </div>
                                                                            </tr>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                </div>
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
@endsection
