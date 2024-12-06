//預設選單跟資料夾檔案
function set_fms_basic(is_trash) {
    var folder_id = $("#folder_id").val();
    var fms_folder = document.getElementsByClassName('fms_folder');
    for (var i = 0; i < fms_folder.length; i++) {
        fms_folder[i].style.display = "none";
    }
    if (is_trash) {
        folder_id = 'trash';
        $('.fms_folder.is_delete').css("display", "table-row");
        $('.fms_list.is_delete').css("display", "table-row");
        $('.fa.fa-pencil').hide();
    } else {
        $('.fms_folder[data-folder-id="' + folder_id + '"]:not(".is_delete")').css("display", "table-row");
        $('.fms_list[data-folder-id="' + folder_id + '"]:not(".is_delete")').css("display", "table-row");
        $('.fa.fa-pencil').show();
    }
    let open_type = $(".fms_lbox_current_btn").attr('data-type');

    $(".fms_list").remove();
    $.ajax({
        url: $('.base-url-plus').val() + '/Fantasy/Fms',
        method: "GET",
        data: {
            ajax: true,
            folder_id: folder_id,
            open_type: open_type,
        },
        dataType: 'JSON',
        cache: false,
        success: function (data) {
            $(".Leon_fms_table").append(data.files);
            $('body').find('.tree').fadeOut(0);
            $(".tree-title:not(.is_delete)").css("display", "block");
            var node = $(".tree-title[data-folder-id='" + folder_id + "']");
            setParentStatus(node);
            generateBreadcrumb(node, 1);
            if (typeof $("body")[0].cms_open_file !== 'undefined' && $("body")[0].cms_open_file != 0) {
                let auto_select_file = $('.fms_lbox_file_select_checkbox[data-file-key="' + $("body")[0].cms_open_file + '"]')
                auto_select_file.prop('checked', true);
                $("body")[0].cms_open_file = "undefined";
                var topPos = auto_select_file.closest('tr').position()?.top + auto_select_file.closest('tr').parent().scrollTop() - auto_select_file.closest('tr').offsetParent()?.position()?.top;
                $('.content-scrollbox').animate({
                    scrollTop: topPos
                }, 200);
            }
            if (is_trash) {
                $('.cms_open_file_edit').hide();
            }
        }
    });
}

$('body').on('click', 'a.btn-item.searchbar', function () {
    $(this).find('.search-data').addClass('active').focus();
})

$("body").on('keyup','.LeonSearchInput',function(event) {
    if (event.which === 13) {
        $(".LeonSearchBtn").click();
    }
});
$('body').on('click', '.LeonSearchBtn', function () {
    let open_type = $(".fms_lbox_current_btn").attr('data-type');
    var search_value = $(this).siblings('input').val();
    if (search_value != '') {
        $.ajax({
            url: $('.base-url-plus').val() + '/Fantasy/Fms',
            method: "GET",
            data: {
                ajax: true,
                search_value: search_value,
                open_type: open_type,
            },
            dataType: 'JSON',
            cache: false,
            success: function (data) {
                $(".fms_folder").hide();
                $(".fms_list").remove();
                $(".Leon_fms_table").append(data.files);
                $('body').find('.tree').fadeOut(0);
                $(".tree-title:not(.is_delete)").css("display", "block");
                var node = $(".tree-title[data-folder-id='" + folder_id + "']");
                // setParentStatus(node);
                generateBreadcrumb(node, 1);
            }
        });
    }
})

$('body').on('click', '.fms_folder_on_list', function (e) {

    var folder_id = $(this).attr('data-id');
    //沒權限
    if ($(this).closest('.tbody_tick').hasClass('cant_use')) {
        alert("您沒有權限");
        return false;
    }
    if (!$(this).closest('.tbody_tick').hasClass('is_delete')) {
        if ($(this).hasClass('fms_folder_back')) {
            treeclick($('.tree-title[data-folder-id="' + folder_id + '"]'), true);
        } else {
            $('.tree-title[data-folder-id="' + folder_id + '"]').click();
        }
    }
});
$('body').on('click', '.folder_edit_upload_new', function () {
    var this_form = $(".ajaxContainer.open");
    var parent_folder_level = this_form.find('input[name="fms[parent_folder_level]"]').val();
    var parent_folder_id = this_form.find('input[name="fms[parent_folder_id]"]').val();
    var parent_branch = this_form.find('input[name="fms[parent_branch]"]').val();
    var self_id = this_form.find('input[name="fms[self_id]"]').val();
    var title = this_form.find('input[name="fms[title]"]').val();
    var note = this_form.find('textarea[name="fms[note]"]').val();
    var is_private = this_form.find('input[name="fms[is_private]"]').val();
    var can_use = this_form.find('select.____select2[name="fms[can_use][]"]').val();

    $.ajax({
        type: "POST",
        url: $('.base-url').val() + '/Ajax/post-edit-folder-new',
        data: {
            '_token': $('._token').val(),
            'id': self_id,
            'parent_folder_level': parent_folder_level,
            'parent_folder_id': parent_folder_id,
            'parent_branch': parent_branch,

            'title': title,
            'note': note,
            'is_private': is_private,
            'can_use': JSON.stringify(can_use),
        },
    }).done(function (data) {
        $('#folder_id').val(parent_folder_id);
        //更新資料夾樹及麵包屑
        syncFolderTreeAndBreadcrumb();

        if (self_id == 0) {
            alert("新增成功");
        } else {
            alert("編輯成功");
        }

        $(".folder_edit_upload_new").closest('ul').find('.close_btn').click();
        return "";
    }).always(function (data) {

    })
});
$('body').on('click', '.folder_edit_delete', function () {
    var this_form = $(".ajaxContainer.open");
    var parent_folder_level = this_form.find('input[name="fms[parent_folder_level]"]').val();
    var parent_folder_id = this_form.find('input[name="fms[parent_folder_id]"]').val();
    var parent_branch = this_form.find('input[name="fms[parent_branch]"]').val();
    var self_id = this_form.find('input[name="fms[self_id]"]').val();
    var title = this_form.find('input[name="fms[title]"]').val();



    var note = this_form.find('textarea[name="fms[note]"]').val();
    var is_private = this_form.find('input[name="fms[is_private]"]').val();
    var can_use = this_form.find('select.____select2[name="fms[can_use][]"]').val();
    if (confirm('你確定要刪除 "' + title + '" 資料夾?')) {
        var folderIDArray = [];
        folderIDArray.push(self_id);
        var toUrl = $('.base-url').val() + '/Ajax/file-exchange?nowFolder=' + 0 + '&delete=1&json_file=[]&json_folder=' + JSON.stringify(folderIDArray);

        $.ajax({
            type: "GET",
            url: toUrl,
        }).done(function (data) {
            if (data.status == 'fail') {
                alert(data.msg);
                return;
            } else {
                alert("成功刪除");
                for (var i = 0; i < folderIDArray.length; i++) {
                    $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').click();
                    $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + folderIDArray[i] + '"]').closest('tr').addClass('is_delete');
                }
                if (folderIDArray.length > 0) {
                    syncFolderTreeAndBreadcrumb();
                }
                set_fms_basic(false);
                $(".folder_edit_delete").closest('ul').find('.close_btn').click();
                return;
            }
        }).always(function (data) { })

    }


});

