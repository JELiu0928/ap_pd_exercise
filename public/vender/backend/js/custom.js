/* ============================================================
 * 客製化js
 * ============================================================ */

var bd = $('body');
bd.data('base', {});
bd.data('fms', {});
bd.data('cms', {});

$(document).ready(function() {

    // 設定左邊slideBar滑鼠移入移出時，顯示/隱葳
    left_slideBar();

    // 右邊滑動隱藏區塊
    close_notifyScreen();

    // 日期選單
    wade_datepicker();

    // 小畫面JS
    small_content_sidebar();

    // 固定sideBar
    $('.content-sidebar .body-list').scrollbar();

    // language_category
    language_category(); // 疑似不需要#HondaDebug

    // 這段不知道功能，但會讓 ui 跑掉
    // $('.table-box .card-header').css('padding','10px 50px 10px 50px');

});
/*======================載入頁面各區塊界面====================*/


/*=====================頁面載入時執行的功能===================*/

// 設定左邊slideBar滑鼠移入移出時，顯示/隱葳
// 只在此js使用#Honda
function left_slideBar() {
    var bar = $('.left-slide'),
        bar_menu_item = bar.find('.sidebar-menu ul.menu-items');

    bar.mouseenter(function() {
        bar_menu_item.addClass('show');
    });

    bar.mouseleave(function() {
        bar_menu_item.removeClass('show');
    });
}

// 關閉提醒視窗
// 只在此js使用#Honda
function close_notifyScreen() {
    var object = '.quickview-wrapper';

    $('.notify-screen').on('click', '.btn', function() {
        setTimeout(function() {
            $(object).css('left', 'calc(100%)');
        }, 450);
    });
}

// 小畫面的JS(1366px)
// 只在此js使用#Honda
function small_content_sidebar() {
    var side_bar = '.content-sidebar',
        window_w = $(window).width(),
        _this;

    //打開
    $('body').on('click', side_bar, function() {
        _this = $(this);

        if (window_w < 1366 && _this.hasClass('open_bar') == false) {
            _this.parent().addClass('open_bar');
        }
    });

    //關閉
    $(document).on('click', function(e) {
        if (window_w < 1366 && $(side_bar).has(e.target).length > 0 || e.target.className == 'content-sidebar') {
            return;
        } else {
            $(side_bar).parent().removeClass('open_bar');
        }
    });
}

//language_category
// 只在此js使用，疑似不需要#HondaDebug
function language_category() {

    var lng = $('.language .sub-menu .lng'), //語系
        display_title = $('.language .display-title .title'); //顯示的標題

    lng.on('click', function() {

        if ($(this).hasClass('level-3')) {
            //兩層，把被選取的語系文字 跟 他上一層的 分類標題名稱 做組合
            //抓出預備更換的文字
            var name = $(this).closest('.lng-category').find('.title-box .title').text();
            var lng = $(this).find('a').text();

            //預防有多餘空白問題(把空白消掉)
            name = name.replace(/ /g, "");
            lng = lng.replace(/ /g, "");

            //將抓出來且去除多餘空白的文字 依規則組合在一起
            display_title.text(name + ' - ' + lng);

        } else {
            //一層，直接把被選擇的語系文字 與 標題名稱 組合
            //抓出預備更換的文字
            var name = display_title.text().split("-")[0]; //用 - 把文字給分隔開來
            var lng = $(this).find('a').text();

            //預防有多餘空白問題(把空白消掉)
            name = name.replace(/ /g, "");
            lng = lng.replace(/ /g, "");

            //將抓出來且去除多餘空白的文字 依規則組合在一起
            display_title.text(name + ' - ' + lng);
        }
    });
}

/*=====================頁面載入時執行的功能===================*/

/*=========================table Function===================*/

