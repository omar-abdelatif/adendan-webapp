@extends('layouts.master')
@section('title', 'كل المشتركين')
@section('breadcrumb-title')
    <h3>كل المشتركين</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">كل المشتركين</li>
@endsection
@section('script')
    <script src="{{asset('assets/js/form-wizard/form-wizard.js')}}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.ar.js')}}"></script>
@endsection
@section('modals')
    {{-- ! Insert Bulk Subscribers ! --}}
    <button type="button" class="btn btn-success text-dark px-2 py-1" data-bs-toggle="modal" data-bs-target="#bulk_upload">
        <i class="icofont icofont-eye"></i>
        <span class="ms-3">إضافة بالجملة</span>
    </button>
    <div class="modal fade" id="bulk_upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة بالجملة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('subscriber.bulk')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="import" accept=".xlsx, .xls">
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">حفظ البيانات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ! Insert Single Subscriber ! --}}
    <button type="button" class="btn btn-success text-dark px-2 py-1 ms-3" data-bs-toggle="modal" data-bs-target="#add_subscriber">
        <i class="icofont icofont-eye"></i>
        <span class="ms-3">إضافة مشترك جديد</span>
    </button>
    <div class="modal fade" id="add_subscriber" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة مشترك جديد</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body basic-wizard important-validation">
                    <div class="stepper-horizontal" id="stepper1">
                        <div class="stepper-one stepper step">
                            <div class="step-circle d-flex align-items-center justify-content-center">
                                <span class="text-primary">1</span>
                            </div>
                            <div class="step-title">البيانات الشخصية</div>
                            <div class="step-bar-left"></div>
                            <div class="step-bar-right"></div>
                        </div>
                        <div class="stepper-two step">
                            <div class="step-circle d-flex align-items-center justify-content-center">
                                <span class="text-primary">2</span>
                            </div>
                            <div class="step-title">البيانات الدراسية</div>
                            <div class="step-bar-left"></div>
                            <div class="step-bar-right"></div>
                        </div>
                        <div class="stepper-three step">
                            <div class="step-circle d-flex align-items-center justify-content-center">
                                <span class="text-primary">3</span>
                            </div>
                            <div class="step-title">البيانات الوظيفية</div>
                            <div class="step-bar-left"></div>
                            <div class="step-bar-right"></div>
                        </div>
                        <div class="stepper-four step">
                            <div class="step-circle d-flex align-items-center justify-content-center">
                                <span class="text-primary">4</span>
                            </div>
                            <div class="step-title">بيانات الإشتراك</div>
                            <div class="step-bar-left"></div>
                            <div class="step-bar-right"></div>
                        </div>
                        <div class="stepper-five step">
                            <div class="step-circle d-flex align-items-center justify-content-center">
                                <span class="text-primary">5</span>
                            </div>
                            <div class="step-title">النهاية</div>
                            <div class="step-bar-left"></div>
                            <div class="step-bar-right"></div>
                        </div>
                    </div>
                    <form action="{{route('subscribe.store')}}" method="post" id="storeSubscriber" enctype="multipart/form-data">
                        @csrf
                        <div id="msform">
                            <article class="stepper-one row g-3 needs-validation custom-input" style="display: flex;">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="email-basic-wizard">
                                                الأسم الكامل
                                            </label>
                                            <input class="form-control text-white" id="email-basic-wizard" type="text" name="name" placeholder="مثلا: محمد أحمد محمود">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="email-basic-wizard">
                                                اللقب و إسم الشهرة
                                            </label>
                                            <input class="form-control text-white" id="email-basic-wizard" type="text" name="nickname" placeholder="مثلا: محمد أحمد محمود">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="col-lg-6 form-label text-white" for="confirmpasswordwizard">
                                                تاريخ الميلاد
                                            </label>
                                            <input class="datepicker-here form-control text-white digits" name="birthdate" readonly id="confirmpasswordwizard" type="text" placeholder="تاريخ الميلاد" data-language="ar" dir="rtl">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="col-6-6 form-label text-white" for="passwordwizard">
                                                العنوان
                                            </label>
                                            <input class="form-control text-white" name="address" id="passwordwizard" type="text" placeholder="عنوان المشترك">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="col-lg-6 form-label text-white" for="confirmpasswordwizard">
                                                رقم المحمول
                                            </label>
                                            <input class="form-control text-white" id="confirmpasswordwizard" name="mobile_no" type="number" placeholder="رقم المحمول">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="col-lg-6 form-label text-white" for="personalImg">
                                                الصورة الشخصية
                                            </label>
                                            <input class="form-control text-white" name="img" id="personalImg" type="file" accept="image/*">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="col-lg-6 form-label text-white" for="personalImg">
                                                صورة البطاقة الشخصية
                                            </label>
                                            <input class="form-control text-white" name="id_img" id="personalImg" type="file" accept="image/*">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="firstnamewizard">
                                                الرقم القومي
                                            </label>
                                            <input class="form-control text-white" id="firstnamewizard" name="ssn" type="number" placeholder="أدخل الرقم القومي">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="firstnamewizard">
                                                الحالة الإجتماعية
                                            </label>
                                            <input class="form-control text-white" id="firstnamewizard" name="martial_status" type="text" placeholder="الحالة الإجتماعية">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="firstnamewizard">
                                                ت المنزل
                                            </label>
                                            <input class="form-control text-white" id="firstnamewizard" name="home_tel" type="number" placeholder="ت المنزل">
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="stepper-two row g-3 needs-validation custom-input" style="display: none;">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="placeholdername1">المؤهل الدراسي</label>
                                            <input class="form-control text-white" id="placeholdername1" name="educational_qualification" type="text" placeholder="المؤهل الدراسي">
                                        </div>
                                        <div class="col-xxl-4 col-lg-6">
                                            <label class="form-label text-white" for="cardNumber01">تاريخ المؤهل</label>
                                            <input class="datepicker-here form-control text-white digits" name="qualification_date" readonly id="cardNumber01" type="text" placeholder="تاريخ المؤهل" data-language="ar">
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="stepper-three row g-3 needs-validation custom-input" style="display: none;">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="email-basic">
                                                الوظيفة
                                            </label>
                                            <input class="form-control text-white" name="job" id="email-basic" type="text" placeholder="الوظيفة">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="validationCustom996">
                                                جهة العمل
                                            </label>
                                            <input class="form-control text-white" name="job_destination" id="validationCustom996" type="text" placeholder="جهة العمل">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="validationCustom996">
                                                عنوان العمل
                                            </label>
                                            <input class="form-control text-white" name="job_address" id="validationCustom996" type="text" placeholder="عنوان العمل">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label text-white" for="validationCustom996">
                                                ت العمل
                                            </label>
                                            <input class="form-control text-white" name="job_tel" id="validationCustom996" type="text" placeholder="ت العمل">
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="stepper-four row g-3 needs-validation custom-input" style="display: none;">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="validationMembership" class="form-label text-white">نوع العضوية</label>
                                            <select name="membership_type" class="form-select text-white" id="validationMembership">
                                                <option selected>إختار نوع العضوية</option>
                                                <option value="عامل">عامل</option>
                                                <option value="إنتساب">إنتساب</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="validationMemberId" class="form-label text-white">رقم العضوية</label>
                                            <input type="number" name="member_id" class="form-control text-white" placeholder="رقم العضوية" id="validationMemberId">
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="stepper-five row justify-content-center w-100 g-3 needs-validation" style="display: none;">
                                <div class="col-12 m-0">
                                    <div class="successful-form text-white text-center my-4">
                                        <img class="img-fluid" src="{{asset('assets/images/icons8-done.gif')}}" alt="successful">
                                        <h6 class="text-center mt-2">اضغط على تأكيد لإضافة المشترك</h6>
                                    </div>
                                </div>
                            </article>
                            <div id="submitButton"></div>
                        </div>
                    </form>
                    <div class="wizard-footer mt-4 d-flex gap-2 justify-content-end" id="wizard-footer">
                        <button class="btn btn-outline-danger" id="backbtn" onclick="backStep()" disabled="">السابق</button>
                        <button class="btn btn-primary" id="nextbtn" onclick="nextStep()">التالي</button>
                    </div>
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
                        <?php $i =1 ?>
                        <div class="table-responsible">
                            <table id="table" class="table table-hover align-middle text-center table-hover" data-order='[[1, "asc"]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-muted text-center"></th>
                                        <th class="text-muted text-center">#</th>
                                        <th class="text-muted text-center">رقم العضوية</th>
                                        <th class="text-muted text-center">الإسم</th>
                                        <th class="text-muted text-center">حالة الإشتراك</th>
                                        <th class="text-muted text-center">متأخرات</th>
                                        <th class="text-muted text-center">مدة المتأخرات بالسنوات</th>
                                        <th class="text-muted text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-muted text-center">{{$i++}}</td>
                                            <td class="text-muted text-center">{{$member->member_id}}</td>
                                            <td class="text-muted text-center">{{$member->name}}</td>
                                            <td class="text-muted text-center">
                                                @if($member->status == 1)
                                                    <span class="badge rounded-pill badge-success text-muted">الإشتراك مفعل</span>
                                                @elseif($member->status == 0)
                                                    <span class="badge rounded-pill badge-danger text-muted">الإشتراك غير مفعل</span>
                                                @elseif ($member->status == 2)
                                                    <span class="badge rounded-pill badge-dark text-muted">المشترك متوفي</span>
                                                @endif
                                            </td>
                                            @if ($member->delays)
                                                <td class="text-muted text-center">
                                                    <span class="text-muted bg-secondary rounded-pill px-4">{{$member->delays->amount}}</span>
                                                    ج.م
                                                </td>
                                            @else
                                                <td class="text-muted text-center">
                                                    <span class="text-muted bg-success rounded-pill px-3">0</span>
                                                    ج.م
                                                </td>
                                            @endif
                                            <td class="text-center text-muted">
                                                @if ($member->delays)
                                                    {{$member->delays->delay_period}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-success rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">
                                                        {{-- ! Donation ! --}}
                                                        <button type="button" class="btn btn-info px-2 py-1 ms-0" data-bs-toggle="modal" data-bs-target="#donating_{{$member->id}}">
                                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                                        </button>
                                                        {{-- ! Edit Member ! --}}
                                                        <a class="btn btn-warning px-2 py-1" role="button" href={{route('subscriber.details',$member->id)}}>
                                                            <i class="icofont icofont-ui-edit"></i>
                                                        </a>
                                                        {{-- ! History ! --}}
                                                        <a class="btn btn-success px-2 py-1" role="button" href={{route('subscription.history',$member->id)}}>
                                                            <i class="icofont icofont-eye"></i>
                                                        </a>
                                                        {{-- ! Add Delay ! --}}
                                                        @if ($member->status == 2)
                                                            <button type="button" class="btn btn-secondary text-white d-none px-2 py-1" data-bs-toggle="modal" data-bs-target="#add_delay_{{$member->id}}">
                                                                <i class="icofont icofont-plus"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-secondary text-white px-2 py-1" data-bs-toggle="modal" data-bs-target="#add_delay_{{$member->id}}">
                                                                <i class="icofont icofont-plus"></i>
                                                            </button>
                                                        @endif
                                                        {{-- ! Donation History ! --}}
                                                        <a href="{{route('donations.showAll', $member->id)}}" class="btn btn-primary px-2 py-1">
                                                            <i class="fa-solid fa-book-heart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- ! Donations ! --}}
                                                <div class="modal fade" id="donating_{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تبرع من العضو {{$member->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('donations.store')}} method="post">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for="member_id" class="text-muted text-right">رقم العضوية</label>
                                                                                <input type="number" name="member_id" id="member_id" class="form-control" value="{{$member->member_id}}" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                                                                <input type="number" class="form-control" placeholder="رقم الإيصال" id="invoice_no" name="invoice_no">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for="amount" class="text-muted">المبلغ</label>
                                                                                <input type="number" class="form-control" placeholder="المبلغ" id="amount" name="amount">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for="donation_duration" class="text-muted">مدة التبرع</label>
                                                                                <input type="text" class="form-control" placeholder="المده" id="donation_duration" name="donation_duration">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for=donation_type class="text-muted">نوع التبرع</label>
                                                                                <select name=donation_type class="form-select" id=donation_type>
                                                                                    <option value="مادي" selected>مادي</option>
                                                                                    <option value="أخرى" id="other_donation">أخرى</option>
                                                                                </select>
                                                                                <input type="text" class="form-control d-none mt-3" placeholder="نوع التبرع الأخر" id="otherDonation" name="other_donation" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label for="donation_destination" class="text-muted">جهة التبرع</label>
                                                                                <input type="text" class="form-control" placeholder="جهة التبرع" name="donation_destination">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer mt-3">
                                                                        <button type="button" class="btn btn-danger text-muted" data-bs-dismiss="modal">إلغاء</button>
                                                                        <button type="submit" role="button" class="btn btn-primary text-muted">تأكيد</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- ! Add Delay ! --}}
                                                <div class="modal fade" id="add_delay_{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة مديونية للعضو {{$member->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('delays.store')}} method="post">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-muted">رقم العضوية</label>
                                                                                <input type="number" class="form-control text-muted" value="{{$member->member_id}}" name="member_id" placeholder="رقم العضوية" readonly>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-muted">مبلغ المديونية</label>
                                                                                <input type="number" class="form-control text-muted" name="amount" placeholder="إجمالي مبلغ المديونية">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="delay_period" class="text-muted">مدة المدينوية</label>
                                                                                <input type="number" class="form-control text-muted" name="delay_period" placeholder="مدة المدينوية">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger text-muted" data-bs-dismiss="modal">إلغاء</button>
                                                                            <button type="submit" role="button" class="btn btn-primary text-muted">تأكيد</button>
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
