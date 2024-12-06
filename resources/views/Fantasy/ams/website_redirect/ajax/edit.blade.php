<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<input type="hidden" name="_lang" value="<?php echo Config::get('app.dataBasePrefix'); ?>">
<div class="backEnd_quill">
    <div class="hiddenArea_frame">
        <div class="hiddenArea_frame_box">
            <div class="detailEditor">
                <div class="editorBody">
                    <div class="editorHeader">
                        <div class="info">
                            <div class="title">
                                <!-- <p class="ams_type_create_zz" style="display:none;">Create CMS Template 新增功能設定</p> -->
                                <p class="ams_type_edit_zz">Website Redirect 管理</p>
                            </div>
                            <div class="area">
                                @if(isset($data['title']))
                                <h3>{{$data['title']}}</h3>
                                @else
                                <h3>301轉址設定</h3>
                                @endif
                                <div class="control">
                                    <ul class="btnGroup">
                                        <li class="check">
                                            <a href="javascript:void(0)" class="updated_ams_edit_btn" data-type="autoredirect">
                                                <span class="fa fa-check"></span>
                                            </a>
                                        </li>
                                        <li class="trash delete_ams_hiddenArea">
                                            <a href="javascript:void(0)" class="delete_ams_information" data-type="autoredirect">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </li>
                                        <!--<li class="file">-->
                                        <!--<a href="javascript:void(0)">-->
                                        <!--<<span class="fa fa-files-o"></span>-->
                                        <!--<</a>-->
                                        <!--<</li>-->
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
                                <p>設定與管理 Website Redirect，你可以在這裡設定301轉址</p>
                            </div>
                        </div>
                    </div>
                    <div class="editorContent">
                        <ul class="box_block_frame">
                            @if(isset($data['id']) AND !empty($data['id']))
                            <input type="hidden" value="{{$data['id']}}" name="Autoredirect[id]" class="supportAmsId_Input">
                            @else
                            <input type="hidden" value="0" name="Autoredirect[id]" class="supportAmsId_Input">
                            @endif
                            <li class="inventory row_style tr_style img_title open_ams_lightbox">
                                <div class="title">
                                    <p class="subtitle">是否啟用301轉址</p>
                                </div>
                                <div class="inner">
                                    <div class="inner_box row_style">
                                        <div class="info_text">
                                            <p style="color:#ff0000;">預設為302轉址，若未確定轉址是否正常，請勿啟用301轉址，避免造成使用者預覽器暫存設定，將無法正常運作</p>
                                        </div>
                                        <div class="switch_box">
                                            <div class="ios_switch mrg-l-30 ams_ios_switch {{(isset($data['active_301']) && $data['active_301'] == 1) ? 'on':''}}">
                                                <input type="hidden" value="{{(isset($data['active_301']) && $data['active_301'] == 1) ? '1':''}}" class="check_ams_rabio" name="amsData[active_301]">
                                                <input type="checkbox">
                                                <div class="box ams_switch_ball">
                                                    <span class="ball"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">舊網址</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['old_url']) AND !empty($data['old_url']))
                                    <input class="normal_input" type="text" placeholder="" name="Autoredirect[old_url]" value="{{$data['old_url']}}">
                                    @else
                                    <input class="normal_input" type="text" placeholder="" name="Autoredirect[old_url]" value="">
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>請輸入原本網站舊網址</p>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">轉向網址</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['new_url']) AND !empty($data['new_url']))
                                    <input class="normal_input" type="text" placeholder="" name="Autoredirect[new_url]" value="{{$data['new_url']}}">
                                    @else
                                    <input class="normal_input" type="text" placeholder="" name="Autoredirect[new_url]" value="">
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>請輸入新網站對應的網址</p>
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
                    <a href="javascript:void(0)" class="updated_ams_edit_btn" data-type="autoredirect">
                        <span class="fa fa-check"></span>
                        <p>SETTING</p>
                    </a>
                </li>
                <li class="trash delete_ams_hiddenArea">
                    <a href="javascript:void(0)" class="delete_ams_information" data-type="autoredirect">
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