function card_table(target) {
    var targetTable = $('[data-tableID="' + target + '"]');
    var settings = {
        sDom: "<'table-responsive't><'row'<p i>>", //在html上增加結構
        paging: false,
        ordering: true,
        info: false,
        destroy: true, //摧毀表格
        scrollY: false,
        scrollX: '100%',
        scrollCollapse: true,
        autoWidth: false,
        aoColumnDefs: [{ //把第一格也就是checkbox那格的排序功能取消
            bSortable: false,
            aTargets: [0]
        }],
    };

    switch (target) {
        case 'cms_table':
            cms_card_table(settings);
            break;
        case 'fms_table':
            fms_card_table(settings);
            //選單開關
            $('.switch-menu').off().click(function() {
                $('.page-content-wrapper').toggleClass('content-sidebar-open')
            })
            break;
        case 'ams_table':
            ams_card_table(settings);
            break;
        case 'ams_ajax_table':
            ams_ajax_card_table(settings);
            break;

        case 'new_cms_table':
            //左右按鈕 滑動table
            // Table_scrollBtn();
            //打開右邊隱藏選單
            open_wrapper();
            //table menu-list下拉選單
            // table_dropdown();
            //計算有幾個可以勾的checkbox
            // dataTable_tickCount();
            break;

        default:
            $('.menu_content.editContentFormArea').scrollbar({});
            // console.log('目標table不存在');
    }

    settings.fnPreDrawCallback = function(oSettings) {
        $('.main-table .dataTables_scrollBody tbody tr.selected').removeClass('selected');
    }

    if (target != 'new_cms_table') {
        targetTable.find('table').DataTable(settings);
    }

    if (target != 'ams_ajax_table') {
        //input點擊事件
        click_event();

        //頁腳切換頁面事件
        pagination_event();
    }

    //給datatable高度 讓scrollbar可以滑到底
    calculate_data_table_height(targetTable);
}

function cms_card_table(settings) {

    settings.fixedColumns = {
        leftColumns: 2
    }; //datatable還沒改，功能先不隱藏#HondaDebug

    settings.initComplete = function() {
        $(this).closest('.card-block').addClass('open');

        //左右按鈕 滑動table
        Table_scrollBtn();

        //打開右邊隱藏選單
        open_wrapper();

        //table menu-list下拉選單
        table_dropdown();

        //計算有幾個可以勾的checkbox
        dataTable_tickCount();
    };
    // 2019.02.21 Alex 加上=>datatable還沒改，功能先隱藏#HondaDebug
    // hoistingTableHeader();
}

function fms_card_table(settings) {
    settings.initComplete = function() {
        // $('.card-block').eq(0).addClass('open');
        //打開右邊隱藏選單
        open_wrapper();

        //計算有幾個可以勾的checkbox
        dataTable_tickCount();
    };
}

function ams_card_table(settings) {
    settings.initComplete = function() {
        $(this).closest('.card-block').addClass('open');
        //計算有幾個可以勾的checkbox
        dataTable_tickCount();
    };
}

function ams_ajax_card_table(settings) {
    settings.initComplete = function() {
        $(this).closest('.card-block').addClass('open');
        //計算有幾個可以勾的checkbox
        dataTable_tickCount();
    };
}

// 點擊事件
// 只在card_table使用#Honda
function click_event() {
    var count_number = [];

    $('.main-table tbody tr .checkbox').on('click', function() {

        $(this).closest('tr').toggleClass('selected');
        //yuan
        if ($(this).closest('tr').hasClass('selected')) {
            $(this).find("input").prop("checked", true);
        } else {
            $(this).find("input").prop("checked", false);
        }
        //yuan end
        var b = ($(this).closest('tr').attr('tick-id')) / 1 + 1;

        var scrollBody_inputCheckbox = $(this).closest('.table-box').find('.dataTables_scrollBody tbody tr .container_checkBox' + b),
            scrollBody_tr = scrollBody_inputCheckbox.closest('tr'),
            scrollLeft_tr = $(this).closest('tr'),
            scrollLeft_tb = $(this).closest('tbody');

        var main_table = $('.main-table');

        //判斷table有沒有fixedColumns:left
        if (main_table.hasClass('no_left') == false) {
            scrollBody_tr.toggleClass('selected');
        }
        //每次點擊都會被啟動的"順序計算器"
        // checkbox_number(scrollBody_tr,scrollLeft_tr,count_number,main_table);
    });
}

// 頁腳切換頁面事件
// 只在card_table使用#Honda
function pagination_event() {
    $('.main-table .dataTables_paginate').on('click', function() {

        $('.main-table .DTFC_LeftWrapper tbody tr input').on('click', function() {

            $(this).closest('tr').addClass('selected');
            var b = ($(this).closest('tr')[0].dataset.dtRow) / 1 + 1;
            $(this).closest('.table-box').find('.dataTables_scrollBody tbody tr input#checkbox' + b).closest('tr').toggleClass('selected');
        });
    });
}

