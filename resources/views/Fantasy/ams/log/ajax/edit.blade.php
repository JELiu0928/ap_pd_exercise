<input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
<input name="_lang" type="hidden" value="<?php echo Config::get('app.dataBasePrefix'); ?>">
<div class="backEnd_quill">
    <div class="hiddenArea_frame">
        <div class="hiddenArea_frame_box">
            <div class="detailEditor">
                <div class="editorBody">
                    <div class="editorHeader">
                        <div class="info">
                            <div class="title">
                                <!-- <p class="ams_type_create_zz" style="display:none;">Create CMS Template 新增功能設定</p> -->
                                <p class="ams_type_edit_zz">Log 紀錄</p>
                            </div>
                            <div class="area">
                                @if (isset($data['log_type']))
                                    <h3>{{ $data['user_name'] . ' ' . $actions[$data['log_type']] ?? $data['log_type'] }}
                                    </h3>
                                @else
                                    <h3>Log 紀錄</h3>
                                @endif
                                <div class="control">
                                    <ul class="btnGroup">
                                        <li class="trash delete_ams_hiddenArea">
                                            <a class="delete_ams_information" data-type="log" href="javascript:void(0)">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </li>
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
                                <p style="color:#ff0000;">紅字為本次異動的資料</p>
                            </div>
                        </div>
                    </div>
                    <div class="editorContent">
                        <ul class="box_block_frame">
                            @if (isset($data['id']) and !empty($data['id']))
                                <input class="supportAmsId_Input" name="log[id]" type="hidden"
                                    value="{{ $data['id'] }}">
                            @else
                                <input class="supportAmsId_Input" name="log[id]" type="hidden" value="0">
                            @endif
                            @php
                                $ChangeData = !empty($data['ChangeData']) ? json_decode($data['ChangeData'], true) : [];
                                $OldChangeData = isset($old_data['ChangeData']) ? json_decode($old_data['ChangeData'], true) : [];
                                unset($ChangeData['branch_id']);
                                unset($ChangeData['temp_url']);
                                unset($ChangeData['updated_at']);
                                unset($ChangeData['created_at']);
                                $isNew = in_array($data['log_type'], ['create', 'insert']);
                            @endphp
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">紀錄時間</p>
                                </div>
                                <div class="inner">
                                    <p style="margin-top: 5px;font-size: 1rem;">{{ $data['create_time'] }}</p>
                                </div>
                            </li>
                            <li class="inventory row_style">
                                <div class="title">
                                    <p class="subtitle">IP位址</p>
                                </div>
                                <div class="inner">
                                    <p style="margin-top: 5px;font-size: 1rem;">{{ $data['ip'] }}</p>
                                </div>
                            </li>
                            @foreach ($ChangeData as $key => $val)
                                @if ($isNew)
                                    <li class="inventory row_style">
                                        <div class="title">
                                            <p class="subtitle">
                                                {{ $columns[$key]['Comment'] ?: $key }}
                                            </p>
                                        </div>
                                        <div class="inner">
                                            <p style="margin-top: 5px;font-size: 1rem;">
                                                {{ $val ?: '-' }}</p>
                                    </li>
                                @elseif (isset($OldChangeData[$key]) && $OldChangeData[$key] != $val)
                                    <li class="inventory row_style">
                                        <div class="title">
                                            <p class="subtitle">
                                                {{ $columns[$key]['Comment'] ?: $key }}
                                            </p>
                                        </div>
                                        <div class="inner">
                                            <p style="margin-top: 5px;font-size: 1rem;color:#ff0000; font-size: 20px">
                                                {{ $val ?: '-' }}</p>
                                            <p style="margin-top: 5px;font-size: 1rem;">
                                                {{ $OldChangeData[$key] ?: '-' }}
                                            </p>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--區塊功能按鈕-->
        <div class="hiddenArea_frame_controlBtn">
            <ul class="btnGroup">
                <li class="trash delete_ams_hiddenArea">
                    <a class="delete_ams_information" data-type="log" href="javascript:void(0)">
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
