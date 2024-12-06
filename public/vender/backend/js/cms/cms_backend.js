var cms = $('.cms_theme');
var fms = $('.fms_theme');
var SearchLock = false;
$('body').on('compositionstart', '.select2MultiNew_search input', function(event) {
    SearchLock = true;
    event.preventDefault();
});
$('body').on('compositionend', '.select2MultiNew_search input', function(event) {
    SearchLock = false;
    event.preventDefault();
});
$('body').on('keyup', '.select2MultiNew_search input', function(event) {
    if(!SearchLock){
        let _this = $(this);
        let keyword = _this.val().trim().replace(/\s/g, "");
        if(keyword == ""){
            _this.closest('.select2MultiNew_option').find('.select2MultiNew_option_item_search').empty().addClass('hide');
            _this.closest('.select2MultiNew_option').find('.select2MultiNew_option_item').removeClass('hide');
        }
    }
});
$('body').on('keydown', '.select2MultiNew_search input', function(event) {
    if (event.key == 'Enter' && !SearchLock) {
        let _this = $(this);
        let options_model = _this.closest('.select2MultiNew_search').attr('data-options_model');
        let main_model = _this.closest('.select2MultiNew_search').attr('data-main_model');
        let keyword = _this.val().trim().replace(/\s/g, "");
        selectSearch(_this.closest('.select2MultiNew_option'),options_model,main_model,keyword);
    }   
});
$('body').on('click', '.select2MultiNew_search a', function() {
    let _this = $(this);
    let options_model = _this.closest('.select2MultiNew_search').attr('data-options_model');
    let main_model = _this.closest('.select2MultiNew_search').attr('data-main_model');
    let keyword = _this.closest('.select2MultiNew_search').find('input').val().trim().replace(/\s/g, "");
    selectSearch(_this.closest('.select2MultiNew_option'),options_model,main_model,keyword);
});
function selectSearch(_this,options_model,main_model,keyword){
    if(keyword != ""){
        $.ajax({
            type: "POST",
            url: $('.base-url').val() + '/Ajax/Search',
            data: {
                ajax: true,
                options_model: options_model,
                main_model: main_model,
                keyword: keyword
            },
            dataType: 'JSON',
            cache: false,
        }).done(function (response) {
            let selectItem = _this.closest('.inner').find('.select2MultiNew').find('span').get().map(function(el){
                return parseInt($(el).attr('data-id'));
            });
            _this.find('.select2MultiNew_option_item_search').empty().removeClass('hide');
            _this.find('.select2MultiNew_option_item').addClass('hide');
            Object.entries(response.data).forEach(([key, value]) => {
                let _active = selectItem.indexOf(value.key) >= 0 ? 'active':'';
                _this.find('.select2MultiNew_option_item_search').append(`<span data-id="`+value.key+`" class="`+_active+`">`+value.title+`</span>`);
            });
        }).fail(function () {
            console.log("open_file_edit error");
        })
    }
}
$('body').on('click', '.select2MultiNew a', function(e) {
    let _this = $(this).closest('span');
    let _inventory = _this.closest('.inventory');
    let _inner = _this.closest('.inner');
    _inner.find('.select2MultiNew_option span[data-id="'+_this.attr('data-id')+'"]').removeClass('active');
    _this.remove();
    let _value = JSON.stringify(_inner.find('.select2MultiNew span').get().map(function(el){
        return $(el).attr('data-id');
    }));
    _inventory.find('.normal_input').val(_value);
});
$('body').on('click', '.select2MultiNew_option span', function(e) {
    let _this = $(this);
    let _inner = _this.closest('.inner');
    _this.toggleClass('active');

    if(_this.hasClass('active')){
        _inner.find('.select2MultiNew').append('<span data-id="'+_this.attr('data-id')+'" draggable="true"><a class="fa fa-remove"></a>'+_this.text()+'</span>');
    }else{
        _inner.find('.select2MultiNew span[data-id="'+_this.attr('data-id')+'"]').remove();
    }
    let _value = JSON.stringify(_inner.find('.select2MultiNew span').get().map(function(el){
        return $(el).attr('data-id');
    }));
    _this.closest('.inventory').find('.normal_input').val(_value);
});
$('body').on('click', '.radio_action_fuc', function () {
    let _this = $(this);
    let _key = _this.closest('.tabulation_head').attr('data-table');
    let _action = _this.attr('data-action');
    if(_action == 'enable_all_preview'){
        $(".tabulation_body_" + _key).find('[name*="is_preview"]').val('1').closest('.radio_btn_switch').addClass('on');
    }
    if(_action == 'disable_all_preview'){
        $(".tabulation_body_" + _key).find('[name*="is_preview"]').val('0').closest('.radio_btn_switch').removeClass('on');
    }
    if(_action == 'enable_all_visible'){
        $(".tabulation_body_" + _key).find('[name*="is_visible"]').val('1').closest('.radio_btn_switch').addClass('on');
    }
    if(_action == 'disable_all_visible'){
        $(".tabulation_body_" + _key).find('[name*="is_visible"]').val('0').closest('.radio_btn_switch').removeClass('on');
    }
});
let draggingRow = null;
$('body').on('dragstart', '.select2MultiNew span', function(e) {
    draggingRow = $(this);
    draggingRow.addClass('dragging');
    e.originalEvent.dataTransfer.effectAllowed = 'move';
});

$('body').on('dragend', '.select2MultiNew span', function() {
    draggingRow.removeClass('dragging');
    draggingRow = null;
});

$('body').on('dragover', '.select2MultiNew span', function(e) {
    e.preventDefault();
    const targetRow = $(this);
    if (targetRow[0] !== draggingRow[0]) {
        if (targetRow[0] !== draggingRow[0]) {
            if (targetRow.index() < draggingRow.index()) {
                draggingRow.insertBefore(targetRow);
            } else {
                draggingRow.insertAfter(targetRow);
            }
        }
    }
    let _this = $(this);
    let _inner = _this.closest('.inner');
    let _value = JSON.stringify(_inner.find('.select2MultiNew span').get().map(function(el){
        return $(el).attr('data-id');
    }));
    _this.closest('.inventory').find('.normal_input').val(_value);
});
$('body').on('dragstart', '.edit_table_drag tbody tr', function(e) {
    draggingRow = $(this);
    draggingRow.addClass('dragging');
    e.originalEvent.dataTransfer.effectAllowed = 'move';
});

$('body').on('dragend', '.edit_table_drag tbody tr', function() {
    draggingRow.removeClass('dragging');
    draggingRow = null;
});

$('body').on('dragover', '.edit_table_drag tbody tr', function(e) {
    e.preventDefault();
    const targetRow = $(this);
    if (targetRow[0] !== draggingRow[0]) {
        if (targetRow[0] !== draggingRow[0]) {
            if (targetRow.index() < draggingRow.index()) {
                draggingRow.insertBefore(targetRow);
            } else {
                draggingRow.insertAfter(targetRow);
            }
        }
    }
});

$('body').on('dragstart', '.picture_box.img_list .has_img', function(e) {
    draggingRow = $(this);
    draggingRow.addClass('dragging');
    e.originalEvent.dataTransfer.effectAllowed = 'move';
});

$('body').on('dragend', '.picture_box.img_list .has_img', function() {
    draggingRow.removeClass('dragging');
    draggingRow = null;
});

$('body').on('dragover', '.picture_box.img_list .has_img', function(e) {
    e.preventDefault();
    const targetRow = $(this);
    if (targetRow[0] !== draggingRow[0]) {
        if (targetRow[0] !== draggingRow[0]) {
            if (targetRow.index() < draggingRow.index()) {
                draggingRow.insertBefore(targetRow);
            } else {
                draggingRow.insertAfter(targetRow);
            }
        }
    }
    let picture_box = $(this).closest('.picture_box');
    //順序重排
    let _rank = 1;
    picture_box.find('.open_fms_lightbox.has_img').each(function(index, el){
        $(el).find('.rank').html(_rank);
        _rank = _rank + 1;
    });
});
$('body').on('click', '.edit_table_add a', function () {
    let _this = $(this);
    let $firstRow = _this.closest('.inner').find('tbody').find('tr:first');
    let $newRow = $firstRow.clone();
    $newRow.find('input').val('');
    _this.closest('.inner').find('tbody').append($newRow);
    _this.closest('.inner').find('tbody').find('tr').each(function(index) {
        $(this).find('th:eq(1)').text(index + 1);
    });
});

