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
//!
function handleChange() {
    let selectElement = document.getElementById("subscriptionType");
    let inputField = document.getElementById("inputField");
    let inputLabel = document.getElementById("inputLabel");

    if (selectElement.value === "subscription") {
        inputField.setAttribute("name", "subscription");
        inputField.setAttribute("placeholder", "أدخل مبلغ الإشتراك");
        inputLabel.innerText = "مبلغ الإشتراك";
    } else if (selectElement.value === "delay") {
        inputField.setAttribute("name", "delay");
        inputField.setAttribute("placeholder", "أدخل مبلغ المتأخرات");
        inputLabel.innerText = "مبلغ المتأخرات";
    }
}
//! updateCraft
let selectElements = document.querySelectorAll("[data-worker-id]");
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
//!
//!
//!
//!
//!
//!
//!
