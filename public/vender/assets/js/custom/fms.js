//fmsjs

$(document).ready(function () {
    card_table('fms_table');

    //view MODE:Grid
    grid_mode();

    //search_bar
    search_event();

    //table view mode event
    table_view_mode();

    //open light_box_img 燈箱圖片
    open_fms_light_box();

    //content_sidebar_click
    content_sidebar_click();
});


function grid_mode() {
    var grid = $('.grid_mode'),
        list = grid.find('.list'),
        unlock = grid.find('.unlock'),
        icon_unlock = unlock.find('.icon_unlock');

    //unlock check event
    unlock.on('click', '.icon_unlock', function () {

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
    _mode_btn.on('click', function () {
        var a = $(this).attr('mode-id');
        var target = '.' + a;
        $(target).addClass('open').siblings('.table_mode').removeClass('open');
        $(this).addClass('open').siblings('.mode_btn').removeClass('open');
        //
        if (a == 'gd_mode') {

            $('.grid_mode .frame').scrollbar({});
            calculate_grid();
            $(window).resize(function () {
                calculate_grid();
            });
        }
    });
}



//light_box_img 燈箱圖片
function open_fms_light_box() {
    var open_btn = $('.open_img_box'),
        close_btn = $('.light_box_img .close_btn');
    light_box = $('.light_box_img');

    open_btn.on('click', function () {
        light_box.addClass('open');
    });

    close_btn.on('click', function () {
        light_box.addClass('close');
        setTimeout(function () {
            light_box.removeClass('open').removeClass('close');
        }, 500);
    });
}





//content_sidebar_click
function content_sidebar_click() {
    var target = $('.level_list');
    target.on('click', 'a', function () {
        var _this_father = $(this).closest('.level_list'),
            _this_grand_father = $(this).closest('.body-list');
        var li = _this_father.find('.level_list'),
            sub = _this_father.find('.sub-menu'),
            arrow = _this_father.find('.arrow');

        //關閉所點擊的分支截點
        if (_this_father.hasClass('open active')) {
            arrow.removeClass("open active");
            sub.slideUp(200, function () {
                li.removeClass("open active");
            });
        }


        //當點擊另一個 level-1 的時候 除了會打開另一個的 level-1 

        //同時還會把現在這個 level-1 以及她抵下的所有被打開的分支都關上
        if (_this_grand_father.children('.level_list.open').hasClass('open active')) {
            _this_grand_father.children('.level_list.open').siblings().find('.sub-menu').slideUp(200, function () {
                $(this).find('.level_list').removeClass('open active');
            });
        }
    });
}

/*============================================================*/