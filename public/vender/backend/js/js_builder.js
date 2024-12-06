/* ============================================================
 * js_builder.js
 * ============================================================ */

$(document).ready(function () {
    $(".hiddenArea_frame .menu_list ul").scrollbar();

    list_headBar_switch();

    list_body_switch();

    builder_checkbox();

    //下拉選單
    //quill_select();

    //partTable(段落表格)
    // quill_table();

    /* 2019.02.15 新增 */
    tabSelector();
    toggleList();

    //partImg(圖片 / 影片管理)
    partImg_inventory_thead_td();
    partImg_openPreview();
    partImg_closePreview();
    partImg_embed();

    //partContent(段落內容 / 設定)
    // partContent_textEditor();

    //基本內容編輯(baseContentEdit)
    // baseContentEdit();

    //quill_input_tag
    quill_input_tag();

    //把content-sidebar 底下的 body-list 原本套版綁的scrollbar拿掉
    //重綁在sidebar-menu 這樣才不會在高度768的時候跑版
    content_sidebar();

    //file_path_frame(檔案路徑)
    file_path_frame();

    // file_path_frame(檔案路徑) Alex 新增
    filePathSelect();
});

//重綁在sidebar-menu
function content_sidebar() {
    $(".body-list").scrollbar("destroy");
    $(".content-sidebar .sidebar-menu").scrollbar();
}

//開啟段落
function list_body_switch() {
    $("body").on("click", ".btn_ctable", function () {
        $(this).closest("form").toggleClass("active");
        if ($(this).hasClass("fa-pencil-square-o")) {
            var _this = $(this).parent();
        } else {
            var _this = $(this);
        }
        const box = _this.closest(".list").find(".list_frame");
        if (box.length > 0) {
            const scroll_body = $(this).closest(".scroll-content");
            const a = $(this).closest(".list_box");
            const parentsForm = a.parents("form").first();
            const listFrame = a.siblings(".list_frame");
            listFrame.fadeToggle().promise().done(function () {
                if (!listFrame.hasClass("open")) {
                    if (!parentsForm.hasClass("three-item")) {
                        scroll_body.animate({scrollTop:_this.parents("form:not([id])").position().top - 38});
                    } else {
                        //第三層
                        scroll_body.animate({scrollTop:_this.parents("form:not([id])").last().position().top +_this.parents("form").first().position().top -80});
                    }
                }
                listFrame.toggleClass("open");
            });
        }
    });
}

//段落的切換
function list_headBar_switch() {
    var object = $(".list_frame .list_headBar li");
    var object2 = ".list_frame .list_headBar li";
    var goal = $(".list_frame .list_body .list_bodyL");

    $("body").on("click", object2, function () {
        var barID = $(this).attr("bar-id");
        if (barID == 4) {
            let fruits = [
                "typeF",
                "typeFL",
                "typeFR",
                "typeFBox",
                "typeFBoxL",
                "typeFBoxR",
                "_article -typeFull-BoxSlice",
                "_article -typeFull-BoxSlice",
                "_article -typeFull-BoxSlice-L",
                "_article -typeFull-BoxSlice-R",
            ];
            let article_type = $(this)
                .closest(".list_frame")
                .find("[name*='article_style']")
                .val();
            if (fruits.indexOf(article_type) < 0) {
                alert("段落樣式請選擇滿版模式");
                return false;
            }
        }
        //對自己的list做class的切換
        $(this).closest(".list_headBar").find("li").removeClass("now");
        // $(this).siblings().removeClass('now');
        $(this).addClass("now");

        //開啟自己這個list的內容
        $(this).closest(".list_frame").find(".list_bodyL").hide();
        // $(this).closest('.list_frame').find('.list_bodyL [body-id=""]').eq(a).fadeIn();
        // $(this).closest('.list_frame').find('.list_bodyL [body-id="' + a + '"]').fadeIn();
        $(this)
            .closest(".list_frame")
            .find('.list_bodyL[body-id="' + barID + '"]')
            .fadeIn();
    });
}

// 2019.02.15 新增段落切換
function tabSelector() {
    var objArray = Array.apply(null, document.querySelectorAll(".tab_box"));
    objArray.forEach(function (obj) {
        var objTabBtn = Array.apply(null, obj.querySelectorAll(".tab_btn"));
        var objTabContent = Array.apply(
            null,
            obj.querySelectorAll(".tab_body")
        );
        objTabBtn.forEach(function (btnObj) {
            btnObj.addEventListener("click", function () {
                var _this = this;
                var tabIndex = this.dataset.tab;
                var siblings = Array.prototype.filter.call(
                    this.parentNode.children,
                    function (child) {
                        return child !== _this;
                    }
                );
                siblings.forEach(function (el) {
                    el.classList.remove("active");
                });
                this.classList.add("active");
                objTabContent.forEach(function (bodyObj) {
                    bodyObj.dataset.tab === tabIndex
                        ? bodyObj.classList.add("active")
                        : bodyObj.classList.remove("active");
                });
            });
        });
    });
}

//隱藏選單checkbox
function builder_checkbox() {
    var content_input = $(".hiddenArea");
    content_input.on("click", ".content_input", function () {
        // if (!$(this).closest('.list').hasClass('chosen')) {
        //     $(this).closest('.tabulation_body').children('div').each(function(index, el) {
        //         $(this).removeClass('chosen');
        //         $(this).children('div').children('.check_box').removeClass('show');

        //     });
        // }

        if ($(this).hasClass("list_checkbox") == true) {
            var a = $(this).closest("form");
            a.hasClass("chosen") == false
                ? a.addClass("chosen")
                : a.removeClass("chosen");
        }

        if ($(this).closest(".table_box").hasClass("quill_table") == true) {
            //在這裡重付命名變數原因是 如果在一開始做，會造成當row 或 col動態新增完畢後 他們的check_box不會被算在裡面
            //所以每次點擊的時候才對變數命名 符合動態效果
            // var quill_table = $('.quill_table .check_box');
            // quill_table.removeClass('show');
            $(this).closest(".check_box").toggleClass("show");
        } else if (
            $(this).closest(".table_box").hasClass("quill_partImg") == true
        ) {
            // var quill_partImg = $('.quill_partImg .check_box');
            // quill_partImg.removeClass('show');
            $(this).closest(".check_box").toggleClass("show");
        } else {
            $(this).closest(".check_box").toggleClass("show");
        }
    });
}

//file_path_frame(檔案路徑)
function file_path_frame() {
    var _this = $("body"),
        sidebar = $(".file_path_frame .content-sidebar");

    //open
    _this.on("click", ".open_file_path_btn", function () {
        var key = $(this).attr("data-key");
        var target_sidebar = $(
            ".file_path_frame .content-sidebar[data-key=" + key + "]"
        );
        target_sidebar.addClass("show_path_box");
    });

    //close
    _this.on("click", ".close_file_path_btn", function () {
        if (sidebar.hasClass("show_path_box")) {
            sidebar.addClass("unshow_path_box").removeClass("show_path_box");
            setTimeout(function () {
                sidebar.removeClass("unshow_path_box");
            }, 1000);
        }
    });
}

//下拉選單
//**************************************//
// quill_select_single (單選模式)        //
// quill_select_multi  (多選模式)        //
//**************************************//
function quill_select() {
    var quill_select_num = $(".quill_select").length;
    // 將scroll綁定到下拉選單上
    var select_list = $(".quill_select .select_list");
    active_scrollBar(select_list);

    //開關事件
    $(".quill_select:not(.active_select)").on(
        "click",
        ".select_object",
        function (e) {
            var $this = $(this);
            var obj_height = $this.outerHeight() - 1;
            if ($this.closest(".quill_select").hasClass("no_effect")) {
                return;
            } else if (!$this.closest(".quill_select").hasClass("open")) {
                $this
                    .closest(".quill_select")
                    .find(".select_wrapper")
                    .css("top", obj_height);
                $this.closest(".quill_select").addClass("open");
                $this.parents(".quill_select").on("blur", function () {
                    $this.closest(".quill_select").removeClass("open");
                    $this.parents(".quill_select").off("blur");
                });
            } else {
                $this.closest(".quill_select").removeClass("open");
            }
        }
    );

    quill_select_multi($(".quill_select.multi_select:not(.active_select)"));
    quill_select_single($(".quill_select:not(.multi_select,.active_select)"));

    setTimeout(function () {
        $(".quill_select").addClass("active_select");
    }, 500);
}

