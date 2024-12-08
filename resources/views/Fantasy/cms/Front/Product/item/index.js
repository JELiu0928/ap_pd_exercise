

if ($('.editSentBtn').length > 0) {

    let _saveBtn = $('.editSentBtn').last().clone();
    _saveBtn.removeClass('editSentBtn').addClass('editSentBtnCustom').hide();
    $('.editSentBtn').last().after(_saveBtn);

}

$(function(){
    // console.log(22222)
})