//編輯檔案
$('body').on('click', '.file_edit_upload', function () {
    if ($(this).hasClass('cant_use')) {
        alert('你沒有權限');
        return false;
    }

    if (LeonSaveCall()) {
        var formData = new FormData();
        var file = '';
        if (fantasy_files_uploads.length > 0) {
            file = fantasy_files_uploads[0];
        }
        var is_delete = $(this).closest('.hiddenArea_frame_controlBtn').attr('data-delete');
        var this_form = $(".ajaxContainer.open");
        var _val_id = this_form.find('input[name="fms[edit_id]"]').val();
        var folder_level = this_form.find('input[name="fms[folder_level]"]').val();
        var folder_id = this_form.find('input[name="fms[folder_id]"]').val();
        var title = this_form.find('input[name="fms[title]"]').val();
        var note = this_form.find('textarea[name="fms[note]"]').val();
        var share_group = this_form.find('input[name="fms[share_group]"]').val();
        var alt = $('input[name="fms[alt]"]').val();
        var url_name = $('input[name="fms[url_name]"]').val();
        var is_private = this_form.find('input[name="fms[is_private]"]').val();
        var can_use = JSON.stringify(this_form.find('select.____select2[name="fms[can_use][]"]').val());

        //切片大小
        const chunkSize = 1024*1024*10; //1024*1024 = 1mb
        let chunkCount = Math.ceil(file.size/chunkSize); //總切片數量
        if(file=='' || chunkCount==1){
            formData.append('file', file);
            formData.append('_token', $('._token').val());
            formData.append('id', _val_id);
            formData.append('folder_level', folder_level);
            formData.append('folder_id', folder_id);
            formData.append('title', title);
            formData.append('url_name', url_name);
            formData.append('alt', alt);
            formData.append('note', note);
            formData.append('share_group', share_group);
            formData.append('is_private', is_private);
            formData.append('can_use', can_use);

            if (_val_id == undefined) {
                alert('您沒有選擇檔案喔');
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: $('.base-url').val() + '/Ajax/post-edit-files',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'text', // 回傳的資料格式
                    success: function (data) {
                        var parsedObj = JSON.parse(data);
                        console.log(parsedObj);
                        if (parsedObj.an) {
                            alert('編輯成功');
                            //如果有更新檔案
                            if (fantasy_files_uploads.length > 0 && parsedObj.data != "") {
                                var fast_table = '';
                                fast_table += ' <td class="text-center w_Check">                                                                                          ';
                                fast_table += '     <div class="tableContent">                                                                                            ';
                                fast_table += '         <label class="select-item">                                                                                       ';
                                fast_table += '             <input type="checkbox"                                                                                        ';
                                fast_table += '                 class="input_number fms_lbox_file_select_checkbox"                                                        ';
                                fast_table += '                 data-id="' + parsedObj.data['id'] + '"                                                                                               ';
                                fast_table += '                 data-src="' + parsedObj.data['real_m_route'] + '"                                                                                               ';
                                fast_table += '                 data-title="' + parsedObj.data['title'] + '"                                                                                             ';
                                fast_table += '                 data-type="' + parsedObj.data['type'] + '"                                                                                              ';
                                fast_table += '                 data-key="">                                                                                              ';
                                fast_table += '             <span class="check-circle icon-check"></span>                                                                 ';
                                fast_table += '         </label>                                                                                                          ';
                                fast_table += '     </div>                                                                                                                ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="tool_ctrl open_file_edit">                                                                                     ';
                                fast_table += '     <div class="tableMaintitle">                                                                                          ';
                                fast_table += '     <div class="title-img rwdhide ' + parsedObj.data['notImgStyle'] + '" data-src="' + parsedObj.data['real_m_route'] + '">                                                                                          ';
                                fast_table += '         <img src="' + parsedObj.data['real_m_route'] + '"  data-src="" alt="">                                                                            ';
                                fast_table += '     </div>                                                                                                                ';
                                fast_table += '         <span class="title-name bold">' + parsedObj.data['title'] + '.' + parsedObj.data['type'] + '</span>                                         ';
                                fast_table += '         <div class="cms_open_file_edit file-edit" data-id="' + parsedObj.data['id'] + '"><span class="fa fa-pencil"></span></div>';
                                fast_table += '     </div>                                                                                                                ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['type'] + '</div>                                                                    ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">檔案</div>                                                      ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['size'] + '</div>                                                              ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['img_w'] + ' x ' + parsedObj.data['img_h'] + '</div>                                                              ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['updated_at'] + '</div>                                                              ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + $(".userName").text() + '</div>                                                                                     ';
                                fast_table += ' </td>                                                                                                                     ';
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').html(fast_table);
                            }
                            //更新資料夾位置
                            //$("#folder_id").val(folder_id);
                            $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').attr('data-folder-id', folder_id);
                            if (is_delete) {
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').removeClass('is_delete');
                            }
                            if ($(".tree-title.active").hasClass('trash')) {
                                set_fms_basic(true);
                            } else {
                                set_fms_basic();
                            }
                            $(".file_edit_upload").closest('ul').find('.close_btn').click();
                            //$(".Leon_fms_table").find('.fms_list_' + $(".Select_folder_id").attr('data-id')).eq(0).before(fast_table);
                            fantasy_files_uploads = [];
                        } else {
                            alert('編輯失敗\n' + parsedObj.message);
                        }
                    }
                }).fail(function () {
                    console.log('edit error');
                });
            } 
        }// chunk==1 if
        else{
            $('.pace').show();
            let __form = document.createElement('form');
            __form.id = 'my-dropzone';
            document.body.appendChild(__form);

            let myDropzone = new Dropzone('#my-dropzone', {
                url: $('.base-url').val() + '/Ajax/post-edit-files-chunk',
                paramName: 'file', // 指定後端接收檔案的參數名稱
                maxFilesize: 10000, // 設定檔案大小上限 單位 mb
                chunkSize: chunkSize,//切片大小 1024*1024 = 1Mb
                chunking: true, // 啟用切片上傳
                forceChunking: true, // 強制切片上傳
                retryChunks: true, // 遇到錯誤是否重試上傳
                parallelUploads: 4, // 同時上傳的切片數量 多檔時才有效
                addRemoveLinks: true, // 顯示移除連結
                headers: {
                    'x-csrf-token': $('._token').val(),
                },
                init: function () {
                    //整個上傳進度剛開始時
                    // this.on("processing", function (file) {
                    //     console.log('processing')
                    // });
                    //每個切片剛開始傳送時
                    this.on("sending", function (file, xhr, formData) {
                        formData.append('file', file);
                        formData.append('_token', $('._token').val());
                        formData.append('id', _val_id);
                        formData.append('folder_level', folder_level);
                        formData.append('folder_id', folder_id);
                        formData.append('title', title);
                        formData.append('url_name', url_name);
                        formData.append('alt', alt);
                        formData.append('note', note);
                        formData.append('share_group', share_group);
                        formData.append('is_private', is_private);
                        formData.append('can_use', can_use);
                    });
                    //上傳完成
                    this.on('complete', function (file) {
                        console.log('complete')
                    });
                    //全部切片上傳成功
                    this.on('success', function (file,data) {
                        $('.pace').hide();
                        // 此處data會自動解開成物件
                        
                        //刪除上傳用的form及Dropzone產出的input
                        $('#my-dropzone').remove();
                        $('.dz-hidden-input').remove();
                        //清除已建立物件
                        Dropzone.instances.forEach((e) => {
                            e.off();
                            e.destroy();
                        });

                        parsedObj = data;
                        if (parsedObj.an) {
                            alert('編輯成功');
                            //如果有更新檔案
                            if (fantasy_files_uploads.length > 0 && parsedObj.data != "") {
                                var fast_table = '';
                                fast_table += ' <td class="text-center w_Check">                                                                                          ';
                                fast_table += '     <div class="tableContent">                                                                                            ';
                                fast_table += '         <label class="select-item">                                                                                       ';
                                fast_table += '             <input type="checkbox"                                                                                        ';
                                fast_table += '                 class="input_number fms_lbox_file_select_checkbox"                                                        ';
                                fast_table += '                 data-id="' + parsedObj.data['id'] + '"                                                                                               ';
                                fast_table += '                 data-src="' + parsedObj.data['real_m_route'] + '"                                                                                               ';
                                fast_table += '                 data-title="' + parsedObj.data['title'] + '"                                                                                             ';
                                fast_table += '                 data-type="' + parsedObj.data['type'] + '"                                                                                              ';
                                fast_table += '                 data-key="">                                                                                              ';
                                fast_table += '             <span class="check-circle icon-check"></span>                                                                 ';
                                fast_table += '         </label>                                                                                                          ';
                                fast_table += '     </div>                                                                                                                ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="tool_ctrl open_file_edit">                                                                                     ';
                                fast_table += '     <div class="tableMaintitle">                                                                                          ';
                                fast_table += '     <div class="title-img rwdhide ' + parsedObj.data['notImgStyle'] + '" data-src="' + parsedObj.data['real_m_route'] + '">                                                                                          ';
                                fast_table += '         <img src="' + parsedObj.data['real_m_route'] + '"  data-src="" alt="">                                                                            ';
                                fast_table += '     </div>                                                                                                                ';
                                fast_table += '         <span class="title-name bold">' + parsedObj.data['title'] + '.' + parsedObj.data['type'] + '</span>                                         ';
                                fast_table += '         <div class="cms_open_file_edit file-edit" data-id="' + parsedObj.data['id'] + '"><span class="fa fa-pencil"></span></div>';
                                fast_table += '     </div>                                                                                                                ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['type'] + '</div>                                                                    ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">檔案</div>                                                      ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['size'] + '</div>                                                              ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['img_w'] + ' x ' + parsedObj.data['img_h'] + '</div>                                                              ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + parsedObj.data['updated_at'] + '</div>                                                              ';
                                fast_table += ' </td>                                                                                                                     ';
                                fast_table += ' <td class="text-center">                                                                                                  ';
                                fast_table += '     <div class="tableContent">' + $(".userName").text() + '</div>                                                                                     ';
                                fast_table += ' </td>                                                                                                                     ';
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').html(fast_table);
                            }
                            //更新資料夾位置
                            //$("#folder_id").val(folder_id);
                            $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').attr('data-folder-id', folder_id);
                            if (is_delete) {
                                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').removeClass('is_delete');
                            }
                            if ($(".tree-title.active").hasClass('trash')) {
                                set_fms_basic(true);
                            } else {
                                set_fms_basic();
                            }
                            $(".file_edit_upload").closest('ul').find('.close_btn').click();
                            //$(".Leon_fms_table").find('.fms_list_' + $(".Select_folder_id").attr('data-id')).eq(0).before(fast_table);
                            fantasy_files_uploads = [];
                        } else {
                            alert('編輯失敗\n' + data['message']);
                        }
                       
                    });
                    //上傳失敗
                    this.on("error", function(file, errorMessage) {
                        alert('上傳失敗');
                    });
                }
            });

            //放入檔案即觸發傳送
            myDropzone.files = [];
            myDropzone.addFile(file);
        }
    }
});