//計算每個dataTable的初始高度
// 只在card_table使用#Honda
function calculate_data_table_height(table) {
    var frame = $(table).closest('.page-container'),
        frame_height = frame.height(),
        jumbotron_height = frame.find('.jumbotron').outerHeight(), //佈告欄的高
        header_height = frame.find('.header').outerHeight(), //最上面的高
        card_head_height = frame.find('.card-header').outerHeight(), //表格上面的按鈕那塊的高
        table_head_height = frame.find('.dataTables_scrollHead').outerHeight(), //表頭高
        page_foot_height = frame.find('.page_foot').outerHeight(), //頁腳高
        scroll_wrapper = '',
        container_height = '';

    // container_height = frame_height - jumbotron_height - header_height - card_head_height - table_head_height - page_foot_height - 40;
    container_height = frame_height - jumbotron_height - header_height - card_head_height - table_head_height - 40;
    scroll_wrapper = container_height + table_head_height;

    table.find('.dataTables_scrollBody').css('max-height', container_height);

    table.find('.DTFC_ScrollWrapper').css('height', scroll_wrapper);

    table.find('.DTFC_LeftBodyLiner').css({ 'max-height': container_height, 'height': container_height });
    table.find('.DTFC_LeftBodyWrapper').css('height', scroll_wrapper);
}

// 2019.02.21 新增
// 強迫 tableHeader 硬是拉到比較高的層級
function hoistingTableHeader() {
    document.querySelector('.dataTables_scrollHead').setAttribute('style', [
        'border: none',
        'position: relative',
        'border: 0',
        'z-index: 1',
    ].join(';'))
}

// table menu-list下拉選單
// 只在cms_card_table使用#Honda
function table_dropdown() {
    $('table .dropdown .dropdown-menu').css({
        'min-width': '150px',
        'width': '100%',
    });
    $('table .dropdown .btn').css('width', '100%');
}

// 左右按鈕 滑動table
// 只在cms_card_table使用#Honda
function Table_scrollBtn() {

    //因為可能會因為"ajax呼叫後"或"多表格" 發生再次綁定
    //所以每次被呼叫就先解綁再綁定，很蠢(先頂著用)
    $('.table-box .arrow-group .arrow').unbind();

    // var x = 0, //初始值
    //     distance = 200; //移動距離

    $('.table-box .arrow-group .arrow').on('click', 'span', function() {

        var box = $(this).closest('.table-box').find('.dataTables_scroll .dataTables_scrollBody'),
            box_head = $(this).closest('.table-box').find('.dataTables_scroll .dataTables_scrollHead'),
            table = box.find('.table'),
            move_length = table.width() - box.width(); //全部可移動寬度 ( clientWidth )

        console.log(table.width() + 'ppp');
        console.log(box.width() + 'ppp');


        if ($(this).hasClass('right')) {

            x = ((box.width() / 4)) + box.scrollLeft(); //box.scrollLeft(); 可以放入數值

            box.animate({
                scrollLeft: x,
            });

            // console.log(x);
            // console.log(distance);
            // console.log(move_length);

            //如果有套scroll 就執行這個
            // if ( x < distance - 1 ) {
            //     //往右走時 先判斷 x 是否小於移動距離
            //     //若小於移動距離就把 x 還原成 0 ， 避免往左走 走到底時的 x 不等於0 ， 進而影響往右走的 x 數值
            //     x = 0;
            // }

            // if ( x + distance < move_length ) {
            //     //如果 x + 移動距離 小於 可移動寬度 便執行
            //     x = x + distance;

            //     box_head.find('.table').css({
            //         'transform': 'translateX(-'+ x +'px)',
            //         '-webkit-transform': 'translateX(-'+ x +'px)',
            //         '-moz-transform': 'translateX(-'+ x +'px)',
            //         '-ms-transform': 'translateX(-'+ x +'px)',
            //         '-o-transform': 'translateX(-'+ x +'px)',
            //     });
            //     box.find('.table').css({
            //         'transform': 'translateX(-'+ x +'px)',
            //         '-webkit-transform': 'translateX(-'+ x +'px)',
            //         '-moz-transform': 'translateX(-'+ x +'px)',
            //         '-ms-transform': 'translateX(-'+ x +'px)',
            //         '-o-transform': 'translateX(-'+ x +'px)',
            //     });

            // }else {
            //     //如果 x + 移動距離 大於 可移動寬度 ， 表示以經到底了 移動距離 大於 可移動寬度
            //     //所以 最後一步的移動數值 就是 可移動寬度 ， 這樣就可以移動到底
            //     x = move_length;

            //     box_head.find('.table').css({
            //         'transform': 'translateX(-'+ move_length +'px)',
            //         '-webkit-transform': 'translateX(-'+ move_length +'px)',
            //         '-moz-transform': 'translateX(-'+ move_length +'px)',
            //         '-ms-transform': 'translateX(-'+ move_length +'px)',
            //         '-o-transform': 'translateX(-'+ move_length +'px)',
            //     });
            //     box.find('.table').css({
            //         'transform': 'translateX(-'+ move_length +'px)',
            //         '-webkit-transform': 'translateX(-'+ move_length +'px)',
            //         '-moz-transform': 'translateX(-'+ move_length +'px)',
            //         '-ms-transform': 'translateX(-'+ move_length +'px)',
            //         '-o-transform': 'translateX(-'+ move_length +'px)',
            //     });

            // }


        } else {

            x = ((box.width() / 4)) - box.scrollLeft(); //box.scrollLeft(); 可以放入數值

            box.animate({
                scrollLeft: -x,
            });

            // console.log(x);
            // console.log(distance);
            // console.log(move_length);

            //如果有套scroll 就執行這個
            // if ( x == 0 ) {
            //     // x == 0 表示 在最左邊了 不用做任何動作
            //     return;

            // }
            // else if ( x - distance < 0 ) {
            //     // x - distance < 0 表示為負值 代表這次移動會超過最左邊的 0px (會跑版) ， 所以就讓它移動到最左邊的 0px
            //     box_head.find('.table').css({
            //         'transform': 'translateX(0px)',
            //         '-webkit-transform': 'translateX(0px)',
            //         '-moz-transform': 'translateX(0px)',
            //         '-ms-transform': 'translateX(0px)',
            //         '-o-transform': 'translateX(0px)',
            //     });
            //     box.find('.table').css({
            //         'transform': 'translateX(0px)',
            //         '-webkit-transform': 'translateX(0px)',
            //         '-moz-transform': 'translateX(0px)',
            //         '-ms-transform': 'translateX(0px)',
            //         '-o-transform': 'translateX(0px)',
            //     });

            // }
            // else if ( x - distance < move_length ) {
            //     // x - distance < move_length 表示 x < 可移動寬度 ， 所以就正常的往左移動
            //     x = x - distance;

            //     box_head.find('.table').css({
            //         'transform': 'translateX(-'+ x +'px)',
            //         '-webkit-transform': 'translateX(-'+ x +'px)',
            //         '-moz-transform': 'translateX(-'+ x +'px)',
            //         '-ms-transform': 'translateX(-'+ x +'px)',
            //         '-o-transform': 'translateX(-'+ x +'px)',
            //     });
            //     box.find('.table').css({
            //         'transform': 'translateX(-'+ x +'px)',
            //         '-webkit-transform': 'translateX(-'+ x +'px)',
            //         '-moz-transform': 'translateX(-'+ x +'px)',
            //         '-ms-transform': 'translateX(-'+ x +'px)',
            //         '-o-transform': 'translateX(-'+ x +'px)',
            //     });

            // }

        }

    })

}

