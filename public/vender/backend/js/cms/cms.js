/* ============================================================
 * 客製化js
 * ============================================================ */

$(document).ready(function() {
    //
    // card_table( $('.main-table').attr('data-tableID') );

    // //
    // calculate_main_container();

    // $(window).resize(function(){
    //     calculate_main_container();
    // });

    // //file_detail產品 / 商品圖片
    // item_file_detail('file_detail_btn');

    // //打開fms lightbox(open_fms_lightbox)
    // // btn_fms_lightbox();

    // //打開db lightbox(open_db_lightbox)
    // // btn_db_lightbox();
    // $('.content-scrollbox').scrollbar({})
    // //打開full preview(open_paragraph_preview)
    // // btn_preview_lightbox();

    ExportBtnCheck();
});

function ExportBtnCheck() {
    $('.ExportBtnCheck').on('click', function() {
        let selectId = $(".w_Check input:checked").map(function() { return $(this).attr('data-id') }).get();
        if (selectId.length > 0) {
            location.href = $('.ExportBtn').attr('href') + '?check=' + JSON.stringify(selectId);
        } else {
            alert('尚未選擇資料');
        }
    });
}

// 計算主要高度
function calculate_main_container() {

    var _container = $('.main_container'),
        _frame = $('.main_container_frame'),
        _frameBox = _frame.find('.hiddenArea_frame_box'),
        _jumbotronHeight = $('.jumbotron').outerHeight(),
        _headerHeight = $('.header').outerHeight(),
        _boxHeader = $('.hiddenArea_frame_box .box_header'),
        _boxBlock = $('.hiddenArea_frame_box .box_block'),
        _containerHeight = '';
    _boxBlockHeight = '';

    var _documentHeight = $(document.body).height();

    _containerHeight = _documentHeight - (_jumbotronHeight + _headerHeight);
    _container.css('height', _containerHeight);

    _boxBlockHeight = _frameBox.height() - _boxHeader.outerHeight();
    _boxBlock.css('height', _boxBlockHeight);
}

