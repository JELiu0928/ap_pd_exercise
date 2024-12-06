<div class="backEnd_quill">
    <div class="detailEditor">
        <div class="editorBody">
            <div class="editorHeader">
                <div class="info">
                    <div class="title">
                        <p>{{ $area_title }}</p>
                    </div>
                    <div class="area">
                        <h3>{{ $folderData['title'] }}</h3>
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
            <input type="hidden" name="fms[parent_folder_id]" value="{{ $folderData['parent_id'] }}">
            <input type="hidden" name="fms[parent_folder_level]" value="{{ $folderData['parent_level'] }}">
            <input type="hidden" name="fms[parent_branch]" value="{{ $folderData['parent_branch'] }}">
            <input type="hidden" name="fms[self_id]" value="{{ $folderData['id'] }}">

            <div class="editorContent">
                <ul class="box_block_frame">
                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">檔案/資料夾名稱</p>
                        </div>
                        <div class="inner">
                            <input class="normal_input" name="fms[title]" type="text" placeholder="" value="{{ $folderData['title']}}">
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
                    {{-- @endif --}}

                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">資料夾是否設為私人</p>
                        </div>
                        <div class="inner">
                            <div class="inner_box row_style">
                                <div class="switch_box">
                                    @if($folderData['id']!=0)
                                    <div class="ios_switch mrg-l-30 @if($selfFolder['is_private']) on @endif">
                                        <input type="checkbox" name="fms[is_private]" value="{{ $selfFolder['is_private'] }}">
                                        <div class="box fms_switch_ball">
                                            <span class="ball"></span>
                                        </div>
                                    </div>
                                    @else
                                    <div class="ios_switch mrg-l-30">
                                        <input type="checkbox" name="fms[is_private]" value="0">
                                        <div class="box fms_switch_ball">
                                            <span class="ball"></span>
                                        </div>
                                    </div>
                                    @endif
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
                            <select class="____select2 valid" name="fms[can_use][]" aria-invalid="false" multiple="multiple">
                                @foreach ($all_owner as $row)

                                <option value="{{ $row['id'] }}" @if(isset($selfFolder['can_use']) && in_array($row['id'],$tempCanUse ) ) selected @endif>
                                    {{ $row['name'] }}
                                </option>

                                @endforeach
                            </select>
                        </div>
                    </li>

                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">備註與說明</p>
                        </div>
                        <div class="inner">
                            <textarea name="fms[note]" id="file_outSite_textarea3" placeholder="可以針對檔案下被註記說明">{{ $folderData['note']}}</textarea>
                            <div class="tips">
                                <span class="title">TIPS</span>
                                <p>可輸入多行文字，內容不支援HTML及CSS、JQ、JS等語法，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放。</p>
                            </div>
                        </div>
                    </li>

                    @if($folderData['id']!='0')
                    <li class="inventory row_style">
                        <div class="title">
                            <p class="subtitle">最後異動時間</p>
                        </div>
                        <div class="inner">
                            <div class="file_date">
                                @if(!empty($last_edit_user))
                                <p class="name">{{$last_edit_user['name']??'N/A'}},</p>
                                <p>在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($selfFolder['updated_at'])) }} 修改過</p>
                                @else
                                <p class="name">{{$owner['name']??'N/A'}},</p>
                                <p>在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($selfFolder['updated_at'])) }} 修改過</p>
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
                                <p>在 {{ date("Y 年 m 月 d 日 H : i : s", strtotime($selfFolder['created_at'])) }} 建立</p>
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
            <li class="check folder_edit_upload_new">
                <a href="javascript:void(0)">
                    <span class="fa fa-check"></span>
                    <p>SETTING</p>
                </a>
            </li>
            @if($folderData['id']!='0')
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
