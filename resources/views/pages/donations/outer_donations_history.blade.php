@extends('layouts.master')
@section('title', 'كل التبرعات')
@section('breadcrumb-title')
    <h3>كل التبرعات الخاصة بالمتبرع {{$donators->name}}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href="{{route('donators.all')}}">كل المتبرعين</a>
    </li>
    <li class="breadcrumb-item active">التبرعات السابقة</li>
@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-center w-50 mx-auto rounded" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">التبرعات السابقة للمتبرع {{$donators->name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table display table-hover text-muted" data-order='[[1,"asc"]]' data-page-length=10>
                                <thead>
                                    <tr>
                                        <th class="text-center">إسم المتبرع</th>
                                        <th class="text-center">رقم الإيصال</th>
                                        <th class="text-center">المبلغ</th>
                                        <th class="text-center">نوع التبرع</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($outerdonations as $donations)
                                        <tr>
                                            <td class="text-center">{{$donators->name}}</td>
                                            <td class="text-center">{{$donations->invoice_id}}</td>
                                            <td class="text-center">{{$donations->amount}}</td>
                                            <td class="text-center">{{$donations->donation_destination}}</td>
                                            <td class="text-center">
                                                {{-- ! Delete ! --}}
                                                <button type="button" class="btn btn-danger text-white px-2 py-1" title="حذف المتبرع" data-bs-toggle="modal" data-bs-target="#delete_donator_{{$donations->id}}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="delete_donator_{{$donations->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف التبرع {{$donations->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('outer_donations.delete', $donations->id)}} method="get">
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
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning text-white px-2 py-1" title="تعديل البيانات" data-bs-toggle="modal" data-bs-target="#update_donator_{{$donations->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="update_donator_{{$donations->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تحديث المتبرع {{$donations->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{route('outer_donations.update')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{$donations->id}}>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                                                                <input type="text" name="invoice_id" class="form-control" value="{{$donations->invoice_id}}" placeholder="رقم الإيصال" id="invoice_no" readonly>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="amount" class="text-muted">المبلغ</label>
                                                                                <input type="text" name="amount" class="form-control" value="{{$donations->amount}}" placeholder="المبلغ" id="amount">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donation_destination" class="text-muted">نوع التبرع</label>
                                                                                <input type="text" name="donation_destination" class="form-control" value="{{$donations->donation_destination}}" placeholder="نوع التبرع" id="donation_destination">
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