$('body').on('click', '.file_edit_delete', function () {
    if ($(this).hasClass('cant_use')) {
        alert('你沒有權限');
        return false;
    }
    var this_form = $(".ajaxContainer.open");
    var _val_src = this_form.find('.img_box img').attr('src');
    var _val_id = this_form.find('input[name="fms[edit_id]"]').val();
    var _val_title = this_form.find('input[name="fms[title]"]').val();
    var is_delete = $(this).closest('.hiddenArea_frame_controlBtn').attr('data-delete');

    if (_val_src == '') {
        alert('刪除失敗\n您沒有選擇檔案');
        return false;
    } else {
        if (confirm('你確定要刪除 "' + _val_title + '" 檔案')) {
            $.ajax({
                type: "POST",
                url: $('.base-url').val() + '/Ajax/post-delete-files',
                data: {
                    '_token': $('._token').val(),
                    'id': _val_id,
                    'src': _val_src,
                    'is_delete': is_delete,
                },
            }).done(function (data) {
                if (data['an']) {
                    if (is_delete == "true") {
                        $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').remove();
                    } else {
                        $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + _val_id + '"]').closest('tr').addClass('is_delete');
                    }
                    $('.fms_hiddenArea').removeClass('open');
                    set_fms_basic(false);
                } else {
                    alert('刪除失敗\n' + data['message']);
                }
            }).always(function (data) { })
        }
    }
});