function quill_select_single(quill_select) {
    quill_select.on("click", ".select_list .option", function () {
        var a = $(this).find("p").text();
        $(this).closest(".quill_select").find(".select_object .title").text(a);
        $(this).closest(".quill_select").removeClass("open");
    });
}

$("body").on("click", ".fms_gd_select_list li", function () {
    // var _area = $('input.fileAreaSupportSet');
    // var _area_first = _area.data('first');
    // var _area_second = _area.data('second');
    // var _area_third = _area.data('third');
    // var _area_branch = _area.data('branch');
    // $('body').find('.fms_gd_select_list li').removeClass('checked');
    // $(this).addClass('checked');
    // change_fms_file_gd_table(_area_first, _area_second, _area_third, _area_branch);
});

function quill_select_multi(quill_select) {
    quill_select.each(function () {
        var this_select = $(this);
        var default_obj = this_select.find(".default");
        var option_code = this_select.find(".option");
        //給option上代號
        for (var c = 0; c < option_code.length; c++) {
            option_code.eq(c).attr("option-id", c);
        }
        //尋找預設的內容
        for (var b = 0; b < default_obj.length; b++) {
            var default_value = default_obj
                .eq(b)
                .addClass("on")
                .find("p")
                .html();
            var default_id = default_obj.eq(b).attr("option-id");
            this_select
                .find(".title")
                .append(
                    ' <span class="item multiOption_' +
                        default_id +
                        '" option-id="' +
                        default_id +
                        '"><i class="number"></i><i class="name">' +
                        default_value +
                        '</i><i class="icon_remove fa fa-remove"></i></span> '
                );
            //
            var option = this_select.find(".title .item:eq(" + b + ") .number");
            var s_num = b + 1;
            option.append("0" + s_num + ".");
        }
    });
    //多選的點擊事件

    quill_select.on("click", ".option", function () {
        var _parent = $(this).parents(".quill_select");
        if ($(this).data("id") != "all") {
            if ($(this).hasClass("on") == false) {
                $(this).addClass("on");
                var target_id = $(this).attr("option-id");
                var target_value = $(this).find("p").html();
                _parent
                    .find(".title")
                    .append(
                        ' <span class="item multiOption_' +
                            target_id +
                            '" option-id="' +
                            target_id +
                            '"><i class="number"></i><i class="name">' +
                            target_value +
                            '</i><i class="icon_remove fa fa-remove"></i></span> '
                    );
                //
                multi_serialNumber(_parent);
                //close
                $(this).closest(".quill_select").removeClass("open");
            } else {
                $(this).removeClass("on");
                var target_id = $(this).attr("option-id");
                var target_object = _parent.find(
                    ".title .multiOption_" + target_id + ""
                );
                target_object.remove();
                //
                multi_serialNumber(_parent);
                //close
                $(this).closest(".quill_select").removeClass("open");
            }
        } else {
            alert(
                "您選擇全選 / 全不選，需要幾秒鐘時間以便資料重整，\r按下確認後請稍後片刻勿重整或點擊畫面。"
            );
            if ($(this).hasClass("sel_all")) {
                //取消全選
                $(this)
                    .siblings("li")
                    .each(function () {
                        if (
                            $(this).hasClass("on") &&
                            $(this).data("id") != "all"
                        ) {
                            $(this).trigger("click");
                        }
                    });
                $(this).removeClass("sel_all");
            } else {
                //全選
                $(this)
                    .siblings("li")
                    .each(function () {
                        if (
                            !$(this).hasClass("on") &&
                            $(this).data("id") != "all"
                        ) {
                            $(this).trigger("click");
                        }
                    });
                $(this).addClass("sel_all");
            }
        }
    });
    //item點擊remove事件
    quill_select.on("click", ".icon_remove", function () {
        var _parent = $(this).parents(".quill_select");
        var delete_id = $(this).closest(".item").attr("option-id"),
            _this_key = $(this).parent("span").parent("p").data("key");
        changeMultiSelectValue(_this_key);
        $(this).closest(".item").remove();
        _parent.find(".select_list .option").eq(delete_id).removeClass("on");
        //
        multi_serialNumber(_parent);
        changeMultiSelectValue(_this_key);
    });
}

function multi_serialNumber(quill_select) {
    var option_num = quill_select.find(".title span");
    for (var a = 0; a < option_num.length; a++) {
        var sum = a + 1;
        option_num
            .eq(a)
            .find(".number")
            .text("0" + sum + ".");
    }
}

//段落表格(part_table)
//**************************************//
// toolBtn-id = 1 (add_row)             //
// toolBtn-id = 2 (add_column)          //
// toolBtn-id = 3 (delete_list)         //
// toolBtn-id = 4,5 (row_sort)          //
// toolBtn-id = 6,7 (col_sort)          //
//**************************************//
function quill_table() {
    //給每個row id 跟 col id
    give_id();

    //首次載入時計算所有quill_table的row數量 跟 col數量
    first_count_RC();

    //依照tool_btn去判斷要執行哪個功能
    partTable_inventory_thead_td();

    quill_tableScroll();

    // build_tableTitle_bar();
    judge_direction();

    //text_editor
    quillTable_textEditor();
    quillTable_linkEditor();
    boxInner_location();
}

function give_id() {
    //給每個row id 跟 col id
    var table = $(".quill_table"),
        row = $(".quill_table .q_body .no_static .row");

    var st_row = $(".quill_table .q_body .static .row .box");

    //row-id
    for (var a = 0; a < row.length; a++) {
        row.eq(a).attr("row-id", a);
        st_row.eq(a).attr("row-id", a);
        var col = row.eq(a).find(".box");
        var st_col = $(".quill_table .q_head .static .box");
        //col-id
        for (var b = 0; b < col.length; b++) {
            row.eq(a).find(".box").eq(b).attr("col-id", b);
            st_col.eq(b).attr("col-id", b);
        }
    }
}

function first_count_RC() {
    //首次載入時計算所有quill_table的row數量 跟 col數量
    var quill_table = $(".quill_table");

    for (var a = 0; a < quill_table.length; a++) {
        var row_Sbox = quill_table.eq(a).find(".q_body .static .box"),
            col_Sbox = quill_table.eq(a).find(".q_head .static .box");

        var row_num = row_Sbox.length,
            col_num = col_Sbox.length;

        if (row_num < 10) {
            row_num = "0" + row_num;
        }

        var table_title_R = quill_table.eq(a).find(".table_title .board .t_r");
        table_title_R.text("R" + row_num);

        if (col_num < 10) {
            col_num = "0" + col_num;
        }

        var table_title_C = quill_table.eq(a).find(".table_title .board .t_c");
        table_title_C.text("C" + col_num);
    }
}

function count_RC(object, btn_id) {
    //計算row數量跟col數量
    var row_num = object.find(".q_body .static .box").length,
        col_num = object.find(".q_head .static .box").length;

    if (btn_id == 1) {
        if (row_num < 10) {
            row_num = "0" + row_num;
        }
        var table_title_R = object.find(".table_title .board .t_r");
        table_title_R.text("R" + row_num);
    } else if (btn_id == 2) {
        if (col_num < 10) {
            col_num = "0" + col_num;
        }
        var table_title_C = object.find(".table_title .board .t_c");
        table_title_C.text("C" + col_num);
    } else if (btn_id == 3) {
        if (row_num < 10) {
            row_num = "0" + row_num;
        }
        var table_title_R = object.find(".table_title .board .t_r");
        table_title_R.text("R" + row_num);

        if (col_num < 10) {
            col_num = "0" + col_num;
        }

        var table_title_C = object.find(".table_title .board .t_c");
        table_title_C.text("C" + col_num);
    }
}

function judge_direction() {
    var check_box = $(".quill_table .content_input");
    check_box.on("click", function () {
        if ($(this).hasClass("horizontal") == true) {
            var object = $(this).closest(".row");
            var id = object.attr("row-id");
            // object.hasClass('solid') == false ? ( object.addClass('solid') ) : ( object.removeClass('solid') );
        } else if ($(this).hasClass("vertical") == true) {
            var object = $(this).closest(".box");
            var id = object.attr("col-id");
        }
    });
}

function partTable_inventory_thead_td() {
    //依照tool_btn去判斷要執行哪個功能
    var tool_btn = $(".part_table .inventory .table_head_th .tool_btn");

    tool_btn.on("click", function () {
        var tool_btn_id = $(this).attr("toolBtn-id") / 1;
        var object = $(this).closest(".frame").find(".quill_table");

        switch (tool_btn_id) {
            case 1:
                add_row(object, tool_btn_id);
                break;

            case 2:
                add_column(object, tool_btn_id);
                break;

            case 3:
                delete_list(object, tool_btn_id);
                break;

            case 4:
            case 5:
                row_sort(object, tool_btn_id);
                break;

            case 6:
            case 7:
                col_sort(object, tool_btn_id);
                break;
        }
    });
}

