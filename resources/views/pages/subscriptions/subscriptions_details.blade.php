@extends('layouts.master')
@section('title', $subscriber->name)
@section('breadcrumb-title')
    <h3>كل الإشتراكات</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">
        <a href="{{route('subscriber.all')}}">كل المشتركين</a>
    </li>
    <li class="breadcrumb-item active">كل الإشتراكات</li>
@endsection
@section('modals')
    {{-- ! Add Subscription ! --}}
    <button type="button" class="btn btn-success text-dark fw-bold px-2 py-1 ms-0" data-bs-toggle="modal" data-bs-target="#add_subs">
        إضافة مدينوية او إشتراك
    </button>
    {{-- ! Add Subscription ! --}}
    <div class="modal fade" id="add_subs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تسديد إشتراك أو مديونية للعضو {{$subscriber->name}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('subscription.store')}} method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="text-white">رقم العضوية</label>
                                    <input type="number" class="form-control text-white" value="{{$subscriber->member_id}}" name="member_id" placeholder="رقم العضوية" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="" class="text-white">نوع المدفوعات</label>
                                    <select name="payment_type" class="form-select">
                                        <option value="إشتراك">إشتراك</option>
                                        <option value="مديونية">مديونية</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="text-white">رقم الإيصال</label>
                                    <input type="number" class="form-control text-white" name="invoice_no" placeholder="رقم الإيضال">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="text-white">تاريخ الدفع</label>
                                    <input type="date" class="form-control text-white" name="pay_date" placeholder="تاريخ الدفع">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="text-white">مبلغ إشتراك</label>
                                    <input type="number" class="form-control text-white" name="subscription_cost" placeholder="أدخل مبلغ الإشتراك">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="text-white">مدة الإشتراك</label>
                                    <input type="text" class="form-control text-white" min="2000" max="3000" name="period" placeholder="مدة الإشتراك">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="delays" class="text-white">مبلغ المديونية</label>
                                    <input type="number" id="delays" class="form-control text-white" name="delays" placeholder="أدخل مبلغ المديونية">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="delay_period" class="text-white">مدة المديونية</label>
                                    <input type="number" id="delay_period" name="delays_period" class="form-control text-white" placeholder="مدة المديونية">
                                </div>
                            </div>
                            <div class="col-lg-12">
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
                <div class="subs-title mb-5">
                    <h2 class="text-center text-decoration-underline">كل الإشتراكات و المديونيات السابقة للعضو {{$subscriber->name}}</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-white text-center">رقم الإيصال</th>
                                        <th class="text-white text-center">نوع الدفع</th>
                                        <th class="text-white text-center">قيمة الإشتراك</th>
                                        <th class="text-white text-center">تاريخ الدفع</th>
                                        <th class="text-white text-center">فترة الإشتراك</th>
                                        <th class="text-white text-center">قيمة المديونية</th>
                                        <th class="text-white text-center">فترة المديونية بالسنوات</th>
                                        <th class="text-white text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ?>
                                    @foreach ($subscriptions as $item)
                                        <tr>
                                            <td></td>
                                            <td class="text-white text-center">{{$item->invoice_no}}</td>
                                            <td class="text-white text-center">{{$item->payment_type}}</td>
                                            <td class="text-white text-center">
                                                @if ($item->subscription_cost)
                                                    <span>{{$item->subscription_cost}}</span>
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-white text-center">{{$item->pay_date}}</td>
                                            <td class="text-white text-center">
                                                @if ($item->period)
                                                    <span>{{$item->period}}</span>
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-white text-center">
                                                @if ($item->delays)
                                                    <span>{{$item->delays}}</span>
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td class="text-white text-center">
                                                @if ($item->delays_period)
                                                    <span>{{$item->delays_period}}</span>
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-success rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">
                                                        {{-- ! Delete ! --}}
                                                        <button type="button" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleting_{{$item->id}}">
                                                            <i class="icofont icofont-trash"></i>
                                                        </button>
                                                        {{-- ! Updating ! --}}
                                                        {{-- <button type="button" class="btn btn-warning px-2 py-1" data-bs-toggle="modal" data-bs-target="#updating_{{$item->id}}">
                                                            <i class="icofont icofont-ui-edit"></i>
                                                        </button> --}}
                                                    </div>
                                                </div>
                                                {{-- ! Delete ! --}}
                                                <div class="modal fade" id="deleting_{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف إشتراك العضو {{$subscriber->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('subscription.destroy', $item->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h1 class="text-white">هل أنت متأكد أنك تريد حذف</h1>
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
                                                {{-- ! Updating ! --}}
                                                {{-- <div class="modal fade" id="updating_{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">جار تحديث إشتراك العضو {{$item->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('subscription.update')}} method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-white">رقم العضوية</label>
                                                                                <input type="number" class="form-control text-white" value="{{$subscriber->member_id}}" name="member_id" placeholder="رقم العضوية" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="" class="text-white">نوع المدفوعات</label>
                                                                                <select name="payment_type" class="form-select">
                                                                                    <option value="إشتراك" {{$item->payment_type === 'إشتراك' ? 'selected' : ''}}>إشتراك</option>
                                                                                    <option value="مديونية" {{$item->payment_type === 'مديونية' ? 'selected' : ''}}>مديونية</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-white">رقم الإيصال</label>
                                                                                <input type="number" class="form-control text-white" name="invoice_no" value="{{$item->invoice_no}}" placeholder="رقم الإيضال">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-white">تاريخ الدفع</label>
                                                                                <input type="date" class="form-control text-white" name="pay_date" value="{{$item->pay_date}}" placeholder="تاريخ الدفع">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-white">مبلغ إشتراك</label>
                                                                                <input type="number" class="form-control text-white" name="subscription_cost" value="{{$item->subscription_cost}}" placeholder="أدخل مبلغ الإشتراك">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-white">مدة الإشتراك</label>
                                                                                <input type="text" class="form-control text-white" min="2000" max="3000" name="period" value="{{$item->period}}" placeholder="مدة الإشتراك">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for="delays" class="text-white">مبلغ المديونية</label>
                                                                                <input type="number" id="delays" class="form-control text-white" name="delays" value="{{$item->delays}}" placeholder="أدخل مبلغ المديونية">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for="delay_period" class="text-white">مدة المديونية</label>
                                                                                <input type="number" id="delay_period" name="delays_period" class="form-control text-white" value="{{$item->delays_period}}" placeholder="مدة المديونية">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
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
                                                </div> --}}
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