//更新資料夾樹及麵包屑
function syncFolderTreeAndBreadcrumb() {
    var folder_id = $("#folder_id").val();
    var fms_folder = document.getElementsByClassName('fms_folder');
    for (var i = 0; i < fms_folder.length; i++) {
        fms_folder[i].style.display = "none";
    }

    $('.fms_folder[data-folder-id="' + folder_id + '"]:not(".is_delete")').css("display", "table-row");
    $('.fms_list[data-folder-id="' + folder_id + '"]:not(".is_delete")').css("display", "table-row");
    $('.fa.fa-pencil').show();

    let open_type = $(".fms_lbox_current_btn").attr('data-type');

    $(".fms_list").remove();
    $.ajax({
        url: $('.base-url-plus').val() + '/Fantasy/Fms',
        method: "GET",
        data: {
            ajax: true,
            folder_id: folder_id,
            open_type: open_type,
        },
        dataType: 'JSON',
        cache: false,
        success: function (data) {
            $(".fms_folder").remove();
            $(".Leon_fms_table > tr:nth-child(1)").after(data.folder);
            $(".folder-tree").html(data.folder_rev);
            Leon_fms_wrapper();
            if (folder_id == '') {
                set_fms_basic(true);
            } else {
                set_fms_basic(false);
            }
        }
    });
}
//更新資料夾樹及麵包屑
function syncFolderTreeAndBreadcrumb_ori() {
    //當下資料夾位置
    var folderID = $('#folder_id').val();
    var url = $(".base-url-plus").val() + "/Fantasy/Fms/" + folderID + "?ajax=1";
    $.ajax({
        url: url,
    }).done(function (data) {
        $(".filetree").eq(1).html(data.folder_rev);
        //$(".folder-tree").html(data.folder_rev);
        $(".fms_folder").remove();
        $(".Leon_fms_table > tr:nth-child(1)").after(data.folder);
        if (data.hasUpLevel) {
            $(".Leon_fms_table > tr:nth-child(1)").show();
            $(".Leon_fms_table > tr:nth-child(1) .fms_folder_back").attr('data-id', data.nowFolderPath.parent_id);
        }
        $('body').find('.tree').fadeOut(0);
        Leon_fms_wrapper();

        if (folderID == '') {
            set_fms_basic(true);
        } else {
            set_fms_basic(false);
        }
    })
}

