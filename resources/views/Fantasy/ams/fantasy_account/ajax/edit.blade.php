<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<div class="backEnd_quill">
    <div class="hiddenArea_frame">
        <div class="hiddenArea_frame_box">
            <div class="detailEditor">
                <div class="editorBody">
                    <div class="editorHeader">
                        <div class="info">
                            <div class="title">
                                <p class="ams_type_edit_zz">Fantasy Account Management 帳號管理</p>
                            </div>
                            <div class="area">
                                @if(isset($data['account']))
                                <h3>{{$data['account']}}</H3>
                                @else
                                <h3>歡迎，新冒險家</h3>
                                @endif
                                <div class="control">
                                    <ul class="btnGroup">
                                        <li class="check">
                                            <a href="javascript:void(0)" class="updated_ams_edit_btn" data-type="fantasy-account">
                                                <span class="fa fa-check"></span>
                                            </a>
                                        </li>
                                        <li class="trash delete_ams_hiddenArea">
                                            <a href="javascript:void(0)" class="delete_ams_information" data-type="fantasy-account">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </li>
                                        <li class="remove">
                                            <a href="javascript:void(0)" class="close_btn close_ams_hiddenArea">
                                                <span class="fa fa-remove"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tips">
                                <span class="title">Tips</span>
                                <p>設定與管理 Fantasy Account，擁有 Account 才能夠登入 Fantasy 進行操作</p>
                            </div>
                        </div>
                    </div>
                    <div class="editorContent">
                        <ul class="box_block_frame">
                            @if(isset($data['id']) AND !empty($data['id']))
                            <input type="hidden" value="{{$data['id']}}" name="amsData[id]" class="supportAmsId_Input">
                            @else
                            <input type="hidden" value="0" name="amsData[id]" class="supportAmsId_Input">
                            @endif
                            {{UnitMaker::imageGroup([
                                'title' => '帳號大頭照',
                                'image_array' =>[[
                                    'name' => 'amsData[photo_image]',
                                    'title' => '',
                                    'value' => ( !empty($data['photo_image']) )? $data['photo_image'] : '',
                                    'set_size' => 'yes',
                                    'width' => '100',
                                    'height' => '100',
                                ]],
                                'tip' => '圖片尺寸 100 x 100 像素，圖片解析度限制 : 72DPI，檔案格式限定 : JPG、PNG、GIF。'
                            ])}}
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">帳號名稱</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['account']) AND !empty($data['account']))
                                    <input class="normal_input" type="text" placeholder="" name="amsData[account]" value="{{$data['account']}}">
                                    @else
                                    <input class="normal_input" type="text" placeholder="" name="amsData[account]" value="">
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>不可與其他管理帳號重複，特殊符號如 : @#$%?/\|*.及全形輸入也請盡量避免。</p>
                                    </div>
                                </div>
                            </li>
                            @if(empty($data))
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">登入密碼設定</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="psbox gray w-50 mrg-r-10">
                                            <input class="normal_input" type="password" placeholder="留空不變,輸入更改" name="amsData[password]">
                                            {{-- <span class="icon blind fa fa-eye-slash"></span> --}}
                                        </div>
                                        <div class="psbox w-50 mrg-l-10">
                                            <input class="normal_input" type="password" placeholder="密碼驗證，請再次輸入密碼" name="amsData[password2]">
                                            {{-- <span class="icon blind fa fa-eye-slash"></span> --}}
                                        </div>
                                    </div>
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>請輸入8-12 位英文字母與數字、符號組合而成的密碼，英文字母至少有一位為大寫字母。</p>
                                    </div>
                                </div>
                            </li>
                            @endif
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">限制登入IP</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['lock_ip']) AND !empty($data['lock_ip']))
                                    <input class="normal_input" type="text" placeholder="" name="amsData[lock_ip]" value="{{$data['lock_ip']}}">
                                    @else
                                    <input class="normal_input" type="text" placeholder="" name="amsData[lock_ip]" value="">
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>若空白則不限制，多個IP請用逗號區分</p>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">帳號是否啟用</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_active']) && $data['is_active'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_active']) && $data['is_active'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_active]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">FMS最大權限管理者</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['fms_admin']) && $data['fms_admin'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['fms_admin']) && $data['fms_admin'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[fms_admin]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>開啟本選項，該帳號可不受擁有者限制，編輯、刪除FMS檔案。</p>
                                    </div>
                                </div>
                            </li> --}}
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">姓名</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['name']) AND !empty($data['name']))
                                    <input class="normal_input" type="text" placeholder="" name="amsData[name]" value="{{$data['name']}}">
                                    @else
                                    <input class="normal_input" type="text" placeholder="" name="amsData[name]" value="">
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p></p>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">電子郵件</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['mail']) AND !empty($data['mail']))
                                    <input class="normal_input" type="text" placeholder="" name="amsData[mail]" value="{{$data['mail']}}">
                                    @else
                                    <input class="normal_input" type="text" placeholder="" name="amsData[mail]" value="">
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p></p>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">備註說明</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['note']) AND !empty($data['note']))
                                    <textarea name="amsData[note]" id="" placeholder="">{{$data['note']}}</textarea>
                                    @else
                                    <textarea name="amsData[note]" id="" placeholder=""></textarea>
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>可輸入多行文字，內容不支援HTML及CSS、JQ、JS等語法，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放。</p>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">最後異動時間</p>
                                </div>
                                <div class="inner">
                                    <div class="file_date">
                                        @if(isset($data['updated_at']) AND !empty($data['updated_at']))
                                        <p>{{$data['updated_at']}}</p>
                                        @else
                                        <p></p>
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
                                    <p class="subtitle">帳號建立日期</p>
                                </div>
                                <div class="inner">
                                    <div class="file_date">
                                        @if(isset($data['created_at']) AND !empty($data['created_at']))
                                        <p>{{$data['created_at']}}</p>
                                        @else
                                        <p></p>
                                        @endif
                                    </div>
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>不開放修改，由系統自行更新。</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--區塊功能按鈕-->
        <div class="hiddenArea_frame_controlBtn">
            <ul class="btnGroup">
                <li class="check">
                    <a href="javascript:void(0)" class="updated_ams_edit_btn" data-type="fantasy-account">
                        <span class="fa fa-check"></span>
                        <p>SETTING</p>
                    </a>
                </li>
                <li class="trash delete_ams_hiddenArea">
                    <a href="javascript:void(0)" class="delete_ams_information" data-type="fantasy-account">
                        <span class="fa fa-trash"></span>
                        <p>DELETE</p>
                    </a>
                </li>
                <li class="remove">
                    <a href="javascript:void(0)" class="close_btn close_ams_hiddenArea">
                        <span class="fa fa-remove"></span>
                        <p>CANCEL</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>