$('body').on('click', '.edit_delete', function () {
    let _this = $(this);
    let _tbody = _this.closest('tbody');
    if(_tbody.find('tr').length == 1){
        alert('第一筆預設無法刪除');
    }else{
        _this.closest('tr').remove();
        _tbody.find('tr').each(function(index) {
            $(this).find('th:eq(1)').text(index + 1); // 設置第一欄為當前行數 + 1
        });
    }
});

$('body').on('click', '.local_file_select', function () {
    let _this = $(this);
    _this.closest('.file-picker').find('.local_file_set').click();
});
$('body').on('change', '.local_file_set', function () {
    let _this = $(this);
    _this.closest('.file-picker').find('.local_file_name').val(_this.val().split('\\').pop());
});


let isComposing = false;
$('body').on('compositionstart', 'input[name*="[url_name]"]', function() {
  isComposing = true;
});
$('body').on('compositionend', 'input[name*="[url_name]"]', function() {
  isComposing = false;
  validateInput(this);
});
$('body').on('input', 'input[name*="[url_name]"]', function() {
  if (!isComposing) {
    validateInput(this);
  }
});
function validateInput(input) {
  // 在這裡處理input事件
  let coverStr = $(input).val().replace(/[^(\u3400-\u4DBF|\u4E00-\u9FFF|\uF900-\uFAFF|\u0020-\u007E|\u3040-\u309F|\u30A0-\u30FF|\uAC00-\uD7AF)]/g, '');
  coverStr = coverStr.replace(/[\s+\?\.\/\!@#$%^&*]/g, '');
  console.log(coverStr);
  $(input).val(coverStr);
}

$('body').on('click', '.coordinate_size', function (e) {
    let action = $(this).data('action');
    if(action == 'add'){
        $("#pinContainer")[0].img_width = $("#pinContainer")[0].img_width / $("#pinContainer")[0].scale;
        $("#pinContainer")[0].img_height = $("#pinContainer")[0].img_height / $("#pinContainer")[0].scale;
        let scale = $("#pinContainer")[0].scale + 0.5;
        $(".coordinate_img").css('scale', scale.toString());
        $("#pinContainer")[0].img_width = $("#pinContainer")[0].img_width * scale;
        $("#pinContainer")[0].img_height = $("#pinContainer")[0].img_height * scale;
        $("#pinContainer")[0].scale = scale;
    }else{
        $(".coordinate_img").css('scale', '1');
        $("#pinContainer")[0].img_width = $($("#pinContainer")[0].el).data('width');
        $("#pinContainer")[0].img_height = $($("#pinContainer")[0].el).data('height');
        $("#pinContainer")[0].scale = 1;
    }
});
$('body').on('click', '.coordinate_modal', function (e) {
    $('.coordinate_lbox').addClass('active');
    let _this = $(this);
    $('#mainImage').attr('src',_this.data('image'));
    let offset = _this.val().split(',');
    let pinContainer = document.getElementById("pinContainer");
    pinContainer.style.left = offset[0];
    pinContainer.style.top = offset[1];
    $("#pinContainer")[0].offsetX = offset[0];
    $("#pinContainer")[0].offsetY = offset[1];
    $("#pinContainer")[0].img_width = _this.data('width');
    $("#pinContainer")[0].img_height = _this.data('height');
    $("#pinContainer")[0].scale = 1;
    $("#pinContainer")[0].return = _this.data('return');
    $("#pinContainer")[0].el = _this;
    $(".coordinate_img").css('scale','1');
    $(".coordinate_img").css('width',_this.data('width'));
});
$('body').on('mousedown', '#mainImage', function (event) {
    let mainImage = document.getElementById("mainImage");
    let pinContainer = document.getElementById("pinContainer");

    //滑鼠實際位置
    let offsetX = event.clientX - mainImage.getBoundingClientRect().left ;
    let offsetY = event.clientY - mainImage.getBoundingClientRect().top ;

    let PercentageX = (offsetX / $("#pinContainer")[0].img_width) * 100;
    let PercentageY = (offsetY / $("#pinContainer")[0].img_height) * 100;

    pinContainer.style.left = PercentageX + "%";
    pinContainer.style.top = PercentageY + "%";
    $("#pinContainer")[0].offsetX = PercentageX + "%";
    $("#pinContainer")[0].offsetY = PercentageY + "%";
    $("#pinContainer")[0].offsetX_PX = offsetX;
    $("#pinContainer")[0].offsetY_PX = offsetY;
});
$('body').on('click', '.coordinate_set', function (e) {
    let x = $("#pinContainer")[0].offsetX;
    let y = $("#pinContainer")[0].offsetY;
    let x_PX = $("#pinContainer")[0].offsetX_PX;
    let y_PX = $("#pinContainer")[0].offsetY_PX;
    $('.coordinate_lbox').removeClass('active');
    if($("#pinContainer")[0].return == '0'){
        $($("#pinContainer")[0].el).val(x+','+y)
    }else{
        $($("#pinContainer")[0].el).val(x_PX+','+y_PX)
    }
    console.log(x,y);
});


$('body').on('click', '.article_select', function () {
    $(".article_lbox .article_item").hide().removeClass('active');
    let _val = $(this).find('input').val();
    let option = $(this).attr('data-option').split(',');
    option.forEach(function (key) {
        $('.article_item[data-key="' + key + '"]').show();
    });
    $('.article_lbox').addClass('active');
    $(".article_lbox")[0].select_item = $(this);
    $('.article_item[data-key="' + _val + '"]').addClass('active');
});
$('body').on('click', '.article_lbox', function (e) {
    if ($(e.target).hasClass('article_lbox')) {
        $('.article_lbox').removeClass('active');
    }
});
$('body').on('click', '.article_item', function () {
    let key = $(this).attr('data-key');
    let img = $(this).find('img').attr('src');
    let title = $(this).find('p').text();
    //文繞圖禁止使用IG
    $(".article_lbox")[0].select_item.closest('.list_body').find('textarea[name*="instagram_content"]').closest('.inventory').show();
    if(key == 'typeLR' || key == 'typeRR'){
        let instagram_content = $(".article_lbox")[0].select_item.closest('.list_body').find('textarea[name*="instagram_content"]');
        if(instagram_content.length > 0 && instagram_content.val() != ""){
            if(!confirm('此段落樣式不支援instagram，切換後將會刪除instagram內容，是否切換?')){
                return false;
            }
        }
        instagram_content.val('');
        instagram_content.closest('.inventory').hide();
    }
    $(".article_lbox")[0].select_item.find('.article_img img').attr('src', img);
    $(".article_lbox")[0].select_item.find('.article_dec').html(title);
    $(".article_lbox")[0].select_item.find('input').val(key);
    $(".article_lbox")[0].select_item.closest('.list').find('.list_box').first().find('.s_img img').attr('src', img);
    $(".article_lbox")[0].select_item.closest('.list').find('.list_box').first().find('.AutoSet_article_style').html(title);
    $('.article_lbox').removeClass('active');
});

$('.head-bar .title-box').on('click', function (e) {
    let _this = $(this);
    if (_this.hasClass('open')) {
        _this.removeClass('open');
        _this.closest('li').find('.sub-menu').slideUp();
    } else {
        _this.addClass('open');
        _this.closest('li').find('.sub-menu').slideDown();
    }
});
$('.head-bar .display-title').on('click', function (e) {
    let _this = $(this);
    if (_this.hasClass('open')) {
        _this.removeClass('open');
        $('.head-bar .level-1 > .sub-menu').slideUp();
    } else {
        _this.addClass('open');
        $('.head-bar .level-1 > .sub-menu').slideDown();
    }
});


$('body').on('click', '.cms_open_file_edit', function (e) {
    var _this = $(this),
        _this_id = _this.parents('.fms_list').find('input').data('id');
    if ($(this).closest('.tbody_tick').hasClass('is_delete')) {
        return false;
    }

    if (_this_id == undefined) {
        _this_id = $('input[name="for_edit_id"]').val();
    }
    if (_this.hasClass('clicked')) {
        return false;
    } else {
        _this.addClass('clicked');
        var is_delete = _this.closest('tr').hasClass('is_delete');
        $.ajax({
            url: $('.base-url').val() + '/Ajax/file-edit/' + _this_id + "/" + is_delete,
            type: 'GET',
        }).done(function (data) {
            if (data == 0) {
                alert('檔案不存在');
            } else if (data == 'not_user') {
                alert('失敗\n您沒有權限編輯該檔案');
            } else {
                $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail_edit').html(data);
                $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail').removeClass('open');
                $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail').empty();

                $('.fmsDetailAjaxArea.uploadArea').addClass('active');
                $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('active');
                $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail_edit').addClass('active');

                setTimeout(function () {
                    $('.fmsDetailAjaxArea.uploadArea').addClass('open').removeClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('open').removeClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail_edit').addClass('open').removeClass('active');
                }, 0)

                $('.editorBody').scrollbar();
                $('input[name="fms[edit_id]"]').val(_this_id);
            }
            close_wrapper();
            filePathSelect();
            quill_select();
            _this.removeClass('clicked');
            components.select2($(".____select2"));
            //是否私人按鈕
            $(".fms_switch_ball").off().on('click', function () {
                $(this).closest('.ios_switch').toggleClass('on');
                if ($(this).closest('.ios_switch').hasClass('on')) {
                    $(this).closest('.inventory').siblings('.auth_group').show();
                    $(this).siblings('input').val(1);
                } else {
                    $(this).closest('.inventory').siblings('.auth_group').hide();
                    $(this).siblings('input').val(0);
                }
            })
        }).fail(function () {
            console.log("open_file_edit error");
        })
    }
    e.stopPropagation();
});

$('body').on('click', '.file_fantasy_download', function () {
    var _this = $(this),
        _this_src = _this.attr('data-src'),
        _this_title = _this.attr('data-title');

    if (_this_src == null || _this_src.length == 0) {
        return;
    }

    var a = document.createElement('a');

    a.href = _this_src;
    a.download = _this_title;
    a.target = "_blank";
    a.click();
});

$('body').on('click', '#onlyfileremove', function () {
    var _this = $(this);
    const inputs = _this.siblings('input');
    inputs.eq(0).val('').attr('value', '');
    inputs.eq(2).attr('data-src', '').attr('data-title', '');
    inputs.eq(3).val('').attr('value', '');
});

$('body').on('click', '.color_picker_add', function () {
    let _color = $(this).closest('.color_picker').find('input').val();
    reload_color('add', _color);
});

//select2 Multi 多選拖曳事件
$('body').on('mousedown', '.select2-selection__choice', function (event) {
    //左建生效
    if (event.button !== 0) return;
    let self = event.currentTarget;
    self.setAttribute('draggable', 'true');
    $(self).parent().children('.select2-selection__choice').each((index, element) => {
        element.dataset.index = index;
        element.addEventListener('drop', dropped);
        //over enter 要取消掉 default
        element.addEventListener('dragover', prevent);
        element.addEventListener('dragenter', prevent);
        element.addEventListener('dragend', removeEvent);
    });

    function prevent(prevent_event) {
        prevent_event.preventDefault();
    }

    function dropped(drop_event) {
        let el = drop_event.currentTarget;
        //假如放到自己身上就沒事
        if (self.dataset.index !== el.dataset.index) {

            //select2 存放 option value 的地方
            let option_target = null;
            let option_move = null;
            let move_index = null;
            let options = $(self).closest('.inner').children('.select2-hidden-accessible').find('option:selected').each((index2, option_el) => {
                if ($(option_el).text() === $(self).text().replace('×', '')) {
                    move_index = index2;
                    option_move = option_el;
                }
                if ($(option_el).text() === $(el).text().replace('×', '')) {
                    option_target = option_el
                }
            });

            if (option_target !== null && option_move !== null && move_index !== null) {
                //element 都抓到後再開始移除
                options.eq(move_index).remove().get(0);
                $(self).parent('ul').children('.select2-selection__choice').eq(parseInt(self.dataset.index)).remove();

                //放到對應的位子
                if (parseInt(el.dataset.index) < parseInt(self.dataset.index)) {
                    $(el).before(self);
                    $(option_target).before(option_move);
                } else {
                    $(el).after(self);
                    $(option_target).after(option_move);
                }
            }
        };
        //最後把事件都移除
        removeEvent();
    }

    function removeEvent() {
        document.querySelectorAll('.select2-selection__choice').forEach(element => {
            element.removeAttribute('draggable');
            element.removeAttribute('data-index');
            element.removeEventListener('drop', dropped);
            element.removeEventListener('dragover', prevent);
            element.removeEventListener('dragenter', prevent);
            element.removeEventListener('dragend', removeEvent);
        });
    }
});

$('body').on('click', '.datatable .tables thead th', function (e) {
    let _this = $(this);
    let theadSortBtn = _this.find('.theadSortBtn');
    if (theadSortBtn.length > 0) {
        if ($(".ajax_fms").length > 0 || $("body.fms_theme").length > 0) {
            var search_column = theadSortBtn.data('column');
            var column_sort = theadSortBtn.attr('data-sort');
            var folder_id = $("#folder_id").val();
            if (column_sort == 0) {
                theadSortBtn.attr('data-sort', '1');
            } else {
                theadSortBtn.attr('data-sort', '0');
            }
            $.ajax({
                url: $('.base-url-plus').val() + '/Fantasy/Fms',
                type: 'GET',
                data: {
                    ajax: true,
                    search_column: search_column,
                    column_sort: column_sort,
                    folder_id: folder_id,
                }
            })
                .done(function (data) {
                    $(".Leon_fms_table .fms_list").remove();
                    $(".Leon_fms_table").append(data.files);
                })
                .fail(function () {
                    console.log("Fms DataTable Reset error");
                })
        } else {

            var search_column = theadSortBtn.data('column')

            var main_div = $('.index-table-div');
            // 移除原排序條件 #adam
            main_div.children('input.searchRulesSet[data-type="sort"]').remove();

            // 從小排到大#adam
            if (_this.find('.fake-th').hasClass('active')) {
                main_div.find('.cms-index_table').before('<input type="hidden" class="searchRulesSet" data-type="sort" data-name="' + search_column + '" data-value="desc">');
                _this.find('.fake-th').removeClass('active')
            }
            // 從大排到小#adam
            else {
                main_div.find('.cms-index_table').before('<input type="hidden" class="searchRulesSet" data-type="sort" data-name="' + search_column + '" data-value="asc">');
                _this.find('.fake-th').addClass('active')
            }
            // datatable refresh #adam
            datatableReset();
        }
    }

});
function Leon_function_reset() {
    ////quill_select();
    wade_datepicker();
    //btn_fms_lightbox();
    baseContentEdit_color_picker();
    components.select2($(".____select2"));
}
// 打開Fms燈箱要執行的事件
function fms_lightbox() {

    close_wrapper();
    close_ajax_btn();
    grid_mode();
    table_view_mode();
}

function Leon_fms_wrapper() {

    function LeonGetFolderpathText(folder_id) {
        var text = $('.Leon_option_list .option[data-id="' + folder_id + '"]').find('p').eq(0).text();
        if ($('.Leon_option_list .option[data-id="' + folder_id + '"]').parent().parent().hasClass('option')) {
            text = LeonGetFolderpathText($('.Leon_option_list .option[data-id="' + folder_id + '"]').parent().parent().attr('data-id')) + ' / ' + text;
        }
        return text;
    }

    function downloadfile(name, hrefurl) {
        var ext = hrefurl.slice((hrefurl.lastIndexOf(".") - 1 >>> 0) + 2);
        if (ext == 'zip') {
            $('body').append('<iframe src="' + hrefurl + '" name="frame1" id="frame1" style="display: none;"></iframe>');
        } else {
            var temporaryDownloadLink = document.createElement("a");
            temporaryDownloadLink.style.display = 'none';
            document.body.appendChild(temporaryDownloadLink);
            temporaryDownloadLink.setAttribute('href', hrefurl);
            temporaryDownloadLink.setAttribute('download', name);
            temporaryDownloadLink.click();
            document.body.removeChild(temporaryDownloadLink);
        }
    }

    //上傳檔案
    $(".fms_bulider_upload").off().on('click', function () {
        $.ajax({
            url: $('.base-url').val() + '/Ajax/file-new',
            type: 'GET',
        })
            .done(function (data) {
                if (data == false) {
                    alert("您沒有權限");
                    return;
                }
                $(".fmsUpload_done").removeClass('open');
                $('.Leon_option_list').html(data);
                $('.fmsDetailAjaxArea.uploadArea').addClass('active');
                $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('active');
                $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsUpload').addClass('active');
                setTimeout(function () {
                    $('.fmsDetailAjaxArea.uploadArea').addClass('open').removeClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('open').removeClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsUpload').addClass('open').removeClass('active');
                }, 400)
                $('.editorBody').scrollbar();
                //Leon 更改預設資料夾位置
                var folder_id = $("#folder_id").val();
                $(".Select_folder_id").attr('data-id', folder_id);
                $(".Select_folder_id").find('p').text(LeonGetFolderpathText(folder_id));
                filePathSelect();
                components.select2($(".____select2"));
                //是否私人按鈕
                $(".fms_switch_ball").off().on('click', function () {
                    $(this).closest('.ios_switch').toggleClass('on');
                    if ($(this).closest('.ios_switch').hasClass('on')) {
                        $(this).closest('.inventory').siblings('.auth_group').show();
                        $(this).siblings('input').val(1);
                    } else {
                        $(this).closest('.inventory').siblings('.auth_group').hide();
                        $(this).siblings('input').val(0);
                    }
                })
            })
            .fail(function () {
                console.log("fms_bulider_upload error");
            })
    });
    $(".localeToDownloadFiles").off().on('click', function () {
        $(".fms_list.can_use .fms_lbox_file_select_checkbox:checked").map(function () {
            downloadfile($(this).attr('data-title'), $(this).attr('data-src'));
        });
    });

    $(".fms_recovery_data").off().on('click', function () {
        var nowFolderID = $("#folder_id").val();
        var isDelete = 0;
        if ($(this).hasClass('delete')) isDelete = 1;
        var _this = $(this);

        var fileIDArray = $(".fms_list.can_use .fms_lbox_file_select_checkbox:checked").map(function () { return $(this).attr('data-id'); }).get();
        var folderIDArray = $(".fms_folder.can_use .fms_lbox_file_select_checkbox:checked").map(function () { return $(this).attr('data-id'); }).get();

        if (fileIDArray.length == 0 && folderIDArray.length == 0) {
            alert("未選擇資料夾/檔案");
            return;
        }
        if (confirm('確定復原檔案/資料夾？')) {
            var toUrl = $('.base-url').val() + '/Ajax/file-exchange?nowFolder=' + nowFolderID + '&recovery=1&json_file=' + JSON.stringify(fileIDArray) + "&json_folder=" + JSON.stringify(folderIDArray);
            $.ajax({
                url: toUrl,
                type: 'GET',
            })
                .done(function (data) {
                    if (data.status == 'fail') {
                        alert(data.msg);
                        return;
                    } else {
                        alert("已復原");
                        for (var i = 0; i < fileIDArray.length; i++) {
                            $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + fileIDArray[i] + '"]').get(0).click();
                            $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + fileIDArray[i] + '"]').closest('tr').removeClass('is_delete');
                        }
                        for (var i = 0; i < folderIDArray.length; i++) {
                            $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').get(0).click();
                            $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').closest('tr').removeClass('is_delete');
                        }
                        if (folderIDArray.length > 0) {
                            syncFolderTreeAndBreadcrumb();
                        }
                        set_fms_basic(true);
                        return;
                    }
                })
                .fail(function () {
                    console.log("open_file_edit error");
                })

        }
    });
    $(".fms_bulider_new").off().on('click', function (e) {
        e.stopPropagation();
        var _this = $(this);
        var is_edit = $(this).hasClass('edit');
        var edit_id = 0;
        var _url = $('.base-url').val() + '/Ajax/folder-edit-new/' + $("#folder_id").val();
        if (is_edit) {
            _url = $('.base-url').val() + '/Ajax/folder-edit-new/' + $("#folder_id").val() + '/' + $(this).attr('data-id');
        }

        if (_this.hasClass('clicked')) {
            return false;
        } else {
            _this.addClass('clicked');
            $.ajax({
                url: _url,
                type: 'GET',
            })
                .done(function (data) {
                    if (data == false) {
                        alert("您沒有權限");
                        return;
                    }
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsFolder_add').html(data);
                    $('.fmsDetailAjaxArea.uploadArea').addClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsFolder_add').addClass('active');
                    setTimeout(function () {
                        $('.fmsDetailAjaxArea.uploadArea').addClass('open').removeClass('active');
                        $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('open').removeClass('active');
                        $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsFolder_add').addClass('open').removeClass('active');
                    }, 400)
                    $('.editorBody').scrollbar();
                    close_wrapper();
                    //quill_select();
                    filePathSelect();
                    _this.removeClass('clicked');
                    components.select2($(".____select2"));

                    //是否私人按鈕
                    $(".fms_switch_ball").off().on('click', function () {
                        $(this).closest('.ios_switch').toggleClass('on');
                        if ($(this).closest('.ios_switch').hasClass('on')) {
                            $(this).closest('.inventory').siblings('.auth_group').show();
                            $(this).siblings('input').val(1);
                        } else {
                            $(this).closest('.inventory').siblings('.auth_group').hide();
                            $(this).siblings('input').val(0);
                        }
                    })
                })
                .fail(function () {
                    console.log("fms_bulider_new error");
                })
        }
    });
    //fms 多檔案切換資料夾
    $(".LeonMoveFiles").off().on('click', function () {
        var nowFolderID = $("#folder_id").val();
        var isDelete = 0;
        if ($(this).hasClass('delete')) isDelete = 1;
        var realDelete = 0;
        if ($('.tree-title.active').hasClass('trash')) realDelete = 1;
        var _this = $(this);

        var fileIDArray = $(".fms_list.can_use .fms_lbox_file_select_checkbox:checked").map(function () { return $(this).attr('data-id'); }).get();
        // var folderIDArray = $(".fms_folder.can_use .fms_lbox_file_select_checkbox:checked").map(function () { return $(this).attr('data-id'); }).get();
        var folderIDArray = $(".fms_folder.can_use .fms_lbox_file_select_checkbox:checked").map(function(){
            if(!$(this).closest('.fms_folder').is(":hidden")) return $(this).attr('data-id');
        }).get();

        if (fileIDArray.length == 0 && folderIDArray.length == 0) {
            alert("未選擇資料夾/檔案");
            return;
        }
        if (isDelete) {
            var inq = confirm('確定刪除檔案/資料夾？');
            if (inq) {
                var toUrl = $('.base-url').val() + '/Ajax/file-exchange?nowFolder=' + nowFolderID + '&delete=1&json_file=' + JSON.stringify(fileIDArray) + "&json_folder=" + JSON.stringify(folderIDArray) + "&realDelete=" + realDelete;
            } else {
                return "";
            }
        } else {
            var toUrl = $('.base-url').val() + '/Ajax/file-exchange?nowFolder=' + nowFolderID + '&json_file=' + JSON.stringify(fileIDArray) + "&json_folder=" + JSON.stringify(folderIDArray);
        }

        $.ajax({
            url: toUrl,
            type: 'GET',
        })
            .done(function (data) {
                if (data.status == 'fail') {
                    alert(data.msg);
                    return;
                } else {
                    if (isDelete) {
                        alert("成功刪除");
                        if (realDelete) {
                            for (var i = 0; i < fileIDArray.length; i++) {
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + fileIDArray[i] + '"]').closest('tr').remove();
                            }
                            for (var i = 0; i < folderIDArray.length; i++) {
                                $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').closest('tr').remove();
                            }
                        } else {
                            for (var i = 0; i < fileIDArray.length; i++) {
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + fileIDArray[i] + '"]').get(0).click();
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + fileIDArray[i] + '"]').closest('tr').find('.tableMaintitle').addClass('is_delete');
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + fileIDArray[i] + '"]').closest('tr').addClass('is_delete').hide();
                            }
                            for (var i = 0; i < folderIDArray.length; i++) {
                                $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').get(0).click();
                                $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').closest('tr').find('.tableMaintitle').addClass('is_delete');
                                $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').closest('tr').addClass('is_delete').hide();
                            }
                        }
                        // if (folderIDArray.length > 0) {
                        //     syncFolderTreeAndBreadcrumb();
                        // }
                        // if (realDelete) {
                        //     set_fms_basic(true);
                        // } else {
                        //     set_fms_basic(false);
                        // }
                        return;
                    }
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail_edit').html(data['view']);
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail').removeClass('open');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail').empty();

                    $('.fmsDetailAjaxArea.uploadArea').addClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('active');
                    $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail_edit').addClass('active');

                    setTimeout(function () {
                        $('.fmsDetailAjaxArea.uploadArea').addClass('open').removeClass('active');
                        $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('open').removeClass('active');
                        $('.fmsDetailAjaxArea.uploadArea .ajaxItem .fmsDetail_edit').addClass('open').removeClass('active');
                    }, 400)

                    $('.editorBody').scrollbar();
                    close_wrapper();
                    filePathSelect();
                    //quill_select();
                    _this.removeClass('clicked');
                }
            })
            .fail(function () {
                console.log("open_file_edit error");
            })
    });

}

