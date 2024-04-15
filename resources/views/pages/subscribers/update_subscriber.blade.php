@extends('layouts.master')
@section('title', 'تعديل مشترك')
@section('breadcrumb-title')
    <h3>تعديل المشترك {{$subscriber->name}}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">
        <a href="{{route('subscriber.all')}}">كل المشتركين</a>
    </li>
    <li class="breadcrumb-item active">تعديل المشترك</li>
@endsection
@section('script')
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.ar.js')}}"></script>
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
                <div class="subscriber_update_form">
                    <form action="{{route('subscribe.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$subscriber->id}}"/>
                        <div id="updateForm py-3">
                            <div class="card card-absolute mt-3">
                                <div class="card-header bg-primary rounded-pill">
                                    <h5 class="txt-light">البيانات الشخصية</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-white" for="email-basic-wizard">
                                                الأسم الكامل
                                            </label>
                                            <input class="form-control text-white" id="email-basic-wizard" type="text" value="{{$subscriber->name}}" name="name" placeholder="مثلا: محمد أحمد محمود">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-white" for="email-basic-wizard">
                                                اللقب و إسم الشهرة
                                            </label>
                                            <input class="form-control text-white" id="email-basic-wizard" type="text" name="nickname" value="{{$subscriber->nickname}}" placeholder="مثلا: محمد أحمد محمود">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="confirmpasswordwizard">
                                                تاريخ الميلاد
                                            </label>
                                            <input class="form-control text-white" name="birthdate" value="{{$subscriber->birthdate}}" id="confirmpasswordwizard" type="date" placeholder="تاريخ الميلاد">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="passwordwizard">
                                                العنوان
                                            </label>
                                            <input class="form-control text-white" name="address" id="passwordwizard" value="{{$subscriber->address}}" type="text" placeholder="عنوان المشترك">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="validatemobilenumber">
                                                رقم المحمول
                                            </label>
                                            <input class="form-control text-white" id="validatemobilenumber" value="{{$subscriber->mobile_no}}" name="mobile_no" type="number" placeholder="رقم المحمول">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="personalImg">
                                                الصورة الشخصية
                                            </label>
                                            <input class="form-control text-white" value="{{$subscriber->img}}" name="img" id="personalImg" type="file" accept="image/*">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="personalImg">
                                                صورة البطاقة الشخصية
                                            </label>
                                            <input class="form-control text-white" value="{{$subscriber->id_img}}" name="id_img" id="personalImg" type="file" accept="image/*">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="firstnamewizard">
                                                الرقم القومي
                                            </label>
                                            <input class="form-control text-white" id="firstnamewizard" value="{{$subscriber->ssn}}" name="ssn" type="number" placeholder="أدخل الرقم القومي">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="firstnamewizard">
                                                الحالة الإجتماعية
                                            </label>
                                            <input class="form-control text-white" id="firstnamewizard" value="{{$subscriber->martial_status}}" name="martial_status" type="text" placeholder="الحالة الإجتماعية">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="firstnamewizard">
                                                ت المنزل
                                            </label>
                                            <input class="form-control text-white" id="firstnamewizard" value="{{$subscriber->home_tel}}" name="home_tel" type="number" placeholder="ت المنزل">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-absolute mt-5">
                                <div class="card-header bg-primary rounded-pill">
                                    <h5 class="txt-light">البيانات الدراسية</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-white" for="placeholdername1">المؤهل الدراسي</label>
                                            <input class="form-control text-white" value="{{$subscriber->educational_qualification}}" id="placeholdername1" name="educational_qualification" type="text" placeholder="المؤهل الدراسي">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-white" for="cardNumber01">تاريخ المؤهل</label>
                                            <input class="form-control text-white" value="{{$subscriber->qualification_date}}" name="qualification_date" id="cardNumber01" type="date" placeholder="تاريخ المؤهل">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-absolute mt-5">
                                <div class="card-header bg-primary rounded-pill">
                                    <h5 class="txt-light">البيانات الوظيفية</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-white" for="email-basic">
                                                الوظيفة
                                            </label>
                                            <input class="form-control text-white" value="{{$subscriber->job}}" name="job" id="email-basic" type="text" placeholder="الوظيفة">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fw-bold text-white" for="validationCustom996">
                                                جهة العمل
                                            </label>
                                            <input class="form-control text-white" value="{{$subscriber->job_destination}}" name="job_destination" id="validationCustom996" type="text" placeholder="جهة العمل">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="validationCustom996">
                                                عنوان العمل
                                            </label>
                                            <input class="form-control text-white" value="{{$subscriber->job_address}}" name="job_address" id="validationCustom996" type="text" placeholder="عنوان العمل">
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label class="form-label fw-bold text-white" for="validationCustom996">
                                                ت العمل
                                            </label>
                                            <input class="form-control text-white" value="{{$subscriber->job_tel}}" name="job_tel" id="validationCustom996" type="number" placeholder="ت العمل">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-absolute mt-5">
                                <div class="card-header bg-primary rounded-pill">
                                    <h5 class="txt-light">البيانات الإشتراك</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 mt-3">
                                            <label for="validationMembership" class="form-label fw-bold text-white">نوع العضوية</label>
                                            <select name="membership_type" class="form-select text-white" id="validationMembership">
                                                <option selected disabled>إختار نوع العضوية</option>
                                                <option value="عامل" {{$subscriber->membership_type === 'عامل' ? 'selected' : ''}}>عامل</option>
                                                <option value="إنتساب" {{$subscriber->membership_type === 'إنتساب' ? 'selected' : ''}}>إنتساب</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mt-3">
                                            <label for="validationMemberId" class="form-label fw-bold text-white">رقم العضوية</label>
                                            <input type="number" value="{{$subscriber->member_id}}" name="member_id" class="form-control text-white" placeholder="رقم العضوية" id="validationMemberId">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card card-absolute mt-5">
                                <div class="card-header bg-primary rounded-pill">
                                    <h5 class="txt-light">البيانات الصحية</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <input type="checkbox" class="checkbox_animated" name="status" id="deathOrNot" {{ $subscriber->status ? 'checked' : '' }}>
                                            <label for="deathOrNot" class="text-center mb-0">هل الشخص متوفي ؟</label>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary w-100 fw-bold mb-4">تأكيد</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
