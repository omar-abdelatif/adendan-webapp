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
        autoWidth: true,
        searching: true,
        pageLength: 20,
        pagingTag: "button",
        pagingType: "simple_numbers",
        ordering: true,
    });
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
    //! Get Cost By Years
});
//! Multi Datatables in Same Page
for (let i = 0; i < 500; i++) {
    let table = document.querySelector("#table" + i);
    new DataTable(table, {
        paging: true,
        // scrollY: tables[i],
        ordering: true,
        autoWidth: true,
        searching: true,
        pagingTag: "button",
        pagingType: "simple_numbers",
        deferRender: true,
        // serverSide: true,
        scroller: {
            loadingIndicator: true,
        },
    });
}
//! Remove Alert After  5 Seconds
const errors = document.querySelectorAll("#error");
errors.forEach((error) => {
    setTimeout(function () {
        error.style.display = "none";
    }, 5000);
});

