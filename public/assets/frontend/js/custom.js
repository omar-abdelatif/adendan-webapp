//! Fixed Navbar
window.addEventListener("scroll", () => {
    if (window.scrollY > 150) {
        document.querySelector(".navbar").classList.add("fixed");
    } else {
        document.querySelector(".navbar").classList.remove("fixed");
    }
});
//! Play Music On Page Load
// document.addEventListener("DOMContentLoaded", function () {
//     var audio = document.getElementById("audio-player");
//     var hasPlayed = false; // Flag to track playback status

//     window.addEventListener("scroll", function () {
//         if (window.scrollY > 10 && !hasPlayed) {
//             hasPlayed = true;
//             setTimeout(function () {
//                 audio.play();
//             }, 3000);
//         }
//     });
// });
//! Arabic Direction To The News Bar
$(document).ready(function () {
    $("#newsTicker2").breakingNews({
        direction: "rtl",
    });
});
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

$(function () {
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
});
