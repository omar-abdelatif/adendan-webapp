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
                        <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 1, "desc" ]]' data-page-length='10'>
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
                                        <td class="text-center">{{$item->member_id}}</td>
                                        <td class="text-center">{{$item->mobile_no ?? '-'}}</td>
                                        <td class="text-center">{{$item->ssn ?? '-'}}</td>
                                        <td class="text-center">{{$item->address ?? '-'}}</td>
                                        <td class="text-center">{{$item->birthdate ?? '-'}}</td>
                                        <td class="text-center">
                                            <button type="button" class="border-0 bg-transparent text-danger" data-bs-toggle="modal" title="حذف" data-bs-target="#deleting_{{$item->id}}">
                                                <i class="fa-solid fa-trash-can fs-5"></i>
                                            </button>
                                            <div class="modal fade" id="deleting_{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">جار حذف بيانات البعضو {{$item->name}}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action={{route('search.delete', $item->id)}} method="get">
                                                                @csrf
                                                                <div class="form-title text-center">
                                                                    <h3 class="text-white my-2">هل أنت متأكد من الحذف</h3>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                    <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('search.approve') }}" method="POST" id="searchedForm_{{$item->id}}" data-form-id="{{$item->id}}">
                                                @csrf
                                                <input type="hidden" name="member_id" value="{{$item->member_id}}">
                                                <input type="hidden" name="mobile_number" value="{{$item->mobile_number}}">
                                                <input type="hidden" name="ssn" value="{{$item->ssn}}">
                                                <input type="hidden" name="address" value="{{$item->address}}">
                                                <input type="hidden" name="birthdate" value="{{$item->birthdate}}">
                                                <button type="submit" class="border-0 bg-transparent text-success approve-request" data-approve-id="{{$item->id}}" title="موافقة">
                                                    <i class="fa-solid fa-check fs-5"></i>
                                                </button>
                                            </form>
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