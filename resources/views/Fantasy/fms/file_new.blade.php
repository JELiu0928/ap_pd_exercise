<div class="">
    <!-- <div class="hiddenArea_frame uploadArea_frame"> -->
    <!-- <div class="hiddenArea_frame_box"> -->
    <div class="detailEditor">
        <div class="editorBody">
            <div class="editorHeader">
                <div class="info">
                    <div class="title">
                        <p>FILE UPLOAD 檔案上傳</p>
                    </div>
                    <div class="area">
                        <h3>請依下列步驟進行操作</h3>
                        <div class="control">
                            <ul class="btnGroup">
                                <li class="remove">
                                    <a href="javascript:;" class="close_btn">
                                        <span class="fa fa-remove"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="editorContent">
                <ul class="box_block_frame">
                    <li class="inventory row_style">
                        <p class="subtitle"><span class="en_title">step1.</span>選擇檔案上傳的資料夾位置</p>
                        <div class="inner">
                            <div class="select_Box" data-type="path">
                                <div class="select_Btn Select_folder_id" data-id="0">
                                    <p class="title">資料夾位置</p>
                                    <i class="arrow pg-arrow_down"></i>
                                </div>
                                <ul class="option_list Leon_option_list" data-id="0" data-level="-1">
                                    {{-- 所有資料夾 --}}
                                    @include('Fantasy.fms.folder_all_select')
                                </ul>
                            </div>
                            <div class="tips">
                                <span class="title">TIPS</span>
                                <p>你可以指定檔案的資料夾位置。</p>
                            </div>
                        </div>
                    </li>
                    <li class="inventory fileUpload upload_box">
                        <input type="file" name="file[]" style="display:none;" class="fileInputClick" multiple>
                        <p class="subtitle">
                            <span class="en_title">step2.</span> 選擇要上傳的檔案
                        </p>
                        <div class="upload_frame fileUploadClick" ondrop="javascript: drop_image(event);" ondragover="javascript: dragHandler(event);">
                            <div class="upload_frame_info">
                                <div class="center_box">
                                    <span class="fa fa-cloud-upload"></span>
                                </div>
                                <div class="info_box">
                                    <p class="en">Press or Drag Files to Here</p>
                                    <p>按下按鈕或拖曳檔案到這裡</p>
                                </div>
                            </div>
                        </div>
                        <div class="tips">
                            <span class="title">TIPS</span>
                            <p>你可以選擇多個檔案上傳，也可以直接將檔案拖曳到區塊中 ( <span style="color:#ff0000;">拖曳功能只支援
                                    Chrome</span> )，預設的檔案上傳容量為
                                15MB，若你需要更大的上傳容量，請與開發者聯繫。</p>
                        </div>
                    </li>
                    <li class="inventory fileUpload">
                        <p class="subtitle">
                            <span class="en_title">step3.</span> 確認檔案上傳清單
                        </p>
                        <ul class="upload_list locale_file_list">
                            <!--待上傳列表-->
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <!--區塊功能按鈕-->
    <div class="hiddenArea_frame_controlBtn">
        <ul class="btnGroup">
            <li class="check">
                <a href="javascript:void(0)" class="localeToServer">
                    <span class="fa fa-cloud-upload"></span>
                    <p>UPLOAD</p>
                </a>
            </li>
        </ul>
    </div>
    <!-- </div> -->
</div>