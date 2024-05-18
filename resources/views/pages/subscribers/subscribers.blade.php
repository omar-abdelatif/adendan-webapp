@php
    $user = Auth::user();
@endphp
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
    <script>
        let selectedElements = document.querySelectorAll("[data-donation-id]")
        selectedElements.forEach((selectElement) => {
            let otherCraftInput = document.querySelector(`input[name="other_donation"][data-donation-id="${selectElement.dataset.donationId}"]`);
            function handleDonation() {
                let selectedOption = selectElement.options[selectElement.selectedIndex].value;
                if (selectedOption === "أخرى") {
                    otherCraftInput.disabled = false;
                    otherCraftInput.classList.remove('d-none')
                } else {
                    otherCraftInput.value = "";
                    otherCraftInput.disabled = true;
                    otherCraftInput.removeAttribute("value");
                    otherCraftInput.classList.add('d-none')
                }
            }
            selectElement.addEventListener("change", function () {
                handleDonation();
            });
        })
    </script>
@endsection
@section('modals')
    <div class="btn-group" role="group">
        <button class="btn btn-success rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button>
        <div class="dropdown-menu text-center py-2 px-3" style="left: 0px;top: 40px;" aria-labelledby="btnGroupVerticalDrop1">
            {{-- ! Insert Single Subscriber ! --}}
            <button type="button" class="btn btn-success px-2 py-1 mb-2" data-bs-toggle="modal" data-bs-target="#add_subscriber">
                <i class="icofont icofont-plus fw-bold"></i>
                <span>إضافة مشترك جديد</span>
            </button>
            {{-- ! Insert Bulk Subscribers && Insert Bulk Delay ! --}}
            @if ($user->role === 'subscriptions')
                <button type="button" class="btn btn-success px-2 py-1 mb-2 d-none" data-bs-toggle="modal" data-bs-target="#bulk_upload">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة مشتركين بالجملة</span>
                </button>
                <button type="button" class="btn btn-success px-2 py-1 mb-2 d-none" data-bs-toggle="modal" data-bs-target="#insert_bulk_delay">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة متأخرات بالجملة</span>
                </button>
            @elseif ($user->role === 'media')
                <button type="button" class="btn btn-success px-2 py-1 mb-2 d-none" data-bs-toggle="modal" data-bs-target="#bulk_upload">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة مشتركين بالجملة</span>
                </button>
                <button type="button" class="btn btn-success px-2 py-1 mb-2 d-none" data-bs-toggle="modal" data-bs-target="#insert_bulk_delay">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة متأخرات بالجملة</span>
                </button>
            @else
                <button type="button" class="btn btn-success px-2 py-1 mb-2" data-bs-toggle="modal" data-bs-target="#bulk_upload">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة مشتركين بالجملة</span>
                </button>
                <button type="button" class="btn btn-success px-2 py-1 mb-2" data-bs-toggle="modal" data-bs-target="#insert_bulk_delay">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة متأخرات بالجملة</span>
                </button>
            @endif
            {{-- ! Insert Bulk Subscription Delays Per Year ! --}}
            <button type="button" class="btn btn-success px-2 py-1 mb-2" data-bs-toggle="modal" data-bs-target="#bulk_delay_subscribers">
                <i class="icofont icofont-plus fw-bold"></i>
                <span>إضافة مديونية على كل الأعضاء</span>
            </button>
            {{-- ! Insert Bulk Donations ! --}}
            @if ($user->role === 'subscriptions')
                <button type="button" class="btn btn-success px-2 py-1 mb-2 d-none" data-bs-toggle="modal" data-bs-target="#insert_bulk_delay">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة متأخرات التبرعات بالجملة</span>
                </button>
            @elseif ($user->role === 'media')
                <button type="button" class="btn btn-success px-2 py-1 mb-2 d-none" data-bs-toggle="modal" data-bs-target="#insert_bulk_delay">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة متأخرات التبرعات بالجملة</span>
                </button>
            @else
                <button type="button" class="btn btn-success px-2 py-1 mb-2" data-bs-toggle="modal" data-bs-target="#insert_bulk_delay">
                    <i class="icofont icofont-plus fw-bold"></i>
                    <span>إضافة متأخرات التبرعات بالجملة</span>
                </button>
            @endif
            {{-- ! Insert Bulk Donations On Subscribers ! --}}
            <button type="button" class="btn btn-success px-2 py-1 mb-2" data-bs-toggle="modal" data-bs-target="#insert_bulk_donation">
                <i class="icofont icofont-plus fw-bold"></i>
                <span>إضافة مدينوية التبرعات على كل المشتركين</span>
            </button>
        </div>
    </div>
    {{-- ! Insert Single Subscriber ! --}}
    <div class="modal fade" id="add_subscriber" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header align-content-center">
                    <h1 class="modal-title fs-5 text-white mb-0" id="exampleModalLabel">إضافة مشترك جديد</h1>
                    <div class="yearly-cost px-2">
                        <span class="fw-bold rounded-pill badge badge-warning text-dark fs-6">تكلفة الإشتراك = {{$cost}} ج.م لعام {{$year}}</span>
                    </div>
                    <div class="current-sub-cost px-2">
                        <span class="fs-6 fw-bold badge badge-success rounded-pill"> الإشتراك الحالي للعضو الجديد: {{$currentSubCost + 50}} ج.م</span>
                    </div>
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
                            <article class="stepper-one row g-3 custom-input" style="display: flex;">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="form-label text-muted" for="name">
                                                    الأسم الكامل
                                                </label>
                                                <input class="form-control text-muted" id="name" type="text" name="name" placeholder="أدخل الأسم باللغة العربية" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" pattern="[\u0600-\u06FF\s]{3,}" required>
                                                <p id="nameMsgRequired" class="d-none required mb-0">حقل الإسم مطلوب</p>
                                                <p id="nameMsg" class="required d-none mb-0">الأسم باللغة العربية فقط ولا يقل عن 3 أحرف</p>
                                            </div>
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="form-label text-muted" for="nickname">
                                                    اللقب و إسم الشهرة
                                                </label>
                                                <input class="form-control text-muted" id="nickname" type="text" name="nickname" pattern="[\u0600-\u06FF\s]{5,}" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" placeholder="مثلا: محمد أحمد محمود">
                                                <p class="required d-none text-danger mb-0" id="nickReq">هذا الحقل مطلوب</p>
                                                <p class="required d-none text-danger mb-0" id="nickMsg">يجب ان يكون حقل اللقب باللغة العربية ولا يقل عن 5 احرف</p>
                                            </div>
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="form-label text-muted" for="confirmpasswordwizard">
                                                    تاريخ الميلاد
                                                </label>
                                                <input class="datepicker-here form-control text-muted digits" id="birthdate" name="birthdate" readonly id="confirmpasswordwizard" type="text" placeholder="تاريخ الميلاد" data-language="ar" dir="rtl" required>
                                                <p id="birthdateMsgRequired" class="required d-none required mb-0">حقل تاريخ الميلاد مطلوب</p>
                                                <p id="birthdateMsg" class="required d-none mb-0">يجب إدخال التاريخ بصيغة صحيحة</p>
                                            </div>
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="col-6-6 form-label text-muted" for="address">
                                                    العنوان
                                                </label>
                                                <input class="form-control text-muted" name="address" id="address" type="text" pattern="[\u0600-\u06FF\s]{5,}" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" placeholder="عنوان المشترك">
                                                <p class="required d-none mb-0 text-danger" id="addressReq">هذا الحقل مطلوب</p>
                                                <p class="required d-none mb-0 text-danger" id="addressMsg">يجب ان يكون العنوان باللغة العربية</p>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label text-muted" for="confirmpasswordwizard">
                                                    رقم المحمول
                                                </label>
                                                <input type="text" id="mobile_no" name="mobile_no" maxlength="11" class="form-control text-muted" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="أدخل رقم المحمول" required>
                                                <p id="mobileMsgRequired" class="d-none required mb-0">حقل الرقم المحمول مطلوب</p>
                                                <p id="mobileMsg" class=" required d-none mb-0">يجب ان بكون رقم المحمول 11 رقماً لا غير</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="form-label text-muted" for="personalImg">
                                                    الصورة الشخصية
                                                </label>
                                                <input class="form-control text-muted" name="img" id="personalImg" type="file" accept="image/*">
                                                <p class="required d-none fw-bold text-danger mb-0" id="personalimgReq">هذا الحقل مطلوب</p>
                                                <p class="required d-none fw-bold text-danger mb-0" id="personalimgExt">يجب ان يكون امتداد الصورة [ jpg, png, jpeg, webp ]</p>
                                                <p class="required d-none fw-bold text-danger mb-0" id="personalimgSize">يجب ان يكون حجم الصورة اقل من 2 ميجا</p>
                                            </div>
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="form-label text-muted" for="idImg">
                                                    صورة البطاقة الشخصية
                                                </label>
                                                <input class="form-control text-muted" name="id_img" id="idImg" type="file" accept="image/*">
                                                <p class="required d-none fw-bold text-danger mb-0" id="idimgReq">هذا الحقل مطلوب</p>
                                                <p class="required d-none fw-bold text-danger mb-0" id="idimgExt">يجب ان يكون امتداد الصورة [ jpg, png, jpeg, webp ]</p>
                                                <p class="required d-none fw-bold text-danger mb-0" id="idimgSize">يجب ان يكون حجم الصورة اقل من 2 ميجا</p>
                                            </div>
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="form-label text-muted" for="ssn">
                                                    الرقم القومي
                                                </label>
                                                <input type="text" id="ssn" name="ssn" maxlength="14" class="form-control text-muted" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="أدخل الرقم القومي" required>
                                                <p id="ssnMsgRequired" class="d-none required mb-0">حقل الرقم القومي مطلوب</p>
                                                <p id="ssnMsg" class="d-none mb-0">يجب ان بكون الرقم القومي 14 رقماً لا غير</p>
                                            </div>
                                            <div class="form-group mb-lg-3 mb-md-2 mb-sm-1">
                                                <label class="form-label text-muted" for="martial_status">
                                                    الحالة الإجتماعية
                                                </label>
                                                <select name="martial_status" id="martial_status" class="form-select">
                                                    <option selected disabled>الحالة الإجتماعية</option>
                                                    <option value="أعزف">أعزف</option>
                                                    <option value="متزوج">متزوج</option>
                                                    <option value="أرمل">أرمل</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label text-muted" for="home_tel">
                                                    ت المنزل
                                                </label>
                                                <input class="form-control text-muted" id="home_tel" name="home_tel" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="ت المنزل">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="stepper-two row g-3 needs-validation custom-input" style="display: none;">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label text-white" for="placeholdername1">المؤهل الدراسي</label>
                                                <input class="form-control text-white" id="placeholdername1" name="educational_qualification" pattern="[\u0600-\u06FF\s]{5,}" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" type="text" placeholder="المؤهل الدراسي">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label text-white" for="cardNumber01">تاريخ المؤهل</label>
                                                <input class="datepicker-here form-control text-white digits" name="qualification_date" readonly id="cardNumber01" type="text" placeholder="تاريخ المؤهل" data-language="ar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="stepper-three row g-3 needs-validation custom-input" style="display: none;">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label text-muted" for="email-basic">
                                                    الوظيفة
                                                </label>
                                                <input class="form-control text-muted" name="job" pattern="[\u0600-\u06FF\s]{5,}" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" id="email-basic" type="text" placeholder="الوظيفة">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label text-muted" for="validationCustom996">
                                                    جهة العمل
                                                </label>
                                                <input class="form-control text-muted" name="job_destination" pattern="[\u0600-\u06FF\s]{5,}" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" id="validationCustom996" type="text" placeholder="جهة العمل">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label text-muted" for="validationCustom996">
                                                    عنوان العمل
                                                </label>
                                                <input class="form-control text-muted" name="job_address" pattern="[\u0600-\u06FF\s]{5,}" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" id="validationCustom996" type="text" placeholder="عنوان العمل">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label text-muted" for="validationCustom996">
                                                    ت العمل
                                                </label>
                                                <input class="form-control text-muted" name="job_tel" id="validationCustom996" oninput="this.value = this.value.replace(/[^0-9]/g, '')" type="text" placeholder="ت العمل">
                                            </div>
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
                                                <option selected disabled>إختار نوع العضوية</option>
                                                <option value="عامل">عامل</option>
                                                <option value="إنتساب">إنتساب</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="validationMemberId" class="form-label text-white">رقم العضوية</label>
                                            @if (!is_null($newMemberId))
                                                <input type="number" name="member_id" class="form-control text-white" value="{{$newMemberId}}" placeholder="رقم العضوية" id="validationMemberId" readonly>
                                            @else
                                                <input type="number" name="member_id" class="form-control text-white" placeholder="رقم العضوية" id="validationMemberId" readonly>
                                            @endif
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="invoice_no" class="text-muted">رقم إيصال الدفع</label>
                                            <input type="text" name="invoice_no" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control text-muted" id="invoice_no" placeholder="رقم إيصال الدفع">
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
                        <button class="btn btn-outline-danger" id="backbtn" onclick="backStepFunction()" disabled>السابق</button>
                        <button class="btn btn-primary" id="nextbtn" onclick="nextStepFunction()">التالي</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ! Insert Bulk Subscribers ! --}}
    <div class="modal fade" id="bulk_upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة بالجملة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('subscriber.bulk')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="import" accept=".xlsx, .xls">
                        </div>
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">حفظ البيانات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ! Insert Bulk Subscription Delays Per Year ! --}}
    <div class="modal fade" id="bulk_delay_subscribers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة مديونية بالجملة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('delays.costbyyear')}}" method="post" id="debtForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="costYear" class="text-muted">السنة</label>
                                    <select name="year" id="costYear" class="form-select text-muted" required>
                                        <option selected disabled>السنة</option>
                                        @foreach ($years as $year)
                                            <option value="{{$year->year}}">{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                    <p class="required text-danger mb-0 d-none fw-bold" id="costYearMsg">يجب الإختيار من القائمة أعلاه</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="yearly_cost" class="text-muted">المبلغ</label>
                                    <input type="text" name="yearly_cost" maxlength="4" minlength="2" id="yearly_cost" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control" placeholder="المبلغ" required>
                                    <p class="required d-none text-danger mb-0 fw-bold" id="costReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0 fw-bold" id="costMsg">يجب ان يكون اقصى رقم هو 4 ارقام</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" role="button" id="debtSubmit" class="btn btn-primary">تأكيد</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ! Insert Bulk Delay With Excel ! --}}
    {{-- <div class="modal fade" id="insert_bulk_delay" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة متأخرات بالجملة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('bulk_subscriber_delay')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="file" class="form-control" name="import-delay" accept=".xlsx, .xls">
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">حفظ البيانات</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- ! Insert Bulk Donations Modal ! --}}
    <div class="modal fade" id="insert_bulk_delay" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">إضافة متأخرات التبرعات بالجملة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('bulk_subscriber_delay')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="file" class="form-control" name="import-delay" accept=".xlsx, .xls">
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">حفظ البيانات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ! Insert Bulk Donations On Subscribers Modal ! --}}
    <div class="modal fade" id="insert_bulk_donation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="insert-delay">إضافة مدينوية التبرعات على كل المشتركين</h1>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('delays.uploadDonations')}}" method="post" id="DonationDebtForm">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="delay_name" class="text-muted">سبب المديونية</label>
                                    <input type="text" class="form-control text-muted" name="donation_category" placeholder="سبب المديونية" id="delay_reason" oninput="this.value = this.value.replace(/[^\u0600-\u06FF\s]/g, '')" pattern="[\u0600-\u06FF\s]{3,}" required>
                                    <p class="required d-none text-danger mb-0 fw-bold fs-6" id="reasonReq">هذا الحقل مطلوب</p>
                                </div>
                                <div class="form-group">
                                    <label for="delay_amount" class="text-muted">مبلغ المديونية</label>
                                    <input type="text" class="form-control text-muted" name="delay_amount" placeholder="مبلغ المديونية" id="delay_amount" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="2" required>
                                    <p class="required d-none text-danger mb-0 fw-bold fs-6" id="DelayAmountReq">هذا الحقل مطلوب</p>
                                    <p class="required d-none text-danger mb-0 fw-bold fs-6" id="DelayAmountMsg">يجب ان يكون المبلغ مكون من 2 رقم على الاقل</p>
                                </div>
                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                    <button type="submit" role="button" id="DonationDebtSubmit" class="btn btn-primary">تأكيد</button>
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
                <div class="card">
                    <div class="card-body">
                        <?php $i =1 ?>
                        <div class="table-responsible">
                            <table id="table" class="table table-hover align-middle text-center table-hover" data-order='[[0, "asc"]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-muted text-center">#</th>
                                        <th class="text-muted text-center">رقم العضوية</th>
                                        <th class="text-muted text-center">الإسم</th>
                                        <th class="text-muted text-center">حالة الإشتراك</th>
                                        <th class="text-muted text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td class="text-muted text-center">{{$i++}}</td>
                                            <td class="text-muted text-center">{{$member->member_id}}</td>
                                            <td class="text-muted text-center">{{$member->name}}</td>
                                            <td class="text-muted text-center">
                                                @if($member->status == 0)
                                                    <span class="badge rounded-pill badge-danger text-white">الإشتراك غير مفعل</span>
                                                @elseif($member->status == 1)
                                                    <span class="badge rounded-pill badge-success text-dark">الإشتراك مفعل</span>
                                                @elseif ($member->status == 2)
                                                    <span class="badge rounded-pill badge-dark text-white">المشترك متوفي</span>
                                                @elseif ($member->status == 3)
                                                    <span class="badge rounded-pill badge-warning text-dark">الإشتراك معلق</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-info  rounded ms-0" id="btnGroupVerticalDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu text-center py-2 px-3" aria-labelledby="btnGroupVerticalDrop1">
                                                        {{-- ! History ! --}}
                                                        @if ($user->role === 'subscriptions')
                                                            <a class="btn btn-primary px-2 py-1" title="الإشتراكات السابقة" role="button" href={{route('subscriptionRole.subscription.history',$member->id)}}>
                                                                <i class="icofont icofont-eye"></i>
                                                            </a>
                                                        @elseif ($user->role === 'media')
                                                            <a class="btn btn-primary px-2 py-1" title="الإشتراكات السابقة" role="button" href={{route('subscription.history',$member->id)}}>
                                                                <i class="icofont icofont-eye"></i>
                                                            </a>
                                                        @else
                                                            <a class="btn btn-primary px-2 py-1" title="الإشتراكات السابقة" role="button" href={{route('subscription.history',$member->id)}}>
                                                                <i class="icofont icofont-eye"></i>
                                                            </a>
                                                        @endif
                                                        {{-- ! Edit Member ! --}}
                                                        @if ($user->role === 'subscriptions')
                                                            <a class="btn btn-warning px-2 py-1" title="تعديل البيانات" role="button" href={{route('subscriptionRole.subscriber.details',$member->id)}}>
                                                                <i class="icofont icofont-ui-edit"></i>
                                                            </a>
                                                        @elseif ($user->role === 'media')
                                                            <a class="btn btn-warning px-2 py-1" title="تعديل البيانات" role="button" href={{route('subscriptionRole.subscriber.details',$member->id)}}>
                                                                <i class="icofont icofont-ui-edit"></i>
                                                            </a>
                                                        @else
                                                            <a class="btn btn-warning px-2 py-1" title="تعديل البيانات" role="button" href={{route('subscriber.details',$member->id)}}>
                                                                <i class="icofont icofont-ui-edit"></i>
                                                            </a>
                                                        @endif
                                                        {{-- ! Donation History ! --}}
                                                        @if ($user->role === 'subscriptions')
                                                            <a href="{{route('subscriptionRole.donations.showAll', $member->id)}}" title="التبرعات السابقة" class="btn btn-primary px-2 py-1">
                                                                <i class="fa-solid fa-book-heart"></i>
                                                            </a>
                                                        @elseif ($user->role === 'media')
                                                            <a href="{{route('donations.showAll', $member->id)}}" title="التبرعات السابقة" class="btn btn-primary px-2 py-1">
                                                                <i class="fa-solid fa-book-heart"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{route('donations.showAll', $member->id)}}" title="التبرعات السابقة" class="btn btn-primary px-2 py-1">
                                                                <i class="fa-solid fa-book-heart"></i>
                                                            </a>
                                                        @endif
                                                        {{-- ! Donation ! --}}
                                                        <button type="button" class="btn btn-info px-2 py-1 ms-0" title="تبرع جديد" data-bs-toggle="modal" data-bs-target="#newdonating_{{$member->id}}">
                                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                                        </button>
                                                        {{-- ! Add Subscription ! --}}
                                                        {{-- <button type="button" class="btn btn-success fw-bold px-2 py-1" data-bs-toggle="modal" data-bs-target="#add_subs_{{$member->id}}">
                                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                                        </button> --}}
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="newdonating_{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تبرع من العضو {{$member->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('donations.store')}} method="post">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="member_id" class="text-muted text-right">رقم العضوية</label>
                                                                                <input type="number" name="member_id" id="member_id" class="form-control" value="{{$member->member_id}}" readonly>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="invoice_no" class="text-muted">رقم الإيصال</label>
                                                                                <input type="number" class="form-control" placeholder="رقم الإيصال" id="invoice_no" name="invoice_no">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="donation_type" class="text-muted">نوع التبرع</label>
                                                                                <select name="donation_type" class="form-select" id="donation_type" data-donation-id="{{$member->id}}">
                                                                                    <option value="" selected disabled>نوع التبرع</option>
                                                                                    <option value="مادي">مادي</option>
                                                                                    <option value="أخرى" id="other_donation">أخرى</option>
                                                                                </select>
                                                                                <select name="donation_category" id="category-donation-type" class="text-muted form-select mt-3 d-none" data-donation-id={{$member->id}} disabled>
                                                                                    <option selected disabled>-- إختر نوع التبرع المادي --</option>
                                                                                    <option value="تبرع تنمية">تبرع تنمية</option>
                                                                                    <option value="تبرع إنتساب">تبرع إنتساب</option>
                                                                                    <option value="تبرع زكاة مال">تبرع زكاة مال</option>
                                                                                    <option value="تبرع زكاة فطر">تبرع زكاة فطر</option>
                                                                                    <option value="تبرع كفالة أيتام">تبرع كفالة أيتام</option>
                                                                                </select>
                                                                                <input type="text" class="form-control mt-3 d-none" placeholder="نوع التبرع الأخر" data-donation-id="{{$member->id}}" id="otherDonation" name="other_donation" disabled>
                                                                                <input type="number" class="form-control mt-3 d-none" placeholder="المبلغ" data-donation-id="{{$member->id}}" id="otherDonation" name="amount" disabled>
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
                                                {{-- ! Add Subscription ! --}}
                                                {{-- <div class="modal fade" id="add_subs_{{$member->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">تسديد إشتراك أو مديونية للعضو {{$member->name}}</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action={{route('subscription.store')}} method="post">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-muted">رقم العضوية</label>
                                                                                <input type="number" class="form-control text-muted" value="{{$member->member_id}}" name="member_id" placeholder="رقم العضوية" readonly>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="title" class="text-muted">رقم الإيصال</label>
                                                                                <input type="number" class="form-control text-muted" name="invoice_no" placeholder="رقم الإيضال">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="payment_type" class="text-muted">نوع المدفوعات</label>
                                                                                <select name="payment_type" class="form-select text-muted" id="payment_type" data-payment-id="{{$member->id}}">
                                                                                    <option selected>إختر نوع المدفوعات</option>
                                                                                    <option value="إشتراك">إشتراك</option>
                                                                                    <option value="متأخرات">متأخرات</option>
                                                                                </select>
                                                                                <input type="number" class="form-control text-muted d-none mt-3" id="subscriptionCost" name="subscription_cost" data-payment-id="{{$member->id}}" placeholder="أدخل مبلغ الإشتراك">
                                                                                <input type="text" class="form-control text-muted d-none mt-3" id="subscriptionPeriod" name="period" data-payment-id="{{$member->id}}" placeholder="مدة الإشتراك" min="2000" max="3000">
                                                                                <input type="number" class="form-control text-muted d-none mt-3" id="delayAmount" name="delays_period" data-payment-id="{{$member->id}}" placeholder="أدخل مبلغ المديونية">
                                                                                <input type="number" class="form-control text-muted mt-3 d-none" id="delayPeriod" name="delays" data-payment-id="{{$member->id}}" id="delayPeriod" placeholder="مدة المديونية">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إلغاء</button>
                                                                            <button type="submit" role="button" class="btn btn-primary">تأكيد</button>
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
