@extends('layouts.master')
@section('title', 'تقارير التبرعات')
@section('breadcrumb-title')
    <h3>تقارير التبرعات</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير التبرعات</li>
@endsection
@section('css')
    <style>
        .text-tight{
            text-align: right !important
        }
        .text-left{
            text-align: left !important
        }
        .pe-6 {
            padding-left: 3rem !important;
        }
    </style>
@endsection
@section('script')
    <script>
        $(function(){
            let table = $("#inner_donations").DataTable();
            let totalAmount = 0;
            table.rows().every(function () {
                let row = this.data();
                let amount = parseFloat(row[6].replace(",", ""));
                if (!isNaN(amount)) {
                    totalAmount += amount;
                }
            });
            $("#totalAmount").text(totalAmount.toFixed(2));
        })
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="light-card balance-card widget-hover w-50 mx-auto justify-content-center rounded-pill bg-primary mb-4">
                    <i class="fas fa-dollar-sign" style="font-size:30px;"></i>
                    تـقرير التبرعات
                </h3>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="64" height="64" src="https://img.icons8.com/external-xnimrodx-lineal-color-xnimrodx/64/external-condo-city-scape-xnimrodx-lineal-color-xnimrodx.png" alt="external-condo-city-scape-xnimrodx-lineal-color-xnimrodx"/>
                            </div>
                            <h5 class="mb-0">صيانة مقر</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationHeadquartersSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1 ">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="65" height="65" src="https://img.icons8.com/external-hidoc-kerismaker/65/external-Headstone-funeral-hidoc-kerismaker.png" alt="external-Headstone-funeral-hidoc-kerismaker" />
                            </div>
                            <h5 class="mb-0">المقابر</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationTombsSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="70" height="70" src="https://img.icons8.com/external-konkapp-outline-color-konkapp/70/external-van-transportation-konkapp-outline-color-konkapp.png" alt="external-van-transportation-konkapp-outline-color-konkapp"/>
                            </div>
                            <h5 class="mb-0">ص.سيارة</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationDeathCarSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="64" height="64" src="https://img.icons8.com/external-bzzricon-flat-bzzricon-studio/64/external-zakat-ramadan-bzzricon-flat-bzzricon-flat-bzzricon-studio.png" alt="external-zakat-ramadan-bzzricon-flat-bzzricon-flat-bzzricon-studio"/>
                            </div>
                            <h5 class="mb-0">زكاة مال</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationMoneyZakatSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="64" height="64" src="https://img.icons8.com/stickers/64/food-donor.png" alt="food-donor"/>
                            </div>
                            <h5 class="mb-0">زكاة فطر</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationFoodZakatSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="64" height="64" src="https://img.icons8.com/dusk/64/donate.png" alt="donate"/>
                            </div>
                            <h5 class="mb-0">تبرع تنمية</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationDevSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="64" height="64" src="https://img.icons8.com/external-anggara-filled-outline-anggara-putra/64/external-loan-economy-anggara-filled-outline-anggara-putra.png" alt="external-loan-economy-anggara-filled-outline-anggara-putra" />
                            </div>
                            <h5 class="mb-0">تبرع إنتساب</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationAffiliateSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="64" height="64" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-kids-modelling-agency-flaticons-lineal-color-flat-icons-3.png" alt="external-kids-modelling-agency-flaticons-lineal-color-flat-icons-3"/>                            </div>
                            <h5 class="mb-0">كفالة يتيم</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationOrphanSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="70" height="70" src="https://img.icons8.com/bubbles/70/question-mark.png" alt="question-mark"/>
                            </div>
                            <h5 class="mb-0">أخرى</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{$donationOtherSum}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-absolute">
                    <div class="card-header bg-primary rounded-pill">
                        <h4 class="mb-0">التبرعات الداخلية</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle text-muted table-hover" id="inner_donations" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">رقم العضوية</th>
                                        <th class="text-center">رقم الإيصال</th>
                                        <th class="text-center">نوع التبرع</th>
                                        <th class="text-center">تبرعات أخرى</th>
                                        <th class="text-center">جهة التبرع</th>
                                        <th class="text-center">المبلغ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    @foreach ($donations as $donation)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td>
                                            <td class="text-center">{{$donation->member_id}}</td>
                                            <td class="text-center">{{$donation->invoice_no}}</td>
                                            <td class="text-center">{{$donation->donation_type}}</td>
                                            <td class="text-center">
                                                @if ($donation->donation_type === 'أخرى')
                                                    {{$donation->other_donation}}
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($donation->donation_type == 'مادي')
                                                    {{$donation->donation_category}}
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$donation->amount}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center">
                                            <b>الإجمالي</b>
                                        </td>
                                        <td id="totalAmount" class="text-left" colspan="6"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
