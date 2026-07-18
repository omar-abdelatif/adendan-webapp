@extends('layouts.master')
@section('title', 'الرسائل')
@section('breadcrumb-title')
    <h3>الرسائل</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">الرئيسية</li>
    <li class="breadcrumb-item active">الرسائل</li>
@endsection
@section('script')
    <script>
        window.smsRoutes = {
            storeMsg: "{{ route('sms.storeMsg') }}",
            balance:  "{{ route('sms.balance') }}"
        };
        window.csrfToken = "{{ csrf_token() }}";
        window.arabicOnly = function (input) {
            input.value = input.value.replace(/[^\u0600-\u06FF\s]/g, '');
        };
        function toggleCondolence() {
            const show = document.getElementById('has_condolence').checked;
            document.getElementById('condolence_options').style.display = show ? 'block' : 'none';
            buildMsg();
        }
        function getSelectedDays() {
            const checked = document.querySelectorAll('.day-check:checked');
            return Array.from(checked).map(el => el.value);
        }
        window.buildMsg = function () {
            const gender    = document.getElementById('gender').value;
            const name      = document.getElementById('name').value.trim();
            const dPlace    = document.getElementById('death_place').value;
            const dAddr     = document.getElementById('death_address').value.trim();
            const prayer    = document.getElementById('prayer_time').value;
            const burial    = document.getElementById('burial_place').value.trim();
            const hasCond   = document.getElementById('has_condolence').checked;
            const men       = document.getElementById('men').checked;
            const women     = document.getElementById('women').checked;
            const days      = window.getSelectedDays();
            const womenText = document.getElementById('women_condolence_text').value.trim();
            const mosque    = document.getElementById('mosque_name').value;
            document.getElementById('men_days').style.display   = men   ? 'block' : 'none';
            document.getElementById('women_text').style.display = women ? 'block' : 'none';
            if (!name) {
                // document.getElementById('sms_preview').textContent = '—';
                document.querySelector('.sms_preview').textContent = '—';
                window.updateCounter('');
                return;
            }
            let msg = `${gender} ${name} ${dPlace}`;
            if (dAddr) msg += ` ${dAddr}`;
            msg += ` و صلاة الجنازة ${prayer}`;
            if (mosque) msg += ` بـ${mosque}`;
            if (burial) msg += `والدفن ب${burial}`;
            if (!hasCond) {
                msg += ' ولا يوجد عزاء للرجال ولا للسيدات';
            } else {
                if (men && women) {
                    let menText = ' وعزاء الرجال';
                    if (days.length > 0) menText += ` ${days.join(' و')} بالمقر`;
                    else menText += ' بالمقر';
                    msg += menText;
                    if (womenText) msg += ` وعزاء السيدات ${womenText}`;
                } else if (men && !women) {
                    let menText = ' وعزاء الرجال';
                    if (days.length > 0) menText += ` ${days.join(' و')} بالمقر`;
                    else menText += ' بالمقر';
                    msg += `${menText} ولا عزاء للسيدات`;
                } else if (women && !men) {
                    if (womenText) msg += ` وعزاء السيدات ${womenText} ولا عزاء للرجال`;
                } else {
                    msg += ' وعزاء';
                }
            }
            // document.getElementById('sms_preview').textContent = msg;
            document.querySelector('.sms_preview').textContent = msg;
            document.getElementById('msg_content').value = msg;
            window.updateCounter(msg);
        }
        function updateCounter(msg) {
            const len = msg.length;
            const sms = len <= 70 ? 1 : len <= 134 ? 2 : 3;

            document.getElementById('char_count').textContent = len;
            document.getElementById('sms_count').textContent  = sms;

            const counter = document.getElementById('sms_counter');
            counter.className = len > 134 ? 'text-danger' : 'text-muted';
        }
    </script>
    <script src="{{asset('assets/js/sms.js')}}"></script>
