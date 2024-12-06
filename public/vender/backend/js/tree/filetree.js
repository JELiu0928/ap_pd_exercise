$(document).ready(function () {
    $('body').find('.tree').fadeOut(0);
    if ($('.ready-tree').length == 1) setParentStatus($('.ready-tree'));

    $('body').on('click', '.tree-title', function () {
        treeclick($(this), true);
    });
    $("body")[0].fms_open = false;
    $("body")[0].fms_open_index = 0;

    let folder_id = location.search.replace('?folder_id=', '') || "";
    if (folder_id != "") {
        treeclick($('.tree-title[data-folder-id="' + folder_id + '"]'), true);
    }
    $('body').on('click', '.breadcrumb-item', function () {
        $('.tree-title[data-folder-id="' + $(this).attr('data-folder-id') + '"]').click();
        //取消勾選項目
        $('input.fms_lbox_file_select_checkbox').prop('checked', false);
        $('.fms_folder.selected').removeClass('selected');
        $('.fms_list.selected').removeClass('selected');
        $('.w_Check').removeClass('selected');
    });
    if ($('body').hasClass('fms_theme')) {
        window.addEventListener("popstate", function (event) {
            let folder_id = location.search.replace('?folder_id=', '') || 0;
            treeclick($('.tree-title[data-folder-id="' + folder_id + '"]'), false);
        });
    }
    // add by Kevin
    $('.main-tree > .tree-title ~ ul.is_delete').last().prevAll('ul:not(.is_delete)').first().addClass('last-visible')
});

function treeclick(_this, _push) {
    if (_this.hasClass('cant_use')) {
        alert("您沒有權限");
        return;
    }
    var trash = false;
    if (_this.hasClass('trash')) {
        trash = true;
        $(".Leon_folder_back").css("display", "none");
        $(".leon-trash-hide").css("display", "none");
        $(".leon-trash-show").css("display", "flex");
    } else {
        if (_this.attr('data-parent-id') == -1) {
            $(".Leon_folder_back").css("display", "none");
        } else {
            $(".Leon_folder_back").css("display", "table-row");
        }
        $(".leon-trash-hide").css("display", "inline-flex");
        $(".leon-trash-show").css("display", "none");
    }
    if (_push) {
        if ($("body").hasClass('cms_theme')) {
            if (!$("body")[0].fms_open) {
                history.pushState({ folder_id: -1, fms_open_index: -1 }, null);
                console.log('folder_id -1');
            }
            $("body")[0].fms_open = true;
            $("body")[0].fms_open_index = $("body")[0].fms_open_index + 1;
            history.pushState({ folder_id: _this.attr('data-folder-id'), fms_open_index: $("body")[0].fms_open_index }, null);
            console.log('folder_id ' + _this.attr('data-folder-id'));
        } else {
            //history.pushState({ state: $('#folder_id').val() }, null, $('.base-url-plus').val() + '/Fantasy/Fms' + "?folder_id=" + _this.attr('data-folder-id'));
        }
    }
    $(".select_folder_name").html(_this.find('.title').text());
    $('#folder_id').val(_this.attr('data-folder-id'));
    $(".fms_folder_back").attr('data-id', _this.attr('data-parent-id'));
    //取消勾選項目
    $('input.fms_lbox_file_select_checkbox').prop('checked', false);
    $('.fms_folder.selected').removeClass('selected');
    $('.fms_list.selected').removeClass('selected');
    $('.w_Check').removeClass('selected');
    $(".tree-title").removeClass('active');
    $('.check-circle.icon-check:first').siblings('input').prop('checked', false);
    // generateBreadcrumb(_this, 1);
    // setSelfStatus(_this);
    set_fms_basic(trash);
}
/**
 * Set the list opened or closed
 * */
function setSelfStatus(node) {
    //$(".tree-title").removeClass('active');
    console.log(node);
    var elements = [];
    $(node).each(function () {
        elements.push($(node).nextAll());
    });
    for (var i = 0; i < elements.length; i++) {
        elements[i].fadeIn(0);
        // if (elements[i].css('display') == 'none') {
        //     elements[i].fadeIn(0);
        // } else {
        //     elements[i].fadeOut(0);
        // }
    }
    if (elements.length > 0 && elements[0].css('display') != 'none') {
        $(node).addClass('active');
    } else {
        $(node).removeClass('active');
    }
    //console.log(elements);
}

function setParentStatus(node) {
    setSelfStatus(node);
    if ($(node).closest('.tree').length == 1) {
        var nextNode = $(node).closest('.tree').siblings('.tree-title');
        setParentStatus(nextNode)
    }
}

//生成麵包屑 由下到上 first 被點擊的那個資料夾
var breadcrumbHtml = "";

function generateBreadcrumb(node, first = 0, on_up = false) {
    if (first == 1) breadcrumbHtml = "";
    if ($(node).closest('.tree').length == 1) {
        var nextNode = $(node).closest('.tree').siblings('.tree-title').eq(0);
        generateBreadcrumb(nextNode, 0, on_up);
        breadcrumbHtml += '<li class="breadcrumb-item" aria-current="page" data-folder-id="' + $(nextNode).attr("data-folder-id") + '"><a href="javascript:;">' + $(nextNode).text() + '</a></li>';
    }
    if (first == 1) breadcrumbHtml += '<li class="breadcrumb-item active" aria-current="page" data-folder-id="' + $(node).attr("data-folder-id") + '"><a href="javascript:;">' + $(node).text() + '</a></li>';

    if (on_up) {
        $(".fmsUpload_done .subtitle").html('<li class="breadcrumb-item"><span class="icon fa fa-folder"></span></li>' + breadcrumbHtml);
    } else {
        $(".files-breadcrumb").html(breadcrumbHtml);
    }
}