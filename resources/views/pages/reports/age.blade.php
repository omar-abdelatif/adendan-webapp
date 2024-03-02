@extends('layouts.master')
@section('title', 'تقارير السن')
@section('breadcrumb-title')
    <h3>تقارير السن</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير السن</li>
@endsection
@section('script')
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.ar.js')}}"></script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="age-filter w-50 mx-auto mb-5">
                            <form action="{{route('reports.age')}}" method="get">
                                @csrf
                                <div class="form-group d-flex align-items-center">
                                    <input class="datepicker-age form-control text-white digits" name="birthdate" readonly id="confirmpasswordwizard" type="text" placeholder="تاريخ الميلاد" data-language="ar" dir="rtl">
                                    <button type="submit" class="btn btn-success px-4 ms-3">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <div class="searchResultTitle text-center mb-5">
                                @if (isset($ageKey))
                                    @if ($ages->isNotEmpty())
                                        <h1>نتائج البحث عن "{{ $ageKey }}"</h1>
                                    @elseif (isset($message))
                                        <h1>{{ $message }}</h1>
                                    @endif
                                @endif
                            </div>
                            @if (isset($ageKey) && $ages->isNotEmpty())
                                <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم العضوية</th>
                                            <th class="text-center">الأسم</th>
                                            <th class="text-center">السن</th>
                                            <th class="text-center">رقم المحمول</th>
                                            <th class="text-center">حالة الإشتراك</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ages as $age)
                                            <tr>
                                                <td>{{$age->member_id}}</td>
                                                <td>{{$age->name}}</td>
                                                <td>{{$age->birthdate}}</td>
                                                <td>{{$age->mobile_no}}</td>
                                                <td>
                                                    @if($age->status == 1)
                                                        <span class="badge rounded-pill badge-success">الإشتراك مفعل</span>
                                                    @else
                                                        <span class="badge rounded-pill badge-danger">الإشتراك غير مفعل</span>
                                                    @endif
                                                </td>
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
                                            <th class="text-center">السن</th>
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
