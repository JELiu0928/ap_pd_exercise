$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});
//即時處理事件
function InstantProcessing() {
    //判斷資料重複
    $(document).on('blur', '.verify_repeat', function(event) {
        let _this = $(this);
        $.ajax({
            url: $('.base-url').val() + '/Ajax/verify',
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            data: {
                field: _this.attr('name'),
                value: _this.val(),
                dataId: $('.editContentDataId').val()
            }
        }).done(function(response) {
            if (!response.state) {
                alert(_this.closest('.inventory').find('.subtitle').text() + ' - 偵測到資料重複');
                _this.css('background-color', '#ffe2e2');
                _this.addClass('verify_repeat_error');
            } else {
                _this.css('background-color', '#fff');
                _this.removeClass('verify_repeat_error');
            }
        }).fail(function() {
            console.log("ajax error");
        });
    });
    $(document).on('blur', '.verify_required', function(event) {
        let _this = $(this);
        if(_this.val().trim()=='') alert('此欄位必填')
    })

    let verifyArray = [
        { className: 'verify_email', 'regex': /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/, 'text': '格式請符合 demo@gamil.com' },
        { className: 'verify_phone', 'regex': /^(09)[0-9]{8}$/, 'text': '格式請符合 0910123456' },
        { className: 'verify_telphone', 'regex': /^[0][1-9]{1,3}[-][0-9]{6,8}$/, 'text': '格式請符合 04-23223899' },
    ];
    verifyArray.forEach((item) => {
        $(document).on('blur', '.' + item.className, function(event) {
            let _this = $(this);
            let mailformat = item.regex;
            if (!_this.val().match(mailformat)) {
                alert(_this.closest('.inventory').find('subtitle').text() + ' 格式錯誤，' + item.text);
                _this.addClass('verify_format_error');
                _this.css('background-color', '#ffe2e2');
            } else {
                _this.css('background-color', '#fff');
                _this.removeClass('verify_format_error');
            }
        });
    });
}

//存檔前處理事件
function LeonSaveCall() {
    $('[name*="url_name"]').each(function() {
        $(this).val($(this).val().replace(/[^\u4e00-\u9fa5a-zA-Z0-9_-]/g, ''));
    });
    $(".ThreeContent .__leonselect2multiple").each(function(index) {
        let new_name = $(this).attr('data-original') + '[' + index + '][]';
        $(this).attr('name', new_name);
        $(this).addClass(new_name);
    });
    if (!LeonVerify()) {
        return false;
    }
    return true;
}
//存檔前驗證事件
function LeonVerify() {
    let _error = false;
    $('.verify_required').each(function() {
        let _this = $(this);
        if (_this.val().trim() == "") {
            Errorfocus(_this);
            _error = true;
            return false;
        }
    });
    if (_error) {
        return false;
    }
    $(".verify_repeat_error").each(function() {
        let _this = $(this);
        Errorfocus(_this);
        _error = true;
        return false;
    });
    if (_error) {
        return false;
    }
    $(".verify_format_error").each(function() {
        let _this = $(this);
        Errorfocus(_this);
        _error = true;
        return false;
    });
    if (_error) {
        return false;
    }
    return true;
}

function Errorfocus(_this) {
    let _form = _this.closest(".backEnd_quill").closest('form')[0].id;
    $('.editContentMenu li[data-form="' + _form + '"]').click();
    //第三層
    if (_this.closest('.three-item').length > 0) {
        _this.closest('.tabulation_body').find('.stack_state').removeClass('active');
        _this.closest('.tabulation_body').find('.list_frame').removeClass('open').hide();
        _this.closest('.list_body').find('.list_bodyL').hide();
        _this.closest('.list_bodyL').show();
        let three_tab = _this.closest('.list_bodyL').attr('body-id');
        _this.closest('.list_frame').find('.list_headBar li').removeClass('now');
        _this.closest('.list_frame').find('.list_headBar li[bar-id="' + three_tab + '"]').addClass('now');
        _this.closest('.list_frame').addClass('open').show();
        _this.closest('.stack_state').closest('.stack_state').addClass('active');
        _this.closest('.stack_state').find('.list_frame').first().addClass('open').show();
    } else {
        //第二層
        if (_this.closest('.tabulation_body').length > 0) {
            _this.closest('.tabulation_body').find('.stack_state').removeClass('active');
            _this.closest('.tabulation_body').find('.list_frame').removeClass('open').hide();
            _this.closest('.stack_state').addClass('active');
            _this.closest('.list_frame').addClass('open').show();
        }
    }
    let auto_select_file = _this.closest('.inventory');
    let topPos = auto_select_file.offset().top - $('.editContentFormArea').offset().top;
    $('.mainContent .editorBody.scroll-content').animate({ scrollTop: topPos }, 200, function() {
        alert(_this.closest('.inventory').find('.subtitle').text() + ' - 必填項目未填寫');
    });
}
$(function() {
    InstantProcessing();
});
