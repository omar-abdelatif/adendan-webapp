@extends('layouts.master')
@section('title', 'تقارير المنتسبين')
@section('breadcrumb-title')
<h3>تقارير المنتسبين</h3>
@endsection
@section('breadcrumb-items')
<li class="breadcrumb-item">التقارير</li>
<li class="breadcrumb-item active">تقارير المنتسبين</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 box-col-12">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="65" height="65" src="https://img.icons8.com/3d-fluency/65/conference-call--v1.png" alt="conference-call--v1"/>
                            </div>
                            <h5>إجمالي المنتسبين</h5>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1">{{count($associates)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php $i =1 ?>
                        <div class="table-responsible">
                            <table id="table" class="table display align-middle text-muted table-hover" data-order='[[0, "asc"]]' data-page-length="10">
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">رقم العضوية</th>
                                    <th class="text-center">إسم العضو</th>
                                    <th class="text-center">رقم المحمول</th>
                                    <th class="text-center">نوع العضوية</th>
                                    <th class="text-center">حالة الإشتراك</th>
                                </thead>
                                <tbody>
                                    @foreach ($associates as $associate)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$associate->member_id}}</td>
                                            <td>{{$associate->name}}</td>
                                            <td>{{$associate->mobile_no}}</td>
                                            <td>{{$associate->membership_type}}</td>
                                            <td>
                                                @if($associate->status == 0)
                                                    <span class="badge rounded-pill badge-danger text-white">الإشتراك غير مفعل</span>
                                                @elseif($associate->status == 1)
                                                    <span class="badge rounded-pill badge-success text-dark">الإشتراك مفعل</span>
                                                @elseif ($associate->status == 2)
                                                    <span class="badge rounded-pill badge-dark text-white">المشترك متوفي</span>
                                                @elseif ($associate->status == 3)
                                                    <span class="badge rounded-pill badge-warning text-dark">الإشتراك معلق</span>
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