function setDbLbox(li) {
    console.log(li);

    $('.db_lbox_setting').on('click', function() {
        var _this = $(this);
        var nodata = 0;
        var is_empty = li.find('.inner .select_object').data('empty');

        if ($('.table_section').hasClass('one_shot')) {
            //單選
            var temp_data = temp_title = '';
            $('input.db_lbox_select_checkbox').each(function(index, el) {
                if ($(this).prop('checked') === true) {
                    temp_data = $(this).attr('id');
                    temp_title = $(this).attr('data-title');
                }
            });

            if (temp_data != '') {
                li.find('input').val(temp_data);
                // li.find('.inner .select_object .title').text(temp_title);
                li.find('p.title').first().text(temp_title);
            } else if (is_empty == 'yes') {
                li.find('input').val('');
                // li.find('.inner .select_object .title').text('-');
                li.find('p.title').first().text('-');
            } else {
                nodata = 1;
            }
        } else if ($('.table_section').hasClass('multi_shot')) {
            //多選-下拉選單
            var temp_data = '[',
                temp_title = '';
            var num = 0;
            $('input.db_lbox_select_checkbox').each(function(index, el) {
                if ($(this).prop('checked') === true) {
                    num++;
                    temp_data += (temp_data == '[') ? '"' + $(this).attr('id') + '"' : ', "' + $(this).attr('id') + '"';
                    temp_title += '<span class="item multiOption_' + (index + 1) + '" option-id="' + (index + 1) + '">';
                    temp_title += '<i class="number">' + (num < 10 ? '0' : '') + num + '.</i>';
                    temp_title += '<i class="name">' + $(this).attr('data-title') + '</i></span>';
                }
            });
            temp_data += ']';

            if (temp_data != '') {
                li.find('input').val(temp_data);
                li.find('.inner .select_object .title').html(temp_title);
            } else if (is_empty == 'yes') {
                li.find('input').val('');
                li.find('.inner .title .item').remove();
            } else {
                nodata = 1;
            }
        } else if ($('.table_section').hasClass('sontable')) {
            //sontable-下拉選單
            var temp_data = new Array()
            var temp_title = new Array()

            $('input.db_lbox_select_checkbox').each(function(index, el) {
                if ($(this).prop('checked') === true) {
                    temp_data.push($(this).attr('id'))
                    temp_title.push($(this).attr('data-title'))
                }
            });

            var newlist = li.data('content')
            var tableKey = li.data('table')
            var tableModel = li.data('sontablemodel') //預設model
            var tableColumn = li.data('column') //預設欄位
            var theField = tableModel + '[' + tableColumn + '][]'

            if (temp_data.length != 0) {
                $('li.emptyContent').remove();
                temp_data.forEach(function(elementm, index) {

                    var randomCode = Math.random().toString(36).substring(7)

                    $('.backEnd_quill ul.frame .tabulation_body').append(newlist);
                    $('.addKeyClass').addClass('cms_new_' + randomCode);
                    $('.addkeyFrame').addClass('list_frame_' + randomCode);
                    $('.addDataKey').attr('data-key', randomCode);
                    $('.addKeyValue').val(randomCode);

                    $('.addImgClass').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('img_' + keyClass + randomCode + keyClass);
                    });
                    $('.addImgValClass').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('value_' + keyClass + randomCode + keyClass);
                    });
                    $('.addFileClass').each(function(index, el) {
                        var keyClass = $(this).parents('.open_fms_lightbox').find('img').data('key');
                        $(this).addClass('file_' + keyClass + randomCode + keyClass);
                    });
                    $('.addFolderClass').each(function(index, el) {
                        var keyClass = $(this).parents('.open_fms_lightbox').find('img').data('key');
                        $(this).addClass('folder_' + keyClass + randomCode + keyClass);
                    });
                    $('.addTypeClass').each(function(index, el) {
                        var keyClass = $(this).parents('.open_fms_lightbox').find('img').data('key');
                        $(this).addClass('type_' + keyClass + randomCode + keyClass);
                    });
                    $('.addSizeClass').each(function(index, el) {
                        var keyClass = $(this).parents('.open_fms_lightbox').find('img').data('key');
                        $(this).addClass('size_' + keyClass + randomCode + keyClass);
                    });
                    $('.addMulitSelectClass').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('multi_select_' + keyClass + randomCode + 'multi');
                    });
                    $('.addMulitListClass').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('multi_sselect_list_' + keyClass + randomCode + 'multi');
                    });
                    $('.addSelectGroup').each(function(index, el) {
                        var model = $(this).data('model'),
                            next = $(this).data('next'),
                            _this_p = $(this).parent().parent().parent().find('p.addSelectGroupP');
                        $(this).attr('id', 'relsel_' + randomCode + '_' + model);
                        if ($(this).data('next') != '') $(this).data('next', randomCode + '_' + next);
                        _this_p.attr('id', 'relselo_' + randomCode + '_' + model);
                    });
                    $('.addImgKey').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).attr('data-key', keyClass + randomCode + keyClass);
                    });
                    $('.addMultiKey').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).attr('data-key', keyClass + randomCode + 'multi');
                    });
                    $('.filepicker_input_key').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('filepicker_input_' + keyClass + randomCode + 'file');
                    });
                    $('.filepicker_src_key').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('filepicker_src_' + keyClass + randomCode + 'file');
                    });
                    $('.filepicker_title_key').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('filepicker_title_' + keyClass + randomCode + 'file');
                    });
                    $('.filepicker_value_key').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).addClass('filepicker_value_' + keyClass + randomCode + 'file');
                    });
                    $('.filepicker_change_key').each(function(index, el) {
                        var keyClass = $(this).data('key');
                        $(this).attr('data-key', keyClass + randomCode + 'file');
                    });

                    var chooseFiled = $(".addKeyClass [name='" + theField + "']")
                    if (chooseFiled.attr('type') == 'text') {
                        if (chooseFiled.hasClass('normal_input')) {
                            chooseFiled.val(temp_title[index])
                        } else {
                            chooseFiled.html(temp_title[index])
                        }

                    } else {
                        chooseFiled.val(elementm)
                        chooseFiled.prev().find('p').html(temp_title[index])
                    }

                    $('.addKeyClass').removeClass('addKeyClass');
                    $('.addkeyFrame').removeClass('addkeyFrame');
                    $('.addDataKey').removeClass('addDataKey');
                    $('.addKeyValue').removeClass('addKeyValue');
                    $('.addImgClass').removeClass('addImgClass');
                    $('.addFileClass').removeClass('addFileClass');
                    $('.addFolderClass').removeClass('addFolderClass');
                    $('.addTypeClass').removeClass('addTypeClass');
                    $('.addSizeClass').removeClass('addSizeClass');
                    $('.addImgValClass').removeClass('addImgValClass');
                    $('.addImgKey').removeClass('addImgKey');
                    $('.addMulitSelectClass').removeClass('addMulitSelectClass');
                    $('.addMulitListClass').removeClass('addMulitListClass');
                    $('.addSelectGroup').removeClass('addSelectGroup');
                    $('.addSelectGroupP').removeClass('addSelectGroupP');
                    $('.addMultiKey').removeClass('addMultiKey');
                    $('.filepicker_input_key').removeClass('filepicker_input_key');
                    $('.filepicker_src_key').removeClass('filepicker_src_key');
                    $('.filepicker_title_key').removeClass('filepicker_title_key');
                    $('.filepicker_value_key').removeClass('filepicker_value_key');
                    $('.filepicker_change_key').removeClass('filepicker_change_key');

                    var count = $('.tabulation_body_' + tableKey).children('div.stack_state').length;
                    var newDiv = $('.tabulation_body_' + tableKey).children('div.stack_state').eq(count - 1);
                    newDiv.attr('data-rank', count);
                    var rankDiv = newDiv.children('div').children('div.sort_number');
                    rankDiv.children('p').text(count);
                    rankDiv.children('input').val(count);

                    _this.removeClass('clicked');
                    //quill_select();
                    wade_datepicker();
                    baseContentEdit_color_picker();
                    item_file_detail('file_detail_btn');
                });

            } else {
                nodata = 1;
            }
        }

        if (nodata == 0) {
            $('article.ams_lbox').removeClass('go_animation');
            $('article.ams_lbox').removeClass('open');
            $('article.ams_lbox').children('div').empty();
        } else {
            alert('請選擇關聯資料');
        }
    });
};

function closeDbLbox() {
    //關閉
    $('.close_ajax_btn').on('click', function() {
        $('article.ams_lbox').removeClass('go_animation');
        $('article.ams_lbox').removeClass('open');
        $('article.ams_lbox').children('div').empty();
    })
};
/*============================================================*/
