@extends('layouts.master')
@section('title', 'تقارير بيانات الاعضاء التي يجب تحديثها')
@section('breadcrumb-title')
    <h3>تقارير بيانات الاعضاء التي يجب تحديثها</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">تقارير بيانات الاعضاء التي يجب تحديثها</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table display align-middle text-center table-hover partial-data" id="table" data-order='[[ 1, "desc" ]]' data-page-length='10'>
                            <thead>
                                <tr>
                                    <th class="text-center">إسم العضو</th>
                                    <th class="text-center">رقم العضوية</th>
                                    <th class="text-center">رقم المحمول</th>
                                    <th class="text-center">الرقم القومي</th>
                                    <th class="text-center">العنوان</th>
                                    <th class="text-center">تاريخ الميلاد</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr id="row_{{ $item->id }}">
                                        <td class="text-center">{{$item->name}}</td>
                                        <td class="text-center">{{$item->member_id ?? '-'}}</td>
                                        <td class="text-center">{{$item->mobile_no ?? '-'}}</td>
                                        <td class="text-center">{{$item->ssn ?? '-'}}</td>
                                        <td class="text-center">{{$item->address ?? '-'}}</td>
                                        <td class="text-center">{{$item->birthdate ?? '-'}}</td>
                                        <td class="text-center">
                                            @if ($item->member_id)
                                                <form action="{{ route('search.approve') }}" method="POST" class="searchedForm" data-form-id="{{$item->id}}">
                                                    @csrf
                                                    <input type="hidden" name="member_id" value="{{$item->member_id}}">
                                                    <input type="hidden" name="mobile_no" value="{{$item->mobile_no}}">
                                                    <input type="hidden" name="ssn" value="{{$item->ssn}}">
                                                    <input type="hidden" name="address" value="{{$item->address}}">
                                                    <input type="hidden" name="birthdate" value="{{$item->birthdate}}">
                                                    <button type="submit" class="border-0 bg-transparent text-success approve-request" data-approve-id="{{$item->id}}" title="موافقة">
                                                        <i class="fa-solid fa-check fs-5"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if (empty($item->member_id))
                                                <form action="" method="post" class="insertNew" data-form-id="{{$item->id}}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <input type="hidden" name="name" value="{{$item->name}}">
                                                    <input type="hidden" name="mobile_no" value="{{$item->mobile_no}}">
                                                    <input type="hidden" name="ssn" value="{{$item->ssn}}">
                                                    <input type="hidden" name="address" value="{{$item->address}}">
                                                    <input type="hidden" name="birthdate" value="{{$item->birthdate}}">
                                                    <button type="submit" class="border-0 bg-transparent text-success insert-request" data-approve-id="{{$item->id}}" title="إدخال جديد">
                                                        <i class="fa-solid fa-plus fs-5"></i>
                                                    </button>
                                                </form>
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
@endsection