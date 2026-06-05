@extends('layouts.master')
@section('title', 'طلبات التحديث')
@section('breadcrumb-title')
    <h3>طلبات التحديث</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">التقارير</li>
    <li class="breadcrumb-item active">طلبات التحديث</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table display align-middle text-muted text-center" data-order='[[1,"asc"]]' data-page-length=10>
                                <thead>
                                    <tr>
                                        <th>رقم العضوية</th>
                                        <th>الاسم</th>
                                        <th>العنوان</th>
                                        <th>رقم الهاتف</th>
                                        <th>الرقم القومي</th>
                                        <th>تاريخ الميلاد</th>
                                        <th>المهنة</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{ $request->member_id }}</td>
                                            <td>{{ $request->name }}</td>
                                            <td>{{ $request->address }}</td>
                                            <td>{{ $request->mobile_no }}</td>
                                            <td>{{ $request->ssn }}</td>
                                            <td>{{ $request->birth_date }}</td>
                                            <td>{{ $request->job_title }}</td>
                                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <form action="{{ route('user.updateRequest') }}" method="POST" class="updateForm" data-updateForm-id="{{$request->id}}">
                                                    @csrf
                                                    <input type="hidden" name="name" value="{{$request->name}}">
                                                    <input type="hidden" name="member_id" value="{{$request->member_id}}">
                                                    <input type="hidden" name="mobile_no" value="{{$request->mobile_no}}">
                                                    <input type="hidden" name="ssn" value="{{$request->ssn}}">
                                                    <input type="hidden" name="address" value="{{$request->address}}">
                                                    <input type="hidden" name="job_title" value="{{$request->job_title}}">
                                                    <input type="hidden" name="birthdate" value="{{$request->birth_date}}">
                                                    <button class="btn btn-success approve-update-request" data-member-id="{{ $request->member_id }}" title="قبول الطلب">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('user.declineUpdateRequest', $request->id) }}" method="POST" class="declineForm" data-declineForm-id="{{$request->id}}">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="member_id" value="{{$request->member_id}}">
                                                    <button class="btn btn-danger declined-update-request" data-member-id="{{ $request->member_id }}" title="رفض الطلب">
                                                        <i class="fa-solid fa-times"></i>
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
    </div>
@endsection
