function postByAjax(url, method, formData, message) {
    $.ajax({
        method: method,
        data: formData,
        url: url,
        processData: false,
        contentType: false,
        success: function (data) {
            Swal.fire({
                icon: "success",
                title: message,
                text: data.message,
                showConfirmButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
            if (data.status && data.id) {
                document.querySelector(`#row_${data.id}`)?.remove();
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "حدث خطأ",
                text: xhr.responseJSON?.message || "حدث خطأ غير متوقع",
                showConfirmButton: true,
            });
        },
    });
}
//! Jquery
$(function () {
    //! Image Upload Preview
    $(document).on("change", "#image", function (e) {
        let memberId = $(this).data("member-id");
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#showImage_" + memberId).attr("src", e.target.result);
        };
        reader.readAsDataURL(e.target.files[0]);
    });
    //! Image Upload Preview For Update Subscriber ID Image
    $(document).on("change", "#id_img", function (e) {
        let memberId = $(this).data("member-id");
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#idImage_" + memberId).attr("src", e.target.result);
        };
        reader.readAsDataURL(e.target.files[0]);
    });
    //! Single Datatable
    $("#table").DataTable({
        paging: true,
        scrollY: 400,
        ordering: true,
        autoWidth: true,
        searching: true,
        pageLength: 20,
        pagingTag: "button",
        pagingType: "simple_numbers",
        ordering: true,
        deferRender: true,
    });
    //! Multi Datatables in Same Page
    let table = $("#table");
    if (table) {
        for (let i = 0; i < 500; i++) {
            $("#table" + i).DataTable({
                paging: true,
                scrollY: table[i],
                ordering: true,
                autoWidth: true,
                searching: true,
                pagingTag: "button",
                pagingType: "simple_numbers",
                deferRender: true,
            });
        }
    }
    //! Add new row
    $(".addRow").click(function () {
        let newRow = $(
            "<div class='d-flex align-items-center justify-content-evenly py-4 border-top border-bottom-2 border-white'>" +
                "<input type='text' name='url[]' class='form-control text-center text-white' placeholder='رابط الفيديو'>" +
                "<a href='javascript:void(0)' class='btn btn-danger px-2 py-2 removeRow ms-2'>-</a>" +
                "</div>",
        );
        $("#inputs").append(newRow);
    });
    //! Remove row
    $("#inputs").on("click", ".removeRow", function () {
        $(this).closest(".d-flex").remove();
    });
    //! Change Date Separator
    $(".datepicker-age").datepicker({
        dateFormat: "dd/mm/yyyy",
    });
    $(".datepicker-here").datepicker({
        dateFormat: "yyyy-mm-dd",
    });
    //! Approve or Reject Update Request
    let approveBtns = document.querySelectorAll(".approve-update-request");
    approveBtns.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            let form = this.closest("form");
            let url = form.getAttribute("action");
            let formData = new FormData(form);
            postByAjax(url, "POST", formData, "تم الموافقة على التعديلات");
        });
    });
    let declineBtns = document.querySelectorAll(".declined-update-request");
    declineBtns.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            let form = this.closest("form");
            let url = form.getAttribute("action");
            let formData = new FormData();
            postByAjax(url, "DELETE", formData, "تم رفض التعديلات");
        });
    });
});

//! JavaScript
document.addEventListener("DOMContentLoaded", function () {
    //! Remove Alert After 5 Seconds
    const errors = document.querySelectorAll("#error");
    errors.forEach((error) => {
        setTimeout(function () {
            error.style.display = "none";
        }, 5000);
    });
    //! Copy News Address
    document.querySelectorAll(".copy").forEach(function (btn) {
        btn.addEventListener("click", function () {
            let newsId = this.dataset.newsId;
            let baseUrl = window.location.origin;
            let publicUrl = `${baseUrl}/all_news/single_news/${newsId}`;
            let tempInput = document.createElement("input");
            tempInput.value = publicUrl;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            alert("تم نسخ رابط الخبر");
        });
    });
    //! Form For Get The Incomplete Data From The Subscssriber
    let searchedForms = document.querySelectorAll(
        ".searchedForm[data-form-id]",
    );
    if (searchedForms) {
        searchedForms.forEach((form) => {
            let url = form.getAttribute("action");
            let approveBtn = form.querySelector(".approve-request");
            approveBtn.addEventListener("click", function (e) {
                e.preventDefault();
                let formData = new FormData(form);
                postByAjax(url, "POST", formData, "تم الموافقة على التعديلات ");
            });
        });
    }
    //! Show Death State Container If The Subscriber Is Dead
    let deathOrNot = document.getElementById("deathOrNot");
    let deathStateContainer = document.getElementById("deathStateContainer");
    function toggleDeathState() {
        if (deathOrNot.checked) {
            deathStateContainer.classList.remove("d-none");
        } else {
            deathStateContainer.classList.add("d-none");
        }
    }
    if (deathOrNot && deathStateContainer) {
        deathOrNot.addEventListener("change", toggleDeathState);
        toggleDeathState();
    }
});
