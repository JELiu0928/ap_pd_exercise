{{-- --------$html---------------------------------------------------- --}}
<form class="covertoform list stack_state addDataKey addKeyClass" data-key="">
    <div class="wait-save-box">
        <input name="{{ $set['name'] }}[wait_save_del]" type="hidden" value="0">
        <div class="wait-save-del">點擊Setting後刪除此筆資料<a class="wait-save-del-cancel"><span class="fa fa-remove"></span></a>
        </div>
    </div>
    <div class="list_box">

        {{-- 選擇按鈕 --}}
        @if ($copy == 'yes' || $delete == 'yes')
        <div class="item check_box addKeyClass addDataKey" data-id="" data-key="">
            <input class="content_input list_checkbox" type="checkbox">
            <label class="content_inputBox">
                <span></span>
            </label>
        </div>
        @endif

        <input class="addKeyClass" name="{{ $set['name'] }}[id]" type="hidden" value="">
        <input class="addKeyValue" name="{{ $set['name'] }}[quillFantasyKey]" type="hidden" value="">
        <input name="modelName" type="hidden" value="{{ $set['name'] }}">
        <input name="SecondIdColumn" type="hidden" value="{{ $set['SecondIdColumn'] }}">

        {{-- 排序 --}}
        @if($sort == 'yes')
            <div class="item sort_number">
                <input name="{{ $set['name'] }}[{{ $set['sort_field'] ?: 'w_rank' }}]" type="text" value="">
            </div>
        @endif

        {{-- 項目 --}}
        @foreach($tableSet as $key2 => $row2)
            @if($row2['type'] == 'textInput')
                <div class="item text">
                    <input name="{{ $set['name'] }}[{{ $row2['value'] }}]" type="text" value="{{ $row2['default'] ?: '' }}" style="border-style:none;background-color: #efefef;border: solid 1px #c7c7c7;width: 90%;" placeholder="Please enter here">
                </div>
            @elseif($row2['type'] == 'text_image')
                <div class="item text btn_ctable">
                    <div class="s_img">
                        <img class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['img'] : '' }}" src="">
                    </div>
                    <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">-</p>
                </div>
            @elseif($row2['type'] == 'filesText')
                <div class="item text btn_ctable">
                    <div class="s_img">
                        <img src="" alt="">
                    </div>
                    <p></p>
                </div>
            @elseif ($row2['type'] == 'imgText')
            <div class="item text btn_ctable imgText">
                @foreach($row2['img'] as $imgKey)
                <div class="s_img">
                    <img name="{{$set['name']}}[{{$imgKey}}][]" src="" alt="">
                </div>
                @endforeach
                <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}"></p>
            </div>
            @elseif($row2['type'] == 'radio_btn')
                <div class="item ios_switch radio_btn_switch {{ !empty($row2['default']) ? 'on' :'' }}" style="min-width: 80px">
                    <input name="{{ $set['name'] }}[{{ $row2['value'] }}]" type="text" value="{{ !empty($row2['default']) ?: 0 }}">
                    <div class="box" style="left: 23%;">
                        <span class="ball"></span>
                    </div>
                </div>
            @elseif($row2['type'] == 'select_just_show')
                <div class="item text btn_ctable">
                    <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                        {{ !empty($row2['default']) ? $row2['default'] : '' }}</p>
                </div>
            @elseif($row2['type'] == 'select_article4_show')
                <div class="item text btn_ctable">
                    <div class="s_img">
                        <img src="/vender/assets/img/article4/typeBasic.jpg" alt="">
                    </div>
                    <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                        {{ array_values($row2['options'])[0]['title'] }}</p>
                </div>
            @elseif($row2['type'] == 'select')
                @php
                    $temp_options = !empty($row2['options']) ? $row2['options'] : [];
                @endphp

                <div class="item text">
                    <div class="quill_select" style="width:100%;">
                        <div class="select_object" style="border-style: none;">
                            <p class="title"></p>
                            <span class="arrow pg-arrow_down"></span>
                        </div>

                        <div class="select_wrapper">
                            <ul class="select_list edit_select">
                                @foreach($temp_options as $key3 => $row3)
                                    <li class="option single_select_fantasy" data-id="{{ $row3['key'] }}">
                                        <p>{{ $row3['title'] }}</p>
                                    </li>
                                @endforeach
                                <input name="{{ $set['name'] }}[{{ $row2['value'] }}]" type="hidden" value="">
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif($row2['type'] == 'just_show')
                @if(!empty($row[$row2['value']]))
                    <div class="item text btn_ctable">
                        <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                            {{ $row[$row2['value']] }}</p>
                    </div>
                @else
                    <div class="item text btn_ctable">
                        <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                            {{ !empty($row2['default']) ? $row2['default'] : '' }}</p>
                    </div>
                @endif
            @endif
        @endforeach

        {{-- 編輯刪除按鈕 --}}
        @if($hasContent == 'yes' || $delete == 'yes' || $is_link == 'yes')
            <div class="item edit_btnGroup">
                @if($hasContent == 'yes')
                    <span class="fa fa-pencil-square-o btn_ctable addDataKey" data-key=""></span>
                @endif

                @if($delete == 'yes')
                    <span class="fa fa-trash addKeyClass addDataKey deleteSonTableData" data-id="" data-key="" data-model="{{ $set['name'] }}"></span>
                @endif
            </div>
        @endif

    </div>

    {{-- 展開項目 --}}
    @if($hasContent == 'yes')
        <div class="list_frame addkeyFrame">

            {{-- tabSet --}}
            @if(count($tabSet) > 0)
                <ul class="list_headBar">
                    @foreach($tabSet as $key_2 => $row_2)
                        @if($key_2 == 0)
                            <li class="now" bar-id="{{ $key_2 }}">
                                <p>{{ $row_2['title'] }}</p>
                            </li>
                        @else
                            <li bar-id="{{ $key_2 }}">
                                <p>{{ $row_2['title'] }}</p>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif

            <ul class="list_body">
                @foreach($tabSet as $key_2 => $row_2)
                    <li class="list_bodyL part_content" body-id="{{ $key_2 }}">
                        <ul class="list_part_body">
                            {{-- 第二層元件 --}}
                            @foreach($row_2['content'] as $key_3 => $row_3)
                                @php
                                    $auto = isset($row_3['auto']) ? ' DataSync' : '';
                                    $autoSelect = isset($row_3['auto']) ? 'DataSyncSelect' : '';
                                    $autosetup = isset($row_3['auto']) ? 'AutoSet_' . $row_3['value'] : '';
                                @endphp
                                @if($row_3['type'] == 'multiLocal')
                                    <li class="inventory">
                                        <div class="list_frame" style="display: block;">
                                            <ul class="list_headBar">
                                                @foreach($langArray as $multiLocalKey => $multiLocalVal)
                                                    <li @if ($multiLocalKey==array_key_first($langArray)) class="now" @endif bar-id="multiLocal_{{ $multiLocalKey }}">
                                                        <p>{{ $multiLocalVal['title'] }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <ul class="list_body" style="padding: 30px 15px;">
                                                @foreach($langArray as $multiLocalKey => $multiLocalVal)
                                                    <li class="list_bodyL part_content" body-id="multiLocal_{{ $multiLocalKey }}">
                                                        <ul class="list_part_body">
                                                            @foreach($row_3['content'] as $mkey_3 => $mrow_3)
                                                                @if($mrow_3['type'] == 'textInput')
                                                                    <li class="inventory">
                                                                        <p class="subtitle">
                                                                            {{ !empty($mrow_3['title']) ? $mrow_3['title'] : '' }}
                                                                        </p>
                                                                        <input class="normal_input {{ $auto }}" name="{{ $set['name'] }}[{{ $multiLocalVal['key'] . '_' . $mrow_3['value'] }}]" data-autosetup="{{ $autosetup }}" type="text" value="" {{ !empty($mrow_3['disabled']) ? $mrow_3['disabled'] : '' }}>
                                                                        @if(!empty($mrow_3['tip']))
                                                                            <div class="tips">
                                                                                <span class="title">TIPS</span>
                                                                                <p>{!! $mrow_3['tip'] !!}</p>
                                                                            </div>
                                                                        @endif
                                                                    </li>

                                        </div>
                                    </li>
                                @elseif($row_3['type'] == 'radio_area')
                                    @php
                                        $row_3['auto'] = $autoSelect;
                                        $row_3['autosetup'] = $autosetup;
                                        $row_3['sontable'] = true;
                                        $row_3['sontable_add'] = true;
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                        $row_3['value'] = 0;
                                    @endphp
                                    {{ UnitMaker::radio_area($row_3) }}
                                @elseif ($row_3['type'] == 'numberInput')
                                @php
                                    $row_3['sontable'] = true;
                                    $row_3['sontable_add'] = true;
                                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                    $row_3['value'] = $row[$row_3['value']] ?? '0';
                                @endphp
                                {{ UnitMaker::numberInput($row_3) }}
                                @elseif($row_3['type'] == 'select')
                                    @php
                                        $row_3['sontable'] = true;
                                        $row_3['sontable_add'] = true;
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                    @endphp
                                    {{ UnitMaker::select2($row_3) }}
                                @elseif($row_3['type'] == 'select2')
                                    @php
                                        $row_3['auto'] = $autoSelect;
                                        $row_3['autosetup'] = $autosetup;
                                        $row_3['sontable'] = true;
                                        $row_3['sontable_add'] = true;
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                    @endphp
                                    {{ UnitMaker::select2($row_3) }}
                                @elseif($row_3['type'] == 'select2Multi')
                                    @php
                                        $row_3['auto'] = $autoSelect;
                                        $row_3['autosetup'] = $autosetup;
                                        $row_3['original'] = $set['name'];
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                    @endphp
                                    {{ UnitMaker::select2Multi($row_3) }}
                                @elseif($row_3['type'] == 'select2MultiNew')
                                    @php
                                        $row_3['auto'] = $autoSelect;
                                        $row_3['autosetup'] = $autosetup;
                                        $row_3['original'] = $set['name'];
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                    @endphp
                                    {{ UnitMaker::select2MultiNew($row_3) }}
                                @elseif($row_3['type'] == 'selectBydata')
                                    @php
                                        $row_3['sontable'] = true;
                                        $row_3['sontable_add'] = true;
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                    @endphp
                                    {{ UnitMaker::selectBydata($row_3) }}
                                @elseif($row_3['type'] == 'textArea')
                                    @php
                                        $row_3['auto'] = $autoSelect;
                                        $row_3['autosetup'] = $autosetup;
                                        $row_3['sontable'] = true;
                                        $row_3['sontable_add'] = true;
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                        $row_3['value'] = '';
                                    @endphp
                                    {{ UnitMaker::textArea($row_3) }}
                                @elseif($row_3['type'] == 'lang_textArea')
                                    <li class="inventory">
                                        <p class="subtitle">{{ !empty($row_3['title']) ? $row_3['title'] : '' }}</p>
                                        @foreach(Config::get('cms.langArray') as $val)
                                            <div class="Leon-langs-input">
                                                <span>{{ $val['abb_title'] }}</span>
                                                <textarea name="{{ $set['name'] }}[{{ $val['key'] . '_' . $row_3['value'] }}]" type="text" @if(!empty($row_3['verify'])&&empty($row_3['disabled'])) data-verify=" {{ json_encode($row_3['verify']) }}" @endif>
                                                    {{ !empty($row_3['disabled']) ? $row_3['disabled'] : '' }}></textarea>
                                            </div>
                                        @endforeach
                                        @if(!empty($row_3['tip']))
                                            <div class="tips">
                                                <span class="title">TIPS</span>
                                                <p>{!! $row_3['tip'] !!}</p>
                                            </div>
                                        @endif
                                    </li>
                                @elseif($row_3['type'] == 'textSummernote')
                                    @php
                                        $row_3['sontable'] = true;
                                        $row_3['sontable_add'] = false;
                                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                        $row_3['value'] = $row[$row_3['value']];
                                    @endphp
                                    {{ UnitMaker::textSummernote($row_3) }}
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

        </li>
    @elseif($row_3['type'] == 'lang_textInput')
        <li class="inventory">
            <p class="subtitle">{{ !empty($row_3['title']) ? $row_3['title'] : '' }}</p>
            @foreach(Config::get('cms.langArray') as $val)
                <div class="Leon-langs-input">
                    <span>{{ $val['abb_title'] }}</span>
                    <input class="normal_input {{ $auto }}" name="{{ $set['name'] }}[{{ $val['key'] . '_' . $row_3['value'] }}]" data-autosetup="{{ 'AutoSet_' . $val['key'] . '_' . $row_3['value'] }}" type="text" value="" @if(!empty($row_3['verify'])&&empty($row_3['disabled'])) data-verify=" {{ json_encode($row_3['verify']) }}" @endif {{ !empty($row_3['disabled']) ? $row_3['disabled'] : '' }} @if(isset($row_3['required']) && $row_3['required']==true) required @endif autocomplete="off">
                </div>
            @endforeach

            @if(!empty($row_3['tip']))
                <div class="tips">
                    <span class="title">TIPS</span>
                    <p>{!! $row_3['tip'] !!}</p>
                </div>
            @endif
        </li>
        @elseif ($row_3['type'] == 'article_select')
        <li class="inventory">
            <p class="subtitle">{{(!empty($row_3['title'])) ? $row_3['title'] : ''}}</p>
            <div class="inner">
                <div class="article_select" data-option="{{ implode(",", array_keys($row_3['options'])) }}" >
                    <input type="hidden" value="{{$row_3['options'][array_key_first($row_3['options'])]['key']}}" name="{{$set['name']}}[{{$row_3['value']}}]">
                    <div class="article_img"><img src="/vender/assets/img/article4/{{$row_3['options'][array_key_first($row_3['options'])]['key']}}.jpg"></div>
                    <p class="article_dec AutoSet_article_style">{{$row_3['options'][array_key_first($row_3['options'])]['title']}}</p>
                    <span class="fa fa-pencil-square-o btn_ctable" data-key=""></span>
                </div>
            </div>
        </li>
    @elseif(in_array($row_3['type'], ['textInput', 'textInputTarget', 'textInputTargetAcc']))
        @php

            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = '';

            if (isset($row_3['target'])) {
            $row_3['target']['value'] = '0';
            $row_3['target']['name'] = $set['name'] . '[' . $row_3['target']['name'] . ']';
            }

            if (isset($row_3['accessible'])) {
            $row_3['accessible']['value'] = '';
            $row_3['accessible']['name'] = $set['name'] . '[' . $row_3['accessible']['name'] . ']';
            }

        @endphp
        @if($row_3['type'] == 'textInput')
        {{ UnitMaker::textInput($row_3) }}
        @endif
            @if($row_3['type'] == 'textInputTarget')
        {{ UnitMaker::textInputTarget($row_3) }}
        @endif
            @if($row_3['type'] == 'textInputTargetAcc')
        {{ UnitMaker::textInputTargetAcc($row_3) }}
        @endif
    @elseif ($row_3['type'] == 'table')
    @php
        $row_3['auto'] = $autoSelect;
        $row_3['autosetup'] = $autosetup;
        $row_3['sontable'] = true;
        $row_3['sontable_add'] = true;
        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
        $row_3['value'] = '';
    @endphp
    {{ UnitMaker::table($row_3) }}
    @elseif($row_3['type'] == 'radio_area')
        @php
            $row_3['auto'] = $autoSelect;
            $row_3['autosetup'] = $autosetup;
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = 0;
        @endphp
        {{ UnitMaker::radio_area($row_3) }}
        @elseif ($row_3['type'] == 'numberInput')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = $row[$row_3['value']] ?? '0';
        @endphp
        {{ UnitMaker::numberInput($row_3) }}
    @elseif($row_3['type'] == 'select')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
        @endphp
        {{ UnitMaker::select2($row_3) }}
    @elseif($row_3['type'] == 'select2')
        @php
            $row_3['auto'] = $autoSelect;
            $row_3['autosetup'] = $autosetup;
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
        @endphp
        {{ UnitMaker::select2($row_3) }}
    @elseif($row_3['type'] == 'select2Multi')
        @php
            $row_3['auto'] = $autoSelect;
            $row_3['autosetup'] = $autosetup;
            $row_3['original'] = $set['name'];
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
        @endphp
        {{ UnitMaker::select2Multi($row_3) }}
    @elseif($row_3['type'] == 'select2MultiNew')
        @php
            $row_3['auto'] = $autoSelect;
            $row_3['autosetup'] = $autosetup;
            $row_3['original'] = $set['name'];
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
        @endphp
        {{ UnitMaker::select2MultiNew($row_3) }}
    @elseif($row_3['type'] == 'selectBydata')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
        @endphp
        {{ UnitMaker::selectBydata($row_3) }}
    @elseif($row_3['type'] == 'textArea')
        @php
            $row_3['auto'] = $autoSelect;
            $row_3['autosetup'] = $autosetup;
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = '';
        @endphp
        {{ UnitMaker::textArea($row_3) }}
    @elseif($row_3['type'] == 'lang_textArea')
        <li class="inventory">
            <p class="subtitle">{{ !empty($row_3['title']) ? $row_3['title'] : '' }}</p>
            @foreach(Config::get('cms.langArray') as $val)
                <div class="Leon-langs-input">
                    <span>{{ $val['abb_title'] }}</span>
                    <textarea name="{{ $set['name'] }}[{{ $val['key'] . '_' . $row_3['value'] }}]" type="text" @if(!empty($row_3['verify'])&&empty($row_3['disabled'])) data-verify=" {{ json_encode($row_3['verify']) }}" @endif {{ !empty($row_3['disabled']) ? $row_3['disabled'] : '' }}></textarea>
                </div>
            @endforeach
            @if(!empty($row_3['tip']))
                <div class="tips">
                    <span class="title">TIPS</span>
                    <p>{!! $row_3['tip'] !!}</p>
                </div>
            @endif
        </li>
    @elseif($row_3['type'] == 'textSummernote')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = false;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = '';
        @endphp
        {{ UnitMaker::textSummernote($row_3) }}
    @elseif($row_3['type'] == 'sn_textArea')
        @php
            $row_3['sontable'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['tips'] = !empty($row_3['tip']) ? $row_3['tip'] : '';
        @endphp
        {{ UnitMaker::sn_textArea($row_3) }}
    @elseif($row_3['type'] == 'radio_btn')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = 0;
        @endphp
        {{ UnitMaker::radio_btn($row_3) }}
    @elseif($row_3['type'] == 'image_group')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = false;
            if(isset($row_3['input'])){
                $row_3['image_array'][0]['input'] = '';
                foreach($row_3['input'] as $k=>$v){
                    $row_3['input'][$k]['value'] = $set['name'] . '[' . $row_3['input'][$k]['value'] . '][]';
                }
                // $row_3['input'] = $set['name'] . '[' . $row_3['input'] . '][]';
            }
            $row_3['image_array'] = array_map(function ($inner) use ($set) {
            $inner['name'] = $set['name'] . '[' . $inner['value'] . ']';
            $inner['value'] = '';
            return $inner;
            }, $row_3['image_array'] ?? []);
        @endphp
        {{ UnitMaker::imageGroup($row_3) }}
    @elseif($row_3['type'] == 'selectMulti')
        @php
            $title = !empty($row_3['title']) ? $row_3['title'] : '';
            $select_value = !empty($row_3['value']) ? $row_3['value'] : 0;
            $select_options = !empty($row_3['options']) ? $row_3['options'] : [];
            $options_group_set = !empty($row_3['options_group_set']) ? $row_3['options_group_set'] : 'no';
            $options_group = !empty($row_3['options_group']) ? $row_3['options_group'] : [];
            $tip = !empty($row_3['tip']) ? $row_3['tip'] : '';
            $randomWord_multi = \Illuminate\Support\Str::random(17);
        @endphp

        <li class="inventory">
            <p class="subtitle">{{ $title }}</p>
            <div class="inner">
                <div class="quill_select multi_select">
                    <div class="select_object">
                        <p class="title addMultiKey" data-key="{{ $randomWord_multi }}">
                        </p>
                        <span class="arrow pg-arrow_down"></span>
                    </div>

                    @if(!empty($disabled) and $disabled == 'disabled')
                    @else
                        <input class="addMulitSelectClass" name="{{ $set['name'] }}[{{ $row_3['value'] }}]" data-key="{{ $randomWord_multi }}" type="hidden" value="">
                        <div class="select_wrapper">
                            <ul class="addMultiKey addMulitListClass select_list" data-key="{{ $randomWord_multi }}">
                                @if($options_group_set == 'yes')
                                    @foreach($options_group as $key_1 => $row_1)
                                        <p class="category">{{ $row_1['title'] }}</p>

                                        @foreach($row_1['key'] as $row_key)
                                            @foreach($select_options as $keyy => $roww)
                                                @if($value_o['key'] == $row_key)
                                                    <li class="multi_select_fantasy option {{ '' }}" data-id="{{ $roww['key'] }}">
                                                        <p>{{ $roww['title'] }}</p>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @else
                                    @foreach($select_options as $keyy => $roww)
                                        <li class="multi_select_fantasy option {{ '' }}" data-id="{{ $roww['key'] }}">
                                            <p>{{ $roww['title'] }}</p>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            @if(!empty($tip))
                <div class="tips">
                    <span class="title">TIPS</span>
                    <p>{!! $tip !!}</p>
                </div>
            @endif
        </li>
    @elseif($row_3['type'] == 'selectMultiBydata')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
        @endphp
        {{ UnitMaker::selectMultiBydata($row_3) }}
    @elseif($row_3['type'] == 'selectGroup')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['rand'] = '';
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
            $row_3['value'] = 0;
        @endphp
        {{ UnitMaker::selectGroup($row_3) }}
    @elseif($row_3['type'] == 'datePicker')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = false;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = '';
        @endphp
        {{ UnitMaker::datePicker($row_3) }}
    @elseif($row_3['type'] == 'timePicker')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = false;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = '';
        @endphp
        {{ UnitMaker::timePicker($row_3) }}
    @elseif($row_3['type'] == 'dateRange')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['name2'] = $set['name'] . '[' . $row_3['value2'] . ']';
            $row_3['value'] = '';
            $row_3['value2'] = '';
        @endphp
        {{ UnitMaker::dateRange($row_3) }}
    @elseif($row_3['type'] == 'timeRange')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['name2'] = $set['name'] . '[' . $row_3['value2'] . ']';
            $row_3['value'] = '';
            $row_3['value2'] = '';
        @endphp
        {{ UnitMaker::timeRange($row_3) }}
    @elseif($row_3['type'] == 'dateTime')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['name2'] = $set['name'] . '[' . $row_3['value2'] . ']';
            $row_3['value'] = '';
            $row_3['value2'] = '';
        @endphp
        {{ UnitMaker::dateTime($row_3) }}
    @elseif($row_3['type'] == 'colorPicker')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = false;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = $row_3['default'] ?? '#fff';
        @endphp
        {{ UnitMaker::colorPicker($row_3) }}
    @elseif($row_3['type'] == 'filePicker')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = false;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
            $row_3['value'] = '';
        @endphp
        {{ UnitMaker::filePicker($row_3) }}
    @elseif($row_3['type'] == 'select_simple')
        @php
            $row_3['sontable'] = true;
            $row_3['sontable_add'] = true;
            $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
        @endphp
        {{ UnitMaker::select($row_3) }}
    @elseif($row_3['type'] == 'html')
        <li class="inventory row_style"></li>
    @endif
    @endforeach

    {{-- -----------------------------第三層圖片管理----------------------------- --}}
    @php
        $is_three = !empty($row_2['is_three']) ? $row_2['is_three'] : 'no';
        $is_three_create = !empty($row_2['create']) ? $row_2['create'] : 'yes';
        $is_three_delete = !empty($row_2['delete']) ? $row_2['delete'] : 'yes';
        $is_three_copy = !empty($row_2['copy']) ? $row_2['copy'] : 'yes';
        $MultiImgcreate = !empty($row_2['three']['MultiImgcreate']) ? $row_2['three']['MultiImgcreate'] : 'no';
        $imageColumn = !empty($row_2['three']['imageColumn']) ? $row_2['three']['imageColumn'] : '';
        $three = !empty($row_2['three']) ? $row_2['three'] : [];
    @endphp

    @if($is_three == 'yes')
        @php
            $son_son_db = $row_2['three_model'];
            $threeDataArray = [
            'son_son_db' => $son_son_db,
            'sort_field' => $row_2['sort_field'] ?? '',
            'three' => $three,
            ];
            $add_html = View::make('Fantasy.cms_view.includes.template.WNsontable.add_html', $threeDataArray)->render();
            $third_randomWord = \Illuminate\Support\Str::random(9) . $key_2;
        @endphp

        <li class="inventory" style="display:block">
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{{ $three['tip'] }}</p>
            </div>

            {{-- /*編輯按鈕群*/ --}}
            <div class="frame">
                <!--photo，video點了打開FMS ， embed點了直接新增一個list-->
                <ul class="table_head">
                    <li class="table_head_th">
                        @if($is_three_create == 'yes')
                            <div class="td tool_btn addInThirdTb addValueInTable" data-table="{{ $third_randomWord }}" data-content='{{ $add_html }}' toolBtn-id="1">
                                <!--打開fms-->
                                <span class="fa fa-plus"></span>
                                <p>Add</p>
                            </div>
                        @endif

                        {{-- 批次新增圖片按鈕 --}}
                                                        
                        @if ($MultiImgcreate == 'yes')
                        <div class="td tool_btn addInThirdTb lbox_fms_open" data-table="{{ $third_randomWord }}" data-type="sontable"
                         data-key="{{ $third_randomWord }}" data-content="{{ $add_html }}" data-model="{{ $son_son_db }}" 
                         data-column="{{ $imageColumn }}" toolBtn-id="1">
                            <span class="fa fa-plus"></span>
                            <p>Add multi image</p>
                        </div>
                        @endif

                        @if($is_three_copy == 'yes')
                            <div class="td tool_btn threeTableCopy CopySonTableDataGroup" data-table="{{ $third_randomWord }}" data-setting="{{ $setting }}" toolBtn-id="1">
                                <span class="fa fa-files-o"></span>
                                <p>Copy</p>
                            </div>
                        @endif

                        @if($is_three_delete == 'yes')
                            <div class="td tool_btn deleteThirdTableDataGroup" data-table="{{ $third_randomWord }}" data-model="{{ $son_son_db }}" toolBtn-id="4">
                                <span class="fa fa-trash"></span>
                                <p>Delete</p>
                            </div>
                        @endif
                    </li>
                </ul>
                <ul style="display: none">
                    <li class="tabulation_head three">
                        <div class="list">
                            <div class="item t-a-c check_box">
                                <p>選擇</p>
                            </div>
                            <div class="item t-a-c sort_number">
                                <p>順序</p>
                            </div>
                            @foreach($three['three_tableSet'] as $three_val)
                                <div class="item t-a-c {{ $three_val['type'] == 'radio_btn' ? 'switch_btn' : 'text' }}">
                                    <p>{{ $three_val['title'] }}</p>
                                </div>
                            @endforeach
                            <div class="item t-a-c edit_btnGroup">
                                <p>編輯</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="table_list quill_partImg table_box thirdTbNew_{{ $third_randomWord }} {{($three['article_video'] ?? '')}} son-table">
                </ul>
        </li>
    @endif
    </ul>
    </li>
    @endforeach
    </ul>
    </div>
    @endif
</form>