//檔案移動
$('body').on('click', '.file_edit_exchange', function () {
    var this_form = $(".ajaxContainer.open");
    var parent_folder_level = this_form.find('input[name="fms[parent_folder_level]"]').val();
    var parent_folder_id = this_form.find('input[name="fms[parent_folder_id]"]').val();
    var parent_branch = this_form.find('input[name="fms[parent_branch]"]').val();

    var json_file = this_form.find('input[name="fms[json_file]"]').val();
    var json_folder = this_form.find('input[name="fms[json_folder]"]').val();

    var folder_id = this_form.find('input[name="fms[folder_id]"]').val();

    $.ajax({
        type: "POST",
        url: $('.base-url').val() + '/Ajax/post-edit-files-exchange',
        data: {
            '_token': $('._token').val(),
            'parent_folder_level': parent_folder_level,
            'parent_folder_id': parent_folder_id,
            'parent_branch': parent_branch,
            'json_file': json_file,
            'json_folder': json_folder,
        },
    }).done(function (res) {
        if (res.status == 'fail') {
            alert(res.msg);
            return '';
        } else {
            alert(res.msg);
            var files = $.parseJSON($(".ajaxContainer.open").find('input[name="fms[json_file]"]').val());
            for (var i = 0; i < files.length; i++) {
                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + files[i] + '"]').click();
                $('.fms_list .fms_lbox_file_select_checkbox[data-id="' + files[i] + '"]').closest('tr').attr('data-folder-id', folder_id);
            }
            var json_folder = $.parseJSON($(".ajaxContainer.open").find('input[name="fms[json_folder]"]').val());
            for (var i = 0; i < json_folder.length; i++) {
                $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + json_folder[i] + '"]').click();
                $('.fms_folder .fms_lbox_file_select_checkbox[data-id="' + json_folder[i] + '"]').closest('tr').attr('data-folder-id', folder_id);
            }
            if (json_folder.length > 0) {
                syncFolderTreeAndBreadcrumb();
            } else {
                set_fms_basic(false);
            }
            $(".file_edit_exchange").closest('ul').find('.close_btn').click();
        }
    })
});
/*將檔案設為全域變數*/
var fantasy_files_uploads = [];
var fantasy_files_keys = [];
var fantasy_files_count = 0;
var temp_count = 0;
$('body').on('change', 'input.fileInputClick', function (e) {
    temp_count = 0;
    var files = e.currentTarget.files;
    /*顯示圖片在區塊上*/
    for (var i = 0; i < files.length; i++) {
        var randKey = randomWord(false, 3) + fantasy_files_count;
        fantasy_files_uploads[fantasy_files_count] = files[i];
        fantasy_files_keys[fantasy_files_count] = randKey;
        showFilesInHtml(files[i], randKey, fantasy_files_count, 'multiple', files.length);
        fantasy_files_count++;
    }

    $(".fileInputClick").val('');
});
$('body').on('change', 'input.fileInputClick_one', function (e) {
    var files = e.currentTarget.files;
    /*顯示圖片在區塊上*/
    fantasy_files_uploads = [];
    fantasy_files_keys = [];
    fantasy_files_count = 0;
    for (var i = 0; i < files.length; i++) {
        var randKey = randomWord(false, 3) + fantasy_files_count;
        fantasy_files_uploads[0] = files[i];
        fantasy_files_keys[0] = randKey;
        showFilesInHtml(files[i], randKey, 0, 'one', files.length);
    }
    $(".fileInputClick_one").val('');
});

function drop_image(e) {
    e.preventDefault();
    var files = e.dataTransfer.files;
    /*顯示圖片在區塊上*/
    for (var i = 0; i < files.length; i++) {
        var randKey = randomWord(false, 3) + fantasy_files_count;
        fantasy_files_uploads[fantasy_files_count] = files[i];
        fantasy_files_keys[fantasy_files_count] = randKey;
        showFilesInHtml(files[i], randKey, fantasy_files_count, 'multiple', files.length);
        fantasy_files_count++;
    }
}

function drop_image_one(e) {
    e.preventDefault();
    var files = e.dataTransfer.files;
    /*顯示圖片在區塊上*/
    fantasy_files_uploads = [];
    fantasy_files_keys = [];
    fantasy_files_count = 0;
    for (var i = 0; i < files.length; i++) {
        var randKey = randomWord(false, 3) + fantasy_files_count;
        fantasy_files_uploads[0] = files[i];
        fantasy_files_keys[0] = randKey;
        showFilesInHtml(files[i], randKey, 0, 'one', files.length);
    }
}
$('body').on('click', '.fileUploadClick', function () {
    $(this).closest('li').find('.fileInputClick').click();
});
$('body').on('click', '.fileUploadClick_one', function () {
    $(this).closest('li').find('.fileInputClick_one').click();
});

