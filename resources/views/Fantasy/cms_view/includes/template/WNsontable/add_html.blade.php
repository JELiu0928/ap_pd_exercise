<form class="covertoform three-item item addKeyClass" data-rank="" partImg-id="">
    <div class="wait-save-box">
        <input name="{{ $son_son_db }}[wait_save_del]" type="hidden" value="0">
        <div class="wait-save-del">點擊Setting後刪除此筆資料<a class="wait-save-del-cancel"><span class="fa fa-remove"></span></a>
        </div>
    </div>
    <div class="list_box">
        <div class="item check_box">
            <input class="content_input list_three_checkbox list_checkbox" type="checkbox">
            <label class="content_inputBox">
                <span></span>
            </label>
        </div>
        <input class="addThirdId" name="{{ $son_son_db }}[id]" type="hidden">
        <input class="addFantasyKey" name="{{ $son_son_db }}[quillSonFantasyKey]" type="hidden">
        <input class="addThirdSid" name="SecondIdColumn" type="hidden" value="{{ $three['SecondIdColumn'] }}">
        <input class="addThirdSid" name="modelName" type="hidden" value="{{ $son_son_db }}">
        <div class="item sort_number">
            <input name="{{ $son_son_db }}[{{ $sort_field ?: 'w_rank' }}]" type="text">
        </div>
        @foreach ($three['three_tableSet'] as $three_val)
            @if ($three_val['type'] == 'just_show')
                <div class="item text btn_ctable">
                    <p class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}">-</p>
                </div>
            @endif

            @if ($three_val['type'] == 'select_just_show')
                <div class="item text btn_ctable">
                    <p class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}">-</p>
                </div>
            @endif

            @if ($three_val['type'] == 'text_image')
                <div class="item text btn_ctable">
                    <div class="s_img">
                        <img class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['img'] : '' }}"
                            src="">
                    </div>
                    <p class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}">-</p>
                </div>
            @endif
            @if ($three_val['type'] == 'article_text_image')
                <div class="item text btn_ctable">
                    <div class="s_img">
                        <img class="AutoSet_article_img" src="">
                    </div>
                    <p class="AutoSet_article_dec">-</p>
                </div>
            @endif

            @if ($three_val['type'] == 'radio_btn')
                <div class="item ios_switch radio_btn_switch on" style="min-width: 80px">
                    <input name="{{ $son_son_db }}[{{ $three_val['value'] }}]" type="text" value="1">
                    <div class="box" style="left: 23%;">
                        <span class="ball"></span>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="item edit_btnGroup">
            <span class="fa fa-pencil-square-o btn_ctable three" data-key=""></span>
            <span class="fa fa-trash deleteThirdTableData" data-id="" data-key=""
                data-model="{{ $son_son_db }}"></span>
        </div>
    </div>
    <div class="list_frame">
        <ul class="ThreeContent" style="width:100%">
            @include('Fantasy.cms_view.includes.template.WNsontable.'.($three['article_video'] ?? 'three_content'), [
                'randomWord_son' => '',
                'value_son' => [],
            ])
        </ul>
    </div>
</form>
