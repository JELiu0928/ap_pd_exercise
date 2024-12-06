//cmsjs
$(document).ready( function(){
    //
    card_table( $('.main-table').attr('data-tableID') );

    //file_detail產品 / 商品圖片
    item_file_detail('file_detail_btn');

    //search_bar
    search_event();

    //打開fms lightbox(open_fms_lightbox)
    btn_fms_lightbox();

    //打開db lightbox(open_db_lightbox)
    // btn_db_lightbox();

    //打開full preview(open_paragraph_preview)
    btn_preview_lightbox();
});