// 計算有幾個可以勾的checkbox
// 只在cms_card_table/fms_card_table/ams_card_table/ams_ajax_card_table使用#Honda
function dataTable_tickCount() {

    var tick = $('.dataTables_scrollBody .tbody_tick');

    for (var a = 0; a < tick.length; a++) {

        tick.eq(a).attr('tick-id', a);

        var box_id = a + 1;

        tick.eq(a).find('.checkbox input').addClass('container_checkBox' + box_id);

    }

}

// checkbox點擊顯示數字
// 只在click_event使用#Honda
function checkbox_number(tr, left_tr, count_number, main_table) {

    if (tr.hasClass('selected') == true) {
        if (main_table.hasClass('no_left') == true) {
            var target = tr;
        } else {
            var target = left_tr;
        }

        //現在的陣列長度，用來看現在順序到哪
        var base_id = count_number.length;

        //在tr上面放一個順序的數字
        target.attr('sort-id', base_id);

        //這個是顯示出順序的數字
        target.find('label span').html(base_id + 1);

        //把 順序 放入陣列裡
        count_number[base_id] = [base_id];
    } else {
        //取消選取時
        //先把現在這個被取消的 順序數字放入a
        if (main_table.hasClass('no_left') == true) {
            var a = tr.attr('sort-id') / 1;
            var target = tr;
        } else {
            var a = left_tr.attr('sort-id') / 1;
            var target = left_tr;
        }

        //把被取消的順序數字刪除
        target.attr('sort-id', '');

        //把顯示出的順序數字也刪除
        target.find('label span').html('');

        //從陣列裡把被取消的那列給刪除
        count_number.splice(a, 1);

        //用迴圈把所有的順序重跑一次
        for (var index = 0; index < count_number.length; index++) {
            //取出每條的順序數字
            var b = target.siblings('.selected').eq(index).attr('sort-id');

            //將 順序數字 與 刪除的那列 做比較
            //當順序數字 大於或等於 刪除的數字時 才做順序數字的更新(因為每次只能點擊一個 所以順序數字只要固定的-1)
            if (b >= a) {
                target.siblings('.selected').eq(index).attr('sort-id', b - 1);
                target.siblings('.selected').eq(index).find('label span').html(b);
            }
        }
    }
}