function open_fms_light_box() {
    if (!bd.data('fms').open_img_box) {
        $('body').on('click', '.open_img_box', function (e) {
            var _this_src = $(this).data('src');
            $('img.img_show_lbox').attr('src', _this_src);
            setTimeout(function () {
                $('.chImgLightBox').addClass('open');
            }, 0);
            e.stopPropagation();
        });
        bd.data('fms')['open_img_box'] = true;
    }
    if (!bd.data('fms').close_img_box) {
        $('body').on('click', '.close_img_box', function () {
            $('.chImgLightBox').addClass('close');
            setTimeout(function () {
                $('.chImgLightBox').removeClass('open').removeClass('close');
            }, 0);
            setTimeout(function () {
                $('.chImgLightBox').find('img').attr('src', '');
            }, 150);
        });
        bd.data('fms')['close_img_box'] = true;
    }
}

function close_wrapper() {
    // cms關閉按鈕 //wade
    // $('.cms_theme .cms_hiddenArea.cmsDetailAjaxArea').on('click', '.close_btn', function () {
    //     $('.cms_theme .cms_hiddenArea.cmsDetailAjaxArea .ajaxItem').addClass('remove');
    //     setTimeout(function () {
    //         $('.cms_theme .cms_hiddenArea.cmsDetailAjaxArea .ajaxItem').removeClass('open remove');
    //         $('.cms_theme .cms_hiddenArea.cmsDetailAjaxArea').addClass('remove');
    //     }, 0);

    //     setTimeout(function () {
    //         $('.cms_theme .cms_hiddenArea.cmsDetailAjaxArea').removeClass('open remove');
    //         $('.editContentFormArea form:nth-child(n+3)').empty();
    //         $('.editFormName').text('-');
    //         $('ul.editContentMenu').children('li').removeClass('opened');
    //         $('ul.editContentMenu').children('li').removeClass('active');
    //         $('ul.editContentMenu').children('li').removeClass('wait-sent');
    //         $('ul.editContentMenu').children('li').removeClass('clicked');
    //         $('.dataEditTitle').text('');
    //         $(".SonDataEditTitle").html('-');
    //         $('body')[0].dataId = '';
    //         $('.editContentArea').data('model', '');
    //         $('.editContentArea').attr('data-mod', '');
    //         $('.sp-container').remove();
    //         $('li.cms-delete-btn').attr('data-id', '0');
    //     }, 150)
    // });

    // fms關閉按鈕 //wade
    $('.fms_theme .ajaxContainer').on('click', '.close_btn', function () {
        $('.fmsDetailAjaxArea.uploadArea .ajaxItem').addClass('remove');
        $('.fmsDetailAjaxArea.uploadArea .ajaxItem .ajaxContainer').addClass('remove');
        setTimeout(function () {
            $('.fmsDetailAjaxArea.uploadArea .ajaxItem').removeClass('open remove');
            $('.fmsDetailAjaxArea.uploadArea .ajaxItem .ajaxContainer').removeClass('open remove');
            $('.fmsDetailAjaxArea.uploadArea').addClass('remove');

        }, 0)
        setTimeout(function () {
            $('.fmsDetailAjaxArea.uploadArea').removeClass('open remove');
        }, 150)

        if (!$('.ajaxContainer').hasClass('fmsUpload') && !$('.ajaxContainer').hasClass('fmsUpload_ing') && !$('.ajaxContainer').hasClass('fmsUpload_done')) {
            $('.fmsDetailAjaxArea.uploadArea .ajaxItem .ajaxContainer').empty();
        }
    });
}