function add_row(object, btn_id) {
    var box_num = object.find(".q_head .static .box").length;

    //先新增一個row
    object
        .find(".q_body .static .row .box:eq(0)")
        .before(" <li class='box'></li> ");
    object
        .find(".q_body .no_static .row:eq(0)")
        .before(" <ul class='row adding'></ul> ");

    //塞check_box 塞p
    var add_checkBox =
        '<div class="check_box"><input type="checkbox" class="content_input horizontal"><label class="content_inputBox"></label></div>';
    object
        .find(".q_body .static .box:eq(0)")
        .append('<p class="base_f">Row ' + 1 + "</p>")
        .append(add_checkBox);

    //用迴圈建立td
    for (var index = 0; index < box_num; index++) {
        var insert_html =
            '<li class="box" col-id="' +
            index +
            '"><div class="inner_btn"><span class="editor fa fa-pencil"></span><span class="connect fa fa-link"></span></div></li>';

        object.find(".q_body .no_static .adding").append(insert_html);

        //當新增td(box)到最後一個的時候，重新在計算一次row的id
        if (index == box_num - 1) {
            object.find(".adding").removeClass("adding");
            give_id();
        }
    }

    //把每一個row第一格的 Row字做更換
    var row = object.find(".q_body .static .row");
    var row_leng = row.find(".box").length;

    for (var a = 0; a < row_leng; a++) {
        var num = a + 1;
        var row_fBox = object.find(".q_body .static .row .box:eq(" + a + ")");
        row_fBox.find("p").text("Row " + num);
    }
    count_RC(object, btn_id);
}

function add_column(object, btn_id) {
    var row = object.find(".q_body .no_static .row"),
        row_num = row.length,
        col_num = object.find(".q_head .static .box").length;

    //在q_head 塞一個新box
    object.find(".q_head .static .box:eq(0)").before(" <li class='box'></li> ");

    //預計塞入 q_head 新box的內容
    var text_p = "<p></p>";
    var add_checkBox =
        '<div class="check_box"><input type="checkbox" class="content_input vertical"><label class="content_inputBox"></label></div>';
    var inner =
        '<div class="inner"><span class="pg-minus"></span><p>Auto</p><span class="pg-plus"></span></div>';
    var inner_btn =
        '<div class="inner_btn"><span class="editor fa fa-pencil"></span></div>';

    //把內容塞入 q_head新box
    object
        .find(".q_head .static .box:eq(0)")
        .append(add_checkBox + text_p + inner + inner_btn);

    for (var a = 0; a < row_num; a++) {
        row.eq(a)
            .find(".box:eq(0)")
            .before(
                ' <li class="box adding"><div class="inner_btn"><span class="editor fa fa-pencil"></span><span class="connect fa fa-link"></span></div></li> '
            );

        //當新增td(box)到最後一個的時候，重新在計算一次col的id
        if (a == row_num - 1) {
            give_id();
        }
    }

    //對table_title新增一個項目，讓數量可以跟col數量相對應
    object
        .find(".table_title .bar")
        .append(
            " <div class='box'><p class='base_f'>Column " +
                col_num +
                "</p></div> "
        );

    row.find(".box.adding").removeClass("adding");

    count_RC(object, btn_id);
}

function delete_list(object, btn_id) {
    var target_box = object.find(".check_box.show input");
    var row = object.find(".q_body .no_static .row");

    if (target_box.hasClass("horizontal") == true) {
        var target_id = target_box.closest("li").attr("row-id");

        object.find(".q_body .static .row .box").eq(target_id).remove();
        object.find(".q_body .no_static .row").eq(target_id).remove();

        //重新建立id排序
        give_id();

        //把每一個row第一格的 Row字做更換
        var row = object.find(".q_body .static .row");
        var row_leng = row.find(".box").length;
        for (var a = 0; a < row_leng; a++) {
            var num = a + 1;
            var row_fBox = object.find(
                ".q_body .static .row .box:eq(" + a + ")"
            );
            row_fBox.find("p").text("Row " + num);
        }
    } else {
        var target_id = target_box.closest(".box").attr("col-id");
        object.find(".q_head .static .box").eq(target_id).remove();
        for (var a = 0; a < row.length; a++) {
            object
                .find(".q_body .no_static .row")
                .eq(a)
                .find(".box:eq(" + target_id + ")")
                .remove();
            //重新建立id排序
            give_id();
        }
    }
    count_RC(object, btn_id);
}

function row_sort(object, btn_id) {
    var target_box = object.find(".check_box.show input");
    var row = object.find(".q_body .no_static .row");
    var st_row = object.find(".q_body .static .row .box");
    var target_id = target_box.closest("li").attr("row-id") / 1;

    if (target_box.hasClass("vertical") == false) {
        if (btn_id == 4 && target_id >= 1) {
            row.eq(target_id - 1).before(row.eq(target_id));
            st_row.eq(target_id - 1).before(st_row.eq(target_id));
            give_id();

            //把每一個row第一格的 Row字做更換
            var row = object.find(".q_body .static .row");
            var row_leng = row.find(".box").length;

            for (var a = 0; a < row_leng; a++) {
                var num = a + 1;
                var row_fBox = object.find(
                    ".q_body .static .row .box:eq(" + a + ")"
                );
                row_fBox.find("p").text("Row " + num);
            }
        } else if (btn_id == 5) {
            row.eq(target_id + 1).after(row.eq(target_id));
            st_row.eq(target_id + 1).after(st_row.eq(target_id));
            give_id();

            //把每一個row第一格的 Row字做更換
            var row = object.find(".q_body .static .row");
            var row_leng = row.find(".box").length;

            for (var a = 0; a < row_leng; a++) {
                var num = a + 1;
                var row_fBox = object.find(
                    ".q_body .static .row .box:eq(" + a + ")"
                );
                row_fBox.find("p").text("Row " + num);
            }
        }
    }
}

function col_sort(object, btn_id) {
    var target_box = object.find(".check_box.show input");
    var row = object.find(".q_body .no_static .row");
    var st_col = object.find(".q_head .static .box");

    var target_id = target_box.closest(".box").attr("col-id") / 1;
    var forward_id = target_id - 1,
        backward_id = target_id + 1;

    if (target_box.hasClass("horizontal") == false) {
        if (btn_id == 6 && target_id >= 1) {
            for (var a = 0; a < row.length; a++) {
                var move_item = row.eq(a).find(".box:eq(" + target_id + ")");
                row.eq(a)
                    .find(".box:eq(" + forward_id + ")")
                    .before(move_item);
            }

            var st_col_item = st_col.eq(target_id);
            st_col.eq(forward_id).before(st_col_item);
            give_id();
        } else if (btn_id == 7) {
            for (var a = 0; a < row.length; a++) {
                var move_item = row.eq(a).find(".box:eq(" + target_id + ")");
                row.eq(a)
                    .find(".box:eq(" + backward_id + ")")
                    .after(move_item);
            }

            var st_col_item = st_col.eq(target_id);
            st_col.eq(backward_id).after(st_col_item);
            give_id();
        }
    }
}

function quill_tableScroll() {
    //quill_table裡面的table scroll
    var quill_table = $(".quill_table"),
        row_hd = $(".row_hd");

    quill_table.find(".q_body .no_static").scrollbar();

    $(".quill_table .q_body .no_static").scroll(function () {
        var a = $(this).scrollTop();
        var b = $(this).scrollLeft();

        $(this)
            .closest(".quill_table")
            .find(".q_body .static .row")
            .css("top", "-" + a + "px");
        $(this)
            .closest(".quill_table")
            .find(".q_head .static")
            .css("left", "-" + b + "px");
        $(this)
            .closest(".quill_table")
            .find(".table_title .bar .bar_inner")
            .css("transform", "translateX(-" + b + "px)");
    });
}

function build_tableTitle_bar() {
    var quill_table = $(".quill_table"),
        bar = quill_table.find(".bar"),
        col = quill_table.find(".q_head .static .box");

    for (var a = 1; a <= col.length; a++) {
        bar.append(
            " <li class='box'><p class='base_f'>Column " + a + "</p></li> "
        );
    }
}

