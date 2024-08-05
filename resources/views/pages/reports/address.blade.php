@extends('layouts.master')
@section('title', 'تقارير السكن')
@section('breadcrumb-title')
    <h3>تقارير السكن</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير السكن</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="location-filter w-50 mx-auto mb-5">
                            <form action="{{route('reports.location')}}" method="get">
                                @csrf
                                <div class="form-group d-flex align-items-center">
                                    <input class="form-control text-white" name="address" type="text" placeholder="إسم المنطقة">
                                    <button type="submit" class="btn btn-success px-4 ms-3">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <div class="searchResultTitle text-center mb-5">
                                @if (isset($locationKey) && $locations->isNotEmpty())
                                    <h1>نتائج البحث عن "{{ $locationKey }}"</h1>
                                @else
                                    <h1>{{ $message }}</h1>
                                @endif
                            </div>
                            @if (isset($locationKey) && $locations->isNotEmpty())
                                <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">رقم العضوية</th>
                                            <th class="text-center">الأسم</th>
                                            <th class="text-center">العنوان</th>
                                            <th class="text-center">رقم المحمول</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i =1 ?>
                                        @foreach ($locations as $item)
                                            <tr>
                                                <td class="text-center text-white">{{$i++}}</td>
                                                <td class="text-center text-white">{{$item->member_id}}</td>
                                                <td class="text-center text-white">{{$item->name}}</td>
                                                <td class="text-center text-white">{{$item->address}}</td>
                                                <td class="text-center text-white">{{$item->mobile_no}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                    <thead>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">رقم العضوية</th>
                                            <th class="text-center">الأسم</th>
                                            <th class="text-center">العنوان</th>
                                            <th class="text-center">رقم المحمول</th>
                                            <th class="text-center">حالة الإشتراك</th>
                                        </tr>
                                    </thead>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
