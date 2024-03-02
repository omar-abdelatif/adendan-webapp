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
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-white text-center">رقم العضوية</th>
                                        <th class="text-white text-center">إسم المشترك</th>
                                        <th class="text-white text-center">تاريخ الإشتراك</th>
                                        <th class="text-white text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscriber)
                                        <tr>
                                            <td>{{$subscriber->member_id}}</td>
                                            <td>{{$subscriber->name}}</td>
                                            <td>{{$subscriber->created_at->format('Y-m-d')}}</td>
                                            <td>
                                                {{-- ! Details ! --}}
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
                                                                <div class="horizontal-wizard-wrapper">
                                                                    <div class="row g-3">
                                                                        <div class="col-12 main-horizontal-header">
                                                                            <div class="nav nav-pills horizontal-options justify-content-center" id="horizontal-wizard-tab" role="tablist" aria-orientation="vertical">
                                                                                <a class="nav-link active" id="wizard-info-tab_{{$subscriber->id}}" data-bs-toggle="pill" href="#wizard-info_{{$subscriber->id}}" role="tab" aria-controls="wizard-info" aria-selected="true">
                                                                                    <div class="horizontal-wizard">
                                                                                        <div class="stroke-icon-wizard">
                                                                                            <i class="fa fa-user text-white"></i>
                                                                                        </div>
                                                                                        <div class="horizontal-wizard-content">
                                                                                            <h6 class="text-white">بيانات شخصية</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                                <a class="nav-link" id="bank-wizard-tab_{{$subscriber->id}}" data-bs-toggle="pill" href="#bank-wizard_{{$subscriber->id}}" role="tab" aria-controls="bank-wizard" aria-selected="false" tabindex="-1">
                                                                                    <div class="horizontal-wizard">
                                                                                        <div class="stroke-icon-wizard">
                                                                                            <i class="fa fa-chain-broken text-white"></i>
                                                                                        </div>
                                                                                        <div class="horizontal-wizard-content">
                                                                                            <h6 class="text-white">تفاصيل الإشتراك</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="tab-content dark-field" id="horizontal-wizard-tabContent">
                                                                                <div class="tab-pane fade show active" id="wizard-info_{{$subscriber->id}}" role="tabpanel" aria-labelledby="wizard-info-tab">
                                                                                    <form class="row g-3 needs-validation" novalidate="">
                                                                                        <div class="col-xl-6">
                                                                                            <label class="form-label text-white" for="customLastname">
                                                                                                الرقم القومي
                                                                                            </label>
                                                                                            <input class="form-control" value="{{$subscriber->ssn}}" type="text" placeholder="الرقم القومي" readonly>
                                                                                        </div>
                                                                                        <div class="col-xl-6">
                                                                                            <label class="form-label text-white">
                                                                                                الرقم المحمول
                                                                                            </label>
                                                                                            <input class="form-control" type="number" value="{{$subscriber->mobile_no}}" placeholder="الرقم المحمول" readonly>
                                                                                        </div>
                                                                                        <div class="col-xl-6">
                                                                                            <label class="form-label text-white" for="custom-zipcode">تاريخ الميلاد</label>
                                                                                            <input class="form-control" type="text" value="{{$subscriber->birthdate}}" readonly>
                                                                                        </div>
                                                                                        <div class="col-xl-6">
                                                                                            <label class="form-label text-white" for="customContact1">العنوان</label>
                                                                                            <input class="form-control" type="text" value="{{$subscriber->address}}" readonly>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="tab-pane fade" id="bank-wizard_{{$subscriber->id}}" role="tabpanel" aria-labelledby="bank-wizard-tab">
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
                                                                                                            <td>{{$subscription->pay_date}}</td>
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
