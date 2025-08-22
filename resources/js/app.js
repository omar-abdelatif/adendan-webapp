import './bootstrap';

function postByAjax() {
    console.log("hello from post by ajax function");
}

//! Vanilla JavaScript Codes
document.addEventListener("DOMContentLoaded", function () {
    let textAreas = document.querySelectorAll("textarea[data-news-id]");
    if (textAreas) {
        textAreas.forEach(function (item) {
            ClassicEditor.create(item).then((editor) => {
                ckEditorInstance = editor;
                editor.model.document.on("change:data", () => {
                    const rawText = editor.getData().replace(/<[^>]*>/g, "").trim();
                    if (rawText.length > 0) {
                        const firstChar = rawText.charAt(0);
                        const isArabic = /[\u0600-\u06FF]/.test(firstChar);
                        editor.editing.view.change((writer) => {
                            writer.setAttribute( "direction", isArabic ? "rtl" : "ltr", editor.editing.view.document.getRoot() );
                        });
                    }
                });
                editor.model.document.registerPostFixer((writer) => {
                    const root = editor.model.document.getRoot();
                    for (const range of root.getChildren()) {
                        for (const item of range.getChildren()) {
                            if (item.is("textProxy")) {
                                const urlMatch = item.data.match(/https?:\/\/[^\s<]+/);
                                if (urlMatch) {
                                    writer.setAttribute( "linkHref", urlMatch[0], item );
                                }
                            }
                        }
                    }
                    return false;
                });
            }).catch((err) => console.error(err));
        });
    }
});
//! Jquey Codes
$(function () {
    let approveBtn = $(".approve-request");
    approveBtn.each(function () {
        let approveIdBtn = $(this).data("approve-id");
        $(this).on("click", function () {
            postByAjax();
        });
    });
});