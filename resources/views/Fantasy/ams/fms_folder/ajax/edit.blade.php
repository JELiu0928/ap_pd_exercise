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
                                <p class="ams_type_edit_zz">FMS Folder 目錄管理</p>
                            </div>
                            <div class="area">
                                @if(isset($data['title']))
                                <h3>{{$data['title']}}</h3>
                                @else
                                <h3>新資料夾</h3>
                                @endif
                                <div class="control">
                                    <ul class="btnGroup">
                                        <li class="check">
                                            <a href="javascript:void(0)" class="updated_ams_edit_btn"
                                                data-type="fms-folder">
                                                <span class="fa fa-check"></span>
                                            </a>
                                        </li>
                                        <li class="trash delete_ams_hiddenArea">
                                            <a href="javascript:void(0)" class="delete_ams_information"
                                                data-type="fms-folder">
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
                                <p>設定與管理 FMS 目錄，你可以在這裡管理根目錄層級的 FMS 目錄</p>
                            </div>
                        </div>
                    </div>
                    <div class="editorContent">
                        <ul class="box_block_frame">
                            @if(isset($data['id']) AND !empty($data['id']))
                            <input type="hidden" value="{{$data['id']}}" name="FmsZero[id]" class="supportAmsId_Input">
                            @else
                            <input type="hidden" value="0" name="FmsZero[id]" class="supportAmsId_Input">
                            @endif
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">資料夾名稱</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['title']) AND !empty($data['title']))
                                    <input class="normal_input" type="text" placeholder="" name="FmsZero[title]"
                                        value="{{$data['title']}}">
                                    @else
                                    <input class="normal_input" type="text" placeholder="" name="FmsZero[title]"
                                        value="">
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>請輸入欲使用資料夾名稱</p>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">備註說明</p>
                                </div>
                                <div class="inner">
                                    @if(isset($data['note']) AND !empty($data['note']))
                                    <textarea name="FmsZero[note]" id="" placeholder="">{{$data['note']}}</textarea>
                                    @else
                                    <textarea name="FmsZero[note]" id="" placeholder=""></textarea>
                                    @endif
                                    <div class="tips">
                                        <span class="title">TIPS</span>
                                        <p>可輸入多行文字，內容不支援HTML及CSS、JQ、JS等語法，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放。</p>
                                    </div>
                                </div>
                            </li>
                            <li class="inventory row_style tr_style">
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
                            <li class="inventory row_style tr_style">
                                <div class="title">
                                    <p class="subtitle">建立日期</p>
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
                    <a href="javascript:void(0)" class="updated_ams_edit_btn" data-type="fms-folder">
                        <span class="fa fa-check"></span>
                        <p>SETTING</p>
                    </a>
                </li>
                <li class="trash delete_ams_hiddenArea">
                    <a href="javascript:void(0)" class="delete_ams_information" data-type="fms-folder">
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