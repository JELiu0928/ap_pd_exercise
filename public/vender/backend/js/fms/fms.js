/* ============================================================
 * 客製化js
 * ============================================================ */

$(document).ready(function() {
    //
    card_table('fms_table');

    //view MODE:Grid
    grid_mode();

    //table view mode event
    table_view_mode();

    //content_sidebar_click
    // content_sidebar_click();
    setTimeout(function() {
        $('.sidebar-menu').scrollbar();
        $('.dataTables_scrollBody').scrollbar();
    }, 1000)

    alert('ss');

});

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

//content_sidebar_click 
// 沒用到 #adam
function content_sidebar_click() {
    var target = $('.level_list');
    target.on('click', 'a', function() {
        var _this_father = $(this).closest('.level_list'),
            _this_grand_father = $(this).closest('.body-list'),
            li = _this_father.find('.level_list'),
            sub = _this_father.find('.sub-menu'),
            arrow = _this_father.find('.arrow');

        //關閉所點擊的分支截點
        if (_this_father.hasClass('open active')) {
            arrow.removeClass("open active");
            sub.slideUp(200, function() {
                li.removeClass("open active");
            });
        }

        //當點擊另一個 level-1 的時候 除了會打開另一個的 level-1 
        //同時還會把現在這個 level-1 以及她抵下的所有被打開的分支都關上
        if (_this_grand_father.children('.level_list.open').hasClass('open active')) {
            _this_grand_father.children('.level_list.open').siblings().find('.sub-menu').slideUp(200, function() {
                $(this).find('.level_list').removeClass('open active');
            });
        }
    });
}
