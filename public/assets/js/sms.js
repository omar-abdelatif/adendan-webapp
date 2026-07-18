$(function () {
    let renewBtns = document.querySelectorAll(".renew");
    if (renewBtns.length > 0) {
        renewBtns.forEach((btn) => {
            $(document).on("click", ".renew", function () {
                let memberId = $(this).data("member-id");
                let subscriberId = $(this).data("subscriber-id");
                let renewUrl = $(this).data("renew-url");
                console.log(renewUrl, subscriberId, memberId);
                Swal.fire({
                    title: "تأكيد التجديد",
                    text: "هل أنت متأكد أنك تريد تجديد اشتراك هذا المشترك؟",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "نعم، جدد الاشتراك",
                    cancelButtonText: "لا، إلغاء",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: renewUrl,
                            method: "PUT",
                            data: { member_id: memberId },
                            headers: { "X-CSRF-TOKEN": window.csrfToken },
                            success: function (data) {
                                Swal.fire({
                                    icon: "success",
                                    title: "تم التجديد بنجاح",
                                    text: data.message,
                                    showConfirmButton: true,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    "خطأ",
                                    "حدث خطأ أثناء التجديد: " + error,
                                    "error",
                                );
                            },
                        });
                    }
                });
            });
        });
    }
});
document.addEventListener("DOMContentLoaded", function () {
    //! Send SMS
    let smsForm = document.getElementById("smsForm");
    if (smsForm) {
        smsForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const content = document.getElementById("msg_content").value;
            sendSms(content, null);
        });
        function sendSms(content, numbers) {
            const payload = { content };
            if (numbers) payload.numbers = numbers;
            Swal.fire({
                title: "جارٍ إرسال الرسائل...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            fetch(window.smsRoutes.storeMsg, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => {
                    if (!res.ok) {
                        return res.json().then((err) => {
                            throw new Error(err.message || "حدث خطأ");
                        });
                    }
                    return res.json();
                })
                .then((data) => {
                    setTimeout(() => {
                        Swal.close();
                        const hasFailures = data.failed_count > 0;
                        Swal.fire({
                            icon: hasFailures ? "warning" : "success",
                            title: "نتيجة الإرسال",
                            html: `
                            <p>✅ نجاح: <strong>${data.success_count}</strong></p>
                            <p>❌ فشل: <strong>${data.failed_count}</strong></p>
                        `,
                            confirmButtonText: hasFailures ? "إعادة إرسال للفاشلين" : "حسناً",
                            confirmButtonColor: hasFailures ? "#f0ad4e" : "#3085d6",
                            showCancelButton: hasFailures,
                            cancelButtonText: "إغلاق",
                        }).then((result) => {
                            if (result.isConfirmed && hasFailures) {
                                sendSms(content, data.failed_numbers);
                            }
                        });
                    }, 10000);
                })
                .catch((error) => {
                    Swal.close();
                    Swal.fire("خطأ", error.message, "error");
                });
        }
    }
    //! Show Balance
    fetch(window.smsRoutes.balance).then((res) => res.json()).then((data) => {
        document.getElementById("balance-remining").textContent = data.balance;
    });
    //! Message Length and SMS Count
    document.getElementById("msg_content").addEventListener("input", function () {
        const length = this.value.length;
        document.getElementById("char_count").textContent = length;
        let smsCount = 1;
        if (length <= 70) smsCount = 1;
        else if (length <= 137) smsCount = 2;
        else if (length <= 204) smsCount = 3;
        else if (length <= 271) smsCount = 4;
        else if (length <= 338) smsCount = 5;
        else smsCount = Math.ceil((length - 70) / 67) + 1;
        document.getElementById("sms_count").textContent = smsCount;
    });
});
