function postByAjax(url, method, formData, message, rowId = null) {
    $.ajax({
        url: url,
        method: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            Swal.fire({
                icon: "success",
                title: message,
                text: data.message,
                showConfirmButton: true,
            });
            if (data.status && data.id) {
                document.querySelector(`#row_${data.id}`)?.remove();
            }
        },
        error: function (xhr, status, error) {
            console.log("Error:", error);
        },
    });
}
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
    //! Use CK EDITOR
    let textAreas = document.querySelectorAll("textarea[data-news-id]");
    if (textAreas.length > 0) {
        textAreas.forEach(function (item) {
            if (textarea.ckEditorInitialized) {
                console.warn("CKEditor already created on this textarea. Skipping...");
                return;
            }
            ClassicEditor.create(item).then((editor) => {
                ckEditorInstance = editor;
                editor.editing.view.change((writer) => {
                    const root = editor.editing.view.document.getRoot();
                    writer.setAttribute("dir", "rtl", root);
                    writer.setStyle("text-align", "right", root);
                });
                editor.model.document.on("change:data", () => {
                    editor.editing.view.change((writer) => {
                        const root = editor.editing.view.document.getRoot();
                        writer.setAttribute("dir", "rtl", root);
                        writer.setStyle("text-align", "right", root);
                    });
                });
                editor.editing.view.document.on("clipboardInput",(evt, data) => {
                        editor.editing.view.change((writer) => {
                            const root =
                                editor.editing.view.document.getRoot();
                            writer.setAttribute("dir", "rtl", root);
                            writer.setStyle("text-align", "right", root);
                        });
                        if (data.content) {
                            editor.model.change((writer) => {
                                for (const child of data.content.getChildren()) {
                                    if (child.is("element")) {
                                        writer.setAttribute(
                                            "direction",
                                            "rtl",
                                            child
                                        );
                                        writer.setAttribute(
                                            "textAlignment",
                                            "right",
                                            child
                                        );
                                    }
                                }
                            });
                        }
                    },{ priority: "high" }
                );
                editor.model.document.registerPostFixer(() => {
                    const root = editor.model.document.getRoot();
                    let changed = false;
                    for (const child of root.getChildren()) {
                        if (child.is("element")) {
                            for (const node of child.getChildren()) {
                                if (
                                    node.is("text") &&
                                    !node.hasAttribute("linkHref")
                                ) {
                                    const text = node.data;
                                    const urlRegex =
                                        /https?:\/\/[^\s<>"{}|\\^`\[\]]+/g;
                                    let match;
                                    while (
                                        (match = urlRegex.exec(text)) !==
                                        null
                                    ) {
                                        const start = match.index;
                                        const end = start + match[0].length;
                                        const range =
                                            editor.model.createRange(
                                                editor.model.createPositionAt(
                                                    child,
                                                    start
                                                ),
                                                editor.model.createPositionAt(
                                                    child,
                                                    end
                                                )
                                            );
                                        editor.model.change((writer) => {
                                            writer.setAttribute(
                                                "linkHref",
                                                match[0],
                                                range
                                            );
                                        });
                                        changed = true;
                                    }
                                }
                            }
                        }
                    }
                    return changed;
                });
            }).catch((err) => console.error(err));
        });
    }
    //! Form For Get The Incomplete Data From The Subscssriber
    let searchedForms = document.querySelectorAll(".searchedForm[data-form-id]");
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
});