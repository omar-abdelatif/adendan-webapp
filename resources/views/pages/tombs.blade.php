@php
    $user = Auth::user();
@endphp
@extends('layouts.master')
@section('title', 'كل المقابر')
@section('breadcrumb-title')
    <h3>كل المقابر</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل المقابر</li>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add_cat">إضافة مقبره جديد</button>
    <div class="modal fade" id="add_cat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة مقبره جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action={{route('tomb.store')}} method="post" id="tombForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="title" class="text-muted">إسم المقبره</label>
                                    <input type="text" class="form-control text-muted" id="tombName" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s\d\/\-\.\,]/g, '')" name="title" placeholder="إسم المقبره" required>
                                    <p class="required d-none text-danger mb-0" id="tombReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0" id="tombMsg">يجب أن يكون الإسم باللغة العربية ولا يقل عن 3 أحرف</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="title" class="text-muted">المنطقة</label>
                                    <select name="region" class="form-select text-muted" id="regionSelect" required>
                                        <option selected>المنطقة</option>
                                        <option value="أكتوبر" class="option-control">أكتوبر</option>
                                        <option value="الفيوم" class="option-control">الفيوم</option>
                                        <option value="15مايو" class="option-control">15مايو</option>
                                        <option value="القطامية" class="option-control">القطامية</option>
                                        <option value="الغفير" class="option-control">الغفير</option>
                                        <option value="زينهم" class="option-control">زينهم</option>
                                        <option value="وادي الراحة" class="option-control">وادي الراحة</option>
                                        <option value="القرية" class="option-control">القرية</option>
                                    </select>
                                    <p class="required d-none text-danger fw-bold mb-0" id="regionMsg">يرجى اختيار المنطقة من القائمة أدناه</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="title" class="text-muted">نوع المقبره</label>
                                    <select name="tomb_specialization" class="form-select text-muted" required>
                                        <option selected>نوع المقبره</option>
                                        <option value="عيون" class="option-control">عيون</option>
                                        <option value="لحد" class="option-control">لحد</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="title" class="text-muted">تصنيف المقبره</label>
                                    <select name="tomb_type" class="form-select text-muted" required>
                                        <option selected>تصنيف المقبره</option>
                                        <option value="رجال" class="option-control">رجال</option>
                                        <option value="سيدات" class="option-control">سيدات</option>
                                        <option value="مختلط" class="option-control">مختلط</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tomb_guard_name" class="text-muted">إسم التربي</label>
                                    <input type="text" id="tomb_guard_name" class="form-control text-muted" pattern="[\u0600-\u06FF\s]{10,}" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" name="tomb_guard_name" placeholder="إسم التربي">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tomb_guard_number" class="text-muted">رقم المحمول</label>
                                    <input type="number" id="tomb_guard_number" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control text-muted" name="tomb_guard_number" placeholder="رقم المحمول">
                                    <p class="required d-none text-danger mb-0" id="guardMob">يجب ان يكون رقم المحمول مكون من 11 رقم</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-muted">الموقع</label>
                                    <input type="url" name="location" id="location" placeholder="موقع المقبره" class="form-control text-muted" required>
                                    <p class="d-none required text-danger" id="locationReq">حقل الموقع مطلوب</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                    <button type="submit" role="button" id="tombSubmit" class="btn btn-primary">تأكيد</button>
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
            <div class="alert alert-danger text-center w-50 mx-auto rounded" id="error">
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
                            <?php $i = 1 ?>
                            <table class="table display align-middle text-center table-hover" id="table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <td class="text-center text-muted">#</td>
                                        <td class="text-center text-muted">إسم المقبره</td>
                                        <td class="text-center text-muted">تصنيفف المقبره</td>
                                        <td class="text-center text-muted">التخصص</td>
                                        <td class="text-center text-muted">المنطقة</td>
                                        <td class="text-center text-muted">إسم التربي</td>
                                        <td class="text-center text-muted">رقم المحمول</td>
                                        <td class="text-center text-muted">الموقع</td>
                                        <td class="text-center text-muted">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tombs as $tomb)
                                        <tr>
                                            <td class="text-muted">{{$i++}}</td>
                                            <td class="text-muted">{{$tomb->title}}</td>
                                            <td class="text-muted">{{$tomb->tomb_type}}</td>
                                            <td class="text-muted">{{$tomb->tomb_specialization}}</td>
                                            <td class="text-muted">{{$tomb->region}}</td>
                                            <td class="text-muted">
                                                @if ($tomb->tomb_guard_name)
                                                    {{$tomb->tomb_guard_name}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                @if ($tomb->tomb_guard_number)
                                                    {{$tomb->tomb_guard_number}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                @if ($tomb->location)
                                                    <a href="{{$tomb->location}}" class="btn">
                                                        <i class="fa-solid fa-link text-muted fs-6"></i>
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{-- ! Update ! --}}
                                                <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editingborder_{{$tomb->id}}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <div class="modal fade" id="editingborder_{{$tomb->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">تحديث المقبره {{$tomb->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('tomb.update')}} method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{$tomb->id}}>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="text-muted">إسم المقبره</label>
                                                                                <input type="text" class="form-control text-muted" value="{{$tomb->title}}" name="title" placeholder="إسم المقبره">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label for="title" class="text-muted">المنطقة</label>
                                                                                <select name="region" class="form-select text-muted">
                                                                                    <option selected>إختر المنطقة</option>
                                                                                    <option value="أكتوبر" class="option-control" {{$tomb->region === 'أكتوبر' ? 'selected' : ''}}>أكتوبر</option>
                                                                                    <option value="الفيوم" class="option-control" {{$tomb->region === 'الفيوم' ? 'selected' : ''}}>الفيوم</option>
                                                                                    <option value="15مايو" class="option-control" {{$tomb->region === '15مايو' ? 'selected' : ''}}>15مايو</option>
                                                                                    <option value="القطامية" class="option-control" {{$tomb->region === 'القطامية' ? 'selected' : ''}}>القطامية</option>
                                                                                    <option value="الغفير" class="option-control" {{$tomb->region === 'الغفير' ? 'selected' : ''}}>الغفير</option>
                                                                                    <option value="زينهم" class="option-control" {{$tomb->region === 'زينهم' ? 'selected' : ''}}>زينهم</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-muted">نوع المقبره</label>
                                                                                <select name="tomb_type" class="form-select text-muted" required>
                                                                                    <option selected>نوع المقبره</option>
                                                                                    <option value="رجال" class="option-control" {{$tomb->tomb_type === 'رجال' ? 'selected' : ''}}>رجال</option>
                                                                                    <option value="سيدات" class="option-control" {{$tomb->tomb_type === 'سيدات' ? 'selected' : ''}}>سيدات</option>
                                                                                    <option value="مختلط" class="option-control" {{$tomb->tomb_type === 'مختلط' ? 'selected' : ''}}>مختلط</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-muted">تصنيفف المقبره</label>
                                                                                <select name="tomb_specialization" class="form-select text-muted" required>
                                                                                    <option selected>تصنيفف المقبره</option>
                                                                                    <option value="عيون" class="option-control" {{$tomb->tomb_specialization === 'عيون' ? 'selected' : ''}}>عيون</option>
                                                                                    <option value="لحد" class="option-control" {{$tomb->tomb_specialization === 'لحد' ? 'selected' : ''}}>لحد</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="tomb_guard_name" class="text-muted">إسم التربي</label>
                                                                                <input type="text" id="tomb_guard_name" class="form-control text-muted" value="{{$tomb->tomb_guard_name}}" name="tomb_guard_name" placeholder="إسم التربي">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="tomb_guard_number" class="text-muted">رقم المحمول</label>
                                                                                <input type="number" id="tomb_guard_number" class="form-control text-muted" value="{{$tomb->tomb_guard_number}}" name="tomb_guard_number" placeholder="رقم المحمول">
                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <label class="text-muted">الموقع</label>
                                                                                <input type="text" name="location" value="{{$tomb->location}}" placeholder="موقع المقبره" class="form-control text-muted">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                                                                <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- ! Delete ! --}}
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleting_{{$tomb->id}}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleting_{{$tomb->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">حذف المقبره {{$tomb->title}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('tomb.delete', $tomb->id)}} method="get">
                                                                    @csrf
                                                                    <div class="form-title text-center">
                                                                        <h1 class="text-muted">هل أنت متأكد من الحذف</h1>
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
