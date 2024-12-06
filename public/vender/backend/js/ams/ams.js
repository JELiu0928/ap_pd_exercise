// AMS側欄編號 #adam
$(function () {
    $('.level-1.level_list:visible').each(function (index, element) {
        $(element).find('span.icon').html('0' + (index + 1))
    })
});

(function ($) {
    $.fn.rabioBtn = function () {
        var ele = this;
        ele.on('click', function () {
            var _this = $(this),
                _this_model = _this.data('model'),
                _this_column = _this.data('column'),
                _this_id = _this.data('id');
            if (_this.hasClass('clicked')) {
                return false;
            } else {
                _this.addClass('clicked');
                var _this_value = _this.hasClass('ch') ? 0 : 1;

                $.ajax({
                    url: $('.base-url').val() + '/Ajax/radio-switch/' + _this_model + '/' + _this_id,
                    type: 'GET',
                    data: {
                        column: _this_column,
                        item: _this_value
                    },
                })
                    .done(function () {
                        _this.toggleClass('ch');
                        _this.removeClass('clicked');
                    })
                    .fail(function () {
                        console.log("error");
                    })
            }
        });
    };
    $.fn.radioAmsSwitch = function () {
        var ele = this;
        ele.on('click', function () {
            var _this = $(this);
            if (_this.hasClass('on')) {
                if (_this.hasClass('review-switch')) {
                    _this.val(0).attr('value', '0').removeClass('on');
                    _this.children('input.check_ams_rabio').val('0');
                } 
                else if(_this.hasClass('view-switch')){
                    _this.removeClass('on');
                    _this.children('input.check_ams_rabio').attr('value', '0');
                    _this.children('input.check_ams_rabio').val('0');
                    _this.siblings('.ams_ios_switch').removeClass('on')
                        .children('input.check_ams_rabio').val(0).attr('value', '0');
                }
                else {
                    _this.removeClass('on');
                    _this.children('input.check_ams_rabio').attr('value', '0');
                    _this.children('input.check_ams_rabio').val('0');
                    _this.siblings('.review-switch').removeClass('on')
                        .children('input.check_ams_rabio').val(0).attr('value', '0');
                }
            } else {
                if (_this.hasClass('review-switch')) {
                    _this.closest('.switch_box').find('input.check_ams_rabio').val(1).attr('value', '1')
                        .closest('.ios_switch').addClass('on');
                } else {
                    _this.addClass('on');
                    _this.children('input.check_ams_rabio').attr('value', '1');
                    _this.children('input.check_ams_rabio').val('1');
                    _this.closest('.switch_box').find('.view-switch input.check_ams_rabio').val(1).attr('value', '1')
                        .closest('.ios_switch').addClass('on');
                }
            }
        });
    };
    $.fn.updateAmsData = function () {
        var ele = this;
        ele.on('click', function () {
            var _this = $(this),
                _this_type = _this.data('type');
            if (_this.hasClass('clicked')) {
                return false;
            } else {
                $("#ams_edit_form select").each(function () {
                    if ($(this).prop('multiple') === false) {
                        if ($(this).val() == null) {
                            $("#ams_edit_form").append("<input type='hidden' name='" + $(this).attr('name') + "' value='' data-unchecked-value='xxxx'>");
                        }
                    } else {
                        if ($(this).val().length == 0) {
                            $("#ams_edit_form").append("<input type='hidden' name='" + $(this).attr('name') + "' value='' data-unchecked-value='xxxx'>");
                        }
                    }
                });
                temp_loading();
                _this.addClass('clicked');
                var form = document.getElementById('ams_edit_form');
                var ajax = new XMLHttpRequest();
                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4 && ajax.status == 200) {
                        var response = JSON.parse(ajax.responseText);
                        if (response.result == true) {
                            if (response.status == 'create') {
                                $('.ams_type_create_zz').css('display', 'none');
                                $('.ams_type_edit_zz').css('display', '');
                                $('.delete_ams_hiddenArea').css('display', '');
                                $('input.supportAmsId_Input').val(response.id);
                                $('input.supportAmsId_Input').attr('value', response.id);
                            }
                            amsBasicFunction.index_reset();
                            temp_loading();
                        } else if (response.result == false) {
                            alert(response.warning)
                            temp_loading();
                        }
                        _this.removeClass('clicked');

                        // 若修改的'AMS權限管理'，則更新左側Ams的sidebar
                        if (_this_type == 'ams-manager') {
                            $('#ams_sidebar').load($('.base-url-plus').val() + '/Fantasy/Ams/sidebar', function () { });
                        }
                    }
                };
                ajax.open("POST", $('.base-url-plus').val() + '/Fantasy/Ajax/ams-update/' + _this_type, true);
                ajax.setRequestHeader('X_REQUESTED_WITH', 'XMLHttpRequest');
                ajax.send(new FormData(form));
            }
        });
    };
    $.fn.deleteAmsData = function () {
        var ele = this;
        ele.on('click', function () {
            var _this = $(this),
                _this_type = _this.data('type');
            if (_this.hasClass('clicked')) {
                return false;
            } else {
                $('.block_out').addClass('show');
                var delete_fuck_check = confirm("是否決定刪除資料？");
                _this.addClass('clicked');
                if (delete_fuck_check == true) {
                    $.ajax({
                        url: $('.base-url-plus').val() + '/Fantasy/Ajax/ams-delete/' + _this_type,
                        type: 'GET',
                        data: {
                            id: $('input.supportAmsId_Input').val()
                        },
                    })
                        .done(function () {
                            $('.close_ams_hiddenArea').trigger('click');
                            amsBasicFunction.index_reset();
                            alert("刪除成功");
                            $('.block_out').removeClass('show');
                        })
                        .fail(function () {
                            console.log("error");
                        })

                } else {
                    _this.removeClass('clicked');
                }
            }
        });
    };
    $.fn.setAmsMember = function () {
        var ele = this,
            temp_data = '';
        ele.on('click', function () {
            var _this = $(this),
                _this_key = _this.data('key');
            $('input.ams-member-checkbox').each(function (index, el) {
                if ($(this).prop('checked') === true) {
                    temp_data = $(this).data('json');
                }
            });

            if (temp_data != '') {
                $('.member_input_' + _this_key).attr('value', temp_data.id);
                $('.member_input_' + _this_key).val(temp_data.id);
                $('.member_img_' + _this_key).attr('src', temp_data.img_route);
                $('div.member_title_' + _this_key).removeClass('no_selfie');
                $('p.member_title_' + _this_key).text(temp_data.name);
            }

            amsBasicFunction.close_member_lbox();
        });
    };
    $.fn.closeAmsMember = function () {
        var ele = this;
        ele.on('click', function () {
            amsBasicFunction.close_member_lbox();
        });
    };
    $.fn.openAmsMember = function () {
        var ele = this;
        ele.on('click', function () {
            var _this = $(this),
                _this_key = _this.data('key');

            if (_this.hasClass('clicked')) {
                console.log('Double Click!!');
                return false;
            } else {
                _this.addClass('clicked');

                $.ajax({
                    url: $('.base-url-plus').val() + '/Fantasy/Ajax/member-list/' + _this_key,
                    type: 'GET',
                })
                    .done(function (data) {
                        $('article.ams_lbox').children('div').append(data);
                        $('article.ams_lbox').addClass('open');
                        setTimeout(function () {
                            card_table('ams_ajax_table');

                            $('.checkbox label').on('click', function () {
                                $('.ams-member-checkbox').prop('checked', false);
                                $(this).prev('.ams-member-checkbox').prop('checked', true);
                            });

                            $('.member_lbox_setting').setAmsMember();
                            $('.member_lbox_cancel').closeAmsMember();
                        }, 500);
                        setTimeout(function () {
                            $('article.ams_lbox').addClass('go_animation');
                        }, 1000);

                        _this.removeClass('clicked');
                    })
                    .fail(function () {
                        console.log("error");
                    })
            }

        });
    };
    $.fn.openAmsEdit = function () {
        var ele = this;
        ele.on('click', function () {
            var _this = $(this),
                _this_type = _this.data('type'),
                _this_id = _this.data('id'),
                _this_ym = _this.data('ym');
            if (_this.hasClass('clicked')) {
                console.log('Double Click!!');
                return false;
            } else {
                _this.addClass('clicked');
                let _openUrl = $('.base-url-plus').val() + '/Fantasy/Ajax/ams-information/' + _this_type + '/' + _this_id;
                if(_this_ym!=undefined) _openUrl += '?date='+_this_ym;
                $.ajax({
                    url: _openUrl,
                    type: 'GET',
                })
                    .done(function (data) {
                        $('.ams_hiddenArea').find('#ams_edit_form').append(data.content);
                        if (ele.selector == '.edit_ams_wrapper') {
                            $('.ams_type_create_zz').css('display', 'none');
                            $('.ams_type_edit_zz').css('display', '');
                        } else if (ele.selector == '.create_ams_wrapper') {
                            $('.ams_type_create_zz').css('display', '');
                            $('.ams_type_edit_zz').css('display', 'none');
                            $('.delete_ams_hiddenArea').css('display', 'none');
                        }
                        //quill_select();
                        amsBasicFunction.close_wrapper();
                        amsBasicFunction.open_wrapper();
                        $('.ams_ios_switch').radioAmsSwitch();
                        $('.updated_ams_edit_btn').updateAmsData();
                        $('.delete_ams_information').deleteAmsData();
                        $('.open_member_list').openAmsMember();
                        _this.removeClass('clicked');
                        components.select2($(".____select2"));

                        setTimeout(function () {
                            $('.multi_select_has_auth .inner').attr('style', 'width:100%');
                            $('.multi_select_has_auth div.title').attr('style', 'width:0%');
                        });
                    })
                    .fail(function () {
                        console.log("error");
                    })
            }

        });
    };
})(window.jQuery);