/*擋住直接開圖片*/
function dragHandler(e) {
    e.preventDefault();
}
//檔案上傳預覽資料
function showFilesInHtml(file, key, index, action, count) {

    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (e) {
        if (file.size > 1048576 * 64) {
            var num = file.size / 1048576,
                _this_size = num.toFixed(2) + ' MB';

            var html = '<li class="list" data-key="' + key + '" data-index="' + index + '">';
            html += '<div class="list_title option">';
            html += '<div class="list_img">';
            html += '<img src="" alt="">';
            html += '</div>';
            html += '<p>' + file.name + ',檔案超過限制大小</p>';
            html += '</div>';
            html += '<div class="list_capacity option">';
            html += '<p>' + _this_size + '</p>';
            html += '</div>';
            html += '<div class="list_tool option">';
            // html += '<span class="icon fa fa-pencil-square-o"></span>';
            html += '<span class="icon fa fa-trash upload_list_delete"></span>';
            html += '</div>';
            html += '</li>';
            $('.locale_file_list').append(html);
            fantasy_files_uploads[index] = '';
            fantasy_files_keys[index] = '';
            return false;
        } else if (file.size > 1048576) {
            var num = file.size / 1048576,
                _this_size = num.toFixed(2) + ' MB';
        } else {
            var num = file.size / 1024,
                _this_size = num.toFixed(2) + ' KB';
        }

        var ext = file.name.split(".");
        ext = ext[ext.length - 1].toLowerCase();
        var arrayExtensions = ["svg", "ai", "avi", "css", "doc", "docx", "ppt", "pptx", "eps", "gif", "jpg", "html", "mov", "mp3", "pdf", "psd", "rar", "zip", "txt", "wav", "jpeg", "xls", "xlsx", "png", "bmp", "gif", "mpg", "mp4", "webm", "json", "dwg"];
        if (arrayExtensions.lastIndexOf(ext) == -1) {
            var html = '<li class="list" data-key="' + key + '" data-index="' + index + '">';
            html += '<div class="list_title option">';
            html += '<div class="list_img">';
            html += '<img src="" alt="">';
            html += '</div>';
            html += '<p>' + file.name + ',此檔案不符合規定類型</p>';
            html += '</div>';
            html += '<div class="list_capacity option">';
            html += '<p>' + _this_size + '</p>';
            html += '</div>';
            html += '<div class="list_tool option">';
            // html += '<span class="icon fa fa-pencil-square-o"></span>';
            html += '<span class="icon fa fa-trash upload_list_delete"></span>';
            html += '</div>';
            html += '</li>';
            if (action == 'one') {
                $('.locale_file_list_one').html(html);
            } else {
                $('.locale_file_list').append(html);
            }
            fantasy_files_uploads[index] = '';
            fantasy_files_keys[index] = '';
            return false;
        }
        var _this_image = '/vender/assets/img/icon/' + ext + '.png';
        if (file.type.match('image')) {
            _this_image = e.target.result;
        }

        var html = '<li class="list" data-key="' + key + '" data-index="' + index + '">';
        html += '<div class="list_title option">';
        html += '<div class="list_img">';
        html += '<img src="' + _this_image + '" alt="">';
        html += '</div>';
        html += '<p>' + file.name + '</p>';
        html += '</div>';
        html += '<div class="list_capacity option">';
        html += '<p>' + _this_size + '</p>';
        html += '</div>';
        html += '<div class="list_tool option">';
        // html += '<span class="icon fa fa-pencil-square-o"></span>';
        html += '<span class="icon fa fa-trash upload_list_delete"></span>';
        html += '</div>';
        html += '</li>';

        if (action == 'one') {
            $('.locale_file_list_one').html(html);
        } else {
            $('.locale_file_list').append(html);
        }
        var html_uploading = '<li class="list" data-key="' + key + '" data-index="' + index + '">';
        html_uploading += '<div class="list_title option">';
        html_uploading += '<div class="list_img">';
        html_uploading += '<img src="' + _this_image + '" alt="">';
        html_uploading += '</div>';
        html_uploading += '<p>' + file.name + '</p>';
        html_uploading += '</div>';
        html_uploading += '<div class="list_capacity option">';
        html_uploading += '<p>' + _this_size + '</p>';
        html_uploading += '</div>';
        html_uploading += '<div class="list_tool option">';
        html_uploading += '<div class="circle_pace circle_' + key + '"></div>';
        html_uploading += '</div>';
        html_uploading += '</li>';
        if (action == 'one') {
            $('.upload_file_list_one').append(html_uploading);
        } else {
            $('.upload_file_list').append(html_uploading);
        }
        temp_count++;
        if (temp_count >= count) {
            $('.editorBody.scroll-content').animate({
                scrollTop: 780
            }, 200);
        }
    }
}
$('body').on('click', 'span.upload_list_delete', function () {
    var _this = $(this);
    var _this_parent_li = _this.parent('div').parent('li');
    var _this_key = _this_parent_li.data('key');
    var _this_index = _this_parent_li.data('index');

    _this_parent_li.remove();
    //檔案給空值
    fantasy_files_uploads[_this_index] = "";
    //fantasy_files_uploads.splice(_this_index, 1);
    $('.upload_file_list').children('li.list').each(function (index, el) {
        var _this_list = $(this);
        var _this_list_key = _this_list.data('key');

        if (_this_list_key == _this_key) {
            _this_list.remove();
        }
    });
});

$('body').on('click', '.localeToServer', function () {
    /*計算能上傳檔案的數量*/
    var uploads_count = $('.upload_file_list').children('li.list').length;
    if (uploads_count < 1) {
        alert('未新增檔案');
    } else {
        for (var i = 0; i < fantasy_files_uploads.length; i++) {
            var className = '.circle_' + fantasy_files_keys[i];
            $(className).quillCircleBar({
                type: 'normal'
            });
        }
        $('.total_pace').quillCircleBar({
            type: 'total'
        });
        $('.total_pace').quillCircleBar({
            type: 'total',
            number: 0,
            baseNumber: uploads_count
        });
        $(".uploaded_files").empty();
        $('form.fmsUpload').removeClass('open active');
        $('form.fmsUpload_ing').addClass('open');
        checkWhatFileNotUpload();
    }
});

