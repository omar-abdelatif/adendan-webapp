@extends('layouts.master')
@section('title', 'تقارير متأخرات الإشتراك')
@section('breadcrumb-title')
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير متأخرات الإشتراك</li>
@endsection
@section('content')
    <section class="old_sub">
        <div class="container-fluid">
               <div class="col-lg-12">
                <h3 class="light-card balance-card widget-hover w-50 mx-auto justify-content-center rounded-pill bg-primary mb-4">
                    <i class="fas fa-dollar-sign" style="font-size:30px;"></i>
                    تقارير متأخرات الإشتراك
                </h3>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                                   <div class="col-lg-12">
                                        <h3 class="light-card balance-card widget-hover text-white w-25 mx-auto justify-content-center rounded-pill bg-success mb-4">
                                            بـحـث مـتقدم
                                        </h3>
                                    </div>
                            <div class="filter-form">
                                <form action="{{ route('reports.search') }}" method="get">
                                    <div class="forms d-flex w-100 justify-content-center mx-auto">

                                        <div class="form-group me-5">
                                            <input type="number" class="form-control" placeholder="المبلغ" name="amount">
                                        </div>
                                        <div class="form-group me-5">
                                            <select name="optype" class="form-select pe-4 ps-3">
                                                <option disabled selected>
                                                   أختر العمليه
                                                </option>
                                                <option value=">">
                                                    أكثر من
                                                </option>
                                                <option value="<">
                                                    أقل من
                                                </option>
                                                <option value="=">
                                                    يساوي
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-warning fw-bold fs-6 rounded-pill text-dark" value="بحث">
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {{-- <table id="table" class="table align-middle table-hover text-center text-muted" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">الإسم</th>
                                            <th class="text-center">رقم العضوية</th>
                                            <th class="text-center">المبلغ الكلي</th>
                                            <th class="text-center">المدفوع</th>
                                            <th class="text-center">باقي المبلغ</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($query as $sub)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $sub->name }}</td>
                                                <td>{{ $sub->member_id }}</td>
                                                <td>{{$sub->amount}}</td>
                                                <td>
                                                    @if ($sub->delay_amount)
                                                        {{$sub->delay_amount}}
                                                    @else
                                                        <span class="fw-bold">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($sub->delay_remaining)
                                                        {{$sub->delay_remaining}}
                                                    @else
                                                        <span class="fw-bold">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">الإجمالي</td>
                                            <td>{{$totalAmount}}</td>
                                        </tr>
                                    </tfoot>
                                </table> --}}
                                @if(isset($queryResult))
                                    @if($queryResult->isEmpty())
                                        <p>{{ $noOldDelays }}</p>
                                    @else
                                        <table id="table" class="table align-middle table-hover text-center text-muted" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">الإسم</th>
                                                    <th class="text-center">رقم العضوية</th>
                                                    <th class="text-center">المبلغ الكلي</th>
                                                    <th class="text-center">المدفوع</th>
                                                    <th class="text-center">باقي المبلغ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                @foreach($queryResult as $subscriber)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $subscriber->name }}</td>
                                                        <td>{{ $subscriber->member_id }}</td>
                                                        <td>{{ $subscriber->amount }}</td>
                                                        <td>
                                                            @if ($subscriber->delay_amount)
                                                                {{$subscriber->delay_amount}}
                                                            @else
                                                                <span class="fw-bold">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($subscriber->delay_remaining)
                                                                {{$subscriber->delay_remaining}}
                                                            @else
                                                                <span class="fw-bold">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                @else
                                    @if($delays->isEmpty())
                                        <p>{{ $noOldDelays }}</p>
                                    @else
                                        <table id="table" class="table align-middle table-hover text-center text-muted" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">الإسم</th>
                                                    <th class="text-center">رقم العضوية</th>
                                                    <th class="text-center">العنوان</th>
                                                    <th class="text-center">المبلغ الكلي</th>
                                                    <th class="text-center">المدفوع</th>
                                                    <th class="text-center">باقي المبلغ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                @foreach($delays as $delay)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $delay->name }}</td>
                                                        <td>{{ $delay->member_id }}</td>
                                                        <td>{{ $delay->address }}</td>
                                                        <td>{{ $delay->amount }}</td>
                                                        <td>
                                                            @if ($delay->delay_amount)
                                                                {{$delay->delay_amount}}
                                                            @else
                                                                <span class="fw-bold">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($delay->delay_remaining)
                                                                {{$delay->delay_remaining}}
                                                            @else
                                                                <span class="fw-bold">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