/*=========================table Function===================*/


/*==========================共用 Start======================*/

/*綁定scroll_bar*/
/*ajax呼叫結構進來後 可以綁scroll_bar*/
/*例: active_scrollBar( $('.normal .quill_select .select_list') )*/
/*這樣就可以把 normal 下的所有下拉選單的select_list 綁scroll_bar*/
function active_scrollBar(object) {
    object.scrollbar();
}

// 日期選單的datepicker , daterangepicker , timepicker 的啟動function都放在form_element.js裡
// 想要看使用範例可以去看form_element.js
// Date Pickers
// 可移#Honda
function wade_datepicker() {
    $('.datepicker-input').each(function(index, el) {
        var _this = $(this);
        if (!_this.hasClass('active_date')) {
            _this.datepicker({
                todayHighlight: true,
                autoclose: true,
                language: 'zh-TW',
                format: 'yyyy/mm/dd',
                // startDate: '+0d',
            });
            _this.addClass('active_date');
        }

    });
}

function grid_mode() {
    var grid = $('.grid_mode'),
        list = grid.find('.list'),
        unlock = grid.find('.unlock'),
        icon_unlock = unlock.find('.icon_unlock');

    //unlock check event
    unlock.on('click', '.icon_unlock', function() {
        if ($(this).closest(list).hasClass('check') == false) {
            $(this).closest(list).addClass('check');
        } else {
            $(this).closest(list).removeClass('check');
        }
    });
}

function calculate_grid() {
    var _innerContent = $('.fms_theme .inner-content'),
        _innerHeight = _innerContent.height(),
        _jumbotronHeight = _innerContent.find('.jumbotron').outerHeight(),
        _cardHeaderHeight = _innerContent.find('.card-header').outerHeight(),

        _frameHeight = _innerHeight - (_jumbotronHeight + _cardHeaderHeight),

        _gridMode = $('.grid_mode'),
        _frame = $('.grid_mode .frame');

    _frame.css('height', _frameHeight);
}

//table view mode event
function table_view_mode() {
    var _mode_btn = $('.card-header .mode_btn'),
        _table_mode = $('.table_mode');

    _mode_btn.on('click', function() {
        var _area = $('input.fileAreaSupportSet');
        var _area_zero = _area.data('zero');
        var _area_first = _area.data('first');
        var _area_second = _area.data('second');
        var _area_third = _area.data('third');
        var _area_branch = _area.data('branch');

        var a = $(this).attr('mode-id');
        if (a == 'lt_mode') {
            change_fms_file_lt_table(_area_zero, _area_first, _area_second, _area_third, _area_branch);
            $('.grid_sort').hide();
        } else if (a == 'lp_mode') {
            change_fms_file_lp_table(_area_zero, _area_first, _area_second, _area_third, _area_branch);
            $('.grid_sort').hide();
        } else if (a == 'gd_mode') {
            change_fms_file_gd_table(_area_zero, _area_first, _area_second, _area_third, _area_branch);
            $('.grid_sort').show();
            //quill_select();
        }

        var target = '.' + a;

        $(target).addClass('open')
        $(target).siblings('.table_mode').removeClass('open')

        $(this).addClass('open')
        $(this).siblings('.mode_btn').removeClass('open')

        if (a == 'gd_mode') {
            $('.grid_mode .frame').scrollbar({});
            calculate_grid();
            $(window).resize(function() {
                calculate_grid();
            });
        }
    });
}

/**
 *
 * 產生英數字混合金鑰
 *
 * @param bool randomFlag 若設true，產生長度在min~max之間的金鑰，否則產生長度為min的金鑰
 * @param int min 金鑰最短長度
 * @param int max 金鑰最長長度
 */
function randomWord(randomFlag, min, max) {
    var str = "",
        range = min,
        arr = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    // 随機決定金鑰長度
    if (randomFlag) {
        range = Math.round(Math.random() * (max - min)) + min;
    }

    // 產生金鑰
    for (var i = 0; i < range; i++) {
        pos = Math.round(Math.random() * (arr.length - 1));
        str += arr[pos];
    }

    return str;
}

// 登出後台
function basic_logout() {
    $.ajax({
            url: $('.base-url-plus').val() + "/auth/logout",
            type: 'GET',
        })
        .done(function(data) {
            document.location.href = $('.base-url-plus').val() + "/Fantasy";
        })
        .fail(function() {
            console.log("logout error");
        });
}

/*==========================共用 End========================*/
