<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<div class="backEnd_quill">
    <div class="hiddenArea_frame">
        <div class="hiddenArea_frame_box">
            <div class="detailEditor">
                <div class="editorBody">
                    <div class="editorHeader">
                        <div class="info">
                            <div class="title">
                                <!-- <p class="ams_type_create_zz" style="display:none;">Create AMS 新增管理權限</p> -->
                                <p class="ams_type_edit_zz">Edit AMS 權限管理</p>
                            </div>
                            <div class="area">
                                @if(isset($data['UsersData']))
                                <h3>{{ $data['UsersData']['name'] }}</h3>
                                @else
                                <h3>歡迎，新冒險家</h3>
                                @endif
                                <div class="control">
                                    <ul class="btnGroup">
                                        <li class="check">
                                            <a href="javascript:void(0)" class="updated_ams_edit_btn" data-type="ams-manager">
                                                <span class="fa fa-check"></span>
                                            </a>
                                        </li>
                                        <li class="trash delete_ams_hiddenArea">
                                            <a href="javascript:void(0)" class="delete_ams_information" data-type="ams-manager">
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
                                <span class="title">Tips{{-- TIPS --}}</span>
                                <p>設定與管理 Fantasy Account 在 AMS 中的操作權限</p>
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
                            <li class="inventory row_style tr_style img_title open_ams_lightbox">
                                <div class="title">
                                    是否啟用
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">設定 AMS 管理權限是否啟用-P</p>
                                            <p>選擇要取得
                                                <strong>AMS</strong> 管理授權的管理者帳號，打開授權開關將可決定管理帳號是否可進入
                                                <strong>AMS</strong> 進行管理
                                            </p>
                                        </div>
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
                                    <div class="inner_box" style="display:none;">
                                        <ul class="radio state_button mrg-0">
                                            <li class="mrg-r-20">
                                                <input type="radio" checked="checked" value="" name="radio2" id="stateA">
                                                <label for="stateA">
                                                    <strong>Administrator</strong>最大權限管理者
                                                </label>
                                            </li>
                                            <li class="mrg-r-20">
                                                <input type="radio" value="no" name="radio2" id="stateB">
                                                <label for="stateB">
                                                    <strong>Manager</strong>限定權限管理者
                                                </label>
                                            </li>
                                        </ul>
                                        <div class="tips">
                                            <span class="title">TIPS</span>
                                            <p>Administrator 最大權限管理者可對所有管理項目進行管理，Manage
                                                限定權限管理者只可對被指派項目進行管理。</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{UnitMaker::select2([
                                'name' => 'amsData[user_id]',
                                'title' => '管理者',
                                'value' => ( !empty($data['user_id']) )? $data['user_id'] : '',
                                'options' => $FantasyUserEmpty
                            ])}}
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">Fantasy</br>Account</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">Fantasy Account 管理權限是否啟用</p>
                                            <p>打開授權開關，將授權管理帳號可進入
                                                <strong>Account 帳號管理</strong>，並對內容及設定進行編輯作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_fantasy']) && $data['is_fantasy'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_fantasy']) && $data['is_fantasy'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_fantasy]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">AMS</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">AMS 管理權限是否啟用</p>
                                            <p>打開授權開關，將授權管理帳號管理
                                                <strong>AMS 權限管理</strong>，並對內容及設定進行編輯作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_ams']) && $data['is_ams'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_ams']) && $data['is_ams'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_ams]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if($configSet['setBranchs'])
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">CMS Template</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">CMS Template 分館語系設定</p>
                                            <p>打開授權開關，將授權管理帳號管理
                                                <strong>CMS Template 分館後台語系啟用設定、分館網址設定</strong>，並對內容及設定進行編輯作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_cover_page']) && $data['is_cover_page'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_cover_page']) && $data['is_cover_page'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_cover_page]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">CMS Template</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">CMS Template 分館資料設定</p>
                                            <p>打開授權開關，將授權管理帳號管理
                                                <strong>CMS Template 設定分館可編輯的資料類別</strong>，並對內容及設定進行編輯作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_cms_template']) && $data['is_cms_template'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_cms_template']) && $data['is_cms_template'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_cms_template]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            @endif
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">CMS Template</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">CMS Template 帳號權限管理</p>
                                            <p>打開授權開關，將授權管理帳號管理
                                                <strong>CMS Template 依帳號設定可編輯的資料類別</strong>，並對內容及設定進行編輯作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_cms_template_ma']) && $data['is_cms_template_ma'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_cms_template_ma']) && $data['is_cms_template_ma'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_cms_template_ma]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">FMS</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">Fma Folder 管理權限是否啟用</p>
                                            <p>打開授權開關，將授權管理帳號可進入
                                                <strong>Fms Folder 基本目錄管理</strong>，且帳號可不受擁有者限制，編輯、刪除FMS檔案。
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_folder']) && $data['is_folder'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_folder']) && $data['is_folder'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_folder]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <li class="inventory row_style tr_style" style="display:none;">
                                <div class="title">
                                    <p class="subtitle">Fantasy</br>Setting</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">Fantasy Setting 管理權限是否啟用</p>
                                            <p>打開授權開關，將授權管理帳號可進入
                                                <strong>Fantasy Setting 權限管理</strong>，並對內容及設定進行編輯作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_fantasy_setting']) && $data['is_fantasy_setting'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_fantasy_setting']) && $data['is_fantasy_setting'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_fantasy_setting]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">Website</br>Redirect</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">Website Redirect 管理權限是否啟用</p>
                                            <p>打開授權開關，將授權管理帳號可進入
                                                <strong>Website Redirect 管理</strong>，並對內容及設定進行編輯作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_autoredirect']) && $data['is_autoredirect'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_autoredirect']) && $data['is_autoredirect'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_autoredirect]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">Log</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">Log 權限是否啟用</p>
                                            <p>打開授權開關，將授權管理帳號可進入
                                                <strong>Log 紀錄</strong>，並對內容及設定進行查看作業
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{ (isset($data['is_log']) && $data['is_log'] == 0) ? '':'on' }}">
                                                <input type="hidden" value="{{ (isset($data['is_log']) && $data['is_log'] == 0) ? '0':'1' }}" class="check_ams_rabio" name="amsData[is_log]">

                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
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
                    <a href="javascript:void(0)" class="updated_ams_edit_btn" data-type="ams-manager">
                        <span class="fa fa-check"></span>
                        <p>SETTING</p>
                    </a>
                </li>
                <li class="trash delete_ams_hiddenArea">
                    <a href="javascript:void(0)" class="delete_ams_information" data-type="ams-manager">
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