var amsBasicFunction = {
    sidebar_vs_url: function () {
        $ele_array = $('.ams-list-doyouwanttobeagoodman').find('a');
        $now_url = location.href;
        $ele_array.each(function (index, el) {
            if ($(this).attr('href') == $now_url) {
                $(this).parent('li').addClass('open');
                $(this).attr('href', 'javascript:;');
            }
        });
    },
    open_wrapper: function () {

        // 20200202 wade
        $('.amsDetailAjaxArea.ams_hiddenArea').addClass('active');
        $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem').addClass('active');
        $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem #ams_edit_form').addClass('active');

        setTimeout(function () {
            $('.amsDetailAjaxArea.ams_hiddenArea').addClass('open').removeClass('active');
            $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem').addClass('open').removeClass('active');
            $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem #ams_edit_form').addClass('open').removeClass('active');
        }, 400)

        $('.editorBody').scrollbar();
        // var content = $('.ams_hiddenArea .hiddenArea_frame_box .box_block');
        // var content = $('.ams_hiddenArea .hiddenArea_frame_box .editorBody');

        // var a = $('.box_header').outerHeight(),
        //     b = $('.hiddenArea_frame_controlBtn').outerHeight(),
        //     c = a + b,
        //     bg = $('.ams_hiddenArea');

        // bg.addClass('open');
        // if (content.hasClass('scroll-wrapper') == false) {
        //     // content.scrollbar({});
        //     components.scrollBar(content);
        //     bg.find('.hiddenArea_frame_box .scroll-wrapper.box_block').css('max-height', 'calc(100% - ' + c + 'px)');

        // } else {

        //     content.find('.menu_content').scrollbar({});
        //     bg.find('.hiddenArea_frame_box .scroll-wrapper.menu_content').css('max-height', 'calc(100% - ' + c + 'px)');

        // }
    },
    close_wrapper: function () {

        $('.close_ams_hiddenArea').on('click', function () {
            //20200202 wade
            $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem').addClass('remove');
            $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem .ajaxContainer').addClass('remove');

            setTimeout(function () {
                $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem').removeClass('open remove');
                $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem .ajaxContainer').removeClass('open remove');
                $('.amsDetailAjaxArea.ams_hiddenArea').addClass('remove');

            }, 500)

            setTimeout(function () {
                $('.amsDetailAjaxArea.ams_hiddenArea').removeClass('open remove');
            }, 650)

            $('.amsDetailAjaxArea.ams_hiddenArea .ajaxItem .ajaxContainer').empty();

            // var object = $('.ams_hiddenArea');
            // object.removeClass('open');
            // $('.ams_hiddenArea').children('form').empty();
        });
    },
    index_reset: function () {
        var _tbody = $('tbody.ams_tbody'),
            _type = _tbody.data('type');

        $.ajax({
            url: $('.base-url-plus').val() + '/Fantasy/Ajax/index-reset/' + _type,
            type: 'GET',
            dataType: 'html',
        })
            .done(function (data) {
                _tbody.empty();
                _tbody.append(data);
                // card_table('ams_table');
                $('.rabioAmsBtn').rabioBtn();
                $('.edit_ams_wrapper').openAmsEdit();
                $('.create_ams_wrapper').openAmsEdit();
            })
            .fail(function () {
                console.log("error");
            })

    },
    close_member_lbox: function () {
        $('article.ams_lbox').children('div').empty();
        $('article.ams_lbox').removeClass('open');
        $('article.ams_lbox').removeClass('go_animation');
    },
    just_do_it: function () {
        this.sidebar_vs_url();
        card_table('ams_table');
        $('.rabioAmsBtn').rabioBtn();
        $('.edit_ams_wrapper').openAmsEdit();
        $('.create_ams_wrapper').openAmsEdit();
    },
};
amsBasicFunction.just_do_it();