@endsection
@section('modals')
    <button type="button" class="btn btn-success" title="إضافة مشتركين بالجملة" data-bs-toggle="modal" data-bs-target="#add_new">مشتركين بالجملة</button>
    <div class="modal fade" id="add_new" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إضافة مشتركين بالجملة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('sms.bulkstore')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="import-subscriber" accept=".xlsx, .xls">
                        </div>
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">تسجيل البيانات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#send_msg">إرسال رسالة</button>
    <div class="modal fade" id="send_msg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">إرسال رسالة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('sms.storeMsg')}}" id="smsForm" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label text-muted">اسم المتوفي (ثلاثي)</label>
                                    <input type="text" id="name" class="form-control" placeholder="محمد احمد محمود" pattern="[\u0600-\u06FF\s]+" oninput="arabicOnly(this); buildMsg()">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="gender" class="form-label text-muted">جنس المتوفي</label>
                                    <select id="gender" class="form-control" onchange="buildMsg()">
                                        <option disabled>— اختر —</option>
                                        <option value="توفي">ذكر</option>
                                        <option value="توفيت">أنثى</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="death_place" class="form-label text-muted">مكان الوفاة</label>
                                    <select id="death_place" class="form-control" onchange="buildMsg()">
                                        <option disabled>— اختر —</option>
                                        <option value="بالمنزل">المنزل</option>
                                        <option value="بمستشفى">المستشفى</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="death_address" class="form-label text-muted">عنوان مكان الوفاة</label>
                                    <input type="text" id="death_address" class="form-control" placeholder="عنوان مكان الوفاة" oninput="buildMsg()">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="prayer_time" class="form-label text-muted">وقت صلاة الجنازة</label>
                                    <select id="prayer_time" class="form-control" onchange="buildMsg()">
                                        <option disabled>— اختر —</option>
                                        <option value="عقب صلاة الظهر">الظهر</option>
                                        <option value="عقب صلاة الجمعة">الجمعة</option>
                                        <option value="عقب صلاة العصر">العصر</option>
                                        <option value="عقب صلاة المغرب">المغرب</option>
                                        <option value="عقب صلاة العشاء">العشاء</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="burial_place" class="form-label text-muted">مكان الدفن</label>
                                    <select id="burial_place" class="form-control" onchange="buildMsg()">
                                        <option disabled>— اختر —</option>
                                        <option value="اكتوبر">اكتوبر</option>
                                        <option value="الفيوم">الفيوم</option>
                                        <option value="مايو">مايو</option>
                                        <option value="القطامية">القطامية</option>
                                        <option value="الغفير">الغفير</option>
                                        <option value="زينهم">زينهم</option>
                                        <option value="العين السخنة">العين السخنة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="has_condolence" onchange="toggleCondolence()">
                                    <label class="form-check-label text-muted" for="has_condolence">يوجد عزاء</label>
                                </div>
                                <div id="condolence_options" style="display:none; padding-right: 1.5rem; margin-top: 10px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="men" onchange="buildMsg()">
                                        <label class="form-check-label text-muted" for="men">الرجال</label>
                                    </div>
                                    <div id="men_days" style="display:none; padding-right: 1.5rem; margin-top: 8px;">
                                        <label class="text-muted" style="font-size: 13px;">أيام العزاء</label>
                                        <div class="d-flex gap-3 flex-wrap mt-1">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input day-check" name="men_day" value="اليوم" id="day_today" onchange="buildMsg()">
                                                <label class="form-check-label text-muted" for="day_today">اليوم</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input day-check" name="men_day" value="السبت" id="day_sat" onchange="buildMsg()">
                                                <label class="form-check-label text-muted" for="day_sat">السبت</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input day-check" name="men_day" value="الاثنين" id="day_mon" onchange="buildMsg()">
                                                <label class="form-check-label text-muted" for="day_mon">الاثنين</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input day-check" name="men_day" value="الأربعاء" id="day_wed" onchange="buildMsg()">
                                                <label class="form-check-label text-muted" for="day_wed">الأربعاء</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="women" onchange="buildMsg()">
                                        <label class="form-check-label text-muted" for="women">السيدات</label>
                                    </div>
                                    <div id="women_text" style="display:none; padding-right: 1.5rem; margin-top: 8px;">
                                        <input type="text" id="women_condolence_text" class="form-control" placeholder="مثال: يوم السبت فقط" pattern="[\u0600-\u06FF\s]+" oninput="arabicOnly(this); buildMsg()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="mosque_name" class="form-label text-muted">مكان صلاة الجنازة</label>
                                    <input type="text" id="mosque_name" name="mosque_name" class="form-control" placeholder="مسجد النور" pattern="[\u0600-\u06FF\s]+" oninput="arabicOnly(this); buildMsg()">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="text-muted">معاينة الرسالة</label>
                                {{-- <div id="sms_preview" class="form-control text-muted" style="min-height: 80px; background: #f8f9fa; white-space: pre-wrap; direction: rtl;">—</div> --}}
                                {{-- <textarea name="" id="sms_preview" class="form-control" cols="30" rows="10">—</textarea> --}}
                                {{-- <small id="sms_counter" class="text-muted">
                                    <span id="char_count">0</span> / 134 حرف &nbsp;|&nbsp; <span id="sms_count">1</span> رسالة
                                </small> --}}
                                <textarea name="content" id="msg_content" class="form-control sms_preview" placeholder="—"></textarea>
                                <small id="sms_counter" class="text-muted">
                                    <span id="char_count">0</span> / 134 حرف &nbsp;|&nbsp; <span id="sms_count">1</span> رسالة
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" role="button" id="associateSubmit" class="btn btn-primary">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-success mx-2" data-bs-toggle="modal" title="تعديل رسوم الرسالة" data-bs-target="#sms_fees">رسوم الرسالة</button>
    <div class="modal fade" id="sms_fees" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-muted" id="exampleModalLabel">تعديل رسوم الرسالة</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('sms.updateFees')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="fees_amount" class="form-label text-muted">المبلغ (ج.م)</label>
                            <input type="number" name="amount" id="fees_amount" class="form-control" value="{{ $fees->amount }}" min="0" required>
                        </div>
                        <button class="btn btn-success fw-bold text-white mt-3 w-100" type="submit">تحديث الرسوم</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="{{route('sms.createNew')}}" class="btn btn-success ms-2" title="إضافة مشترك">اضافة مشترك</a>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/3d-fluent/100/user-2.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">عدد الاعضاء المشتركين:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted"> {{$members}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/3d-fluent/100/user-2.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">عدد الغير الاعضاء المشتركين:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted"> {{$nonMembers}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/color/80/money-transfer.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">المبلغ المحصل:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted"> {{$totalAmount}} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/color/80/money-transfer.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">الرصيد المتبقي:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted" id="balance-remining"></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 box-col-4">
                <div class="card widget-1">
                    <div class="card-body align-items-center">
                        <div class="widget-content">
                            <div class="bg-round">
                                <img width="100" height="100" src="https://img.icons8.com/color/80/money-transfer.png" alt="user-2"/>
                            </div>
                            <div>
                                <h5 class="text-muted fs-4">الرسوم:</h5>
                            </div>
                        </div>
                        <div class="font-Info">
                            <h5 class="mb-1 text-muted" id="fees">{{ $fees->amount }} ج.م</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-resposive">
                            <table class="table display align-middle text-center table-hover" id="table2" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                                <thead>
                                    <tr>
                                        <th class="text-center">الرسالة</th>
                                        <th class="text-center">حالة الاشتراك</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sms as $item)
                                        <tr>
                                            <td class="text-center">{{$item->message}}</td>
                                            <td class="text-center">{{$item->sent_status}}</td>
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
