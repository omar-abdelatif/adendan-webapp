import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    //! CKEditor Initialization
    const details = document.getElementById("newscontent");
    if (details) {
        CKEDITOR.replace("newscontent", {
            language: "ar",
            contentsLangDirection: "rtl",
            contentsCss: [
                CKEDITOR.basePath + "contents.css",
                `p[data-placeholder]:empty::before {
                    content: attr(data-placeholder);
                    color: #aaa;
                    font-style: italic;
                    pointer-events: none;
                    display: block;
                }`,
            ],
            removePlugins: "elementspath",
            resize_enabled: false,
            toolbar: [
                {
                    name: "alignment",
                    items: ["JustifyRight", "JustifyCenter", "JustifyLeft"],
                },
                { name: "direction", items: ["BidiRtl", "BidiLtr"] },
                { name: "basicstyles", items: ["Bold", "Underline"] },
                { name: "paragraph", items: ["NumberedList", "BulletedList"] },
                { name: "links", items: ["Link", "Unlink"] },
                { name: "styles", items: ["Format", "Font", "FontSize"] },
                { name: "clipboard", items: ["Undo", "Redo"] },
            ],
            on: {
                instanceReady: function (evt) {
                    const editor = evt.editor;
                    if (!editor.getData().trim()) {
                        editor.setData(
                            '<p data-placeholder="اكتب تفاصيل الخبر هنا"></p>',
                        );
                    }
                    editor.on("change", function () {
                        const content = editor.getData();
                        const updated = content.replace(
                            /<p([^>]*)data-placeholder="[^"]*"([^>]*)>(.*?)<\/p>/gi,
                            function (match, before, after, inner) {
                                return inner.trim().length > 0
                                    ? `<p${before}${after}>${inner}</p>`
                                    : match;
                            },
                        );
                        if (updated !== content) {
                            editor.setData(updated);
                        }
                    });
                },
            },
        });
        CKEDITOR.plugins.add("ConvertLinks", {
            init: function (editor) {
                editor.ui.addButton("ConvertLinks", {
                    label: "تحويل الروابط",
                    command: "convertLinks",
                    toolbar: "custom",
                });
                editor.addCommand("convertLinks", {
                    exec: function (editor) {
                        const rawText = editor
                            .getData()
                            .replace(/<[^>]*>/g, "")
                            .trim();
                        const urlRegex = /https?:\/\/[^\s<]+/g;
                        const updatedText = rawText.replace(
                            urlRegex,
                            function (url) {
                                return `<a href="${url}" target="_blank">${url}</a>`;
                            },
                        );
                        editor.setData(updatedText);
                    },
                });
            },
        });
    }
    //! Use CK EDITOR In Update Modal
    document.addEventListener("show.bs.modal", function (event) {
        const modal = event.target;
        if (!modal.id.startsWith("editing_")) return;
        const textarea = modal.querySelector("textarea[data-news-id]");
        if (!textarea || textarea.dataset.ckInitialized) return;
        textarea.dataset.ckInitialized = "true";
        const originalContent = textarea.value;
        CKEDITOR.replace(textarea.id, {
            language: "ar",
            contentsLangDirection: "rtl",
            extraPlugins: "ConvertLinks",
            toolbar: [
                {
                    name: "alignment",
                    items: ["JustifyRight", "JustifyCenter", "JustifyLeft"],
                },
                { name: "direction", items: ["BidiRtl", "BidiLtr"] },
                { name: "basicstyles", items: ["Bold", "Underline"] },
                { name: "paragraph", items: ["NumberedList", "BulletedList"] },
                { name: "links", items: ["Link", "Unlink"] },
                { name: "styles", items: ["Format", "Font", "FontSize"] },
                { name: "clipboard", items: ["Undo", "Redo"] },
            ],
            on: {
                instanceReady: function (evt) {
                    evt.editor.setData(originalContent);
                },
            },
        });
        const form = textarea.closest("form");
        if (form) {
            form.addEventListener("submit", () => {
                textarea.value = CKEDITOR.instances[textarea.id].getData();
            });
        }
    });
});