close_wrapper();
Leon_fms_wrapper();
open_fms_light_box();

function DataSync(ele) {
    let _this = $(ele);
    let _autosetup = _this.attr('data-autosetup');
    console.log(_this, _this.val());
    if (_this.closest('.three-item').length > 0) {
        _this.closest('.three-item').find('p.' + _autosetup).eq(0).html(_this.val());
    } else {
        _this.closest('.stack_state').find('p.' + _autosetup).eq(0).html(_this.val());
    }
}
function DataSyncSelect(ele) {
    let _this = $(ele);
    let _autosetup = _this.attr('data-autosetup');
    let data = _this.select2('data');
    if (_this.closest('.three-item').length > 0) {
        _this.closest('.three-item').find('p.' + _autosetup).eq(0).html(data[0].text);
    } else {
        _this.closest('.stack_state').find('p.' + _autosetup).eq(0).html(data[0].text);
    }
}
//輸入就顯示在列表上
$(function () {
    $(document).on('keyup blur', '.DataSync', function (event) {
        DataSync(this);
    });

    $(document).on('select2:select', '.DataSyncSelect', function (e) {
        DataSyncSelect(this);
    });
});
$('body').on('click', '.radio_btn_switch', function () {
    var _this = $(this),
        _this_input = _this.find('input');
    if (_this.hasClass('on')) {
        _this.removeClass('on');
        _this_input.val('0');
    } else {
        _this.addClass('on');
        _this_input.val('1');
    }
});
$('body').on('click', '.wait-save-del-cancel', function () {
    $(this).closest('.three-item').find('.wait-save-box').eq(0).removeClass('active');
    $(this).closest('.three-item').find('.wait-save-box').eq(0).find('input').val(0);
    $(this).closest('.list').find('.wait-save-box').eq(0).removeClass('active');
    $(this).closest('.list').find('.wait-save-box').eq(0).find('input').val(0);
});
$('body').on('click', 'span.deleteSonTableData', function () {
    $(this).closest('.list').find('.wait-save-box').eq(0).find('input').val(1);
    $(this).closest('.list').find('.wait-save-box').eq(0).addClass('active');
    $(this).closest('.chosen').removeClass('chosen').find('.check_box').removeClass('show').find('input').prop('checked', false);
});
$('body').on('click', 'span.deleteThirdTableData', function () {
    $(this).closest('.three-item').find('.wait-save-box').eq(0).find('input').val(1);
    $(this).closest('.three-item').find('.wait-save-box').eq(0).addClass('active');
    $(this).closest('.chosen').removeClass('chosen').find('.check_box').removeClass('show').find('input').prop('checked', false);
});
$('body').on('click', '.deleteSonTableDataGroup', function () {
    let _this_table = $(this).attr('data-table');
    $('.tabulation_body_' + _this_table).children('form').each(function (index, el) {
        if ($(this).find('.check_box').hasClass('show')) {
            $(this).closest('.list').find('.wait-save-box').eq(0).addClass('active').find('input').val('1');
            $(this).closest('.chosen').removeClass('chosen').find('.check_box').removeClass('show').find('input').prop('checked', false);
        }
    });
});
$('body').on('click', '.controlSonTableDataGroup', function () {
    let _this_table = $(this).attr('data-table');
    let _this_body_control = $('.tabulation_body_' + _this_table).attr('data-control') || "close";
    if(_this_body_control == 'close'){
        $('.tabulation_body_' + _this_table).attr('data-control','open');
        $('.tabulation_body_' + _this_table + " form").addClass('active');
        $('.tabulation_body_' + _this_table + " .list_frame").show();
    }else{
        $('.tabulation_body_' + _this_table).attr('data-control','close');
        $('.tabulation_body_' + _this_table + " form").removeClass('active');
        $('.tabulation_body_' + _this_table + " .list_frame").hide();
    }

});
$('body').on('click', 'div.deleteThirdTableDataGroup', function () {
    let _this_table = $(this).attr('data-table');
    $('.thirdTbNew_' + _this_table).children('form').each(function (index, el) {
        if ($(this).find('.check_box').hasClass('show')) {
            $(this).closest('.three-item').find('.wait-save-box').eq(0).addClass('active').find('input').val('1');
        }
    });
});
$('body').on('click', '.checkbox_area label', function (event) {
    let _this = $(this);
    if (_this.find('input').val() == 0) {
        _this.addClass('active');
        _this.find('input').val(1);
    } else {
        _this.removeClass('active');
        _this.find('input').val(0);
    }
});
function reload_color(action, color) {
    $.ajax({
        url: "//" + location.host + "/Fantasy/Color",
        type: 'GET',
        dataType: 'JSON',
        cache: false,
        data: {
            action: action,
            color: color
        }
    }).done(function (response) {
        if(action == 'add'){
            alert("已加入");
        }
    }).fail(function () {
        console.log("data error");
    });
}
function radio_area_set(_ele) {
    let _this = $(_ele);
    let AutoSetSelect = _this.hasClass('.DataSyncSelect');
    if (AutoSetSelect) {
        let autosetup = _this.attr('data-autosetup');
        if (autosetup != "") {
            _this.closest('.list').find('.' + autosetup).html(_this.text());
        }
    }
    let _val = _this.data('value');

    let _model = _this.closest('.radio_area').find('input').attr('name').substring(0, _this.closest('.radio_area').find('input').attr('name').indexOf('['));
    let _hide = _this.attr('data-hide') || "";
    let _hidetip = _this.attr('data-hidetip') || "";
    let _hideArray = _hide.split(',');
    let _hidetipArray = _hidetip.split(',');
    let is_son = _this.closest('.list_body').length;
    let is_three = _this.closest('.ThreeContent').length;
    _this.closest('.radio_area').find('input').val(_val);
    _this.closest('.radio_area').find('label').removeClass('active');
    _this.addClass('active');
    let ele;
    if (is_three > 0) {
        ele = _this.closest('.article_video_right');
    } else {
        if (is_son > 0) {
            ele = _this.closest('.list_body');
        } else {
            ele = _this.closest('.frame');
        }
    }
    _this.closest('.radio_area').find('label').map(function () {
        let _temp = $(this).attr('data-hide');
        if (_temp != "") {
            let _tempArray = _temp.split(',');
            _tempArray.forEach(function (value) {
                ele.find("[name='" + _model + "[" + value + "]']").closest('.inventory').show();
            });
        }
        let _temptip = $(this).attr('data-hidetip') || "";
        if (_temptip != "") {
            let _tempArray = _temptip.split(',');
            _tempArray.forEach(function (value) {
                if (value != "") {
                    ele.find("." + value).show();
                }
            });
        }
    });
    _this.closest('.radio_area').find('label').map(function () {
        let _temp = $(this).attr('data-hide');
        if (_temp != "") {
            let _tempArray = _temp.split(',');
            _tempArray.forEach(function (value) {
                if (ele.find("[name='" + _model + "[" + value + "]']").closest('.radio_area').length > 0) {
                    console.log(ele.find("[name='" + _model + "[" + value + "]']").closest('.radio_area').find('label.active')[0]);
                    radio_area_set(ele.find("[name='" + _model + "[" + value + "]']").closest('.radio_area').find('label.active')[0]);
                }
            });
        }
    });
    _hideArray.forEach(function (value) {
        if (value != "") {
            ele.find("[name='" + _model + "[" + value + "]']").closest('.inventory').hide();
        }
    });
    _hidetipArray.forEach(function (value) {
        if (value != "") { ele.find("." + value).hide(); }
    });

}

