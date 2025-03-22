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
                "</div>"
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
    //! Copy News Address
    $(".copy").click(function () {
        let newsId = $(this).data("news-id");
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
//! Remove Alert After  5 Seconds
const errors = document.querySelectorAll("#error");
errors.forEach((error) => {
    setTimeout(function () {
        error.style.display = "none";
    }, 5000);
});

