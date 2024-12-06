<input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
{{-- 不能用當前語系  改用 unit 紀錄的語系 --}}
<input name="_lang" type="hidden"
    value="@if ($BranchOriginUnit) {{ $BranchOriginUnit['locale'] . '_' }} @else {{ config::get('app.dataBasePrefix') }} @endif">
<div class="backEnd_quill">
    <div class="hiddenArea_frame">
        <div class="hiddenArea_frame_box">
            <div class="detailEditor">
                <div class="editorBody">
                    <div class="editorHeader">
                        <div class="info">
                            <div class="title">
                                <!-- <p class="ams_type_create_zz" style="display:none;">Create CMS Template 新增功能設定</p> -->
                                <p class="ams_type_edit_zz">Edit CMS Template 權限設定</p>
                            </div>
                            <div class="area">
                                @if (isset($data['UsersData']))
                                    <h3>{{ $data['UsersData']['name'] }}</h3>
                                @else
                                    <h3>歡迎，新冒險家</h3>
                                @endif
                                <div class="control">
                                    <ul class="btnGroup">
                                        <li class="check">
                                            <a class="updated_ams_edit_btn" data-type="cms-manager"
                                                href="javascript:void(0)">
                                                <span class="fa fa-check"></span>
                                            </a>
                                        </li>
                                        <li class="trash delete_ams_hiddenArea">
                                            <a class="delete_ams_information" data-type="cms-manager"
                                                href="javascript:void(0)">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </li>
                                        <!--<li class="file">-->
                                        <!--<a href="javascript:void(0)">-->
                                        <!--<<span class="fa fa-files-o"></span>-->
                                        <!--<</a>-->
                                        <!--<</li>-->
                                        <li class="remove">
                                            <a class="close_btn close_ams_hiddenArea" href="javascript:void(0)">
                                                <span class="fa fa-remove"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tips">
                                <span class="title">Tips</span>
                                <p>設定 Fantasy Account 的 CMS Template 管理權限，若未開啟管理權限，則管理者無法於 CMS 中檢視/編輯 Template 內容</p>
                            </div>
                        </div>
                    </div>
                    <div class="editorContent">
                        <ul class="box_block_frame">
                            @if (isset($data['id']) and !empty($data['id']))
                                <input class="supportAmsId_Input" name="amsData[id]" type="hidden"
                                    value="{{ $data['id'] }}">
                            @else
                                <input class="supportAmsId_Input" name="amsData[id]" type="hidden" value="0">
                            @endif
                            <li class="inventory row_style tr_style img_title open_ams_lightbox">
                                <div class="title">
                                    <p class="subtitle">是否啟用</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">該管理權限設定 是否啟用</p>
                                            <p>未啟用視同該使用者無權限</p>
                                            {{-- <p>選擇要取得
                                                <strong>CMS emplate</strong>管理授權的管理者帳號，打開授權開關將可決定管理帳號是否可進入
                                                <strong>CMS Template</strong> 進行管理
                                            </p> --}}
                                        </div>
                                        <div class="switch_box">
                                            <div
                                                class="ios_switch mrg-l-30 ams_ios_switch {{ isset($data['is_active']) && $data['is_active'] == 0 ? '' : 'on' }}">
                                                <input class="check_ams_rabio" name="amsData[is_active]" type="hidden"
                                                    value="{{ isset($data['is_active']) && $data['is_active'] == 0 ? '0' : '1' }}">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{ UnitMaker::select2([
                                'name' => 'amsData[user_id]',
                                'title' => '管理者',
                                'value' => !empty($data['user_id']) ? $data['user_id'] : '',
                                'options' => $FantasyUsers,
                                // 'disabled'=>true,

                            ]) }}
                            {{ UnitMaker::select2([
                                'name' => 'amsData[branch_unit_id]',
                                'title' => '選擇分館',
                                'value' => !empty($data['branch_unit_id']) ? $data['branch_unit_id'] : '',
                                'options' => $branch_unit_options,
                            ]) }}
                            {{-- <li class="inventory row_style tr_style review-action"
                                @if (!$need_review) style="display: none" @endif>
                                <div class="title">
                                    <p class="subtitle">編輯免審核</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p class="title">無審核權限編輯是否免審核</p>
                                            <p>預設無審核權限者，編輯後會資料會自動下架，若不讓資料下架，可開啟此功能
                                            </p>
                                        </div>
                                        <div class="switch_box">
                                            <div
                                                class="ios_switch mrg-l-30 ams_ios_switch {{ isset($data['is_review_edit']) && $data['is_review_edit'] == 0 ? '' : 'on' }}">
                                                <input class="check_ams_rabio" name="amsData[is_review_edit]"
                                                    type="hidden"
                                                    value="{{ isset($data['is_review_edit']) && $data['is_review_edit'] == 0 ? '0' : '1' }}">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                            <li class="inventory row_style" style="padding: 40px 0px 0px 0px;">
                                <div class="title">
                                    <p class="subtitle">控制全部單元</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div style="display: flex;">
                                            <a class="ios_switch_select_block_all" data-val="0"
                                                href="javascript:void(0)"
                                                style="background-color: #c5c5c5;padding: 5px;color: #fff;">全關</a>
                                            <a class="ios_switch_select_block_all" data-val="1"
                                                href="javascript:void(0)"
                                                style="background-color: #3a9eea;padding: 5px;color: #fff;">全開</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <div class="ajax_html">
                                @include('Fantasy.ams.cms_manager.ajax.unit', [
                                    'need_review' => $need_review,
                                ])
                            </div>
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">最後異動時間</p>
                                </div>
                                <div class="inner">
                                    <div class="file_date">
                                        @if (isset($data['updated_at']) and !empty($data['updated_at']))
                                            <p>{{ $data['updated_at'] }}</p>
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
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">建立日期</p>
                                </div>
                                <div class="inner">
                                    <div class="file_date">
                                        @if (isset($data['created_at']) and !empty($data['created_at']))
                                            <p>{{ $data['created_at'] }}</p>
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
                    <a class="updated_ams_edit_btn" data-type="cms-manager" href="javascript:void(0)">
                        <span class="fa fa-check"></span>
                        <p>SETTING</p>
                    </a>
                </li>
                <li class="trash delete_ams_hiddenArea">
                    <a class="delete_ams_information" data-type="cms-manager" href="javascript:void(0)">
                        <span class="fa fa-trash"></span>
                        <p>DELETE</p>
                    </a>
                </li>
                <li class="remove">
                    <a class="close_btn close_ams_hiddenArea" href="javascript:void(0)">
                        <span class="fa fa-remove"></span>
                        <p>CANCEL</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
