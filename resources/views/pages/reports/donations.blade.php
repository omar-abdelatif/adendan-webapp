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
            let table = $("#donations").DataTable();
            let totalAmount = 0;
            table.rows().every(function () {
                let row = this.data();
                console.log(row)
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
                <div class="card card-absolute">
                    <div class="card-header bg-primary rounded-pill">
                        <h4 class="mb-0">التبرعات الخارجية</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle text-muted table-hover" id="donations" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">إسم المتبرع</th>
                                        <th class="text-center">رقم الإيصال</th>
                                        <th class="text-center">نوع المتبرع</th>
                                        <th class="text-center">نوع التبرع</th>
                                        <th class="text-center">مدة التبرع</th>
                                        <th class="text-center">المبلغ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    @foreach ($donators as $donator)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td>
                                            <td class="text-center">{{$donator->name}}</td>
                                            <td class="text-center">{{$donator->invoice_id}}</td>
                                            <td class="text-center">{{$donator->donator_type}}</td>
                                            <td class="text-center">{{$donator->donation_destination}}</td>
                                            <td class="text-center">
                                                @if (isset($donator->donators->donator_type))
                                                    {{$donator->donators->duration}}
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$donator->amount}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="px-3">
                                        <td class="text-center">
                                            <b>الإجمالي</b>
                                        </td>
                                        <td id="totalAmount" class="pe-6 text-left" colspan="6"></td>
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
