<div class="backEnd_quill">
    <div class="detailEditor">
        <div class="editorBody">
            <div class="editorHeader">
                <div class="info">
                    <div class="title">
                        <p>{{ $area_title }}</p>
                    </div>
                    <div class="area">
                        <h3>共選取 {{ $allCount }} 個檔案</h3>
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
            <input type="hidden" name="fms[folder_id]" value="{{ $folder_id }}">
            <input type="hidden" name="fms[parent_folder_id]" value="{{ $parent['id'] }}">
            <input type="hidden" name="fms[parent_folder_level]" value="{{ $parent['self_level'] }}">
            <input type="hidden" name="fms[parent_branch]" value="{{ $parent['branch_id'] }}">
            <input type="hidden" name="fms[json_file]" value="{{ $file_id_json }}">
            <input type="hidden" name="fms[json_folder]" value="{{ $folder_id_json }}">
            <div class="editorContent">
                <ul class="box_block_frame">

                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">檔案目錄位置</p>
                        </div>
                        <div class="inner">
                            <div class="select_Box" data-type="path">
                                <div class="select_Btn" data-id="0">
                                    <p class="title">{{ $nowFolderPathText }}</p>
                                    <i class="arrow pg-arrow_down"></i>
                                </div>
                                <ul class="option_list" data-id="0" data-level="-1">
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

                </ul>
            </div>
        </div>
    </div>
    <!--區塊功能按鈕-->
    <div class="hiddenArea_frame_controlBtn">
        <ul class="btnGroup">
            <li class="check file_edit_exchange">
                <a href="javascript:void(0)">
                    <span class="fa fa-check"></span>
                    <p>SETTING</p>
                </a>
            </li>
            {{-- <li class="trash file_edit_delete">
                <a href="javascript:void(0)">
                    <span class="fa fa-trash"></span>
                    <p>DELETE</p>
                </a>
            </li> --}}
            <li class="remove">
                <a href="javascript:void(0)" class="close_btn">
                    <span class="fa fa-remove"></span>
                    <p>CANCEL</p>
                </a>
            </li>
        </ul>
    </div>
</div>