$('body').on('click', '.radio_area label', function (event) {
    radio_area_set(this);
});
$('body').on('dragover', '.lbox_fms_open', function (e) {
    e.preventDefault();
});
$('body').on('drop', '.lbox_fms_open', function (e) {
    e.preventDefault();
    let _this_key = $(e.target).attr('data-key');
    let imageUrl = e.originalEvent.dataTransfer.getData('URL');
    $.ajax({
        url: $('.base-url').val() + "/Ajax/file-search",
        type: 'GET',
        dataType: 'JSON',
        cache: false,
        data: {
            imageUrl: imageUrl
        }
    }).done(function (response) {
        console.log(_this_key,response.file,response.file.real_route);
        if ($('.img_' + _this_key).closest('.box').hasClass('DataSync')) {
            let _autosetup = $('.img_' + _this_key).closest('.box').attr('data-autosetup')
            if ($('.img_' + _this_key).closest('.three-item').length > 0) {
                $('.img_' + _this_key).closest('.three-item').find('.' + _autosetup).attr('src', _val_src);
            } else {
                $('.img_' + _this_key).closest('.stack_state').find('.' + _autosetup).attr('src', _val_src);
            }
        }

        $('.img_' + _this_key).attr('src', response.file.real_route);
        $('.value_' + _this_key).attr('value', response.file.file_key);
        $('.file_' + _this_key).html('<span>FILE</span>' + response.file.title + '.' + response.file.type);
        $('.folder_' + _this_key).html('<span>FOLDER</span>' );
        $('.type_' + _this_key).html('<span>TYPE</span>' );
        $('.size_' + _this_key).html('<span>SIZE</span>');
        $('.img_' + _this_key).parent('div').parent('div').addClass('has_img');
        //自動換圖
        $('.img_' + _this_key).closest('.list').find('.list_box').find('.imgText').find('img[name="' + $('.value_' + _this_key).attr('name') + '"]').attr('src', response.file.real_route);
        $('.img_' + _this_key).closest('.list').find('.list_box').find('.filesText').find('img[name="' + $('.value_' + _this_key).attr('name') + '"]').attr('src', response.file.real_route);
        $('.img_' + _this_key).closest('.list').find('.list_box').find('.filesText').find('p').html(response.file.title + '.' + response.file.type);

    }).fail(function () {
        console.log("search data error");
    });
});
$('body').on('click', '.lbox_fms_open', function () {
    var _this_type = $(this).attr('data-type'),
        _this_key = $(this).attr('data-key');
    var _this_input = '';
    if(_this_type=='img' || _this_type == 'img_list') _this_input = 'input.value_' + _this_key;
    if(_this_type=='file') _this_input = 'input.filepicker_value_' + _this_key;
    var _this_value = $(_this_input).val() != '' ? $(_this_input).val() : '0';
    console.log(_this_value);
    
    if(_this_type == 'img_list' && _this_value != '0'){
        _this_type = 'img';
    }

    //如果切換類型,要更新燈箱
    if($("body")[0].fms_data_type != _this_type){
        $(".fmsAjaxArea .ajaxItem").removeClass('open');
    }

    $("body")[0].fms_data_type = _this_type;
    $("body")[0].fms_data_key = _this_key;
    $("body")[0].fms_data_value = _this_value;

    if($(".fmsAjaxArea .ajaxItem").hasClass('open') && _this_value == "0"){
        $(".fmsAjaxArea").addClass('open');
        $('.fms_lbox_file_select_checkbox:checked').prop('checked',false);
        $(".LeonSearchInput").val('');
        if(_this_type == 'sontable' || _this_type == 'img_list'){
            $(".hiddenArea_frame_controlBtn .number").html('multiple');
        }else{
            $(".hiddenArea_frame_controlBtn .number").html('1');
        }
    }else{
    $.ajax({
        url: $('.base-url').val() + "/Ajax/fms-lbox/" + _this_type + '/' + _this_key + '/' + _this_value,
        type: 'GET',
        dataType: 'JSON',
        cache: false,
        data: {
            cms_open: true
        }
    }).done(function (response) {
        const frame = $(".fms_lbox .frame").first();
        frame.html(response.blade);
        $("#folder_id").val(response.folder_id);
        $("body")[0].cms_open_file = _this_value;
        //需啟動的JS
        fms_lightbox();
        if (_this_type == 'img' || _this_type == 'file') {
            $('.Leon-fms-check-all').hide();
            $('.fms-move').parents('.btn-item').hide();
            $(".Leon_fms_table").addClass('one_shot').removeClass('multi_shot');
        } else {
            $(".Leon_fms_table").addClass('multi_shot').removeClass('one_shot');
        }
        // set_fms_basic(false);
        $('.tree-title[data-folder-id="' + response.folder_id + '"]').click();
        Leon_fms_wrapper();
        $('.tree-title.trash').parent().hide();
        $('.fmsAjaxArea.fms_lbox').addClass('active');
        $('.fmsAjaxArea.fms_lbox .ajaxItem').addClass('active');
        $('.fmsAjaxArea.fms_lbox .ajaxItem .fms_container ').addClass('active');

        setTimeout(function () {
            $('.fmsAjaxArea.fms_lbox').addClass('open').removeClass('active');
            $('.fmsAjaxArea.fms_lbox .ajaxItem').addClass('open').removeClass('active');
            $('.fmsAjaxArea.fms_lbox .ajaxItem .fms_container ').addClass('open').removeClass('active');
        }, 0)

        setTimeout(() => {
            frame.find('.content-scrollbox').scrollbar();
            const scroll = frame.find('.scroll-content');
            const checked = frame.find('.fms_lbox_file_select_checkbox:checked');
            if (scroll.length > 0 && checked.length > 0) {
                scroll.scrollTop(checked.eq(0).closest('.fms_list').position().top - window.innerHeight / 4);
            }
        }, 1000)
        if(_this_type == 'sontable'){
            $(".hiddenArea_frame_controlBtn .number").html('multiple');
        }else{
            $(".hiddenArea_frame_controlBtn .number").html('1');
        }
    }).fail(function () {
        console.log("delete data error");
    });
    }
});
$('body').on('click', '.fms_lbox_current_btn', function () {
    var _this = $(this),
    _this_key = $("body")[0].fms_data_key,
    _this_type = $("body")[0].fms_data_type;

    var _val_src = '',
        _val_id = 0,
        _val_title = '',
        _val_type = '',
        _val_size = '',
        _val_folder = $('.fms_lbox .breadcrumb li').get().map((el) => el.innerText).join(' / ');


    var choose_folder = false

    if (_this_type == 'img') {
        $('input.fms_lbox_file_select_checkbox').each(function (index, el) {
            if ($(this).prop('checked') === true) {
                if ($(this).data('type') == 'folder') {
                    choose_folder = true
                } else {
                    _val_src = $(this).attr('data-src');
                    _val_id = $(this).attr('data-key');
                    _val_title = $(this).attr('data-title');
                    _val_type = $(this).attr('data-type');
                    _val_size = $(this).parents('.fms_list').find('td').eq(5).find('p').text();
                }
            }
        });

        if (choose_folder == true) {

            alert('請勿選擇資料夾。');
            return false;

        } else {

            if (_val_src == '') {
                alert('您沒有進行圖片選擇喔');
                return false;
            }

            if (_this_key == 'summernote') {
                const newElem = document.createElement('img');
                newElem.setAttribute('src', _val_src);
                $(window.cms_open_file).summernote('editor.saveRange');
                $(window.cms_open_file).summernote('editor.restoreRange');
                $(window.cms_open_file).summernote('editor.focus');
                $(window.cms_open_file).summernote('insertNode', newElem);
            } else {
                if ($('.img_' + _this_key).closest('.box').hasClass('DataSync')) {
                    let _autosetup = $('.img_' + _this_key).closest('.box').attr('data-autosetup')
                    if ($('.img_' + _this_key).closest('.three-item').length > 0) {
                        $('.img_' + _this_key).closest('.three-item').find('.' + _autosetup).attr('src', _val_src);
                    } else {
                        $('.img_' + _this_key).closest('.stack_state').find('.' + _autosetup).attr('src', _val_src);
                    }
                }

                $('.img_' + _this_key).attr('src', _val_src);
                $('.value_' + _this_key).attr('value', _val_id);
                $('.file_' + _this_key).html('<span>FILE</span>' + _val_title + '.' + _val_type);
                $('.folder_' + _this_key).html('<span>FOLDER</span>' + _val_folder);
                $('.type_' + _this_key).html('<span>TYPE</span>' + _val_type);
                $('.size_' + _this_key).html('<span>SIZE</span>' + _val_size);
                $('.img_' + _this_key).parent('div').parent('div').addClass('has_img');
                //自動換圖
                $('.img_' + _this_key).closest('.list').find('.list_box').find('.imgText').find('img[name="' + $('.value_' + _this_key).attr('name') + '[]"]').attr('src', _val_src);
                $('.img_' + _this_key).closest('.list').find('.list_box').find('.filesText').find('img[name="' + $('.value_' + _this_key).attr('name') + '"]').attr('src', _val_src);
                $('.img_' + _this_key).closest('.list').find('.list_box').find('.filesText').find('p').html(_val_title + '.' + _val_type);
                //段落編輯換圖
                $('.img_' + _this_key).closest('.three-item').find('.list_box').find('.s_img img').attr('src', _val_src);
                $("body").attr('data-temp-file',_val_id);
            }
        }

    } else if (_this_type == 'file') {
        $('input.fms_lbox_file_select_checkbox').each(function (index, el) {

            if ($(this).prop('checked') === true) {

                if ($(this).data('type') == 'folder') {
                    choose_folder = true
                } else {
                    _val_src = $(this).attr('data-src');
                    _val_id = $(this).attr('data-key');
                    _val_title = $(this).attr('data-title');
                    _val_type = $(this).attr('data-type');
                }
            }
        });

        if (choose_folder == true) {
            alert('請勿選擇資料夾。');
            return false;
        } else {
            if (_val_src == '') {
                alert('您沒有進行選擇喔');
                return false;
            }
            $('.filepicker_input_' + _this_key).attr('value', _val_title + '.' + _val_type).val('value', _val_title + '.' + _val_type);
            $('.filepicker_input_' + _this_key).attr('value', _val_title + '.' + _val_type).val(_val_title + '.' + _val_type);
            $('.filepicker_src_' + _this_key).attr('data-src', _val_src);
            $('.filepicker_title_' + _this_key).attr('data-title', _val_title + '.' + _val_type);
            $('.filepicker_value_' + _this_key).attr('value', _val_id).val(_val_id);
        }

    } else if (_this_type == 'sontable') {

        const triggerButton = $(`.lbox_fms_open[data-key="${_this_key}"]`);
        const addButton = triggerButton.siblings('.addValueInTable');
        const list = triggerButton.closest('.composite_btn').parent('li').next('.emptyContent').length > 0 ?
            triggerButton.closest('.composite_btn').parent('li').next().next().next('.tabulation_body') :
            triggerButton.closest('.composite_btn').parent('li').next().next('.tabulation_body');

        const name = triggerButton.attr('data-model') + '[' + triggerButton.attr('data-column') + ']';

        if(list.length == 0)
        {

            let search = "ul .thirdTbNew_"+_this_key;
            const three_key = $(search);
            $('input.fms_lbox_file_select_checkbox:checked').each(function (index, el) {
                const self = $(this);
                if (self.data('type') == 'folder') {
                    return;
                } else {
                    _val_src = self.attr('data-src');
                    _val_id = self.attr('data-key');
                    _val_title = self.attr('data-title');
                    _val_type = self.attr('data-type');
                    _val_size = self.parents('.fms_list').find('td').eq(5).find('p').text()

                    addButton.trigger('click');



                    const input = three_key.find('form').last().find(`input[name="${name}"]`).val(_val_id).attr('value', _val_id);

                    const image = input.siblings('img');
                    if (image.length > 0) {
                        image.attr('src', _val_src);
                            let img = input.parents('form.three-item').children('.list_box').find('.AutoSet_article_img');
                            img.attr('src',_val_src);


                        input.closest('.frame').addClass('has_img').find('.info_detail').find('p').each(function (i) {
                            switch (i) {
                                case 0:
                                    $(this).html(`${this.innerHTML}${_val_title}`);
                                    break;
                                case 1:
                                    $(this).html(`${this.innerHTML}${_val_folder}`);
                                    break;
                                case 2:
                                    $(this).html(`${this.innerHTML}${_val_type}`);
                                    break;
                                case 3:
                                    $(this).html(`${this.innerHTML}${_val_size}`);
                                    break;
                            }
                        });
                    }

                    const file = input.parent('.file-picker');
                    if (file.length > 0) {
                        input.siblings('input').each(function (i) {
                            switch (i) {
                                case 0:
                                    $(this).val(_val_title).attr('value', _val_title);
                                    break;
                                case 2:
                                    $(this).attr('data-src', _val_src).attr('data-title', `${_val_title}.${_val_type} `);
                                    break;
                                case 4:
                                    $(this).val(_val_id).attr('value', _val_id);
                                    break;
                            }
                        })
                    }

                }
            });
        }else{
            $('input.fms_lbox_file_select_checkbox:checked').each(function (index, el) {
                const self = $(this);
                if (self.data('type') == 'folder') {
                    return;
                } else {
                    _val_src = self.attr('data-src');
                    _val_id = self.attr('data-key');
                    _val_title = self.attr('data-title');
                    _val_type = self.attr('data-type');
                    _val_size = self.parents('.fms_list').find('td').eq(5).find('p').text()
                    addButton.trigger('click');

                    const input = list.find('form').last().find(`input[name="${name}"]`).val(_val_id).attr('value', _val_id);

                    const image = input.siblings('img');
                if (image.length > 0) {
                    let s_img = list.find('form').last().find('.s_img img');
                    if(s_img.length > 0){
                        s_img.attr('src',_val_src);
                    }


                        image.attr('src', _val_src);
                        input.closest('.frame').addClass('has_img').find('.info_detail').find('p').each(function (i) {
                            switch (i) {
                                case 0:
                                    $(this).html(`${this.innerHTML}${_val_title}`);
                                    break;
                                case 1:
                                    $(this).html(`${this.innerHTML}${_val_folder}`);
                                    break;
                                case 2:
                                    $(this).html(`${this.innerHTML}${_val_type}`);
                                    break;
                                case 3:
                                    $(this).html(`${this.innerHTML}${_val_size}`);
                                    break;
                            }
                        });
                    }

                    const file = input.parent('.file-picker');
                    if (file.length > 0) {
                        input.siblings('input').each(function (i) {
                            switch (i) {
                                case 0:
                                    $(this).val(_val_title).attr('value', _val_title);
                                    break;
                                case 2:
                                    $(this).attr('data-src', _val_src).attr('data-title', `${_val_title}.${_val_type} `);
                                    break;
                                case 4:
                                    $(this).val(_val_id).attr('value', _val_id);
                                    break;
                            }
                        })
                    }

                }
            });
        }
    }else if (_this_type == 'img_list') {
        let picture_box = $(`.lbox_fms_open[data-key="${_this_key}"]`).closest('.picture_box');

        $('input.fms_lbox_file_select_checkbox:checked').each(function (index, el) {
            const self = $(this);
            if (self.data('type') == 'folder') {
                return;
            } else {
                const rand = Math.random().toString(36).substring(2);
                _val_src = self.attr('data-src');
                _val_id = self.attr('data-key');
                _val_title = self.attr('data-title');
                _val_type = self.attr('data-type');
                _val_size = self.parents('.fms_list').find('td').eq(5).find('p').text()
                let $newRow = $(`.lbox_fms_open[data-key="${_this_key}"]`).closest('.open_fms_lightbox').clone();
                let regex = new RegExp(_this_key, 'g');
                $newRow.find('*').each(function() {
                    let currentClass = $(this).attr('class');
                    if (currentClass) {
                        var newClass = currentClass.replace(regex, rand);
                        $(this).attr('class', newClass);
                    }
                });

                $newRow.addClass('has_img');
                $newRow.find('[data-key]').attr('data-key', rand);
                $newRow.find('img').attr('src', _val_src);
                $newRow.find('.box input').val(_val_id);
                $newRow.find('.img_list_input').show();
                $newRow.find('.img_list_title').show();
                picture_box.find('.open_fms_lightbox:last').before($newRow);
            }
        });
        //順序重排
        let _rank = 1;
        picture_box.find('.open_fms_lightbox.has_img').each(function(index, el){
            $(el).find('.rank').html(_rank);
            _rank = _rank + 1;
        });

    }

    setTimeout(function () {
        $('.fms_lbox_current_close').get(0).click();
    }, 100);
});
$('body').on('change', '.fms_lbox_file_select_checkbox', function (e) {
    let _val = $(this).prop('checked');
    if (_val) {
        if ($(".Leon_fms_table").hasClass('one_shot')) {
            $('.Leon_fms_table .select-item input').prop("checked", false);
        }
        $(this).prop("checked", true);
    } else {
        $(this).prop("checked", false);
    }
    e.stopPropagation();
    e.preventDefault();
});