function boxInner_location() {
    //截取目前的滑鼠位置 算出box該出現在什麼位置
    var box_btn = $(".quill_table .no_static, .quill_table .q_head .static");

    var text_editor = $(".quill_table .text_editor"),
        link_editor = $(".quill_table .link_editor");

    box_btn.on("click", ".inner_btn span", function () {
        var this_quillTable = $(this).closest(".quill_table");

        var locate = $(this).closest(".box"),
            box_middle_point = locate.outerWidth() / 2,
            box_center_point = locate.outerHeight() / 2;

        if (
            $(this).hasClass("editor") == true &&
            this_quillTable.hasClass("opening_editor") == false
        ) {
            var boxInner_halfWidth = text_editor.outerWidth() / 2,
                boxInner_height = text_editor.outerHeight();

            var a = locate.offset();

            var parentPos = locate.closest(".hiddenArea_frame").offset();

            var box_left =
                    a.left -
                    parentPos.left -
                    boxInner_halfWidth +
                    box_middle_point,
                box_top = a.top - boxInner_height + box_center_point;

            text_editor.css({
                left: box_left,
                top: box_top,
            });
            text_editor.fadeIn();

            // $('.builder .work-1').scrollbar('destroy');
            this_quillTable.find(".q_body .no_static").scrollbar("destroy");

            this_quillTable.addClass("opening_editor");
        } else if (
            $(this).hasClass("connect") == true &&
            this_quillTable.hasClass("opening_editor") == false
        ) {
            var boxInner_halfWidth = link_editor.outerWidth() / 2,
                boxInner_height = link_editor.outerHeight();

            var a = locate.offset();

            var parentPos = locate.closest(".hiddenArea_frame").offset();

            var box_left =
                    a.left -
                    parentPos.left -
                    boxInner_halfWidth +
                    box_middle_point,
                box_top = a.top - boxInner_height + box_center_point;

            link_editor.css({
                left: box_left,
                top: box_top,
            });
            link_editor.fadeIn();

            // $('.builder .work-1').scrollbar('destroy');
            this_quillTable.find(".q_body .no_static").scrollbar("destroy");

            this_quillTable.addClass("opening_editor");
        }
    });
}

