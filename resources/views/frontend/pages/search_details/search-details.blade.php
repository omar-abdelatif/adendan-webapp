@extends('frontend.layouts.master')
@section('title')
    {{$member->name}}
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item">الإستعلامات</li>
    <li class="breadcrumb-item active" aria-current="page">{{$member->name}}</li>
@endsection
@section('site_styles')
    <style>
        .form-label {
            padding: 10px 20px;
            border: 2px solid #004080;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            min-width: 80px;
            display: inline-block;
            transition: all 0.3s;
        }

        .form-label:hover{
            background-color: #004080;
            color: white;
            transition: all 0.3s;
        }
        input[type="radio"]:checked + .form-label {
            background-color: #004080;
            color: white;
        }

        input[type="radio"]:checked:disabled + .form-label, input[type="radio"]:disabled + .form-label {
            background-color: #004080;
            color: white;
            opacity: 0.5;
            cursor: not-allowed;
        }
        input[type="number"]:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
@endsection
@section('site')
    <section class="search-details-wrappers">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-primary border-2">
                        <div class="card-header bg-primary text-white">
                            <h1 class="card-title text-center my-3 text-decoration-underline fs-3">دفع الإشتراك او المتأخرات للعضو {{$member->name}}</h1>
                        </div>
                        <div class="card-body py-3 px-2">
                            <div class="caution-title mb-3">
                                <h1 class="text-center text-danger text-decoration-underline my-2">المدفوعات في طور التجربة</h1>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="card card-shadow border-rounded">
                                        <h6 class="title pt-3 px-3" aria-level="2">توفير اللحوم للأسر المحتاجة</h6>
                                        <div class="position-relative overflow-hidden center-items-vertically details-image" style="width: 100%">
                                                <img loading="lazy" class="rounded-top-35 p-3 w-100" src="../../../ehsanimagesp.s3.me-south-1.amazonaws.com/P01134.jpg" onerror="this.src='../../assets/images/Default_card.svg';this.onerror='';" alt="توفير اللحوم للأسر المحتاجة">
                                        </div>
                                        <p class="p-3 m-0">عددٌ من الأسر المحتاجة التي تعاني من قلة الدخل؛ ما صعّب عليها عيش الحياة وزاد مشقتها وعناءها بتبرعك تساهم في توفير اللحوم وتوزيعها للأسر الأشد احتياجاً وتكون سبباً في تخفيف ظروفهم المتعسرة، قال الله تعالى: "وَمَا تُنفِقُواْ مِن شَىْءٍ فَإِنَّ ٱللَّهَ بِهِ عَلِيمٌ".</p>
                                        <div class="align-items-center bg-light-grey d-flex justify-content-between px-3 py-2">
                                            <div class="font-semibold">
                                                <span class="text-primary-blue">رقم الحالة</span><span class="text-primary-green ms-2">P47256</span>
                                            </div>
                                            <div class="font-semibold">
                                                <button class="btn btn-dark-grey d-flex px-3 py-1 rounded-pill share-help ghiras_share align-items-center" data-caseid="46257" data-casetype="Project" data-casetitle="توفير اللحوم للأسر المحتاجة" title="شارك التبرع عبر وسائل التواصل الاجتماعي">
                                                    <span class="text-primary-blue me-2">مشاركة</span>
                                                    <i class="fas fa-share-alt share-icon text-primary-green"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col">
                                                <span class="text-primary-green font-semibold">تم جمع</span>
                                                <label class="text-primary-blue d-block h5 font-regular fw-light">7,249<small class="ms-2 text-nowrap">ر.س</small></label>
                                            </div>
                                            <div class="col">
                                                <span class="text-primary-green font-semibold">المبلغ المتبقي</span>
                                                <label class="text-primary-blue d-block h5 font-regular fw-light MaxValSpan">158,501<small class="ms-2 text-nowrap">ر.س</small></label>
                                            </div>
                                        </div>
                                        <div class="rangeslider3 w-100 px-3 pt-3" id="js-rangeslider-0">
                                            <div class="rangeslider-fill-lower">
                                                <div class="rangeslider-thumb" id="donut-46257" style="width: 4%" role="slider" aria-valuemin="0" aria-valuenow="4" aria-valuemax="100" aria-label="تم جمع">
                                                    <div class="range-output" style="transform: rotate(0deg);">
                                                        <output class="output" name="output" for="range">4%</output>
                                                    </div>
                                                </div>
                                            </div>

                                            <style>
                                                #donut-46257 {
                                                    width: 4%;
                                                    animation: donutLoad-46257 2s ease;
                                                    animation-direction: alternate;
                                                }

                                                @keyframes donutLoad-46257 {
                                                    0%   {width: 0;}
                                                    100% {width: 4%;}
                                                }
                                            </style>
                                        </div>
                                        <hr>
                                        <div id="divMoreInfo" class="px-3" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 mb-3 donation-form">
                                    <form method="post" id="details_donation" class="position-relative mb-5" action="https://ehsan.sa/projects/donateproject" novalidate="novalidate">
                                        <div class="cart-wrapper" data-id="46257">
                                            <div class="card card-shadow border-rounded p-3">
                                                <div class="title-with-amounts">
                                                    <h6 class="title mb-3" aria-level="3">مبلغ التبرع</h6>
                                                    <div class="ProhectDetailsSubBox">
                                                        <div class="price-details d-flex flex-lg-nowrap flex-wrap justify-content-center justify-content-lg-between">
                                                            <button type="button" class="btn btn-white border px-3 me-1 input-radius flex-fill pre-amount single-amount amount-from-details" data-amount="10" aria-label="10 ريال سعودي" aria-pressed="false">
                                                                10
                                                                <small class="ms-1">ر.س</small>
                                                            </button>
                                                            <button type="button" class="btn btn-white border px-3 me-1 input-radius flex-fill pre-amount single-amount amount-from-details" data-amount="50" aria-label="50 ريال سعودي" aria-pressed="false">
                                                                50
                                                                <small class="ms-1">ر.س</small>
                                                            </button>
                                                            <button type="button" class="btn btn-white border px-3 me-1 input-radius flex-fill pre-amount single-amount amount-from-details" data-amount="100" aria-label="100 ريال سعودي" aria-pressed="false">
                                                                100
                                                                <small class="ms-1">ر.س</small>
                                                            </button>
                                                            <div class="input-group mt-1 mt-lg-0">
                                                                <input class="only-number form-control border-end-0 input-another-amount cart-amount amount-from-details" id="item-46257-amount" name="amount" placeholder="قيمة المبلغ" value="" autocomplete="off" maxlength="7" inputmode="numeric" pattern="[0-9]*" aria-label="مبلغ آخر (ريال سعودي)" lang="en">
                                                                <span class="input-group-text bg-white border-start-0" id="basic-addon2">
                                                                    <small class="text-primary-green">ر.س</small>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <span class="fs-12px text-danger d-none" id="mainAmountErr">مبلغ التبرع مطلوب</span>
                                                    </div>
                                                    <span class="field-validation-valid" data-valmsg-for="cart_total_hidden" data-valmsg-replace="true" role="alert"></span>
                                                </div>
                                                <style>
                                                    .select2-container--default .select2-selection--single {
                                                        border-radius: .65rem 0 0 .65rem !important;
                                                    }
                                                    span.error {
                                                        color: #dc3545 !important;
                                                        font-size: 13px;
                                                    }
                                                </style>
                                                <div id="paymentAsGiftWrapper">
                                                    <div class="center py-4 border-rounded-2 text-light position-relative gift-box" role="presentation">
                                                        <div class="gift-checkbox-wrapper" role="presentation">
                                                            <div class="form-check form-check-input-square" role="presentation">
                                                                <input class="form-check-input" data-val="true" id="sendAsGiftCheckbox" name="IsGift" type="checkbox" value="true" aria-hidden="false" aria-label="تبرع عن أهلك أو أصدقائك وشاركهم الأجر">
                                                                <label class="form-check-label text-black-50" for="sendAsGiftCheckbox" aria-hidden="true">تبرع عن أهلك أو أصدقائك وشاركهم الأجر</label>
                                                            </div>
                                                            <img class="gift-icon" src="../../assets/images/icons-gift-green.svg" alt="">
                                                        </div>
                                                    </div>
                                                    <div id="gift-details" role="group" aria-label="تفاصيل الهدية" style="display: none;">
                                                        <h3 class="visually-hidden">تفاصيل الهدية</h3>
                                                        <div class="form-group mb-3" role="group" aria-label="بيانات المُتَبَرِّع">
                                                            <h4 class="visually-hidden">بيانات المُتَبَرِّع</h4>
                                                            <label class="col-form-label text-primary-blue font-bold" for="SenderName">اسمك</label>
                                                            <input class="border-bottom form-control senderName payment-input" id="SenderName" data-checkname="true" type="text" value="" name="SenderName" placeholder="اسم المتبرع" data-val-required="اسم المتبرع مطلوب" maxlength="30" aria-label="اسم المتبرع" aria-required="true">
                                                        </div>
                                                        <div id="gifteeContainer" class="form-group mb-3">
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary-blue rounded-pill font-semibold px-4 mb-3 mt-2" id="addGiftee"><i class="fas fa-plus me-2 fs-12px" aria-hidden="true"></i>تبرع عن شخص آخر</button>
                                                        <div class="text-primary-blue font-semibold" id="show-hide-heading" role="heading" aria-level="4">حدد ما تود إظهاره برسالة التبرع</div>
                                                        <div class="d-flex justify-content-between my-3">
                                                            <div role="group" id="checkbox-group" aria-label="حدد ما تود إظهاره برسالة التبرع" class="d-flex flex-column flex-md-row">
                                                                <div class="form-check form-check-inline mt-1 ps-0 ms-4">
                                                                    <input type="checkbox" onchange="handleGiftPreview()" class="input-showAmount rb-primary-green form-check-input" id="ShowHideAmount1" name="ShowHideAmount1">
                                                                    <label class="form-check-label text-muted" for="ShowHideAmount1">إظهار مبلغ التبرع</label>
                                                                </div>
                                                                <div class="form-check form-check-inline mt-1 ps-0 ms-4">
                                                                    <input type="checkbox" onchange="handleGiftPreview()" class="input-showAmount rb-primary-green form-check-input" id="showProjectName" name="showProjectName">
                                                                    <label class="form-check-label text-muted" for="showProjectName">إظهار اسم المشروع</label>
                                                                </div>
                                                            </div>
                                                            <div class="flex-shrink-0">
                                                                <h4 class="visually-hidden">معاينة الرسالة النصية</h4>
                                                                <button type="button" class="btn border-0 p-0" data-bs-toggle="modal" data-bs-target="#showGiftModal">
                                                                    <div class="d-flex flex-column align-items-center text-primary-blue">
                                                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                                                        <span class="fs-12px">معاينة الرسالة</span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <span class="errorMaxPrice font-semibold fs-14px text-danger d-none" role="alert">أعلى قيمة يمكنك التبرع بها 158501.00 و أقل قيمة يمكنك التبرع بها 1.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between pb-3">
                                                    <div class="addToCartWrapper w-100 d-flex">
                                                        <button class="btn btn-gradient flex-fill me-2 donate-now" type="submit" id="submit-details">
                                                            تبرع الآن
                                                        </button>
                                                        <button class="add-to-cart border-0 btn-primary-green btn-round-icon fa-cart-plus fas fs-5" data-initiativetypeid="1" data-url="/projects/0/46257?amount=null" data-maxamount="165750.00" data-id="46257" data-title="توفير اللحوم للأسر المحتاجة" data-type="Project" data-type-name="Project" data-contribution-type="Charity" data-attachment="https://ehsanimagesp.s3.me-south-1.amazonaws.com/P01134.jpg" aria-label="إضافة توفير اللحوم للأسر المحتاجة إلى سلة تبرعاتك">
                                                        </button>
                                                    </div>
                                                    <div class="removeFromCartWrapper d-flex flex-fill justify-content-between mt-5 d-none">
                                                        <button class="btn btn-link remove-from-cart text-grey-3" data-id="46257" data-initiativetypeid="1" aria-label="إزالة توفير اللحوم للأسر المحتاجة  من سلة تبرعاتك">
                                                            ازالة
                                                        </button>
                                                        <label class="addedToCart align-items-center bg-grey-1 d-flex px-5 rounded-pill text-grey-3 flex-fill justify-content-center">مضاف لسلة تبرعاتك <i class="fas fa-cart-plus ms-1"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection