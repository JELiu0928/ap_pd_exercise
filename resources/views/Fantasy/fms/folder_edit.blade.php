<div class="backEnd_quill">
    <div class="detailEditor">
        <div class="editorBody">
            <div class="editorHeader">
                <div class="info">
                    <div class="title">
                        <p>{{ $area_title }}</p>
                    </div>
                    <div class="area">
                        <h3>{{ $folder['title']}}</h3>
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
            <input type="hidden" name="fms[folder_id]" value="{{$folder['id']}}">
            <div class="editorContent">
                <ul class="box_block_frame">
                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">資料夾名稱</p>
                        </div>
                        <div class="inner">
                            <input class="normal_input" name="fms[title]" type="text" placeholder="" value="{{ $folder['title']}}">
                            <div class="tips">
                                <span class="title">TIPS</span>
                                <p>單行輸入，輸入特殊符號如 : @#$%?/\|*及全形也盡量避免。</p>
                            </div>
                        </div>
                    </li>
                    {{-- @if($File['id']=='0')  --}}
                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">檔案目錄位置</p>
                        </div>
                        <div class="inner">
                            <div class="select_Box" data-type="path">
                                <div class="select_Btn Select_folder_id" data-id="0">
                                    <p class="title">{{ $nowFolderPathText }}</p>
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
                    {{-- @endif --}}
                    {{-- 權限功能，Honda交給你惹! --}}
                    @if($folder['id']!='0')
                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">最後異動時間</p>
                        </div>
                        <div class="inner">
                            <div class="file_date">
                                @if(!empty($last_edit_user))
                                <p class="name">{{$last_edit_user['name']??'N/A'}},</p>
                                <p>在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($folder['updated_at'])) }} 修改過</p>
                                @else
                                <p class="name">{{$owner['name']??'N/A'}},</p>
                                <p>在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($folder['updated_at'])) }} 修改過</p>
                                @endif
                            </div>
                            <div class="tips">
                                <span class="title">TIPS</span>
                                <p>不開放修改，由系統自行更新。</p>
                            </div>
                        </div>
                    </li>
                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">建立日期</p>
                        </div>
                        <div class="inner">
                            <div class="file_date">
                                <p class="name">{{$owner['name']??'N/A'}},</p>
                                <p>在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($folder['created_at'])) }} 建立</p>
                            </div>
                            <div class="tips">
                                <span class="title">TIPS</span>
                                <p>不開放修改，由系統自行更新。</p>
                            </div>
                        </div>
                    </li>
                    @endif
                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">擁有者</p>
                        </div>
                        <div class="inner">
                            <div class="owner">
                                <!--32*32-->
                                <p class="name">{{$owner['name']??'N/A'}}</p>
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
            <li class="check folder_edit_upload">
                <a href="javascript:void(0)">
                    <span class="fa fa-check"></span>
                    <p>SETTING</p>
                </a>
            </li>
            @if($folder['id']!='0')
            <li class="trash folder_edit_delete">
                <a href="javascript:void(0)">
                    <span class="fa fa-trash"></span>
                    <p>DELETE</p>
                </a>
            </li>
            @endif
            <li class="remove">
                <a href="javascript:void(0)" class="close_btn">
                    <span class="fa fa-remove"></span>
                    <p>CANCEL</p>
                </a>
            </li>
        </ul>
    </div>
</div>