function checkWhatFileNotUpload() {
    var uploads_count = $('.upload_file_list').children('li.list').length;
    var okFiles = [];
    var current_i = -1;
    $('.upload_file_list').children('li.list').each(function (index, el) {
        var _this = $(this),
            _this_key = _this.attr('data-key');
        if (_this_key != '') {
            if (!_this.hasClass('upload_ok') && !_this.hasClass('upload_error')) {
                if (current_i == -1) {
                    for (var i = fantasy_files_uploads.length; i >= 0; i--) {
                        if (_this_key == fantasy_files_keys[i]) {
                            current_i = i;
                            break;
                        }
                    }
                }
            } else {
                okFiles.push(_this_key);
            }
            $('.total_pace').quillCircleBar({
                type: 'total',
                number: okFiles.length,
                baseNumber: uploads_count
            });
        }
    });

    if (current_i != -1) {
        postFilesToServer(fantasy_files_uploads[current_i], fantasy_files_keys[current_i]);
    } else {
        // set_fms_basic(false);
        let Select_folder_id = $(".Select_folder_id").attr('data-id');
        if (Select_folder_id != $("#folder_id").val()) {
            $('.tree-title[data-folder-id="' + Select_folder_id + '"]').click();
        } else {
            //把上傳的資料塞到表格
            var fast_table = '';
            $('.uploaded_files').children('li.list').each(function (index, el) {

                var _this = $(this);
                var _img_wh = '';
                if (_this.attr('data-imgw') != '') {
                    _img_wh = _this.attr('data-imgw') + ' x ' + _this.attr('data-imgh');
                }
                if (_this.hasClass('upload_ok')) {
                    fast_table += '<tr class="tbody_tick fms_list fms_list_' + $(".Select_folder_id").attr('data-id') + ' can_use" data-folder-id="' + $(".Select_folder_id").attr('data-id') + '" style="cursor: pointer;">';
                    fast_table += ' <td class="text-center w_Check">                                                                                          ';
                    fast_table += '     <div class="tableContent">                                                                                            ';
                    fast_table += '         <label class="select-item">                                                                                       ';
                    fast_table += '             <input type="checkbox"                                                                                        ';
                    fast_table += '                 class="input_number fms_lbox_file_select_checkbox"                                                        ';
                    fast_table += '                 data-id="' + _this.attr('data-id') + '"                                                                                               ';
                    fast_table += '                 data-src="' + _this.attr('data-src') + '"                                                                                               ';
                    fast_table += '                 data-title="' + _this.children('div.list_title').text() + '"                                                                                             ';
                    fast_table += '                 data-type="' + _this.attr('data-type') + '"                                                                                              ';
                    fast_table += '                 data-key="' + _this.attr('data-key') + '">                                                                                              ';
                    fast_table += '             <span class="check-circle icon-check"></span>                                                                 ';
                    fast_table += '         </label>                                                                                                          ';
                    fast_table += '     </div>                                                                                                                ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += ' <td class="tool_ctrl open_file_edit">                                                                                     ';
                    fast_table += '     <div class="tableMaintitle">                                                                                          ';
                    fast_table += '     <div class="title-img rwdhide">                                                                                          ';
                    fast_table += '         <img src="' + _this.find('div.list_title .list_img img').attr('src') + '" data-src="" alt="">                                                                            ';
                    fast_table += '     </div>                                                                                                                ';

                    fast_table += '         <span class="title-name bold">' + _this.children('div.list_title').text() + '</span>                                         ';
                    fast_table += '         <div class="cms_open_file_edit file-edit" data-id="' + _this.attr('data-id') + '"><span class="fa fa-pencil"></span></div>';
                    fast_table += '     </div>                                                                                                                ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += ' <td class="text-center">                                                                                                  ';
                    fast_table += '     <div class="tableContent">' + _this.attr('data-type') + '</div>                                                                    ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += ' <td class="text-center">                                                                                                  ';
                    fast_table += '     <div class="tableContent">檔案</div>                                                      ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += ' <td class="text-center">                                                                                                  ';
                    fast_table += '     <div class="tableContent">' + _this.children('div.list_capacity').text() + '</div>                                                              ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += ' <td class="text-center">                                                                                                  ';
                    fast_table += '     <div class="tableContent">' + _img_wh + '</div>                                                              ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += ' <td class="text-center">                                                                                                  ';
                    fast_table += '     <div class="tableContent">' + _this.attr('data-updated') + '</div>                                                              ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += ' <td class="text-center">                                                                                                  ';
                    fast_table += '     <div class="tableContent">' + $(".userName").text() + '</div>                                                                                     ';
                    fast_table += ' </td>                                                                                                                     ';
                    fast_table += '</tr>                                                                                                                      ';
                }
            });

            if ($(".Leon_fms_table").find('.fms_list_' + $(".Select_folder_id").attr('data-id')).length > 0) {
                $(".Leon_fms_table").find('.fms_list_' + $(".Select_folder_id").attr('data-id')).eq(0).before(fast_table);
            } else {
                $(".Leon_fms_table").append(fast_table);
            }
        }


        $('.upload_file_list').empty();
        $('.locale_file_list').empty();
        $('form.fmsUpload_ing').removeClass('open active');
        $('form.fmsUpload_done').addClass('open');

        if ($('li.leon_5566_123.upload_error').length > 0) {
            $('.fmsUpload_done .upload_frame_info .info_box p').last().html('上傳失敗');
        } else {
            $('.fmsUpload_done .upload_frame_info .info_box p').last().html('上傳已完成');
        }
    }
}
//上傳檔案
function postFilesToServer(file, key) {
    //切片大小
    const chunkSize = 1024*1024*10; //1024*1024 = 1mb
    let chunkCount = Math.ceil(file.size/chunkSize); //總切片數量

    if(chunkCount==1){
        var formData = new FormData(); //建構new FormData()
        formData.append('file', file);
        formData.append('key', key);
        formData.append('folder_id', $(".Select_folder_id").attr('data-id'));
        formData.append('branch', 1);
        formData.append('is_private', $("#is_private").val());
        formData.append('can_use', JSON.stringify($("#can_use").val()));

        $.ajax({
            type: "POST",
            url: $('.base-url').val() + '/Ajax/post-files-fms',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'text', // 回傳的資料格式
            success: function (data) {
                var parsedObj = JSON.parse(data);
                if (parsedObj.an) {
                    UploadAfterDo('upload_ok', key, parsedObj.data);
                } else {
                    UploadAfterDo('upload_error', key, '');
                }
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest(); // 建立xhr(XMLHttpRequest)物件
                xhr.upload.addEventListener("progress", function (progressEvent) { // 監聽ProgressEvent
                    if (progressEvent.lengthComputable) {
                        var percentComplete = progressEvent.loaded / progressEvent.total;
                        var percentVal = Math.round(percentComplete * 100) + "%";
                        var className = '.circle_' + key;
                        $(className).quillCircleBar({
                            type: 'normal',
                            number: percentVal
                        });
                    }
                }, false);
                return xhr; // 注意必須將xhr(XMLHttpRequest)物件回傳
            }
        }).fail(function () {
            UploadAfterDo('upload_error', key, '');
        });
    }
    else{
        let __form = document.createElement('form');
        __form.id = 'my-dropzone';
        document.body.appendChild(__form);

        let myDropzone = new Dropzone('#my-dropzone', {
            url: $('.base-url').val() + '/Ajax/post-files-fms-chunk',
            paramName: 'file', // 指定後端接收檔案的參數名稱
            maxFilesize: 10000, // 設定檔案大小上限 單位 mb
            chunkSize: chunkSize,//切片大小 1024*1024 = 1Mb
            chunking: true, // 啟用切片上傳
            forceChunking: true, // 強制切片上傳
            retryChunks: true, // 遇到錯誤是否重試上傳
            parallelUploads: 4, // 同時上傳的切片數量 多檔時才有效
            addRemoveLinks: true, // 顯示移除連結
            headers: {
                'x-csrf-token': $('._token').val(),
            },
            init: function () {
                //整個上傳進度剛開始時
                // this.on("processing", function (file) {
                //     console.log('processing')
                // });
                //每個切片剛開始傳送時
                this.on("sending", function (file, xhr, formData) {
                    formData.append('key', key);
                    formData.append('folder_id', $(".Select_folder_id").attr('data-id'));
                    formData.append('branch', 1);
                    formData.append('is_private', $("#is_private").val());
                    formData.append('can_use', JSON.stringify($("#can_use").val()));
                    //當前切片位置
                    let currentChunkIndex = file.upload.chunks.length*1;
                    let allChunk = file.upload.totalChunkCount*1;
                    if(currentChunkIndex>0) currentChunkIndex--;
                    percentVal = Math.round(currentChunkIndex/allChunk * 100) + "%";
                    let className = '.circle_' + key;
                    $(className).quillCircleBar({
                        type: 'normal',
                        number: percentVal
                    });
                });
                //上傳完成
                this.on('complete', function (file) {
                    console.log('complete')
                });
                //全部切片上傳成功
                this.on('success', function (file,response) {
                    //進度百分比顯示
                    let className = '.circle_' + key;
                    $(className).quillCircleBar({
                        type: 'normal',
                        number: '100%'
                    });
                    //刪除上傳用的form及Dropzone產出的input
                    $('#my-dropzone').remove();
                    $('.dz-hidden-input').remove();
                    //清除已建立物件
                    Dropzone.instances.forEach((e) => {
                        e.off();
                        e.destroy();
                    });
                    //原有的上傳方法，觸發下一個檔案上傳
                    let parsedObj = response;
                    if (parsedObj.an) {
                        UploadAfterDo('upload_ok', key, parsedObj.data);
                    } else {
                        UploadAfterDo('upload_error', key, '');
                    }
                });
                //上傳失敗
                this.on("error", function(file, errorMessage) {
                    UploadAfterDo('upload_error', key, '');
                });
            }
        });

        //放入檔案即觸發傳送
        myDropzone.files = [];
        myDropzone.addFile(file);
    }
}

