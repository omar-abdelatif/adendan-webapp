@extends('layouts.master')
@section('title', 'تقارير المديونية')
@section('breadcrumb-title')
    <h3>تقارير المديونية</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير المديونية</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table align-middle table-hover text-center text-muted" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-center">الإسم</th>
                                        <th class="text-center">رقم العضوية</th>
                                        <th class="text-center">مبلغ المديونية</th>
                                        <th class="text-center">حالة الإشتراك</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($debts as $debt)
                                        <tr>
                                            <td>{{$debt->name}}</td>
                                            <td>{{$debt->member_id}}</td>
                                            @if ($debt->delays)
                                                <td class="text-muted text-center">
                                                    <span class="text-muted bg-secondary rounded-pill px-4">{{$debt->delays->amount}}</span>
                                                    ج.م
                                                </td>
                                            @else
                                                <td class="text-muted text-center">
                                                    <span class="text-muted bg-success rounded-pill px-3">0</span>
                                                    ج.م
                                                </td>
                                            @endif
                                            <td>
                                                @if ($debt->status === 0)
                                                    <span class="badge rounded-pill badge-danger text-muted">الإشتراك غير مفعل</span>
                                                @endif
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