$('body').on('click', '.ios_switch_selectAll', function () {
    if ($(this).hasClass('on')) {
        $(".ams_ios_switch").not(".lock").each(function () {
            $(this).addClass('on');
            $(this).find('input.check_ams_rabio').attr('value', '1');
        });
    } else {
        $(".ams_ios_switch").not(".lock").each(function () {
            $(this).removeClass('on');
            $(this).find('input.check_ams_rabio').attr('value', '0');
        });
    }
});

$('body').on('click', '.ios_switch_select_block', function () {
    var _this = $(this);
    var val = _this.attr('data-val');
    if (val == 1) {
        _this.closest('.inventory').find('.ams_ios_switch').each(function () {
            $(this).addClass('on');
            $(this).find('input.check_ams_rabio').attr('value', '1');
        });
    } else {
        _this.closest('.inventory').find('.ams_ios_switch').each(function () {
            $(this).removeClass('on');
            $(this).find('input.check_ams_rabio').attr('value', '0');
        });
    }
});
$('body').on('click', '.ios_switch_select_block_all', function () {
    var _this = $(this);
    var val = _this.attr('data-val');
    if (val == 1) {
        $('.switch-block').each(function () {
            $(this).addClass('on');
            $(this).find('input.check_ams_rabio').attr('value', '1');
        });
    } else {
        $('.switch-block').each(function () {
            $(this).removeClass('on');
            $(this).find('input.check_ams_rabio').attr('value', '0');
        });
    }
});
