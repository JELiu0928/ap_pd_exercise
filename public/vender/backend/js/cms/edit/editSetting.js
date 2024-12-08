export function colorPickerSetting() {
    const self = this;
    return {
        color:
            self.val()?.length == 0 || self.val() == null
                ? "#000000"
                : self.val(),
        preferredFormat: "hex3",
        hideAfterPaletteSelect: false,
        showSelectionPalette: false,
        showButtons: false,
        showInput: true,
        showInitial: true,
        showAlpha: true,
        showPalette: true,
        palette: [
            ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
            ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
            [
                "#f4cccc",
                "#fce5cd",
                "#fff2cc",
                "#d9ead3",
                "#d0e0e3",
                "#cfe2f3",
                "#d9d2e9",
                "#ead1dc",
            ],
            [
                "#ea9999",
                "#f9cb9c",
                "#ffe599",
                "#b6d7a8",
                "#a2c4c9",
                "#9fc5e8",
                "#b4a7d6",
                "#d5a6bd",
            ],
            [
                "#e06666",
                "#f6b26b",
                "#ffd966",
                "#93c47d",
                "#76a5af",
                "#6fa8dc",
                "#8e7cc3",
                "#c27ba0",
            ],
            [
                "#c00",
                "#e69138",
                "#f1c232",
                "#6aa84f",
                "#45818e",
                "#3d85c6",
                "#674ea7",
                "#a64d79",
            ],
            [
                "#900",
                "#b45f06",
                "#bf9000",
                "#38761d",
                "#134f5c",
                "#0b5394",
                "#351c75",
                "#741b47",
            ],
            [
                "#600",
                "#783f04",
                "#7f6000",
                "#274e13",
                "#0c343d",
                "#073763",
                "#20124d",
                "#4c1130",
            ],
        ],
        change: function (color) {
            self.parent("div")
                .children("div.ticket_field")
                .children("p")
                .text(color);
            self.val(color); // #ff0000
        },
        beforeShow: function(container) {
            let _thisBefor = $(this);
            _thisBefor.spectrum("container").find('.color_picker_palette').remove();
            let html = '<div class="color_picker_palette"><label>常用顏色</label><div class="color_picker_list"></div></div>';
            _thisBefor.spectrum("container").append(html);
            $.ajax({
                url: "//" + location.host + "/Fantasy/Color",
                type: 'GET',
                dataType: 'JSON',
                cache: false,
                data: {
                    action: 'load',
                    color: ''
                }
            }).done(function (response) {
                const color_div = response
                    .map(function (val) {
                        return (
                            '<div><span data-color="' +
                            val +
                            '" style="background-color:' +
                            val +
                            ';"></span><a class="color_picker_del"><i class="fa fa-remove"></i></a></div>'
                        );
                    })
                    .join("");
                $(".color_picker_list").html(color_div);
                $('.color_picker_list span').on('click', function () {
                    let color = $(this).attr('data-color');
                    self.parent("div")
                        .children("div.ticket_field")
                        .children("p")
                        .text(color);
                    self.val(color); // #ff0000
                    _thisBefor.spectrum("set", color);
                });
                $('.color_picker_del').on('click', function () {
                    let _color = $(this).closest('div').find('span').attr('data-color');
                    if (confirm('是否刪除?')) {
                        reload_color('del', _color);
                        $(this).closest('div').remove();
                    }
                });
            }).fail(function () {
                console.log("data error");
            });
            // return false; // Will never show up
        }
    };
}

