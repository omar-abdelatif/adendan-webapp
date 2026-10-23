import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    //! CKEditor Initialization
    // const details = document.getElementById("newscontent");
    // if (details) {
    //     const isTouch = "ontouchstart" in window || navigator.maxTouchPoints > 0;
    //     CKEDITOR.replace("newscontent", {
    //         language: "ar",
    //         contentsLangDirection: "rtl",
    //         removePlugins: "elementspath",
    //         forcePasteAsPlainText: true,
    //         resize_enabled: false,
    //         toolbar: [
    //             {
    //                 name: "alignment",
    //                 items: ["JustifyRight", "JustifyCenter", "JustifyLeft"],
    //             },
    //             { name: "direction", items: ["BidiRtl", "BidiLtr"] },
    //             { name: "basicstyles", items: ["Bold", "Underline"] },
    //             { name: "paragraph", items: ["NumberedList", "BulletedList"] },
    //             { name: "links", items: ["Link", "Unlink"] },
    //             { name: "styles", items: ["Format", "Font", "FontSize"] },
    //             { name: "clipboard", items: ["Undo", "Redo"] },
    //         ],
    //         on: {
    //             contentDom: function (evt) {
    //                 if (!isTouch) return;
    //                 evt.editor.document.$.addEventListener( "contextmenu", function (e) { e.stopImmediatePropagation(); }, true );
    //             },
    //             instanceReady: function (evt) {
    //                 const editor = evt.editor;
    //                 const editable = editor.editable();
    //                 editor.document.appendStyleText(`
    //                     body.is-empty::before {
    //                         content: "اكتب تفاصيل الخبر هنا";
    //                         color: #aaa;
    //                         font-style: italic;
    //                         position: absolute;
    //                         pointer-events: none;
    //                     }
    //                 `);
    //                 const togglePlaceholder = () => {
    //                     const isEmpty = editable.getText().trim().length === 0;
    //                     editable.$.classList.toggle("is-empty", isEmpty);
    //                 };
    //                 editor.on("change", togglePlaceholder);
    //                 editor.on("mode", togglePlaceholder);
    //                 editor.on("focus", togglePlaceholder);
    //                 editor.on("blur", togglePlaceholder);
    //                 togglePlaceholder();
    //             },
    //         },
    //     });
    //     CKEDITOR.plugins.add("SmartPaste", {
    //         requires: "dialog",
    //         init: function (editor) {
    //             CKEDITOR.dialog.add("smartPasteDialog", function () {
    //                 return {
    //                     title: "لصق",
    //                     minWidth: 300,
    //                     minHeight: 120,
    //                     contents: [
    //                         {
    //                             id: "main",
    //                             elements: [
    //                                 {
    //                                     type: "textarea",
    //                                     id: "text",
    //                                     label: "اضغط مطولًا هنا واختر لصق",
    //                                     rows: 6,
    //                                 },
    //                             ],
    //                         },
    //                     ],
    //                     onShow: function () {
    //                         this.setValueOf("main", "text", "");
    //                     },
    //                     onOk: function () {
    //                         const text = this.getValueOf("main", "text");
    //                         if (text) editor.insertText(text);
    //                     },
    //                 };
    //             });
    //             editor.addCommand("smartPaste", {
    //                 exec: async function (editor) {
    //                     editor.focus();
    //                     if ( navigator.clipboard && navigator.clipboard.readText ) {
    //                         try {
    //                             const text =
    //                                 await navigator.clipboard.readText();
    //                             if (text) {
    //                                 editor.insertText(text);
    //                                 return;
    //                             }
    //                         } catch (e) {
    //                             // اترفض أو مش متاح، نكمل للـ fallback
    //                         }
    //                     }
    //                     editor.openDialog("smartPasteDialog");
    //                 },
    //             });
    //             editor.ui.addButton("SmartPaste", {
    //                 label: "لصق",
    //                 command: "smartPaste",
    //                 icon: "paste",
    //                 toolbar: "clipboard,0",
    //             });
    //         },
    //     });
    //     CKEDITOR.plugins.add("ConvertLinks", {
    //         init: function (editor) {
    //             editor.ui.addButton("ConvertLinks", {
    //                 label: "تحويل الروابط",
    //                 command: "convertLinks",
    //                 toolbar: "custom",
    //             });
    //             editor.addCommand("convertLinks", {
    //                 exec: function (editor) {
    //                     const rawText = editor
    //                         .getData()
    //                         .replace(/<[^>]*>/g, "")
    //                         .trim();
    //                     const urlRegex = /https?:\/\/[^\s<]+/g;
    //                     const updatedText = rawText.replace(
    //                         urlRegex,
    //                         function (url) {
    //                             return `<a href="${url}" target="_blank">${url}</a>`;
    //                         },
    //                     );
    //                     editor.setData(updatedText);
    //                 },
    //             });
    //         },
    //     });
    // }
    const details = document.getElementById("newscontent");
    if (details) {
        const isTouch = "ontouchstart" in window || navigator.maxTouchPoints > 0;
        CKEDITOR.plugins.add("SmartPaste", {
            requires: "dialog",
            init: function (editor) {
                CKEDITOR.dialog.add("smartPasteDialog", function () {
                    return {
                        title: "لصق",
                        minWidth: 300,
                        minHeight: 120,
                        contents: [
                            {
                                id: "main",
                                elements: [
                                    {
                                        type: "textarea",
                                        id: "text",
                                        label: "اضغط مطولًا هنا واختر لصق",
                                        rows: 6,
                                    },
                                ],
                            },
                        ],
                        onShow: function () {
                            this.setValueOf("main", "text", "");
                        },
                        onOk: function () {
                            const text = this.getValueOf("main", "text");
                            if (text) this.getParentEditor().insertText(text);
                        },
                    };
                });
                editor.addCommand("smartPaste", {
                    exec: async function (editor) {
                        editor.focus();
                        if ( navigator.clipboard && navigator.clipboard.readText ) {
                            try {
                                const text = await navigator.clipboard.readText();
                                if (text) {
                                    editor.insertText(text);
                                    return;
                                }
                            } catch (e) {
                                // اترفض أو مش متاح، نكمل للـ fallback
                            }
                        }
                        editor.openDialog("smartPasteDialog");
                    },
                });
                editor.ui.addButton("SmartPaste", {
                    label: "لصق",
                    command: "smartPaste",
                    icon: "paste",
                });
            },
        });
        CKEDITOR.plugins.add("ConvertLinks", {
            init: function (editor) {
                editor.addCommand("convertLinks", {
                    exec: function (editor) {
                        const doc = editor.document.$;
                        const urlRegex = /https?:\/\/[^\s<]+/g;
                        const walker = doc.createTreeWalker(
                            editor.editable().$,
                            NodeFilter.SHOW_TEXT,
                        );
                        const nodes = [];
                        while (walker.nextNode())
                            nodes.push(walker.currentNode);
                        editor.fire("saveSnapshot");
                        nodes.forEach((node) => {
                            if (node.parentNode.closest("a")) return;
                            const text = node.nodeValue;
                            const matches = [...text.matchAll(urlRegex)];
                            if (!matches.length) return;
                            const frag = doc.createDocumentFragment();
                            let last = 0;
                            matches.forEach((m) => {
                                frag.append(text.slice(last, m.index));
                                const a = doc.createElement("a");
                                a.href = m[0];
                                a.target = "_blank";
                                a.textContent = m[0];
                                frag.append(a);
                                last = m.index + m[0].length;
                            });
                            frag.append(text.slice(last));
                            node.replaceWith(frag);
                        });
                        editor.fire("saveSnapshot");
                    },
                });
                editor.ui.addButton("ConvertLinks", {
                    label: "تحويل الروابط",
                    command: "convertLinks",
                });
            },
        });
        CKEDITOR.replace("newscontent", {
            language: "ar",
            contentsLangDirection: "rtl",
            extraPlugins: "SmartPaste,ConvertLinks",
            removePlugins: "elementspath",
            forcePasteAsPlainText: true,
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
                { name: "clipboard", items: ["SmartPaste", "Undo", "Redo"] },
                { name: "custom", items: ["ConvertLinks"] },
            ],
            on: {
                contentDom: function (evt) {
                    if (!isTouch) return;
                    evt.editor.document.$.addEventListener(
                        "contextmenu",
                        function (e) {
                            e.stopImmediatePropagation();
                        },
                        true,
                    );
                },
                instanceReady: function (evt) {
                    const editor = evt.editor;
                    const editable = editor.editable();
                    editor.document.appendStyleText(`
                    body.is-empty::before {
                        content: "اكتب تفاصيل الخبر هنا";
                        color: #aaa;
                        font-style: italic;
                        position: absolute;
                        pointer-events: none;
                    }
                `);
                    const togglePlaceholder = () => {
                        const isEmpty = editable.getText().trim().length === 0;
                        editable.$.classList.toggle("is-empty", isEmpty);
                    };
                    editor.on("change", togglePlaceholder);
                    editor.on("mode", togglePlaceholder);
                    editor.on("focus", togglePlaceholder);
                    editor.on("blur", togglePlaceholder);
                    togglePlaceholder();
                },
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
