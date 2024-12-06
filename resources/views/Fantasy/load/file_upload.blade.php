<!-- 右邊滑動的 隱藏區塊1213 -->
<article class="hiddenArea fms_hiddenArea uploadArea fmsDetailAjaxArea fms_theme">
    <!--FILE UPLOAD 檔案上傳-->
    <div class="ajaxItem fms">
        <form action="" class="fmsUpload ajaxContainer">
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
                                <li class="inventory row_style">
                                    <div class="title">
                                        <p class="subtitle">資料夾是否設為私人</p>
                                    </div>
                                    <div class="inner">
                                        <div class="inner_box row_style">
                                            <div class="switch_box">
                                                <div class="ios_switch mrg-l-30">
                                                    <input type="checkbox" id="is_private" value="0">
                                                    <div class="box fms_switch_ball">
                                                        <span class="ball"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                @php
                                if(isset($selfFolder['can_use'])){
                                $tempCanUse = json_decode($selfFolder['can_use']);
                                if(empty($tempCanUse)) $tempCanUse = [];
                                }
                                else $tempCanUse = [];
                                $all_owner = (isset($all_owner)) ? $all_owner : [];
                                @endphp

                                @if(isset($selfFolder['is_private']) && $selfFolder['is_private']==1)
                                <li class="inventory row_style auth_group">
                                    @else
                                <li class="inventory row_style auth_group" style="display: none;">
                                    @endif
                                    <div class="title">
                                        <p class="subtitle">使用者權限</p>
                                    </div>
                                    <div class="inner">
                                        <select class="____select2 valid" id="can_use" name="fms[can_use][]" aria-invalid="false" multiple="multiple">
                                            @foreach ($all_owner as $row)

                                            <option value="{{ $row['id'] }}" @if(isset($selfFolder['can_use']) && in_array($row['id'],$tempCanUse ) ) selected @endif>
                                                {{ $row['name'] }}
                                            </option>

                                            @endforeach
                                        </select>
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
        </form>
        <!--FILE UPLOAD 檔案上傳-上傳進行中-->
        <form action="" class="fmsUpload_ing ajaxContainer">
            <div class="">
                <!-- <div class="hiddenArea_frame uploadArea_frame"> -->
                <!-- <div class="hiddenArea_frame_box"> -->
                <div class="detailEditor">
                    <div class="editorBody">
                        <div class="editorHeader">
                            <div class="info">
                                <div class="title">
                                    <p>FILE UPLOAD 檔案上傳-上傳進行中</p>
                                </div>
                                <div class="area">
                                    {{-- <h3>請依下列步驟進行操作</h3> --}}
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
                                <li class="inventory fileUpload upload_box uploading">
                                    <p class="subtitle fms_area_name"><span class="icon fa fa-folder"></span></p>
                                    <div class="upload_frame">
                                        <div class="upload_frame_info">
                                            <div class="center_box">
                                                <div class="total_pace"></div>
                                            </div>
                                            {{--   <div class="info_box">
                                            <p>大約還需要 5分鐘</p>
                                            </div> --}}
                                        </div>
                                    </div>
                                    {{--    <div class="tips">
                                    <span class="title">TIPS</span>
                                    <p>上傳進行中你可將視窗關閉，上傳作業將會在背景持續進行，你可以隨時打開視窗確認進度。</p>
                                    </div> --}}
                                </li>
                                <li class="inventory fileUpload">
                                    <ul class="upload_list upload_file_list">
                                        {{-- 上傳清單 --}}
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <!-- </div> -->
            </div>
        </form>
        <!--FILE UPLOAD 檔案上傳-上傳完成-->
        <form action="" class="fmsUpload_done ajaxContainer">
            <div class="">
                <!-- <div class="hiddenArea_frame uploadArea_frame"> -->
                <!-- <div class="hiddenArea_frame_box"> -->
                <div class="detailEditor">
                    <div class="editorBody">
                        <div class="editorHeader">
                            <div class="info">
                                <div class="title">
                                    <p>FILE UPLOAD 檔案上傳-上傳完成</p>
                                </div>
                                <div class="area">
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
                                <li class="inventory fileUpload upload_box">
                                    <ul class="subtitle fms_area_name"></ul>
                                    <div class="upload_frame">
                                        <div class="upload_frame_info">
                                            <div class="center_box">
                                                <span class="tick fa fa-check"></span>
                                            </div>
                                            <div class="info_box">
                                                <p class="en">Upload Completed</p>
                                                <p>上傳已完成</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="inventory fileUpload">
                                    <ul class="upload_list uploaded_files">
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="hiddenArea_frame_controlBtn">
                    <ul class="btnGroup">
                        <li class="remove">
                            <a href="javascript:void(0)" class="close_btn">
                                <span class="fa fa-remove"></span>
                                <p>CANCEL</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- </div> -->
                <!-- </div> -->
            </div>
        </form>
        <!--ADD FOLDER 新增資料夾-->
        <form action="" class="fmsFolderDetail ajaxContainer">
        </form>
        <!--ADD FOLDER 新增資料夾-->
        <form action="" class="fmsFolder_add ajaxContainer">
        </form>
        <!--EDIT FOLDER 編輯資料夾資訊-->
        <form action="" class="fmsFolder_edit ajaxContainer">
        </form>
        <!--FILE INFORMATION 檔案資訊-->
        <form action="" class="fmsDetail ajaxContainer">
        </form>
        <!--EDIT FILE 編輯檔案資訊-->
        <form action="" class="fmsDetail_edit ajaxContainer">
        </form>
        <!--SEARCH FILE 進階檔案搜尋-->
        <form action="" class="fmsSearch ajaxContainer">
        </form>
        <!--FILE NEW 檔案-->
        <form action="" class="locale_folder_new ajaxContainer">
            <div class="">
                <div class="hiddenArea_frame uploadArea_frame">
                    <div class="hiddenArea_frame_box">
                        <div class="detailEditor">
                            <div class="editorBody">
                                <div class="editorHeader">
                                    <div class="info">
                                        <div class="title">
                                            <p>FILE UPLOAD 檔案上傳</p>
                                            <div class="remove">
                                                <a href="javascript:;" class="close_btn">
                                                    <span class="fa fa-remove"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="box_block_frame">
                                    <li class="inventory fileUpload">
                                        <p class="subtitle"><span class="en_title">step1.</span>
                                            選擇新增的資料夾位置{{-- <span class="upload_icon fa fa-cloud-upload"></span> --}}</p>
                                        <div class="">
                                            <div class="select_object">
                                                <p class="subtitle fms_area_name"><span class="icon fa fa-folder"></span></p>
                                            </div>
                                            <div class="select_wrapper">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="inventory row_style">
                                        <div class="title">
                                            <p class="subtitle">資料夾名稱</p>
                                        </div>
                                        <div class="inner">
                                            <input class="normal_input" type="text" placeholder="資料夾名稱" name="newFolder">
                                            <div class="tips">
                                                <span class="title">TIPS</span>
                                                <p>單行輸入，輸入特殊符號如 : @#$%?/\|*及全形也盡量避免。</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--區塊功能按鈕-->
                    <div class="hiddenArea_frame_controlBtn">
                        <ul class="btnGroup">
                            <li class="check">
                                <a href="javascript:void(0)" class="localeToNewFolder">
                                    <span class="fa fa-cloud-upload"></span>
                                    <p>NEW</p>
                                </a>
                            </li>
                            <li class="remove">
                                <a href="javascript:void(0)" class="close_btn">
                                    <span class="fa fa-remove"></span>
                                    <p>CANCEL</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <!--FILE NAME 改檔案名子-->
        <form action="" class="locale_folder_name ajaxContainer">
            <div class="">
                <div class="hiddenArea_frame uploadArea_frame">
                    <div class="hiddenArea_frame_box">
                        <div class="detailEditor">
                            <div class="editorBody">
                                <div class="editorHeader">
                                    <div class="info">
                                        <div class="title">
                                            <p>FILE NAME 修改名稱</p>
                                            <div class="remove">
                                                <a href="javascript:;" class="close_btn">
                                                    <span class="fa fa-remove"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="box_block_frame">
                                    <li class="inventory fileUpload">
                                        <p class="subtitle">
                                            <span class="en_title">step1.</span>
                                            選擇資料夾{{-- <span class="upload_icon fa fa-cloud-upload"></span> --}}
                                        </p>
                                        <div class="">
                                            <div class="select_object">
                                                <p class="subtitle fms_area_name"><span class="icon fa fa-folder"></span></p>
                                            </div>
                                            <div class="select_wrapper">
                                            </div>
                                        </div>
                                    </li>
                                    <li class="inventory row_style">
                                        <div class="title">
                                            <p class="subtitle">資料夾名稱</p>
                                        </div>
                                        <div class="inner">
                                            <input class="normal_input" type="text" placeholder="資料夾名稱" name="nameFolder">
                                            <div class="tips">
                                                <span class="title">TIPS</span>
                                                <p>單行輸入，輸入特殊符號如 : @#$%?/\|*及全形也盡量避免。</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--區塊功能按鈕-->
                    <div class="hiddenArea_frame_controlBtn">
                        <ul class="btnGroup">
                            <li class="check">
                                <a href="javascript:void(0)" class="localeToNameFolder">
                                    <span class="fa fa-cloud-upload"></span>
                                    <p>CHANGE</p>
                                </a>
                            </li>
                            <li class="remove">
                                <a href="javascript:void(0)" class="close_btn">
                                    <span class="fa fa-remove"></span>
                                    <p>CANCEL</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</article>
<!-- 燈箱圖片 -->
<article class="light_box_img chImgLightBox">
    <div class="for_scroll">
        <div class="inner_box" style="display: flex; align-items: center; justify-content: center;">
            <div class="img">
                <img src="" alt="" class="img_show_lbox">
                <div class="close_btn close_img_box">
                    <span class="fa fa-remove"></span>
                </div>
            </div>
        </div>
    </div>
</article>
<!-- 燈箱圖片 -->