$('body').on('click', '.fms_list', function (e) {
    if (e.target.className != "check-circle icon-check" && e.target.className != "input_number fms_lbox_file_select_checkbox") {
        $(this).find('.select-item input').trigger('click');
    }
});
$('body').on('click', '.Leon-fms-check-all', function (e) {
    let checked = true;
    if ($(this).hasClass('checked')) {
        checked = false;
        $(this).removeClass('checked');
    } else {
        $(this).addClass('checked');
    }
    // $('.Leon_fms_table .select-item input').prop("checked", checked);
    $('.fms_list:visible input').prop( "checked", checked );
});
$('body').on('click', 'li.rankSonTableTop', function () {
    const list = $(this).closest('.composite_btn').parent('li').next().next('.tabulation_body');
    const chosen = list.find(' > form.chosen');
    const length = chosen.length;
    if (length > 0) {
        if (confirm('選中的資料將會移置最上方，並且排序會按照列表位置從1開始遞增')) {
            $(chosen.get().reverse()).each(function () {
                list.prepend(this);
            });
            list.find(' > form > .list_box > .sort_number > input').each(function (val, index) {
                $(this).val(val + 1);
            });
            setTimeout(() => {
                chosen.find('>.list_box .list_checkbox').trigger('click');
            }, 200);
        }
    }
});
$('body').on('click', 'li.rankSonTableEnd', function () {
    const list = $(this).closest('.composite_btn').parent('li').next().next('.tabulation_body');
    const chosen = list.find(' > form.chosen');
    const length = chosen.length;
    if (length > 0) {
        if (confirm('選中的資料將會移置最下方，並且排序會按照列表位置從1開始遞增')) {
            chosen.each(function () {
                list.append(this);
            });
            list.find(' > form > .list_box > .sort_number > input').each(function (val, index) {
                $(this).val(val + 1);
            });
            setTimeout(() => {
                chosen.find('>.list_box .list_checkbox').trigger('click');
            }, 200);
        }
    }
});
$('body').on('keydown', '.sort_number input', function (e) {
    const el = e.currentTarget;
    if (!/([0-9]|Backspace|ArrowLeft|ArrowRight|Delete)+/.test(e.key)) {
        e.preventDefault();
    }
    if (el?.value.length >= 10 && !/(Backspace|ArrowLeft|ArrowRight|Delete)+/.test(e.key)) {
        e.preventDefault();
    }
})
$('body').on('click', '.image_remove', function () {
    let _type = $(this).attr('data-type');
    var div_tool = $(this).parent();
    div_tool.parent().parent().removeClass('has_img'); //移掉"代表有圖片"的class
    div_tool.prev().prev().prev().attr('src', 'javascript:;'); //清除圖片的src(不能放空值，不然會變破圖)
    div_tool.prev().prev().attr('value', ''); //清除hidden裡存的值
    if(_type == 'img_list'){
        let picture_box = $(this).closest('.picture_box');
        $(this).closest('.open_fms_lightbox').remove();
        //順序重排
        let _rank = 1;
        picture_box.find('.open_fms_lightbox.has_img').each(function(index, el){
            $(el).find('.rank').html(_rank);
            _rank = _rank + 1;
        });
    }
});
