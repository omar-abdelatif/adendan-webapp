@extends('layouts.master')
@section('title', 'كل التبرعات')
@section('breadcrumb-title')
    <h3>كل التبرعات الخاصة بالمتبرع {{$subscriber->name}}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">
        <a href="{{route('donators.all')}}">كل المتبرعين</a>
    </li>
@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mx-auto w-50 text-center" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display table-hover align-middle text-center text-muted" id="table" data-order='[[0, "asc"]]' data-page-length=10>
                                <thead>
                                    <tr>
                                        <th class="text-center">رقم العضوية</th>
                                        <th class="text-center">رقم الإيصال</th>
                                        <th class="text-center">المبلغ</th>
                                        <th class="text-center">نوع التبرع</th>
                                        <th class="text-center">أخرى</th>
                                        <th class="text-center">جهة التبرع</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donations as $donation)
                                        <tr>
                                            <td>{{$donation->member_id}}</td>
                                            <td>{{$donation->invoice_no}}</td>
                                            <td>{{$donation->amount}}</td>
                                            <td>{{$donation->donation_type}}</td>
                                            <td>
                                                @if ($donation->other_donation != null)
                                                    {{$donation->other_donation}}
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td>{{$donation->donation_destination}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-success rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">
                                                        {{-- ! Edit ! --}}
                                                        <button type="button" class="btn btn-warning text-white px-2 py-1" data-bs-toggle="modal" data-bs-target="#update_donation_{{$donation->id}}">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                        {{-- ! Delete ! --}}
                                                        <button type="button" class="btn btn-danger text-white px-2 py-1" data-bs-toggle="modal" data-bs-target="#delete_donation_{{$donation->id}}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- ! Edit Modal ! --}}
                                                <div class="modal fade" id="update_donation_{{$donation->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تحديث التبرع {{$donation->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{route('donations.update')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{$donation->id}}>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">رقم العضوية</label>
                                                                                <input type="number" class="form-control text-muted" name="member_id" value="{{$donation->member_id}}" readonly>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-white">رقم الإيصال</label>
                                                                                <input type="number" class="form-control text-muted" name="invoice_no" value="{{$donation->invoice_no}}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-muted">المبلغ</label>
                                                                                <input type="number" class="form-control text-muted" name="amount" value="{{$donation->amount}}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donation_type" class="text-muted">نوع التبرع</label>
                                                                                <select name="donation_type" class="form-select" id="donation_type">
                                                                                    <option value="مادي" {{$donation->donation_type == '' ? 'selected' : 'مادي'}}>مادي</option>
                                                                                    <option value="أخرى" id="other_donation" {{$donation->donation_type == 'أخرى' ? 'selected' : ''}}>أخرى</option>
                                                                                </select>
                                                                                @if ($donation->donation_type == 'أخرى')
                                                                                    <input type="text" class="form-control mt-3" placeholder="نوع التبرع الأخر" value="{{$donation->other_donation}}" name="other_donation">
                                                                                @else
                                                                                    <input type="text" class="form-control d-none" placeholder="نوع التبرع الأخر" name="other_donation">
                                                                                @endif
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donation_destination" class="text-muted">جهة التبرع</label>
                                                                                <input type="text" class="form-control" placeholder="جهة التبرع" value="{{$donation->donation_destination}}" name="donation_destination">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donation_duration" class="text-muted">مدة التبرع</label>
                                                                                <input type="text" class="form-control" placeholder="المده" id="donation_duration" value="{{$donation->donation_duration}}" name="donation_duration">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                                <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- ! Delete Modal ! --}}
                                                <div class="modal fade" id="delete_donation_{{$donation->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف التبرع {{$donation->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('donation.remove', $donation->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h1 class="text-white">هل أنت متأكد من الحذف</h1>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                        <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