function UploadAfterDo(upload_state, key, data) {
    $('.upload_file_list').children('li.list').each(function (index, el) {
        var _this = $(this);
        var _this_key = _this.attr('data-key');
        if (key == _this_key) {
            for (var i = fantasy_files_uploads.length; i >= 0; i--) {
                if (_this_key == fantasy_files_keys[i]) {
                    //fantasy_files_uploads[i] = "";
                    _this.addClass(upload_state);
                    _this.children('div.list_tool').empty();
                    _this.children('div.list_tool').append('<span class="icon fa fa-check"></span>');
                    //補上清單
                    var _this_html = '';
                    _this_html = '<li class="leon_5566_123 list ' + upload_state + '"data-key="' + data.file_key + '" data-id="' + data.id + '" data-src="' + data.real_route + '" data-type="' + data.type + '" data-updated="' + data.updated_at + '" data-imgw="' + data.img_w + '" data-imgh="' + data.img_h + '"><div class="list_title option"><div class="list_img">';
                    _this_html += '<img src="' + _this.find('div.list_title .list_img img').attr('src') + '" alt="">';
                    _this_html += '</div>';
                    _this_html += '<p>' + _this.children('div.list_title').text() + '</p>';
                    _this_html += '</div>';
                    _this_html += '<div class="list_capacity option">';
                    _this_html += '<p>' + _this.children('div.list_capacity').text() + '</p>';
                    _this_html += '</div>';
                    _this_html += '<div class="list_tool option">';
                    if (upload_state == 'upload_ok') {
                        _this_html += '<span class="icon fa fa-check"></span>';
                    } else {
                        _this_html += '<span>失敗</span>';
                    }
                    _this_html += '</div>';
                    _this_html += '</li>';
                    $('.uploaded_files').append(_this_html);
                }
            }
        }
    });
    checkWhatFileNotUpload();
}
