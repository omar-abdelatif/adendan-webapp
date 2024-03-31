@extends('layouts.master')
@section('title', 'النثريات')
@section('breadcrumb-title')
    <h3>النثريات</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">النثريات</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة فاتورة جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة فاتورة جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('miscellaneous.store')}} method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category" class="text-muted">التصنيف</label>
                            <select name="category" class="form-select text-muted" id="category">
                                <option selected>إختر التصنيف</option>
                                <option value="كهرباء">كهرباء</option>
                                <option value="مياه">مياه</option>
                                <option value="غاز">غاز</option>
                                <option value="تلفون ارضي">تلفون ارضي</option>
                                <option value="انترنت ارضي">انترنت ارضي</option>
                                <option value="أخرى">أخرى</option>
                            </select>
                            <input type="text" name="other_category" placeholder="تصنيف أخر" id="other_category" class="form-control text-muted d-none mt-3">
                        </div>
                        <div class="form-group">
                            <label for="amount" class="text-muted">المبلغ</label>
                            <input type="number" class="form-control text-muted" id="amount" name="amount" placeholder="المبلغ">
                        </div>
                        <div class="form-group">
                            <label for="invoice_img" class="text-muted">صورة الايصال</label>
                            <input type="file" id="invoice_img" class="form-control text-muted" name="invoice_img" accept="image/*">
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
            <div class="alert alert-danger text-center w-50 mx-auto rounded" id="error">
                <p class="mb-0">{{$error}}</p>
            </div>
        @endforeach
    @endif
    <section class="miscellaneouses">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="table" class="table display align-middle table-hover text-center text-muted" data-order='[[ 0, "asc"]]' data-page-length="10">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">التصنيف</th>
                                        <th class="text-center">التصنيف الأخر</th>
                                        <th class="text-center">المبلغ</th>
                                        <th class="text-center">صورة الفاتورة / الإيصال</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i =1 ?>
                                    @foreach ($miscellaneous as $misc)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$misc->category}}</td>
                                            <td>
                                                @if ($misc->other_category)
                                                    {{$misc->other_category}}
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td>{{$misc->amount}}</td>
                                            <td>
                                                @if ($misc->invoice_img)
                                                    <button type="button" class="btn btn-transparent" data-bs-target="#proof_{{$misc->id}}" data-bs-toggle="modal">
                                                        <img src="{{asset('assets/images/miscellaneous/'.$misc->invoice_img)}}" width="60" class="rounded" alt="">
                                                    </button>
                                                    <div class="modal fade" id="proof_{{$misc->id}}"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-0">
                                                                    <img src="{{asset('assets/images/miscellaneous/'.$misc->invoice_img)}}" width="60" class="rounded w-100" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="fw-bold">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editingborder_{{$misc->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editingborder_{{$misc->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تحديث {{$misc->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('miscellaneous.update')}} method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$misc->id}}">
                                                                    <div class="form-group">
                                                                        <label for="category" class="text-muted">التصنيف</label>
                                                                        <select name="category" class="form-select text-muted" id="category" data-misc-id={{$misc->id}}>
                                                                            <option selected>إختر التصنيف</option>
                                                                            <option value="كهرباء" {{$misc->category === 'كهرباء' ? 'selected' : ''}}>كهرباء</option>
                                                                            <option value="مياه" {{$misc->category === 'مياه' ? 'selected' : ''}}>مياه</option>
                                                                            <option value="غاز" {{$misc->category === 'غاز' ? 'selected' : ''}}>غاز</option>
                                                                            <option value="تلفون ارضي" {{$misc->category === 'تلفون ارضي' ? 'selected' : ''}}>تلفون ارضي</option>
                                                                            <option value="انترنت ارضي" {{$misc->category === 'انترنت ارضي' ? 'selected' : ''}}>انترنت ارضي</option>
                                                                            <option value="أخرى" {{$misc->category === 'أخرى' ? 'selected' : ''}}>أخرى</option>
                                                                        </select>
                                                                        @if ($misc->category === 'أخرى')
                                                                            <input type="text" name="other_category" placeholder="تصنيف أخر" id="other_category" class="form-control text-muted mt-3" data-misc-id={{$misc->id}} value="{{$misc->other_category}}">
                                                                        @else
                                                                            <input type="text" name="other_category" placeholder="تصنيف أخر" id="other_category" class="form-control text-muted mt-3" data-misc-id={{$misc->id}} disabled>
                                                                        @endif
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="amount" class="text-muted">المبلغ</label>
                                                                        <input type="number" class="form-control text-muted" value="{{$misc->amount}}" id="amount" name="amount" placeholder="المبلغ">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="invoice_img" class="text-muted">صورة الايصال</label>
                                                                        <input type="file" id="invoice_img" class="form-control text-muted" value="{{$misc->invoice_img}}" name="invoice_img" accept="image/*">
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
                                                {{-- ! Delete ! --}}
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleting_{{$misc->id}}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$misc->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">حذف المقبره {{$misc->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('miscellaneous.delete', $misc->id)}} method="get">
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
    </section>
@endsection
