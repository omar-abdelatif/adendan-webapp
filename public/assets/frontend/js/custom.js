function postByAjax(url, method, formData) {
    $.ajax({
        url: url,
        method: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data && data.data && data.data.member) {
                let member = data.data.member;
                let memberName = member.name;
                let memberId = member.member_id;
                let memberStatus = member.status;
                let missingFields = data.data.missingFields;
                let delays = data.data.delays;
                let oldDelays = data.data.oldDelays;
                let donationDelay = data.data.donationDelays;
                let donationOldDelays = data.data.donationOlddelays;
                let html = content( memberName, memberId, memberStatus, missingFields, delays, oldDelays, donationDelay, donationOldDelays);
                $("#searchResult").html(html);
            } else {
                let nothing = noSearch();
                $("#searchResult").html(nothing);
                attachSSNListener();
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "عذرا حدث خطأ برجاء المحاولة مره اخرى",
                text: "او ابلاغ المسؤول",
                showConfirmButton: true,
            });
        },
    });
}
function content(memberName, memberId, memberStatus, missingFields, delays, oldDelays, donationDelay, donationOldDelays) {
    let statusText = "";
    let statusClass = "";
    let missingHtml = "";
    let missingBtn = "";
    let missingModal = "";
    let formInputs = "";
    let delaysArr = "";
    let oldDelaysArr = "";
    let donationDelayArr = "";
    let donationOldDelaysArr = "";
    if (memberStatus === 1) {
        statusText = "الإشتراك مفعل";
        statusClass = "text-white bg-primary";
    } else if (memberStatus === 0) {
        statusText = "الإشتراك غير مفعل";
        statusClass = "text-white bg-danger";
    } else if (memberStatus === 2) {
        statusText = "المشترك متوفي";
        statusClass = "text-white bg-dark";
    } else {
        statusText = "الإشتراك معلق";
        statusClass = "text-dark bg-warning";
    }
    if (missingFields && Object.keys(missingFields).length > 0) {
        missingHtml += `
            <div class=""><div class="alert alert-warning mx-3 mt-2">`;
        missingHtml += `<span class="fw-bold">يوجد بيانات غير مكتملة:</span><br/>`;
        for (const [key, label] of Object.entries(missingFields)) {
            formInputs += `
                <input type="hidden" class="form-control" name="name" value="${memberName}">
                <input type="hidden" class="form-control" name="member_id" value="${memberId}">
                <div class="mb-3">
                    <label class="form-label">${label}</label>
                    <input type="${ key === "birthdate" ? "date" : "text" }" class="form-control" name="${key}" placeholder="ادخل ${label}" autocomplete="${key}">
                </div>
            `;
        }
        missingBtn = `<button type="button" class="btn btn-warning mt-3 fw-bold" data-bs-toggle="modal" data-bs-target="#missingModal">استكمال البيانات الناقصة</button>`;
        missingModal = `
            <div class="modal fade" id="missingModal" tabindex="-1" aria-labelledby="missingModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-between">
                            <h5 class="modal-title" id="missingModalLabel">استكمال البيانات الناقصة</h5>
                            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-regular fa-circle-xmark text-danger fs-4"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="searchedData" data-store-url="store-member-main-data">
                                ${formInputs}
                                <button type="submit" class="btn btn-success w-100">ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
        missingHtml += `</div></div>`;
    }
    if (delays && delays.length > 0) {
        delays.map(function (item) {
            delaysArr += `
                <div class="col-lg-3 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green total-current-subscription-amount fw-light d-block" data-total-current-subscription-amount="${item.yearly_cost}">المبلغ السنوي</span>
                            ${item.yearly_cost + 'ج.م'}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-3 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green fw-light d-block">السنة</span>
                            ${item.year}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-3 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                            ${item.paied === null ? 'لا يوجد' : item.paied + 'ج.م'}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-3 p-1 py-2">
                    <div class="text-center">
                        <h3 role="presentation">
                            <span class="h6 text-green fw-light d-block current-subscription-remaining-amount" ${item.remaing ? `data-current-subscription-remaining-amount="${item.remaing}"` : ''}>المتبقي</span>
                            ${item.remaing === null ? 'لا يوجد' : item.remaing + 'ج.م'}
                        </h3>
                    </div>
                </div>
            `;
        }).join("");
    } else {
        delaysArr += `<p class="mb-0 text-center empty-msg fw-bold fs-3">لا توجد مبالغ مستحقة</p>`;
    }
    if (oldDelays && oldDelays.length > 0) {
        oldDelays.map(function (item) {
            oldDelaysArr += `
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green total-subscription-oldDelay-amount fw-light d-block" data-total-subscription-olddelay-amount="${item.amount}">المبلغ المطلوب</span>
                            ${item.amount + 'ج.م'}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                            ${item.delay_amount === null ? 'لا يوجد' : item.delay_amount + 'ج.م'}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h3 role="presentation">
                            <span class="h6 text-green oldDelay-remaining-subscription-amount fw-light d-block current-subscription-remaining-amount" ${item.delay_remaining ? `data-olddelay-subscription-remaining-amount="${item.delay_remaining}"` : ''}>المتبقي</span>
                            ${item.delay_remaining === null ? 'لا يوجد' : item.delay_remaining + 'ج.م'}
                        </h3>
                    </div>
                </div>
            `;
        }).join("");
    } else {
        oldDelaysArr += `<p class="mb-0 text-center empty-msg fw-bold fs-3">لا توجد مبالغ مستحقة</p>`;
    }
    if (donationDelay && donationDelay.length > 0) {
        donationDelay.map(function (item) {
            donationDelayArr += `
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green fw-light total-current-donation-amount d-block" data-total-current-donation-amount="${item.delay_amount}">المبلغ المطلوب</span>
                            ${item.delay_amount + 'ج.م'}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                            ${item.amount_paied === null ? 'لا يوجد' : item.amount_paied + 'ج.م'} 
                        </h4>
                    </div>
                </div>
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green fw-light current-donations-remaining-amount d-block" ${item.amount_remaining ? `data-current-donations-remaining-amount="${item.amount_remaining}"` : ''}>المتبقي</span>
                            ${item.amount_remaining === null ? 'لا يوجد' : item.amount_remaining + 'ج.م'}
                        </h4>
                    </div>
                </div>
            `;
        }).join("");
    } else {
        donationDelayArr += `<p class="mb-0 text-center empty-msg fw-bold fs-3">لا توجد مبالغ مستحقة</p>`;
    }
    if (donationOldDelays && donationOldDelays.length > 0) {
        donationOldDelays.map(function (item) {
            donationOldDelaysArr += `
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green total-donation-oldDelay-amount fw-light d-block" data-total-donation-olddelay-amount="${item.amount}">المبلغ المطلوب</span>
                            ${item.amount + 'ج.م'}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h4 role="presentation">
                            <span class="h6 text-green fw-light d-block">المدفوع</span>
                            ${item.delay_amount === null ? 'لا يوجد' : item.delay_amount + 'ج.م'}
                        </h4>
                    </div>
                </div>
                <div class="col-lg-4 p-1 py-2">
                    <div class="text-center">
                        <h3 role="presentation">
                            <span class="h6 text-green oldDelay-donations-remaining-amount fw-light d-block" data-olddelay-donations-remaining-amount="${item.delay_remaining === null ? 'لا يوجد' : item.delay_remaining + 'ج.م'}">المتبقي</span>
                            ${item.delay_remaining === null ? 'لا يوجد' : item.delay_remaining + 'ج.م'}
                        </h3>
                    </div>
                </div>
            `;
        }).join("");
    } else {
        donationOldDelaysArr += `<p class="mb-0 text-center empty-msg fw-bold fs-3">لا توجد مبالغ مستحقة</p>`;
    }
    let content = `
        <div class="card border-0 mx-auto">
            <div class="card-header p-3 d-flex subscriber_details align-items-center justify-content-evenly bg-secondary">
                <p class="text-white mb-0 fs-5">الإسم: ${memberName}</p>
                <p class="text-white mb-0 fs-5">رقم العضوية: ${memberId}</p>
                <p class="text-white mb-0 fs-5">
                    حالة الإشتراك:
                    <span class="${statusClass} rounded-pill px-3 py-1">${statusText}</span>
                </p>
            </div>
            <div class="card-body bg-light">
                <div class="card-content">
                    <div class="row align-items-center justify-content-evenly">
                        <div class="col-lg-6 mb-3">
                            <div class="delays justify-content-center">
                                <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                    <div class="delays-content d-flex justify-content-center flex-column align-items-center">
                                        <div class="w-100 border-1 border-dark ms-1 rounded-3">
                                            <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                <img width="80" height="80" src="https://img.icons8.com/plasticine/80/cash--v2.png" alt="cash--v2"/>
                                                مديونية الإشتراك السنوي
                                            </h4>
                                            <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">${delaysArr}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="old-delays">
                                <div class="old-content">
                                    <div class="row justify-content-center g-0">
                                        <div class="w-100 border-1 border-dark rounded-3">
                                            <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                    <img width="80" height="80" src="https://img.icons8.com/external-kmg-design-outline-color-kmg-design/80/external-document-folder-and-document-kmg-design-outline-color-kmg-design.png" alt="external-document-folder-and-document-kmg-design-outline-color-kmg-design"/>
                                                    متأخرات الإشتراكات
                                                </h4>
                                                <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">${oldDelaysArr}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="delay-donaion">
                                <div class="delay-donaiton-content">
                                    <div class="row justify-content-center g-0">
                                        <div class="w-100 border-1 border-dark rounded-3">
                                            <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                    <img width="64" height="64" src="https://img.icons8.com/external-those-icons-lineal-color-those-icons/64/external-donate-money-currency-those-icons-lineal-color-those-icons.png" alt="external-donate-money-currency-those-icons-lineal-color-those-icons"/>
                                                    مديونية التبرعات
                                                </h4>
                                                <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">${donationDelayArr}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="old-donations">
                                <div class="old-donation-content">
                                    <div class="row justify-content-center g-0">
                                        <div class="w-100 border-1 border-dark rounded-3">
                                            <div id="fieldInfo-0" class="card statistics-card-category justify-content-evenly statistics-card-grey card-shadow border-rounded-15 p-4">
                                                <h4 class="text-green fw-bold pb-2 d-flex justify-content-evenly align-items-center" aria-level="3">
                                                    <img width="64" height="64" src="https://img.icons8.com/external-justicon-lineal-color-justicon/64/external-donation-economy-and-currency-justicon-lineal-color-justicon.png" alt="external-donation-economy-and-currency-justicon-lineal-color-justicon"/>
                                                    متأخرات التبرعات
                                                </h4>
                                                <div class="row statistics-card-grey-small border-rounded-15 statistics-card-border p-1 py-2">${donationOldDelaysArr}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ${missingHtml}
                        ${missingBtn}
                        ${missingModal}
                    </div>
                </div>
            </div>
        </div>
    `;
    return content;
}
function noSearch() {
    let content = `
        <div class="text-center">
            <h1 class="my-3 text-center">⚠️</h1>
            <h4 class="mb-2 text-center"> الرقم القومي غير موجود</h4>
            <p class="mb-0 mt-2 text-center fw-bold fs-5">برجاء إدخال البيانات الصحيحة من الرابط التالي</p>
            <button class="fw-bold mx-auto btn btn-outline-success mt-3" data-bs-target="#missingModal" data-bs-toggle="modal" target="blank">إدخال البيانات</button>
            <div class="modal fade" id="missingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center bg-primary text-white">
                            <h1 class="text-center">البيانات المطلوب تحديثها</h1>
                        </div>
                        <div class="modal-body bg-light">
                            <form data-store-url="store-member-main-data" method="post" id="searchedData">
                                <div class="form-group mb-3">
                                    <label for="member_name" class="form-label text-right text-primary fw-bold">الإسم كامل</label>
                                    <input type="text" class="form-control border-2 border-primary" id="member_name" placeholder="الإسم بالكامل" name="name" autocomplete="name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="mob_number" class="form-label text-right text-primary fw-bold">رقم المحمول</label>
                                    <input type="text" class="form-control border-2 border-primary" id="mob_number" placeholder="رقم المحمول" name="mobile_no" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ssn" class="form-label text-right text-primary fw-bold">الرقم القومي</label>
                                    <input type="text" class="form-control border-2 border-primary" id="requested_ssn" placeholder="الرقم القومي" name="ssn" required>
                                    <span id="ssnError" class="d-none text-danger fw-bold"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label text-right text-primary fw-bold">العنوان</label>
                                    <input type="text" class="form-control border-2 border-primary" id="address" placeholder="العنوان" name="address" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="birthdate" class="form-label text-right text-primary fw-bold">تاريخ الميلاد</label>
                                    <input type="date" class="form-control border-2 border-primary" id="birthdate" name="birthdate" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                                    <button type="submit" id="submitForm" class="btn btn-primary">تأكيد</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    return content;
}
//! Fixed Navbar
window.addEventListener("scroll", () => {
    if (window.scrollY > 150) {
        document.querySelector(".navbar").classList.add("fixed");
    } else {
        document.querySelector(".navbar").classList.remove("fixed");
    }
});
//! Auto Calculate BirthDate With SSN
function attachSSNListener() {
    let requestedSSN = document.getElementById("requested_ssn");
    let birthdateInput = document.getElementById("birthdate");
    let ssnError = document.getElementById("ssnError");
    let submitBtn = document.getElementById("submitForm");
    if (!requestedSSN) return;
    requestedSSN.addEventListener("input", function () {
        let ssn = this.value.trim();
        if (ssn.length === 14) {
            let century = ssn[0] === "2" ? 1900 : 2000;
            let year = century + parseInt(ssn.substr(1, 2));
            let month = parseInt(ssn.substr(3, 2));
            let day = parseInt(ssn.substr(5, 2));
            birthdateInput.value = `${year}-${month
                .toString()
                .padStart(2, "0")}-${day.toString().padStart(2, "0")}`;
        } else {
            birthdateInput.value = "";
        }
    });
    requestedSSN.addEventListener("input", function () {
        let ssn = requestedSSN.value.trim();
        let ssnRegex = /^(2|3)\d{13}$/;
        if (!ssnRegex.test(ssn)) {
            ssnError.textContent =
                "الرقم القومي لازم يكون 14 رقم ويبدأ بـ 2 أو 3";
            requestedSSN.classList.add("is-invalid");
            ssnError.classList.remove("d-none");
            submitBtn.setAttribute("disabled", "true");
        } else {
            ssnError.textContent = "";
            requestedSSN.classList.remove("is-invalid");
            ssnError.classList.add("d-none");
            submitBtn.removeAttribute("disabled");
        }
    });
}
//! Copy To Clipboard
function copyToClipboard() {
    var tempInput = document.createElement("input");
    tempInput.value = window.location.href;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    alert("Copied the URL: " + tempInput.value);
}
//! Jquery
$(function () {
    //! Arabic Direction To The News Bar
    $("#newsTicker2").breakingNews({
        direction: "rtl",
    });
    //! Payment Form
    let paymentForms = document.querySelectorAll("form[data-payment-id]");
    if (paymentForms) {
        paymentForms.forEach((payment) => {
            let paymentSelect = payment.querySelectorAll(
                `input[name="pay_type"][type="radio"][data-payment-id="${payment.dataset.paymentId}"]`
            );
            let paymentMethod = payment.querySelectorAll(
                `input[name="payment_method"][type="radio"][data-payment-id="${payment.dataset.paymentId}"]`
            );
            let paiedAmount = payment.querySelector(
                `input[name="amount"][data-payment-id="${payment.dataset.paymentId}"]`
            );
            let totalAmount = document.getElementById("totalAmount");
            let remainingAmount = document.getElementById("remainingAmount");
            const amountData = document.querySelector(".view-data");

            let currentSubscriptionAmount = $(
                "span.total-current-subscription-amount"
            ).data("total-current-subscription-amount");
            let currentSubscriptionRemainingAmount = $(
                "span.current-subscription-remaining-amount"
            ).data("current-subscription-remaining-amount");

            let totalOldDelaySubscriptionAmount = $(
                "span.total-subscription-oldDelay-amount"
            ).data("total-subscription-olddelay-amount");
            let totalOldDelaySubscriptionRemainingAmount = $(
                "span.oldDelay-remaining-subscription-amount"
            ).data("olddelay-subscription-remaining-amount");

            let currentDonationAmount = $(
                "span.total-current-donation-amount"
            ).data("total-current-donation-amount");
            let currentDonationRemainingAmount = $(
                "span.current-donations-remaining-amount"
            ).data("current-donations-remaining-amount");

            let totalOldDelayDonationAmount = $(
                "span.total-donation-oldDelay-amount"
            ).data("total-donation-oldDelay-amount");
            let totalOldDelayDonationRemainingAmount = $(
                "span.oldDelay-donations-remaining-amount"
            ).data("oldDelay-donations-remaining-amount");

            let submitButton = document.querySelector(
                `button[type="submit"][data-payment-id="${payment.dataset.paymentId}"]`
            );

            let onlinePayment = document.querySelectorAll(
                `input[type="radio"][name="online_payment"][data-payment-id="${payment.dataset.paymentId}"]`
            );

            let vfCashContainer = document.querySelector(
                ".requested_phone-number"
            );
            let vfCashPhoneNumber = document.querySelector(
                `input[type="number"][name="phone_number"][data-payment-id="${payment.dataset.paymentId}"]`
            );

            if (paymentSelect) {
                paymentSelect.forEach((radio) => {
                    radio.addEventListener("change", function () {
                        const SelectedOption = this.value;
                        switch (SelectedOption) {
                            case "subscription":
                                amountData.classList.remove("d-none");
                                totalAmount.innerHTML =
                                    currentSubscriptionAmount ?? 0;
                                remainingAmount.innerHTML =
                                    currentSubscriptionRemainingAmount ?? 0;
                                if (
                                    +totalAmount.innerHTML === 0 &&
                                    +remainingAmount.innerHTML === 0
                                ) {
                                    paiedAmount.value = "";
                                    paiedAmount.disabled = true;
                                    submitButton.disabled = true;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = true;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = true;
                                    });
                                    vfCashPhoneNumber.disabled = true;
                                } else {
                                    paiedAmount.disabled = false;
                                    submitButton.disabled = false;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = false;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = false;
                                    });
                                    vfCashPhoneNumber.disabled = false;
                                }
                                paymentMethod.forEach((pay) => {
                                    pay.addEventListener("change", function () {
                                        const paymentOption = this.value;
                                        const total = Number(
                                            totalAmount.innerHTML
                                        );
                                        const remaining = Number(
                                            remainingAmount.innerHTML
                                        );
                                        if (paymentOption === "all") {
                                            if (total > 0 && remaining === 0) {
                                                paiedAmount.value = total;
                                                paiedAmount.readOnly = true;
                                                paiedAmount.required = false;
                                            } else if (
                                                total === 0 &&
                                                remaining === 0
                                            ) {
                                                paiedAmount.value = "";
                                                paiedAmount.disabled = true;
                                                paiedAmount.required = false;
                                            }
                                        } else {
                                            paiedAmount.readOnly = false;
                                            paiedAmount.required = true;
                                            paiedAmount.value = "";
                                            paiedAmount.focus();
                                        }
                                    });
                                });
                                break;
                            case "subscription_delay":
                                amountData.classList.remove("d-none");
                                totalAmount.innerHTML =
                                    totalOldDelaySubscriptionAmount ?? 0;
                                remainingAmount.innerHTML =
                                    totalOldDelaySubscriptionRemainingAmount ??
                                    0;
                                if (
                                    +totalAmount.innerHTML === 0 &&
                                    +remainingAmount.innerHTML === 0
                                ) {
                                    paiedAmount.value = "";
                                    paiedAmount.disabled = true;
                                    submitButton.disabled = true;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = true;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = true;
                                    });
                                    vfCashPhoneNumber.disabled = true;
                                } else {
                                    paiedAmount.disabled = false;
                                    submitButton.disabled = false;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = false;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = false;
                                    });
                                    vfCashPhoneNumber.disabled = false;
                                }
                                paymentMethod.forEach((pay) => {
                                    pay.addEventListener("change", function () {
                                        const paymentOption = this.value;
                                        const total = Number(
                                            totalAmount.innerHTML
                                        );
                                        const remaining = Number(
                                            remainingAmount.innerHTML
                                        );
                                        if (paymentOption === "all") {
                                            if (total > 0 && remaining === 0) {
                                                paiedAmount.value = total;
                                                paiedAmount.readOnly = true;
                                                paiedAmount.required = false;
                                            } else if (
                                                total === 0 &&
                                                remaining === 0
                                            ) {
                                                paiedAmount.value = "";
                                                paiedAmount.disabled = true;
                                                paiedAmount.required = false;
                                            }
                                        } else {
                                            paiedAmount.readOnly = false;
                                            paiedAmount.required = true;
                                            paiedAmount.value = "";
                                            paiedAmount.focus();
                                        }
                                    });
                                });
                                break;
                            case "donation_delay":
                                amountData.classList.remove("d-none");
                                totalAmount.innerHTML =
                                    totalOldDelayDonationAmount ?? 0;
                                remainingAmount.innerHTML =
                                    currentDonationRemainingAmount ?? 0;
                                if (
                                    +totalAmount.innerHTML === 0 &&
                                    +remainingAmount.innerHTML === 0
                                ) {
                                    paiedAmount.value = "";
                                    paiedAmount.disabled = true;
                                    submitButton.disabled = true;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = true;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = true;
                                    });
                                    vfCashPhoneNumber.disabled = true;
                                } else {
                                    paiedAmount.disabled = false;
                                    submitButton.disabled = false;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = false;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = false;
                                    });
                                    vfCashPhoneNumber.disabled = false;
                                }
                                paymentMethod.forEach((pay) => {
                                    pay.addEventListener("change", function () {
                                        const paymentOption = this.value;
                                        const total = Number(
                                            totalAmount.innerHTML
                                        );
                                        const remaining = Number(
                                            remainingAmount.innerHTML
                                        );
                                        if (paymentOption === "all") {
                                            if (total > 0 && remaining === 0) {
                                                paiedAmount.value = total;
                                                paiedAmount.readOnly = true;
                                                paiedAmount.required = false;
                                            } else if (
                                                total === 0 &&
                                                remaining === 0
                                            ) {
                                                paiedAmount.value = "";
                                                paiedAmount.disabled = true;
                                                paiedAmount.required = false;
                                            }
                                        } else {
                                            paiedAmount.readOnly = false;
                                            paiedAmount.required = true;
                                            paiedAmount.value = "";
                                            paiedAmount.focus();
                                        }
                                    });
                                });
                                break;
                            case "donation_debt":
                                amountData.classList.remove("d-none");
                                totalAmount.innerHTML =
                                    currentDonationAmount ?? 0;
                                remainingAmount.innerHTML =
                                    totalOldDelayDonationRemainingAmount ?? 0;
                                if (
                                    +totalAmount.innerHTML === 0 &&
                                    +remainingAmount.innerHTML === 0
                                ) {
                                    paiedAmount.value = "";
                                    paiedAmount.disabled = true;
                                    submitButton.disabled = true;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = true;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = true;
                                    });
                                    vfCashPhoneNumber.disabled = true;
                                } else {
                                    paiedAmount.disabled = false;
                                    submitButton.disabled = false;
                                    paymentMethod.forEach((pay) => {
                                        pay.disabled = false;
                                    });
                                    onlinePayment.forEach((item) => {
                                        item.disabled = false;
                                    });
                                    vfCashPhoneNumber.disabled = false;
                                }
                                paymentMethod.forEach((pay) => {
                                    pay.addEventListener("change", function () {
                                        const paymentOption = this.value;
                                        const total = Number(
                                            totalAmount.innerHTML
                                        );
                                        const remaining = Number(
                                            remainingAmount.innerHTML
                                        );
                                        if (paymentOption === "all") {
                                            if (total > 0 && remaining === 0) {
                                                paiedAmount.value = total;
                                                paiedAmount.readOnly = true;
                                                paiedAmount.required = false;
                                            } else if (
                                                total === 0 &&
                                                remaining === 0
                                            ) {
                                                paiedAmount.value = "";
                                                paiedAmount.disabled = true;
                                                paiedAmount.required = false;
                                            }
                                        } else {
                                            paiedAmount.readOnly = false;
                                            paiedAmount.required = true;
                                            paiedAmount.value = "";
                                            paiedAmount.focus();
                                        }
                                    });
                                });
                                break;
                            default:
                                amountData.classList.add("d-none");
                                submitButton.disabled = false;
                                break;
                        }
                    });
                });
                onlinePayment.forEach((pay) => {
                    pay.addEventListener("change", function () {
                        const paymentOption = this.value;
                        if (paymentOption === "e-wallet") {
                            vfCashContainer.classList.remove("d-none");
                        } else {
                            vfCashContainer.classList.add("d-none");
                        }
                    });
                });
            }
        });
    }
    //! Submit Missing Data To Admin
    $(document).on("submit", "#searchedData", function (e) {
        e.preventDefault();
        let form = $("#searchedData");
        let formData = new FormData(form[0]);
        let storeUrl = $(this).data("store-url");
        $.ajax({
            url: storeUrl,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                let modalEl = document.getElementById("missingModal");
                let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
                modalEl.addEventListener(
                    "hidden.bs.modal",
                    function () {
                        document.body.classList.remove("modal-open");
                        document.body.style.overflow = "auto";
                        let backdrop =
                            document.querySelector(".modal-backdrop");
                        if (backdrop) backdrop.remove();
                    },
                    { once: true }
                );
                Swal.fire({
                    icon: "success",
                    title: "تم تسجيل البيانات",
                    text: res.message,
                    showConfirmButton: true,
                });
            },
            error: function (xhr) {
                let modalEl = document.getElementById("missingModal");
                let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();
                modalEl.addEventListener(
                    "hidden.bs.modal",
                    function () {
                        modalEl.classList.remove("fade");
                        let backdrop =
                            document.querySelector(".modal-backdrop");
                        if (backdrop) backdrop.remove();
                    },
                    { once: true }
                );
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: xhr.responseJSON?.message,
                });
            },
        });
    });
    //! Append Search Result To Search Result Container
    let searchBySsnForm = $("#searchBySsnForm");
    if (searchBySsnForm.length) {
        searchBySsnForm.on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(searchBySsnForm[0]);
            postByAjax("/result", "POST", formData);
        });
    }
});