export const datePickerSetting = {
    default: {
        todayHighlight: true,
        autoclose: true,
        language: "zh-TW",
        format: "yyyy-mm-dd",
    },
    custom: {
        todayHighlight: false,
        autoclose: true,
        language: "zh-TW",
        format: "yyyy-mm-dd",
    }
};
export const timePickerSetting = {
    default: {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        defaultTime: '00:00',
        time_24hr: true,
        showSeconds: false, // Display seconds
        showMeridian: false //Do not display AM/PM options
    },
    custom: {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i:s',
        defaultTime: '00:00:00',
        time_24hr: true,
        showSeconds: true, // Display seconds
        showMeridian: false //Do not display AM/PM options
    },
}
var FmsButton = function (context) {
    var ui = $.summernote.ui;

    // create button
    var button = ui.button({
        contents: '<i class="fa fa-regular fa-image">',
        tooltip: "選擇圖片",
        container: $(".note-editor.note-frame"),
        click: function () {
            window.cms_open_file = context.$note[0];
            $.ajax({
                url: $(".base-url").val() + "/Ajax/fms-lbox/img/summernote/0",
                type: "GET",
                dataType: "JSON",
                cache: false,
                data: {
                    cms_open: true,
                },
            })
                .done(function (response) {
                    const frame = $(".fms_lbox .frame").first();
                    frame.html(response.blade);
                    $("#folder_id").val(response.folder_id);

                    $("body")[0].fms_data_key = 'summernote';
                    $("body")[0].fms_data_type = 'img';
                    //需啟動的JS
                    fms_lightbox();

                    $(".Leon-fms-check-all").hide();
                    $(".fms-move").parents(".btn-item").hide();
                    $(".Leon_fms_table")
                        .addClass("one_shot")
                        .removeClass("multi_shot");

                    // set_fms_basic(false);
                    $(
                        '.tree-title[data-folder-id="' +
                            response.folder_id +
                            '"]'
                    ).click();
                    Leon_fms_wrapper();
                    $(".tree-title.trash").parent().hide();
                    $(".fmsAjaxArea.fms_lbox").addClass("active");
                    $(".fmsAjaxArea.fms_lbox .ajaxItem").addClass("active");
                    $(
                        ".fmsAjaxArea.fms_lbox .ajaxItem .fms_container "
                    ).addClass("active");

                    setTimeout(function () {
                        $(".fmsAjaxArea.fms_lbox")
                            .addClass("open")
                            .removeClass("active");
                        $(".fmsAjaxArea.fms_lbox .ajaxItem")
                            .addClass("open")
                            .removeClass("active");
                        $(".fmsAjaxArea.fms_lbox .ajaxItem .fms_container ")
                            .addClass("open")
                            .removeClass("active");
                    }, 0);

                    setTimeout(() => {
                        frame.find(".content-scrollbox").scrollbar();
                        const scroll = frame.find(".scroll-content");
                        const checked = frame.find(
                            ".fms_lbox_file_select_checkbox:checked"
                        );
                        if (scroll.length > 0 && checked.length > 0) {
                            scroll.scrollTop(
                                checked.eq(0).closest(".fms_list").position()
                                    .top -
                                    window.innerHeight / 4
                            );
                        }
                    }, 1000);
                })
                .fail(function () {
                    console.log("delete data error");
                });
        },
    });
    return button.render();
};
export const summernoteSetting = {
    default: {
        placeholder: "Type some words ...",
        tabsize: 2,
        height: 250,
        lang: "zh-TW",
        disableDragAndDrop: true,
        popover: {
            image: [
                [
                    "image",
                    ["resizeFull", "resizeHalf", "resizeQuarter", "resizeNone"],
                ],
                // ['float', ['floatLeft', 'floatRight', 'floatCenter', 'floatNone']],
                ["remove", ["removeMedia"]],
            ],
        },
        toolbar: [
            ["color", ["color"]],
            ["font", ["bold", "underline"]],
            ["para", ["ul", "ol"]],
            ["insert", ["link"]],
            ["lbox_fms_open", ["fmsbtn"]],
            ["misc", ["codeview"]],
        ],
        buttons: {
            fmsbtn: FmsButton,
        },
        icons: {
            bold: "icon-bold",
            underline: "icon-underline",
            link: "icon-link",
        },
        callbacks: {
            onChange: function(contents, $editable) {
                if(contents == "<p><br></p>"){
                    $($editable).html("");
                }
            },
            onImageUpload: function onImageUpload(data) {
                data.pop();
            },
            onPaste: function (e) {
                var bufferText = (
                    (e.originalEvent || e).clipboardData || window.clipboardData
                ).getData("Text");
                e.preventDefault();
                document.execCommand("insertText", false, bufferText);
            },
        },
    },
    custom: {
        placeholder: "Type some words ...",
        tabsize: 2,
        height: 250,
        lang: "zh-TW",
        toolbar: [
            ["para", ["ul", "ol"]],
            ["misc", ["codeview"]],
        ],
        icons: {
            bold: "icon-bold",
            underline: "icon-underline",
            link: "icon-link",
        },
        callbacks: {
            onChange: function(contents, $editable) {
                if(contents == "<p><br></p>"){
                    $($editable).html("");
                }
            },
            onImageUpload: function onImageUpload(data) {
                data.pop();
            },
            onPaste: function (e) {
                var bufferText = (
                    (e.originalEvent || e).clipboardData || window.clipboardData
                ).getData("Text");
                e.preventDefault();
                document.execCommand("insertText", false, bufferText);
            },
        },
    },
    simple: {
        placeholder: "Type some words ...",
        tabsize: 2,
        height: 250,
        lang: "zh-TW", 
        toolbar: [
            ['font', ['bold','superscript','subscript']],
        ],
        icons: {
            bold: "icon-bold",
        },
        callbacks: {
            onImageUpload: function onImageUpload(data) {
                data.pop();
            },
            onPaste: function (e) {
                var bufferText = (
                    (e.originalEvent || e).clipboardData || window.clipboardData
                ).getData("Text");
                e.preventDefault();
                document.execCommand("insertText", false, bufferText);
            },
        },
    },
    article_news: {
        placeholder: "Type some words ...",
        tabsize: 2,
        height: 250,
        lang: "zh-TW", 
        toolbar: [
            ['font', ['bold', 'underline','superscript','subscript']],
            ["para", ["ul", "ol"]],
            ["insert", ["link"]],
            ["lbox_fms_open", ["fmsbtn"]],
        ],
        icons: {
            bold: "icon-bold",
            underline: "icon-underline",
            link: "icon-link",
        },
        callbacks: {
            onImageUpload: function onImageUpload(data) {
                data.pop();
            },
            onPaste: function (e) {
                var bufferText = (
                    (e.originalEvent || e).clipboardData || window.clipboardData
                ).getData("Text");
                e.preventDefault();
                document.execCommand("insertText", false, bufferText);
            },
        },
    },
};