function quillTable_textEditor() {
    var quill_table = $(".quill_table");
    var text_editor = $(".quill_table .text_editor");

    for (var a = 0; a < quill_table.length; a++) {
        quill_table
            .eq(a)
            .find(".text_editor .box")
            .summernote({
                toolbar: [
                    ["style", ["bold"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["color", ["color"]],
                    ["insert", ["link"]],
                    ["mybutton", [""]],
                ],
                tooltip: false,
                height: 210,
                disableResizeEditor: true,
                callbacks: {
                    onInit: function () {
                        $(this)
                            .closest(".text_editor")
                            .find(".note-mybutton")
                            .append(
                                '<button type="button" class="click_btn photo" title="" data-hide="true" tabindex="-1"><i class="fa fa-picture-o"></i></button>'
                            );

                        $(this)
                            .closest(".text_editor")
                            .find(".note-mybutton")
                            .append(
                                '<button type="button" class="click_btn save" title="" data-hide="true" tabindex="-1"><i class="fa fa-check"></i></button>'
                            );

                        $(this)
                            .closest(".text_editor")
                            .find(".note-mybutton")
                            .append(
                                '<button type="button" class="click_btn cancel" title="" data-hide="true" tabindex="-1"><i class="fa fa-remove"></i></button>'
                            );

                        $(this)
                            .closest(".text_editor")
                            .find(".note-mybutton .photo")
                            .on("click", function () {
                                alert("insert photo");
                            });

                        $(this)
                            .closest(".text_editor")
                            .find(".note-mybutton .save")
                            .on("click", function () {
                                alert("save work");
                                text_editor.fadeOut();
                                $(this)
                                    .closest(".quill_table")
                                    .find(".q_body .no_static")
                                    .scrollbar();
                                $(this)
                                    .closest(".quill_table")
                                    .removeClass("opening_editor");
                            });

                        $(this)
                            .closest(".text_editor")
                            .find(".note-mybutton .cancel")
                            .on("click", function () {
                                text_editor.fadeOut();
                                $(this)
                                    .closest(".quill_table")
                                    .find(".q_body .no_static")
                                    .scrollbar();
                                $(this)
                                    .closest(".quill_table")
                                    .removeClass("opening_editor");
                            });
                    },
                },
            });
    }
    $(".note-statusbar").hide();
}

function quillTable_linkEditor() {
    var btn_group = $(".quill_table .link_editor .btn_group"),
        link_editor = $(".quill_table .link_editor");

    btn_group.on("click", "li", function () {
        if ($(this).hasClass("cancel") == true) {
            link_editor.fadeOut();
            $(this)
                .closest(".quill_table")
                .find(".q_body .no_static")
                .scrollbar();
            $(this).closest(".quill_table").removeClass("opening_editor");
        } else if ($(this).hasClass("save") == true) {
            link_editor.fadeOut();
            $(this)
                .closest(".quill_table")
                .find(".q_body .no_static")
                .scrollbar();
            $(this).closest(".quill_table").removeClass("opening_editor");
        }
    });
}

function getselecttext() {
    //抓取反白的字(這函式目前沒用到)
    var t = "";
    if (window.getSelection) {
        t = window.getSelection();
    } else if (document.getSelection) {
        t = document.getSelection();
    } else if (window.document.selection) {
        t = window.document.selection.createRange().text;
    }

    if (t != "") {
        t = "<a href=''>" + t + "</a>";
        alert(t);
    }
}

//段落圖片 / 影片(part_img)
//**************************************//
// toolBtn-id = 1 (add_photo)(打開fms)  //
// toolBtn-id = 2 (add_video)(打開fms)  //
// toolBtn-id = 3 (add_embed_video)     //
// toolBtn-id = 4 (delete)              //
// toolBtn-id = 5,6 (sort)              //
//**************************************//
function partImg_inventory_thead_td() {
    //依照tool_btn去判斷要執行哪個功能

    var tool_btn = $(".part_img .inventory .table_head_th .tool_btn");

    tool_btn.on("click", function () {
        var tool_btn_id = $(this).attr("toolBtn-id") / 1;
        var object = $(this).closest(".frame").find(".quill_partImg");

        switch (tool_btn_id) {
            case 1:
                partImg_addPhoto(object, tool_btn_id);
                break;

            case 2:
                partImg_addVideo(object, tool_btn_id);
                break;

            case 3:
                partImg_addEmbed(object, tool_btn_id);
                break;

            case 4:
                partImg_delete(object, tool_btn_id);
                break;

            case 5:
                partImg_sort(object, tool_btn_id);
                break;

            case 6:
                partImg_sort(object, tool_btn_id);
                break;
        }
    });
}

function partImg_openPreview() {
    var open_btn = $(".editContentArea");
    var preview_box = $(".partImg_lightBox");

    open_btn.on("click", ".open_preview", function () {
        var type = $(this).data("type");
        var this_val = $(this).data("value");
        var this_url = $(this).data("url");
        var this_place = $(this).data("place");
        var this_key = $(this).data("key");
        var this_src = $(this).data("src");
        var this_size = $(this).data("size");

        switch (type) {
            case "image":
                $(".for_embed").hide();
                $(".for_video").hide();
                $(".for_photo").show();
                $(".partImg_lightBox .for_photo .photo img").attr(
                    "src",
                    this_src
                );
                $(".partImg_lightBox .for_photo .describe p").text(this_size);
                break;

            case "video":
                $(".for_photo").hide();
                $(".for_embed").hide();
                $(".for_video").show();
                break;

            case "embed":
                $(".for_photo").hide();
                $(".for_video").hide();
                $(".for_embed").show();
                $("#embed_video").val(this_val);
                $("#embed_video").attr("placeholder", this_place);
                $("#embed_video").attr("data-key", this_key);
                $(".videoBox iframe").attr("src", this_url + this_val);
                $("#iframe_url").val(this_url);
                break;
        }

        preview_box.addClass("open");

        if ($(this).closest(".item").hasClass("photo") == true) {
        }
    });
}

function partImg_closePreview() {
    var close_btn = $(".partImg_lightBox .close_btn");
    var preview_box = $(".partImg_lightBox");

    close_btn.on("click", function () {
        if (preview_box.hasClass("open") == true) {
            preview_box.removeClass("open");
        }

        //關閉embed視窗的時候 把youtube iframe的src抓起來 然後重新放入 iframe的src裡 再次載入
        //這樣做的原因是 關閉視窗的同時可以停止影片播放
        if (
            $(this).closest(".frame").find(".videoBox").hasClass("add_embed") ==
            true
        ) {
            $(".add_embed iframe").each(function () {
                var el_src = $(this).attr("src");
                $(this).attr("src", el_src);
            });
        }
    });
}

function partImg_embed() {
    var insert_btn = $(".partImg_lightBox .for_embed .insert_embed");

    insert_btn.on("click", function () {
        var embedVideo_box = $(this).closest(".frame").find(".videoBox");
        var embed_url = $(this)
            .closest(".frame")
            .find(".input_area textarea")
            .val();

        embedVideo_box
            .find("iframe")
            .attr("src", $("#iframe_url").val() + embed_url);
        embedVideo_box.addClass("add_embed");

        $(".video_" + $("#embed_video").attr("data-key")).val(embed_url);
    });
}

function partImg_listID(object) {
    //更新id
    var list = object.find("li");

    for (var a = 0; a < list.length; a++) {
        list.eq(a).attr("partImg-id", a);

        //順便更新list數字
        list.eq(a)
            .find(".sort_number p")
            .text(a + 1);
    }
}

function partImg_addPhoto(object, tool_btn_id) {
    var check_box =
            '<div class="check_box"><input type="checkbox" class="content_input"><label class="content_inputBox"></label></div>',
        sort_number = '<div class="sort_number"><p></p></div>',
        text =
            '<div class="text"><p class="type">Photo</p><p>點這裡輸入圖片/影片註解文案，不需要註解文案則無需填寫</p></div>',
        edit_thumbnail =
            '<div class="edit_thumbnail photo"><div class="base"><img src="../backstage/assets/img/none-pic.jpg" alt=""></div><div class="upper"><div class="click_btn"><p class="green">Edit</p></div></div></div>',
        edit =
            '<div class="edit"><span class="fa fa-trash"></span><span class="fa fa-gear open_preview"></span></div>';

    partImg_addEvent(
        object,
        check_box,
        sort_number,
        text,
        edit_thumbnail,
        edit
    );
}

function partImg_addVideo(object, tool_btn_id) {
    var check_box =
            '<div class="check_box"><input type="checkbox" class="content_input"><label class="content_inputBox"></label></div>',
        sort_number = '<div class="sort_number"><p></p></div>',
        text =
            '<div class="text"><p class="type">Video</p><p>點這裡輸入圖片/影片註解文案，不需要註解文案則無需填寫</p></div>',
        edit_thumbnail =
            '<div class="edit_thumbnail video"><div class="base"><img src="../backstage/assets/img/test1.jpg" alt=""></div><div class="upper"><div class="play_btn open_preview"><span></span></div><div class="click_btn"><p class="green">Cover</p><p class="gray">Video</p></div></div></div>',
        edit =
            '<div class="edit"><span class="fa fa-trash"></span><span class="fa fa-gear open_preview"></span></div>';

    partImg_addEvent(
        object,
        check_box,
        sort_number,
        text,
        edit_thumbnail,
        edit
    );
}

function partImg_addEmbed(object, tool_btn_id) {
    var check_box =
            '<div class="check_box"><input type="checkbox" class="content_input"><label class="content_inputBox"></label></div>',
        sort_number = '<div class="sort_number"><p></p></div>',
        text =
            '<div class="text"><p class="type">Embed Video</p><p>點這裡輸入圖片/影片註解文案，不需要註解文案則無需填寫</p></div>',
        edit_thumbnail =
            '<div class="edit_thumbnail video"><div class="base"><img src="../backstage/assets/img/test1.jpg" alt=""></div><div class="upper"><div class="play_btn open_preview"><span></span></div><div class="click_btn"><p class="green">Cover</p><p class="gray">Video</p></div></div></div>',
        edit =
            '<div class="edit"><span class="fa fa-trash"></span><span class="fa fa-gear open_preview"></span></div>';

    partImg_addEvent(
        object,
        check_box,
        sort_number,
        text,
        edit_thumbnail,
        edit
    );
}

function partImg_delete(object, tool_btn_id) {
    var delete_object_checkBox = object.find(".check_box.show");
    delete_objec = delete_object_checkBox.closest("li");

    delete_objec.remove();

    //更新ID
    partImg_listID(object);
}

function partImg_sort(object, tool_btn_id) {
    var target_list = object.find(".check_box.show").closest("li");
    target_ID = target_list.attr("partimg-id") / 1;

    if (tool_btn_id == 5 && target_ID > 0) {
        var goal_id = target_ID - 1;
        object.find("li:eq(" + goal_id + ")").before(target_list);
        //更新ID
        partImg_listID(object);
    } else if (tool_btn_id == 6) {
        var goal_id = target_ID + 1;
        object.find("li:eq(" + goal_id + ")").after(target_list);

        //更新ID
        partImg_listID(object);
    }
}

function partImg_addEvent(
    object,
    check_box,
    sort_number,
    text,
    edit_thumbnail,
    edit
) {
    //新增事件
    var quill_partImg = object;
    var list_num = object.find("li").length;

    if (list_num > 0) {
        object
            .find("li:eq(0)")
            .before(
                " <li>" +
                    check_box +
                    sort_number +
                    text +
                    edit_thumbnail +
                    edit +
                    "</li> "
            );

        //更新ID
        partImg_listID(object);
    } else {
        object.append(
            " <li>" +
                check_box +
                sort_number +
                text +
                edit_thumbnail +
                edit +
                "</li> "
        );

        //更新ID
        partImg_listID(object);
    }
}

function partImg_photo() {
    var box = $(".partImg_lightBox .for_photo"),
        box_frame = box.find(".content_box .photo");

    var box_frameW = box_frame.innerWidth();
    var box_frameH = box_frame.innerHeight();

    var photo = box.find(".photo img");

    var w = photo.width();
    var h = photo.height();

    photo.css("max-height", box_frameH);
}

//段落內容 / 設定(part_content)
function partContent_textEditor() {
    var text_editor = $(".summernote_box textarea.box");

    text_editor.summernote({
        toolbar: [
            ["style", ["bold"]],
            ["view", ["codeview"]],
            ["para", ["ol"]],
            // ['insert', ['link']],
            ["mybutton", [""]],
        ],
        tooltip: false,
        height: 195,
        disableResizeEditor: true,
        popover: {
            image: [],
            link: [],
            air: [],
        },
        callbacks: {
            onPaste: function (ne) {
                var bufferText = (
                    (ne.originalEvent || ne).clipboardData ||
                    window.clipboardData
                ).getData("Text/plain");
                //    ne.preventDefault();
                ne.preventDefault
                    ? ne.preventDefault()
                    : (ne.returnValue = false);
                // Firefox fix
                setTimeout(function () {
                    document.execCommand("insertText", false, bufferText);
                }, 10);
                /*  */
            },
        },
    });

    $(".note-statusbar").hide();
}

//基本內容編輯(baseContentEdit)
function baseContentEdit() {
    baseContentEdit_textEditor();
    baseContentEdit_color_picker();
}

function baseContentEdit_textEditor() {
    var text_editor = $(".baseContentEdit .summernote_box .box");

    text_editor.summernote({
        height: 195,
    });

    $(".note-statusbar").hide();
}

function baseContentEdit_color_picker() {
    // $(".palette").each(function(index, el) {
    //     if (!$(this).hasClass('color-picker-already')) {
    //         _this_color = (!$(this).val()) ? '#000000' : $(this).val();
    //         $(this).spectrum({
    //             color: _this_color,
    //             preferredFormat: "hex3",
    //             hideAfterPaletteSelect: false,
    //             showButtons: false,
    //             showInput: true,
    //             showInitial: true,
    //             showAlpha: true,
    //             showPalette: true,
    //             palette: [
    //                 ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
    //                 ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
    //                 ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
    //                 ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
    //                 ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
    //                 ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
    //                 ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
    //                 ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
    //             ],
    //             change: function(color) {
    //                 $(this).parent('div').children('div.ticket_field').children('p').text(color);
    //                 $(this).val(color); // #ff0000
    //             },
    //         });
    //         $(this).addClass('color-picker-already');
    //     }
    // });
    // $('.color_picker').each(function(index, el) {
    //     var _this2 = $(this),
    //         _this2_input = _this2.children('input');
    //     if (!_this2.hasClass('color_picker_already')) {
    //         if (_this2_input.val() == '') {
    //             var ticket_field_dom = '<div class="ticket_field"><p>#000</p></div>';
    //         } else {
    //             var ticket_field_dom = '<div class="ticket_field"><p>' + _this2_input.val() + '</p></div>';
    //         }
    //         _this2.addClass('color_picker_already');
    //         _this2.append(ticket_field_dom);
    //     }
    // });
    // var btn_group = '<div class="btn_group"> <div class="click_btn save"><p><span class="fa fa-check"></span>setting</p></div><div class="click_btn cancel"><p><span class="fa fa-remove"></span>cancel</p></div> </div>';
    // var color_title = '<p class="title">PALETTE<p>';
    // var picker_title = '<p class="title">COLOR TICKETS<p>';
    // $('.sp-container').each(function(index, el)
    // {
    //     if($(this).hasClass('btn-already'))
    //     {
    //         return false;
    //     }
    //     else
    //     {
    //         $(this).append( btn_group );
    //     }
    // });
    // $('.sp-container .sp-picker-container .sp-top').each(function(index, el)
    // {
    //     if($(this).hasClass('btn-already'))
    //     {
    //         return false;
    //     }
    //     else
    //     {
    //         $(this).before( color_title );
    //         $(this).addClass('btn-already');
    //     }
    // });
    // $('.sp-container').each(function(index, el)
    // {
    //     if($(this).hasClass('btn-already'))
    //     {
    //         return false;
    //     }
    //     else
    //     {
    //         $(this).before( picker_title );
    //         $(this).addClass('btn-already');
    //     }
    // });
    //對按鈕綁事件
    // //對按鈕綁事件
    // var object = $('.color_picker .sp-replacer');
    // var save = $('.sp-container .save');
    // var cancel = $('.sp-container .cancel');
    // save.on('click',function(){
    //     object.click();
    // });
    // cancel.on('click',function(){
    //     object.click();
    // });
    // //對color_picker開啟按鈕插入欄位(ticket_field)
    // var color_picker = $('.color_picker');
    // var ticket_field_dom = '<div class="ticket_field"><p>#ff0000</p></div>';
    // color_picker.append( ticket_field_dom );
    // //插入欄位(ticket_field)功能
    // object.click(function(){
    //     var chose_color = $('.sp-container .sp-input');
    //     var ticket_field = $('.color_picker .ticket_field');
    //     ticket_field.find('p').html( chose_color.val() );
    // });
}

function close_ajax_btn() {
    $(".close_ajax_btn").on("click", function () {
        let _this = $(this);
        if ($("body")[0].fms_open_index > 0 && $("body")[0].fms_open) {
            history.go(-$("body")[0].fms_open_index);
            $("body")[0].fms_open_index = 0;
            console.log('sss');
        }else{
            let lbox_frame = $('.lbox_frame');
            if(_this.closest('.ajax_fms').length > 0){
                lbox_frame.removeClass('open');
            }else{
            lbox_frame.addClass('remove');
            setTimeout(function() {
                lbox_frame.removeClass('open go_animation remove')
                lbox_frame.find('.ajax_temp').remove();
            }, 100);
        }
        }
    });
}

//打開db lightbox(open_db_lightbox)
function db_lightbox() {
    //close_ajax_btn
    close_ajax_btn();
}

function btn_db_lightbox() {
    var open_btn = $("body"),
        lbox_frame = $(".db_lbox");

    open_btn.on("click", ".open_db_lightbox .ajax_open", function () {
        var _this = $(this),
            _this_model = $(this).data("model"),
            _this_li = $(this).parents(".inventory");
        _this_id = $(this).siblings("input").val();
        _this_cls = $(this).data("cls");

        $.ajax({
            url: $(".base-url").val() + "/Ajax/by-data/getdata/" + _this_model,
            type: "GET",
        }).done(function (data) {
            $("article.ams_lbox").children("div").append(data);
            $("article.ams_lbox").addClass("open");
            db_lbox_search();

            setTimeout(function () {
                card_table("ams_ajax_table");

                $(".ams-member-checkbox").on("click", function () {
                    $(".ams-member-checkbox").prop("checked", false);
                    $(this).prop("checked", true);
                });

                if (_this_cls == "sontable") {
                    setDbLbox(_this);
                } else {
                    setDbLbox(_this_li);
                }

                closeDbLbox();
            }, 500);

            setTimeout(function () {
                $("article.ams_lbox").addClass("go_animation");

                $("input.db_lbox_select_checkbox").each(function (index, el) {
                    if (_this_cls == "one_shot") {
                        if ($(this).attr("id") == _this_id) {
                            $(this).prop("checked", true);
                        }
                    } else if (_this_cls == "multi_shot") {
                        _this_id_ary = JSON.parse(_this_id);
                        _chkbox = $(this);
                        _chkbox_id = _chkbox.attr("id");
                        _this_id_ary.forEach(function (item) {
                            if (_chkbox_id == item) {
                                _chkbox.prop("checked", true);
                            }
                        });
                    }
                });
            }, 1000);

            //單多選
            if (_this.hasClass("one_shot")) {
                $(".table_section").addClass("one_shot");
                $(".ajax_control_btn .selected .number").text("1");
            } else if (_this.hasClass("multi_shot")) {
                $(".table_section").addClass("multi_shot");
                $(".ajax_control_btn .selected .number").text("N");
            } else if (_this.hasClass("sontable")) {
                $(".table_section").addClass("sontable");
                $(".ajax_control_btn .selected .number").text("N");
            }

            // $('.db_lbox_select_checkbox').on('click', function () {
            setTimeout(() => {
                $("div.ajax_ams.ajax_temp").on(
                    "click",
                    "div.checkbox.text-center",
                    function () {
                        if ($(".table_section").hasClass("one_shot")) {
                            $("input.db_lbox_select_checkbox").prop(
                                "checked",
                                false
                            );
                        }

                        if (
                            $(".table_section").hasClass("multi_shot") ||
                            $(".table_section").hasClass("sontable")
                        ) {
                            if ($(this).find("input").prop("checked") == true) {
                                $(this).find("input").prop("checked", false);
                            } else {
                                $(this).find("input").prop("checked", true);
                            }
                        } else {
                            $(this).find("input").prop("checked", true);
                        }
                    }
                );
            }, 0);
        });
    });
}

//關聯資料集搜尋
function db_lbox_search() {
    var search_btn = $("#db_lbox_search");
    var clear_btn = $("#db_lbox_clear");
    var elInput = document.querySelector("#db_lbox_keyword");
    elInput.addEventListener("keydown", function (e) {
        var code = e.keyCode;
        if (code === 13) {
            search_btn.click();
        }
    });

    search_btn.on("click", function () {
        //先看目前選的有那些
        var sel_id = [];
        $("input.db_lbox_select_checkbox").each(function (index, el) {
            if ($(this).prop("checked") === true) {
                sel_id.push($(this).attr("id"));
            }
        });

        var key = $("#db_lbox_keyword").val();
        var _this_model = $(this).parent(".search_section").attr("data-model");
        $.ajax({
            url: $(".base-url").val() + "/Ajax/by-data/search/" + _this_model,
            data: {
                keyword: key,
                sel_id: sel_id,
            },
            type: "GET",
        }).done(function (data) {
            $(".db_lbox_table").empty().append(data);

            setTimeout(function () {
                card_table("ams_ajax_table");

                $(".ams-member-checkbox").on("click", function () {
                    $(".ams-member-checkbox").prop("checked", false);
                    $(this).prop("checked", true);
                });
            }, 500);
        });
    });

    clear_btn.on("click", function () {
        var _this_model = $(this).parent(".search_section").data("model");
        $.ajax({
            url: $(".base-url").val() + "/Ajax/by-data/reload/" + _this_model,
            type: "GET",
        }).done(function (data) {
            $(".db_lbox_table").empty().append(data);
            $("#db_lbox_keyword").val("");

            setTimeout(function () {
                card_table("ams_ajax_table");

                $(".ams-member-checkbox").on("click", function () {
                    $(".ams-member-checkbox").prop("checked", false);
                    $(this).prop("checked", true);
                });
            }, 500);
        });
    });
}

//file_detail產品 / 商品圖片
function item_file_detail(element) {
    var object = $("." + element);
    var object_box = object.closest(".frame").find(".file_detail_box");

    object.mouseenter(function () {
        var box = $(this).closest(".frame").find(".file_detail_box");

        var childPos = $(this).offset();
        var parentPos = $(this).closest(".hiddenArea_frame").offset();

        var childOffset = {
            top: childPos.top - parentPos.top,
            left: childPos.left - parentPos.left,
        };
        var box_w = box.outerWidth() / 2,
            box_h = box.outerHeight(),
            _this_w = $(this).outerWidth() / 2;

        var box_left = childOffset.left - box_w + _this_w,
            box_top = childOffset.top - box_h;

        box.css({
            left: box_left,
            top: box_top,
        });

        box.addClass("open").addClass("no_stay");

        box.mouseenter(function () {
            box.removeClass("no_stay");
        });
    });

    object.mouseleave(function () {
        var box = object.closest(".frame").find(".file_detail_box");
        setTimeout(function () {
            if (box.hasClass("no_stay") == true) {
                box.removeClass("open").removeClass("no_stay");
            }
        }, 100);
    });

    object_box.mouseleave(function () {
        object_box.removeClass("open");
    });
}

//搜尋bar事件  search_bar
function search_event() {
    var _searchArea = $(".search_area");
}

function open_search(_searchArea) {
    var _openBtn = $(".open_search_btn");

    _openBtn.on("click", function () {
        if (_searchArea.hasClass("open") == false) {
            _searchArea.slideDown();
            _searchArea.addClass("open");
        } else {
            _searchArea.slideUp();
            _searchArea.removeClass("open");
        }
    });
}

function close_search(_searchArea) {
    var _closeBtn = $(".close_search_btn");

    _closeBtn.on("click", function () {
        _searchArea.slideUp();
        _searchArea.removeClass("open");
    });
}

/*2019.02.15 修改*/

// 多選 tag 表單
function quill_input_tag() {
    var textElement = Array.apply(
        null,
        document.querySelectorAll(".quill_input_tag")
    );
    textElement.forEach(function (obj) {
        if (!obj.classList.contains("active")) {
            obj.classList.add("active");
            quill_input_tag_active(obj);
        }
    });
}

function quill_input_tag_active(el) {
    var elInput = el.querySelector("input.content");
    var elUl = el.querySelector("ul.content");
    var addBtn = el.querySelector(".addBtn");

    if (addBtn) {
        // 如果組件裡面沒有 addBtn 也不會噴錯
        addBtn.addEventListener("click", function (e) {
            var text = elInput.value.trim();
            addTagEvent(text, elUl, elInput);
        });
    }

    if (elInput && elUl) {
        elInput.addEventListener("keydown", function (e) {
            var code = e.keyCode;
            var text = elInput.value.trim();
            if (code === 13) {
                e.preventDefault(); //取消如果 form 表單中只有一個 input 時的預設自動送出事件
                addTagEvent(text, elUl, elInput);
            }
        });
    }
}

function addTagEvent(text, elUl, elInput) {
    if (!text && !elUl && !elInput) {
        return;
    }

    if (text.length === 0) {
        return;
    }

    var tagLi = document.createElement("li");
    var tagtext = document.createElement("p");
    var deleteBtn = document.createElement("span");
    tagLi.setAttribute("class", "list");
    deleteBtn.setAttribute("class", "fa fa-remove delete_btn");

    deleteBtn.addEventListener("click", function () {
        var parent = this.parentNode;
        parent.parentNode.removeChild(parent);
    });

    tagtext.innerText = text;
    tagLi.appendChild(tagtext);
    tagLi.appendChild(deleteBtn);
    elUl.appendChild(tagLi);
    elInput.value = "";
}

// 這個很醜，改天想辦法重寫，用 jquery 寫反而好看

function toggleList() {
    // function
    function init() {
        var ulObj = mainObj.children("ul.unorderList");
        for (var i = 0, l = ulObj.length; i < l; i++) {
            i !== 0 ? ulObj.eq(i).addClass("unactive") : "";
        }
    }

    // init
    var mainObj = $(".listBox");
    var btnObj = mainObj.find("button.toggleBtn");
    init();

    // event
    btnObj.on("click", function () {
        var $this = $(this);
        var targetId = $this.data().list;
        for (var i = 0, l = mainObj.length; i < l; i++) {
            var nowObj = mainObj.eq(i);
            var ulObj = nowObj.children("ul.unorderList");
            if (nowObj.data().list === targetId) {
                if (!ulObj.hasClass("unactive")) {
                    ulObj.css("height", "0px");
                    ulObj.addClass("unactive");
                    $this.text("open");
                    return;
                }
                var liObj = ulObj.children("li.log");
                var liObjH = 0;
                for (var j = 0, jl = liObj.length; j < jl; j++) {
                    liObjH += liObj[j].offsetHeight;
                }
                ulObj.css("height", liObjH + "px");
                ulObj.removeClass("unactive");
                $this.text("close");
            } else {
                ulObj.css("height", "0px");
                ulObj.addClass("unactive");
                $this.text("open");
            }
        }
    });
}

function ajaxLightBox($el) {
    var $thisLi = $el.parents(".inventory");
    $.ajax({
        url: "/ajax-ams.html",
        type: "get",
        success: function (res) {
            var lightBox = $("article.ams_lbox");
            lightBox.children("div").append(res);
            card_table("ams_ajax_table");
            lightBox.addClass("open");
            lightBox.on("transitionend", function () {
                lightBox.addClass("go_animation");
                lightBox.off("transitionend");
            });
            $(".close_ajax_btn").on("click", function () {
                lightBox.addClass("remove");
                lightBox.on("transitionend", function () {
                    lightBox.removeClass("remove go_animation open");
                    lightBox.children("div").empty();
                    lightBox.off("transitionend");
                });
            });
        },
    });
}

// 檔案路徑下拉選單
function filePathSelect() {
    // append could icon's click event
    function couldEvent(el) {
        el.on("click", function (e) {
            var $parents = $(this).parents("li.option");
            var pathTextArray = [];
            var pathText;
            for (var i = 0, l = $parents.length; i < l; i++) {
                var obj = $parents.eq(i)[0];
                pathTextArray.unshift(obj.querySelector("p").innerText);
            }
            pathText = pathTextArray.join(" / ");
            btnText.text(pathText);
            btnText.attr("title", pathText);
            listTop.slideUp(s, function () {
                $(this).removeClass("active");
                btnObj.removeClass("active");
            });
            e.stopPropagation();

            //20190306 後端增加
            var folder_id = $(this).parents("li.option").data("id");
            var folder_level = $(this).parents("li.option").data("level");
            var folder_branch = $(this).parents("li.option").data("branch");

            // $('input[name="fms[folder_level]"]').val(folder_level);
            // $('input[name="fms[folder_id]"]').val(folder_id);

            //new
            $('input[name="fms[parent_folder_id]"]').val(folder_id);
            $('input[name="fms[parent_folder_level]"]').val(folder_level);
            $('input[name="fms[parent_branch]"]').val(folder_branch);
            $('input[name="fms[folder_id]"]').val(folder_id);

            //Leon增加
            $(this)
                .closest(".select_Box")
                .find(".select_Btn")
                .attr("data-id", folder_id);
        });
    }
    // 當取得 focus 時 append could(determine) icon
    function catchFocus(el) {
        var cloud = '<i class="fa fa-cloud-upload determine"></i>';
        var cloudDOM = $(cloud);
        couldEvent(cloudDOM);
        el.addClass("focus");
        //el.children('p.title').append(cloudDOM)
        //openPathMap(el)
    }
    // 畫面載入完畢後 initial path
    function initiPath() {
        for (var i = 0, l = openPath.length; i < l; i++) {
            var obj = openPath[i];
            for (var k = 0, kl = openTarget.length; k < kl; k++) {
                var nowObj = openTarget.eq(k);
                if (nowObj.children("p.title").text() === obj) {
                    nowObj.children("ul.option_list").slideDown();
                    i === l - 1 ? catchFocus(nowObj) : "";
                    openTarget = nowObj
                        .children("ul.option_list")
                        .children("li.option");
                    break;
                }
            }
        }
    }
    // 取的被 focus 資料夾的 parents
    function openPathMap(el) {
        var parentPath = el.parents("li.option");
        listTop.find(".open").removeClass("open");
        el.addClass("open");
        parentPath.addClass("open");
    }
    // initial
    var mainObj = $('.select_Box[data-type="path"]');
    var btnObj = mainObj.children(".select_Btn");
    var listTop = mainObj.children('.option_list[data-level="-1"]');
    var listObj = mainObj.find(".select_Btn + ul.option_list li.option");
    var listObj_arrow = mainObj.find(
        ".select_Btn + ul.option_list li.option .arrow"
    );
    var btnText = btnObj.children("p.title");
    var listParent = listObj.parent();
    var s = 300;

    var openPath = btnText.text().split(" / ");
    var openTarget = listTop.children("li.option");

    !btnText.text() ? btnText.text("Select file path") : initiPath();

    // for (var i = 0, l = listParent.length; i < l; i++) {
    //     var obj = listParent.eq(i)
    //     var level = obj.data().level || 0
    //     console.log(obj.find('p').text() + " ---  " + obj.data().id + " --- " + level + "  ---  " + (12 * (level + 1)) + 'px');
    //     //obj.children('li.option').find('p').css('padding-left', (12 * (level + 1)) + 'px')
    //     obj.find('p').eq(0).css('padding-left', (120 * (level + 1)) + 'px')
    // }
    //Leon
    const allElements = document.querySelectorAll(".option");
    [].forEach.call(allElements, (element) => {
        if (typeof element.dataset.level !== "undefined") {
            var px = (parseInt(element.dataset.level) + 1) * 12 + 12;
            element.getElementsByTagName("p")[0].style.paddingLeft = px + "px";
        }
    });

    // addEventListener
    btnObj.off("click").on("click", function (e) {
        var $this = $(this);
        var targetId = $this.data().id;
        var targetObj = $('ul.option_list[data-id="' + targetId + '"]');
        //var targetObj = $('ul.option_list')

        function openList() {
            $this.addClass("active");
            targetObj.addClass("active");
            //targetObj.stop().slideDown(s)
            $('ul.option_list[data-level="-1"]').stop().slideDown(s);
        }
        openList();
        // function closeList() {
        //     targetObj.stop().slideUp(s, function() {
        //         $this.removeClass('active')
        //         targetObj.removeClass('active')
        //     })
        // };
        // !targetObj.hasClass('active') ? openList() : closeList();
        e.stopPropagation();
    });
    listObj_arrow.off("click").on("click", function (e) {
        e.stopPropagation();
        var $this = $(this).parents(".option").first();

        if ($this.hasClass("open")) {
            $this.children("ul.option_list").stop().slideUp(s);
            $this.removeClass("open");
        } else {
            $this.addClass("open");
            if ($this.children("ul.option_list").length !== 0) {
                $this.children("ul.option_list").stop().slideDown(s);
            }
        }
    });
    listObj.off("click").on("click", function (e) {
        var $this = $(this);
        var pathTextArray = [];
        var pathText;
        for (var i = 0, l = $this.length; i < l; i++) {
            var obj = $this.eq(i)[0];
            pathTextArray.unshift(obj.querySelector("p").innerText);
        }
        pathText = pathTextArray.join(" / ");
        btnText.text(pathText);
        btnText.attr("title", pathText);
        // listTop.slideUp(s, function() {
        //     $(this).removeClass('active')
        //     btnObj.removeClass('active')
        // })

        var folder_id = $this.data("id");
        var folder_level = $this.data("level");
        var folder_branch = $this.data("branch");
        // $('input[name="fms[folder_level]"]').val(folder_level);
        // $('input[name="fms[folder_id]"]').val(folder_id);
        //new
        $('input[name="fms[parent_folder_id]"]').val(folder_id);
        $('input[name="fms[parent_folder_level]"]').val(folder_level);
        $('input[name="fms[parent_branch]"]').val(folder_branch);
        $('input[name="fms[folder_id]"]').val(folder_id);

        //Leon增加
        $(this)
            .closest(".select_Box")
            .find(".select_Btn")
            .attr("data-id", folder_id);
        var node = $(".tree-title[data-folder-id='" + folder_id + "']");
        // setParentStatus(node);
        generateBreadcrumb(node, 1, true);

        if ($this.hasClass("focus")) {
            //$this.children('ul.option_list').stop().slideUp(s)
            $this.find(".determine").remove();
            $this.removeClass("focus");
            //$this.removeClass('open')
        } else {
            var originalObj = listTop.find(".focus");
            originalObj.removeClass("focus");
            originalObj.find("i").remove(".determine");
            catchFocus($this);
            //openPathMap($this)
            // if ($this.children('ul.option_list').length !== 0) {
            //$this.children('ul.option_list').stop().slideDown(s)
            // }
        }

        e.stopPropagation();
    });

    $("body").on("click", function () {
        if (btnObj.hasClass("active")) {
            btnObj.removeClass("active");
            listTop.removeClass("active");
            listTop.stop().slideUp(s);
        }
    });
}

/*======================目前未使用的功能====================*/

function openLightBox() {
    var mainObj = $('.select_Box[data-type="lightBox"]');
    var btnObj = mainObj.children(".select_Btn");
    btnObj.on("click", function () {
        var $this = $(this);
        var $thisPath = $this.data("path");
        ajaxLightBox($this);
    });
}

function submitBtnHandler() {
    $('button[name="checkBtn"]').on("click", function () {
        $(".submit_lbox").addClass("open");
    });
    $("i.closeBtn").on("click", function () {
        $(".submit_lbox").removeClass("open");
    });
}

openLightBox();
submitBtnHandler();

/*======================目前未使用的功能====================*/

//打開fms lightbox(open_fms_lightbox)
// function btn_fms_lightbox(){
//     var open_btn = $('.open_fms_lightbox'),
//         lbox_frame = $('.fms_lbox');
//     open_btn.on('click','.ajax_open',function(){
//         $( ".fms_lbox .frame" ).load( "../../../../backstage/ajax-fms.html",function(){
//             //需啟動的JS
//             fms_lightbox();
//         } );
//         lbox_frame.addClass('open');
//         setTimeout(function() {
//             lbox_frame.addClass('go_animation');
//         }, 1000);
//     });
// }

// function fms_lightbox(){
//     //close_btn
//     close_wrapper( $('.ajax_fms .hiddenArea') );
//     //close_ajax_btn
//     close_ajax_btn();
//     //dataTable
//     card_table('fms_lbox');
//     //view MODE:Grid
//     grid_mode();
//     //table view mode event
//     table_view_mode();
//     //open light_box_img 燈箱圖片
//     open_fms_light_box();
//     //scroll bar
//     var target = $('.fms_lbox .hiddenArea_frame_box .box_block');
//     target.scrollbar({});
// }

// //打開ams lightbox(open_ams_lightbox)
// function ams_lightbox(){
//     //close_ajax_btn
//     close_ajax_btn();
//     //dataTable
//     card_table('ams_ajax_table');
// }

// function btn_ams_lightbox(){
//     var open_btn = $('.open_ams_lightbox'),
//         lbox_frame = $('.ams_lbox');
//     open_btn.on('click','.ajax_open',function(){
//         $( ".ams_lbox .frame" ).load( "../../../../backstage/ajax-ams.html",function(){
//             //需啟動的JS
//             ams_lightbox();
//         } );
//         lbox_frame.addClass('open');
//         setTimeout(function() {
//             lbox_frame.addClass('go_animation');
//         }, 1000);
//     });
// }

// //打開full preview(open_paragraph_preview)
// function preview_lightbox(){
//     //綁定scroll bar
//     var paragraph = $('.preview_lbox .public_paragraph');

//     paragraph.scrollbar({});

//     //append close_ajax_btn
//     add_close_btn();

//     //close_ajax_btn
//     close_ajax_btn();

// }
// function btn_preview_lightbox(){

//     var open_btn = $('.open_paragraph_preview'),
//     lbox_frame = $('.preview_lbox');

//     open_btn.on('click',function(){

//         $( ".preview_lbox .frame" ).load( "../../../../backstage/public_paragraph.html",function(){

//             //需啟動的JS
//             preview_lightbox();

//         } );

//         lbox_frame.addClass('open');

//         setTimeout(function() {
//             lbox_frame.addClass('go_animation');
//         }, 500);

//     });

// }
// //append preview close_ajax_btn
// function add_close_btn(){

//     var btn = '<!--後臺preview關閉按鈕--><div class="close_ajax_btn"><span class="fa fa-remove"></span></div>';

//     var frame = $('.preview_lbox').children('.frame');

//     frame.append( btn );

// }

// //(quill_input_tag)
// function quill_input_tag(){

//     var textElement = $('.quill_input_tag');

//     if ( textElement.hasClass('active') == false ) {

//         textElement.addClass('active');

//         quill_input_tag_active( textElement );

//     }else {
//         return;
//     }

// }
// function quill_input_tag_active( textElement ){

//     textElement.on('click','.content',function(){

//         if ( $(this).hasClass('order') == true ) {

//             // console.log('標籤 tag');

//         }else {

//             quill_input_tag_enter( $(this) );
//         }

//     });

// }
// function quill_input_tag_enter(input){

//     var order = input.siblings('.order');

//     input.on('keydown', function(e){

//         var code = e.keyCode,
//             text = input.val();

//         if ( code == 13 && text != '' ) {

//             var list = '<li class="list"><p>'+ text +'</p><span class="fa fa-remove delete_btn"></span></li>';

//             order.append( list );

//             input.val('');

//         }

//     });

// }
