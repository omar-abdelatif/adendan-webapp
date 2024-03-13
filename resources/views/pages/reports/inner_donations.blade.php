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
                let amount = parseFloat(row[7].replace(",", ""));
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
                                        <th class="text-center">مدة التبرع</th>
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
                                            <td class="text-center">{{$donation->donation_destination}}</td>
                                            <td class="text-center">{{$donation->donation_duration}}</td>
                                            <td class="text-center">{{$donation->amount}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center">
                                            <b>الإجمالي</b>
                                        </td>
                                        <td id="totalAmount" class="text-left" colspan="7"></td>
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
