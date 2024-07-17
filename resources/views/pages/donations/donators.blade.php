@php
    $user = Auth::user();
@endphp
@extends('layouts.master')
@section('title', 'كل التبرعات')
@section('breadcrumb-title')
    <h3>كل المتبرعين</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل المتبرعين</li>
@endsection
@section('modals')
    {{-- ! Insert New Donator ! --}}
    <button type="button" class="btn btn-success text-dark px-2 py-1" data-bs-toggle="modal" data-bs-target="#new_donator">
        <i class="icofont icofont-eye"></i>
        <span class="ms-3">إضافة متبرع جديد</span>
    </button>
    <div class="modal fade" id="new_donator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة متبرع جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('donators.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="donator-name" class="text-muted">إسم المتبرع</label>
                            <input type="text" class="form-control" name="name" placeholder="إسم المتبرع" id="donator-name">
                        </div>
                        <div class="form-group">
                            <label for="mobile_number" class="text-muted">رقم المحمول</label>
                            <input type="number" class="form-control" name="mobile_number" placeholder="رقم المحمول" id="mobile_number">
                        </div>
                        <div class="form-group">
                            <label for="donator_type" class="text-muted">نوع المتبرع</label>
                            <select name="donator_type" class="form-select" id="donator_type">
                                <option selected>أختر نوع المتبرع</option>
                                <option value="منتظم">منتظم</option>
                                <option value="موسمي">موسمي</option>
                            </select>
                            <input type="text" class="form-control mt-3 d-none" name="duration" placeholder="مدة التبرع" id="duration">
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
                            <table id="table" class="table display align-middle text-muted text-center" data-order='[[1,"asc"]]' data-page-length=10>
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">إسم المتبرع</th>
                                        <th class="text-center">رقم المحمول</th>
                                        <th class="text-center">مدة التبرع</th>
                                        <th class="text-center">نوع المتبرع</th>
                                        <th class="text-center">تاريخ التسجيل</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    @foreach ($allDonators as $donator)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td>
                                            <td class="text-center">{{$donator->name}}</td>
                                            <td class="text-center">{{$donator->mobile_number}}</td>
                                            <td class="text-center">
                                                @if ($donator->donator_type == 'منتظم')
                                                    {{$donator->duration}}
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$donator->donator_type}}</td>
                                            <td class="text-center">{{$donator->created_at->format('Y-m-d')}}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-success rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">
                                                        {{-- ! Donation ! --}}
                                                        <button type="button" class="btn btn-info px-2 py-1 ms-0 me-1" data-bs-toggle="modal" title="تبرع جديد" data-bs-target="#donating_{{$donator->id}}">
                                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                                        </button>
                                                        {{-- ! Update ! --}}
                                                        <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" title="تحديث بيانات" data-bs-target="#update_donator_{{$donator->id}}">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                        {{-- ! Delete ! --}}
                                                        <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" title="حذف المتبرع" data-bs-target="#delete_donator_{{$donator->id}}">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                        {{-- ! Donation History ! --}}
                                                        @if ($user->role === 'subscriptions')
                                                            <a href="{{route('subscriptionRole.outer_donations.history', $donator->id)}}" title="التبرعات السابقة" class="btn btn-primary px-2 py-1">
                                                                <i class="fa-solid fa-book-heart"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{route('outer_donations.history', $donator->id)}}" title="التبرعات السابقة" class="btn btn-primary px-2 py-1">
                                                                <i class="fa-solid fa-book-heart"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                {{-- ! Delete ! --}}
                                                <div class="modal fade" id="delete_donator_{{$donator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">حذف التبرع {{$donator->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('donators.remove', $donator->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h1 class="text-muted">هل أنت متأكد من الحذف</h1>
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
                                                <div class="modal fade" id="update_donator_{{$donator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">تحديث المتبرع {{$donator->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{route('donators.update')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{$donator->id}}>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="donator-name" class="text-muted">إسم المتبرع</label>
                                                                                <input type="text" class="form-control" name="name" value="{{$donator->name}}" placeholder="إسم المتبرع" id="donator-name">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="mobile_number" class="text-muted">رقم المحمول</label>
                                                                                <input type="number" class="form-control" name="mobile_number" value="{{$donator->mobile_number}}" placeholder="رقم المحمول" id="mobile_number">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="duration" class="text-muted">مدة التبرع</label>
                                                                                <input type="text" class="form-control" name="duration" value="{{$donator->duration}}" placeholder="مدة التبرع" id="duration">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donator_type" class="text-muted">نوع المتبرع</label>
                                                                                <select name="donator_type" class="form-select" id="donator_type">
                                                                                    <option value="منتظم"{{$donator->donator_type === 'منتظم' ? 'selected' : ''}}>منتظم</option>
                                                                                    <option value="موسمي"{{$donator->donator_type === 'موسمي' ? 'selected' : ''}}>موسمي</option>
                                                                                </select>
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
                                                {{-- ! Donation ! --}}
                                                <div class="modal fade" id="donating_{{$donator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة تبرع جديد {{$donator->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('outer_donations.store')}} method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$donator->id}}">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="donator_name" class="text-muted">إسم المتبرع</label>
                                                                                <input type="text" name="name" class="form-control" value="{{$donator->name}}" placeholder="إسم المتبرع" id="donator_name" readonly>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donator_type" class="text-muted">نوع المتبرع</label>
                                                                                <input type="text" name="donator_type" class="form-control" value="{{$donator->donator_type}}" placeholder="نوع المتبرع" id="donator_type" readonly>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                                                                <input type="number" name="invoice_id" class="form-control" placeholder="رقم الإيصال" id="invoice_no">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="amount" class="text-muted">المبلغ</label>
                                                                                <input type="number" name="amount" class="form-control" placeholder="المبلغ" id="amount">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donation_destination" class="text-muted">نوع التبرع</label>
                                                                                <input type="text" name="donation_destination" class="form-control" placeholder="نوع التبرع" id="donation_destination">
                                                                            </div>
                                                                        </div>
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
