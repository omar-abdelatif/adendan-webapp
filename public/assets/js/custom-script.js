//! Jquery
$(document).ready(function () {
    //! Image Upload Preview
    $(document).on("change", "#image", function (e) {
        let memberId = $(this).data("member-id");
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#showImage_" + memberId).attr("src", e.target.result);
        };
        reader.readAsDataURL(e.target.files[0]);
    });
    //! Single Datatable
    $("#table").DataTable({
        paging: true,
        scrollY: 400,
        ordering: true,
        select: {
            style: "multi",
        },
        columnDefs: [
            {
                targets: 0,
                checkboxes: {
                    selectRow: true,
                },
            },
        ],
        autoWidth: true,
        searching: true,
        pageLength: 20,
        pagingTag: "button",
        pagingType: "simple_numbers",
    });
    //! Add Class to Jquery Checkbox
    $("#table").on("draw.dt", function () {
        $(this).find(":checkbox").addClass("checkbox_animated subscriber-data");
    });
    $("#table").trigger("draw.dt");
    //! Add new row
    $(".addRow").click(function () {
        let newRow = $(
            "<div class='d-flex align-items-center justify-content-evenly py-4 border-top border-bottom-2 border-white'>" +
                "<input type='text' name='url[]' class='form-control text-center text-white' placeholder='رابط الفيديو'>" +
                "<a href='javascript:void(0)' class='btn btn-danger px-2 py-2 removeRow ms-2'>-</a>" +
                "</div>"
        );
        $("#inputs").append(newRow);
    });
    //! Remove row
    $("#inputs").on("click", ".removeRow", function () {
        $(this).closest(".d-flex").remove();
    });
    //! Delete All Selected Records
    $("#deleteRecord").click(function () {});
    //! Add Selected Class To Selected Records
    let selectAll = document.getElementById("selectAll");
    if (selectAll) {
        if (selectAll.checked) {
            console.log("checked");
        }
    }
    $("#selectAll").change(function () {
        if (this.checked) {
            $(".subscriber-data").prop("checked", true); // Check all checkboxes
            $(".subscriber-data").closest("tr").addClass("selected"); // Add 'selected' class to their parent <tr> elements
        } else {
            $(".subscriber-data").prop("checked", false); // Uncheck all checkboxes if 'selectAll' is unchecked
            $(".subscriber-data").closest("tr").removeClass("selected"); // Remove 'selected' class from their parent <tr> elements
        }
    });
    //! Change Date Separator
    $(".datepicker-age").datepicker({
        dateFormat: "dd/mm/yyyy",
    });
    $(".datepicker-here").datepicker({
        dateFormat: "yyyy-mm-dd",
    });
    //! Get Cost By Years
});
//! Multi Datatables in Same Page
for (let i = 0; i < 500; i++) {
    let table = document.querySelector("#table" + i);
    new DataTable(table, {
        paging: true,
        // scrollY: tables[i],
        ordering: true,
        select: {
            style: "os",
            selector: "th:first-child",
        },
        columnDefs: [
            {
                targets: 0,
                checkboxes: {
                    selectRow: true,
                },
            },
        ],
        autoWidth: true,
        searching: true,
        pagingTag: "button",
        pagingType: "simple_numbers",
    });
}
//! Remove Alert After  5 Seconds
const errors = document.querySelectorAll("#error");
errors.forEach((error) => {
    setTimeout(function () {
        error.style.display = "none";
    }, 5000);
});
//! craftSelect
let SelectedOption = document.getElementById("craftSelect");
if (SelectedOption) {
    SelectedOption.addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex].value;
        let otherCraftInput = document.getElementsByName("other_craft")[0];
        otherCraftInput.value = "";
        otherCraftInput.disabled = selectedOption !== "أخرى";
    });
}
//! categorySelect
const categorySelect = document.getElementById("categorySelect");
const inputsDiv = document.getElementById("inputs");
const img = document.getElementById("img");
const thumbs = document.getElementById("thumbs");
if (categorySelect) {
    categorySelect.addEventListener("change", function () {
        if (this.value === "عزاء") {
            inputsDiv.classList.add("hidden");
            img.classList.add("hidden");
            thumbs.classList.add("hidden");
            inputsDiv.querySelectorAll("input").forEach(function (input) {
                input.disabled = true;
            });
        } else {
            inputsDiv.classList.remove("hidden");
            img.classList.remove("hidden");
            thumbs.classList.remove("hidden");
            inputsDiv.querySelectorAll("input").forEach(function (input) {
                input.disabled = false;
            });
        }
    });
}
//! updateCraft Worker Page
let selectElements = document.querySelectorAll("[data-worker-id]");
if (selectElements) {
    selectElements.forEach((selectElement) => {
        let otherCraftInput = document.querySelector(
            `input[name="other_craft"][data-worker-id="${selectElement.dataset.workerId}"]`
        );
        function handleUpdateCraft() {
            let selectedOption =
                selectElement.options[selectElement.selectedIndex].value;
            if (selectedOption === "أخرى") {
                otherCraftInput.disabled = false;
            } else {
                otherCraftInput.value = "";
                otherCraftInput.disabled = true;
                otherCraftInput.removeAttribute("value");
            }
        }
        selectElement.addEventListener("change", function () {
            handleUpdateCraft();
        });
    });
}
//! Insert Donation
let allDonations = document.querySelectorAll("[data-donation-id]");
if (allDonations) {
    allDonations.forEach((donation) => {
        let otherDonation = document.querySelector(
            `input[name="other_donation"][data-donation-id="${donation.dataset.donationId}"]`
        );
        let categoryType = document.querySelector(
            `select[name="donation_category"][data-donation-id="${donation.dataset.donationId}"]`
        );
        let Amount = document.querySelector(
            `input[name="amount"][data-donation-id="${donation.dataset.donationId}"]`
        );
        function donationUpdate() {
            let donationValue = donation.options[donation.selectedIndex].value;
            if (donationValue == "أخرى") {
                Amount.classList.remove("d-none");
                Amount.disabled = false;
                categoryType.classList.add("d-none");
                categoryType.disabled = true;
                otherDonation.classList.remove("d-none");
                otherDonation.disabled = false;
            } else if (donationValue == "مادي") {
                Amount.classList.remove("d-none");
                Amount.disabled = false;
                categoryType.classList.remove("d-none");
                categoryType.disabled = false;
                otherDonation.classList.add("d-none");
                otherDonation.disabled = true;
            }
        }
        donation.addEventListener("change", function () {
            donationUpdate();
        });
    });
}
//! Outer Donators Period
let donationSelect = document.getElementById("donator_type");
if (donationSelect) {
    donationSelect.addEventListener("change", function () {
        let donationValue = this.options[this.selectedIndex].value;
        let donationName = document.getElementById("duration");
        if (donationValue == "منتظم") {
            donationName.classList.remove("d-none");
        } else {
            donationName.value = "";
            donationName.classList.add("d-none");
        }
    });
}
//! miscellaneous
let category = document.getElementById("category");
if (category) {
    category.addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex].value;
        let otherCategory = document.getElementById("other_category");
        if (selectedOption === "أخرى") {
            otherCategory.classList.remove("d-none");
        } else {
            otherCategory.value = "";
            otherCategory.classList.add("d-none");
        }
    });
}
//! Update miscellaneous
let selectMiscs = document.querySelectorAll("[data-misc-id]");
if (selectMiscs) {
    selectMiscs.forEach((misc) => {
        let otherCategory = document.querySelector(
            `input[name="other_category"][data-misc-id="${misc.dataset.miscId}"]`
        );
        function handleUpdateCraft() {
            let selectedOption = misc.options[misc.selectedIndex].value;
            if (selectedOption === "أخرى") {
                otherCategory.disabled = false;
            } else {
                otherCategory.value = "";
                otherCategory.disabled = true;
                otherCategory.removeAttribute("value");
            }
        }
        misc.addEventListener("change", function () {
            handleUpdateCraft();
        });
    });
}
//! Pay Subscription or Old Delays
let paymentTypes = document.querySelectorAll("[data-payment-id]");
if (paymentTypes) {
    paymentTypes.forEach((payment) => {
        let subscriptionCost = document.querySelector(
            `input[name="subscription_cost"][data-payment-id="${payment.dataset.paymentId}"]`
        );
        let subscriptionPeriod = document.querySelector(
            `input[name="period"][data-payment-id="${payment.dataset.paymentId}"]`
        );
        let delayAmount = document.querySelector(
            `input[name="delays"][data-payment-id="${payment.dataset.paymentId}"]`
        );
        let delayPeriod = document.querySelector(
            `input[name="delays_period"][data-payment-id="${payment.dataset.paymentId}"]`
        );
        function handleDelay() {
            let selectedPayment = payment.options[payment.selectedIndex].value;
            if (selectedPayment === "إشتراك") {
                subscriptionCost.classList.remove("d-none");
                subscriptionPeriod.classList.remove("d-none");
                delayAmount.classList.add("d-none");
                delayPeriod.classList.add("d-none");
            } else if (selectedPayment === "متأخرات") {
                subscriptionCost.classList.add("d-none");
                subscriptionPeriod.classList.add("d-none");
                delayAmount.classList.remove("d-none");
                delayPeriod.classList.remove("d-none");
            } else {
                subscriptionCost.classList.add("d-none");
                subscriptionPeriod.classList.add("d-none");
                delayAmount.classList.add("d-none");
                delayPeriod.classList.add("d-none");
            }
        }
        payment.addEventListener("change", function () {
            handleDelay();
        });
    });
}
//! Validation Subscriber SSN
const ssn = document.getElementById('ssn')
const ssnMsg = document.getElementById("ssnMsg");
ssn.addEventListener('keypress', function () {
    const regSSN = /(?=.{14,})/;
    if (regSSN.test(ssn.value)) {
        ssn.classList.add("good");
        ssnMsg.classList.add("d-none");
    } else {
        ssn.classList.remove("good");
        ssn.classList.add("error");
        ssnMsg.classList.remove("d-none");
    }
})
//! Validation Subscriber Mobile
const mobile = document.getElementById("mobile_no");
const mobileMsg = document.getElementById("mobileMsg");
mobile.addEventListener("keypress", function () {
    const regMOB = /(?=.{11,})/;
    if (regMOB.test(mobile.value)) {
        mobile.classList.add("good");
        mobileMsg.classList.add("d-none");
    } else {
        mobile.classList.remove("good");
        mobile.classList.add("error");
        mobileMsg.classList.remove("d-none");
    }
});
//!
//!
//!
//!
//!
//!
//!
//!
//!
//!
//!
