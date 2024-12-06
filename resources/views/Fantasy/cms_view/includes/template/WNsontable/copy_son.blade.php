@php
$select2MultiIndex = 0;
$three_select2MultiIndex = 0;
@endphp
@php

@endphp
@foreach ($value as $key => $row)
@php
$keyRank = 1;
$randomWord_va = \Illuminate\Support\Str::random(5);
@endphp
<form class="list stack_state cms_new_{{$randomWord_va}}" data-key="{{$randomWord_va}}" data-id="{{$row['id']}}" data-rank="{{$keyRank}}">
    <div class="wait-save-box {{($row['wait_save_del']) ? 'active':''}}">
        <input type="hidden" value="{{$row['wait_save_del']}}" name="{{$set['name']}}[wait_save_del][]">
        <div class="wait-save-del">點擊Setting後刪除此筆資料<a class="wait-save-del-cancel"><span class="fa fa-remove"></span></a></div>
    </div>
    <div class="list_box">
        <div class="item check_box cms_new_{{$randomWord_va}}" data-id="{{$row['id']}}" data-key="{{$randomWord_va}}">
            <input type="checkbox" class="content_input list_checkbox">
            <label class="content_inputBox">
                <span></span>
            </label>
        </div>

        <input type="hidden" value="{{$row['id']}}" name="{{$set['name']}}[id][]" class="cms_new_{{$randomWord_va}}">
        <input type="hidden" value="{{$randomWord_va}}" name="{{$set['name']}}[quillFantasyKey][]">

        @if ($sort == 'yes')
        <div class="item sort_number">
            <input type="text" value="{{$row[$set['sort_field'] ?: 'w_rank'] ?? '0'}}" name="{{$set['name']}}[{{$set['sort_field'] ?: 'w_rank'}}][]">
        </div>
        @endif

        {{-- 表格內容 --}}

        @foreach ($tableSet as $key2 => $row2)
        @if ($row2['type'] == 'textInput')
        <div class="item text">
            <input type="text" value="{{$row[$row2['value']] ?? $row2['default'] ?? ''}}" placeholder="Please enter here" style="border-style:none;background-color: #efefef;border: solid 1px #c7c7c7;width: 90%;" name="{{$set['name']}}[{{$row2['value']}}][]">
        </div>

        @elseif ($row2['type'] == 'text_image')
        @if (isset($files_temp_array[$row[$row2['img']]]) && $files_temp_array[$row[$row2['img']]]['type'] != 'pdf')
        <div class="item text btn_ctable">
            <div class="s_img">
                <img class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['img']:''}}" src="{{$files_temp_array[$row[$row2['img']]]['real_m_route']}}">
            </div>
            <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}">{{$row[$row2['value']] ?: '-'}}</p>
        </div>
        @else
        <div class="item text btn_ctable">
            <div class="s_img">
                <img class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['img']:''}}" src="">
            </div>
            <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}">{{$row[$row2['value']] ?: '-'}}</p>
        </div>
        @endif

        @elseif ($row2['type'] == 'filesText')

        @if (isset($files_temp_array[$row[$row2['value']]]) && $files_temp_array[$row[$row2['value']]]['type'] != 'pdf')
        <div class="item text btn_ctable filesText">
            <div class="s_img">
                <img src="{{$files_temp_array[$row[$row2['value']]]['real_m_route']}}" alt="">
            </div>
            <p>{{$files_temp_array[$row[$row2['value']]]['title']}}.{{$files_temp_array[$row[$row2['value']]]['type']}}</p>
        </div>
        @else
        <div class="item text btn_ctable">
            <div class="s_img">
                <img src="" alt="">
            </div>
            <p></p>
        </div>
        @endif

        @elseif ($row2['type'] == 'radio_btn')

        <div class="item ios_switch radio_btn_switch {{($row[$row2['value']] == 1) ? 'on':''}}" style="min-width: 80px">
            <input type="text" name="{{$set['name']}}[{{$row2['value']}}][]" value="{{$row[$row2['value']]}}">
            <div class="box" style="left: 23%;">
                <span class="ball"></span>
            </div>
        </div>

        @elseif ($row2['type'] == 'select_just_show')

        @php
        $temp_options = (!empty($row2['options'])) ? $row2['options'] : [];
        $this_value = (!empty($row[$row2['value']])) ? $row[$row2['value']] : 0;

        $findkey = findkey($temp_options,'key',$this_value);
        $key = ($findkey !== null) ? $findkey : 'typeBasic';
        @endphp
        <div class="item text btn_ctable">
            <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}">{{$temp_options[$key]['title'] ?? '-'}}</p>
        </div>
        @elseif ($row2['type'] == 'select_article4_show')
        @php
        $temp_options = (!empty($row2['options'])) ? $row2['options'] : [];
        $this_value = (!empty($row[$row2['value']])) ? $row[$row2['value']] : 0;
        $findkey = findkey($temp_options,'key',$this_value);
        $key = ($findkey !== null) ? $findkey : 'typeBasic';
        @endphp
        <div class="item text btn_ctable">
            <div class="s_img">
                <img src="/vender/assets/img/article4/{{ $this_value }}.jpg " alt="">
            </div>
            <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}">{{$temp_options[$key]['title'] ?: '-'}}</p>
        </div>

        @elseif ($row2['type'] == 'select2')

        @php
        $temp_options = (!empty($row2['options'])) ? $row2['options'] : [];
        $options_group_set = (!empty($row2['options_group_set'])) ? $row2['options_group_set'] : 'no';
        $options_group = (!empty($row2['options_group'])) ? $row2['options_group'] : [];
        $this_value = (in_array($this_value,array_column($temp_options,'key'))) ? array_search($this_value,array_column($temp_options,'key')) : 0;
        @endphp

        <div class="item text">
            <div class="quill_select" style="width:100%;">
                <div class="select_object" style="border-style: none;">
                    @if (isset($temp_options[$this_value]['title']) and !empty($temp_options[$this_value]['title']))
                    <p class="title">{{$temp_options[$this_value]['title']}}</p>
                    @else
                    <p class="title"></p>
                    @endif
                    <span class="arrow pg-arrow_down"></span>
                </div>

                <div class="select_wrapper">
                    <ul class="select_list edit_select">
                        @if ($options_group_set == 'yes')
                        @foreach ($options_group as $key_1 => $row_1)
                        <p class="category">{{$row_1['title']}}</p>

                        @foreach ($row_1['key'] as $row2)
                        @foreach ($temp_options as $key3 => $row3)
                        @if ($row3['key'] == $row2)
                        <li class="option single_select_fantasy" data-id="{{$row3['key']}}">
                            <p>{{$row3['title']}}</p>
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                        @else
                        @foreach ($temp_options as $key3 => $row3)
                        <li class="option single_select_fantasy" data-id="{{$row3['key']}}">
                            <p>{{$row3['title']}}</p>
                        </li>
                        @endforeach
                        @endif

                        <input type="hidden" name="{{$set['name']}}[{{$row2['value']}}][]" value="{{$this_value}}">
                    </ul>
                </div>
            </div>
        </div>

        @elseif ($row2['type'] == 'just_show')

        @if (!empty($row[$row2['value']]))
        <div class="item text btn_ctable">
            <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}">{{$row[$row2['value']]}}</p>
        </div>
        @else
        <div class="item text btn_ctable">
            <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}">{{!empty($row2['default']) ? $row2['default'] : ''}}</p>
        </div>
        @endif

        @endif
        @endforeach


        {{-- 編輯按鈕群 --}}
        @if($hasContent == 'yes' || $delete == 'yes')
        <div class="item edit_btnGroup">

            @if ($hasContent == 'yes')
            <span class="fa fa-pencil-square-o btn_ctable" data-key="{{$randomWord_va}}"></span>
            @endif

            @if($delete == 'yes')
            <span class="fa fa-trash deleteSonTableData" data-id="{{$row['id']}}" data-key="{{$randomWord_va}}" data-model="{{$set['name']}}"></span>
            @endif

            @if ($is_link == 'yes')
            <a href="javascript:;" class="{{$link_class}}" @foreach ($link_key as $dataSet) data-{{$dataSet}}="{{$row[$dataSet]}}" @endforeach>
                <span class="fa fa-link"></span>
            </a>
            @endif
        </div>
        @endif
        {{-- 編輯按鈕群 --- END --}}
    </div>

    @if ($hasContent == 'yes')
    <div class="list_frame list_frame_{{$randomWord_va}}">
        @if (count($tabSet) > 0)
        <ul class="list_headBar">
            @foreach ($tabSet as $key_2 => $row_2)
            <li class="{{($key_2 == 0) ? 'now':'' }}" bar-id="{{$key_2}}">
                <p>{{$row_2['title']}}</p>
            </li>
            @endforeach
        </ul>
        @endif
        <ul class="list_body">
            @foreach ($tabSet as $key_2 => $row_2)
            <li class="list_bodyL part_content" body-id="{{$key_2}}">
                <ul class="list_part_body">
                    @foreach ($row_2['content'] ?? [] as $key_3 => $row_3)
                    @php
                    $auto = (isset($row_3['auto'])) ? ' DataSync':'';
                    $autoSelect = (isset($row_3['auto'])) ? 'DataSyncSelect':'';
                    $autosetup = (isset($row_3['auto'])) ? 'AutoSet_'.$row_3['value']:'';
                    @endphp
                    @if ($row_3['type'] == 'multiLocal')
                    <li class="inventory">
                        <div class="list_frame" style="display: block;">
                            <ul class="list_headBar">
                                @foreach ($langArray as $multiLocalKey => $multiLocalVal)
                                <li @if($multiLocalKey==array_key_first($langArray)) class="now" @endif bar-id="multiLocal_{{$multiLocalKey}}">
                                    <p>{{$multiLocalVal['title']}}</p>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="list_body" style="padding: 30px 15px;">
                                @foreach ($langArray as $multiLocalKey => $multiLocalVal)
                                <li class="list_bodyL part_content" body-id="multiLocal_{{$multiLocalKey}}">
                                    <ul class="list_part_body">
                                        @foreach ($row_3['content'] as $mkey_3 => $mrow_3)
                                        @if ($mrow_3['type'] == 'textInput')
                                        <li class="inventory">
                                            <p class="subtitle">{{(!empty($mrow_3['title'])) ? $mrow_3['title'] : ''}}</p>
                                            <input class="normal_input {{$auto}}" data-autosetup="{{$autosetup}}" type="text" value="{{$row[$multiLocalVal['key'].'_'.$mrow_3['value']]}}" name="{{$set['name']}}[{{$multiLocalVal['key'].'_'.$mrow_3['value']}}][]" {{(!empty($mrow_3['disabled'])) ? $mrow_3['disabled'] : ''}}>
                                            @if (!empty($mrow_3['tip']))
                                            <div class="tips">
                                                <span class="title">TIPS</span>
                                                <p>{!!$mrow_3['tip']!!}</p>
                                            </div>
                                            @endif
                                        </li>
                                        @elseif ($mrow_3['type'] == 'textSummernote')
                                        @php
                                        $data = [
                                        'name' => $set['name'].'['.$multiLocalVal['key'].'_'.$mrow_3['value'].'][]',
                                        'title' => $mrow_3['title'],
                                        'disabled' => !empty($mrow_3['disabled']) ? $mrow_3['disabled'] : '',
                                        'value' => $row[$multiLocalVal['key'].'_'.$mrow_3['value']],
                                        'tip' => (!empty($mrow_3['tip'])) ? $mrow_3['tip'] : ''
                                        ];
                                        @endphp
                                        {{UnitMaker::textSummernote($data)}}
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @elseif ($row_3['type'] == 'lang_textInput')
                    @php
                    $row_3['sontable'] = true;
                    $row_3['model'] = $set['name'];
                    $row_3['name'] = $row_3['value'];
                    @endphp
                    {{UnitMaker::lang_textInput($row_3)}}

                    @elseif (in_array($row_3['type'],['textInput','textInputTarget','textInputTargetAcc']))
                    <li class="inventory">
                        <p class="subtitle">{{!empty($row_3['title']) ? $row_3['title'] : ''}}</p>
                        <div class="inner {{ (isset($row_3['target']) && !empty($row_3['target'])) ? 'url_target':'' }}">
                            <input class="normal_input {{$auto}}" data-autosetup="{{$autosetup}}" type="text" value="{{$row[$row_3['value']]}}" name="{{$set['name']}}[{{$row_3['value']}}][]" {{!empty($row_3['disabled']) ? $row_3['disabled'] : ''}}>
                            @if(isset($row_3['target']) && !empty($row_3['target']))
                            <div class="checkbox_area">
                                <div class="content">
                                    <label class="son box {{($row[$row_3['target']['name']] == '2') ? 'active':''}}" data-hide="{{$row[$row_3['target']['name']]}}">
                                        <input type="hidden" name="{{$set['name']}}[{{$row_3['target']['name']}}][]" value="{{$row[$row_3['target']['name']]}}">
                                        <div class="plan">
                                            <span class="circle"></span>
                                            <span class="yearly">於新視窗開啟</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if(isset($row_3['accessible']))
                        <p>無障礙讀音內容</p>
                        <div class="inner">
                            <input class="normal_input" type="text" value="{{$row[$row_3['accessible']['name']]}}" name="{{$set['name'].'['.$row_3['accessible']['name'].']'}}[]" required autocomplete="off">
                        </div>
                        @endif
                        @if (!empty($row_3['tip']))
                        <div class="tips">
                            <span class="title">TIPS</span>
                            <p>{!!$row_3['tip']!!}</p>
                        </div>
                        @endif
                    </li>
                    @elseif ($row_3['type'] == 'radio_area')
                    @php
                    $row_3['auto'] = $autoSelect;
                    $row_3['autosetup'] = $autosetup;
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::radio_area($row_3)}}
                    @elseif ($row_3['type'] == 'numberInput')
                    @php
                        $row_3['sontable'] = true;
                        $row_3['sontable_add'] = true;
                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                        $row_3['value'] = $row[$row_3['value']] ?? '0';
                    @endphp
                    {{ UnitMaker::numberInput($row_3) }}
                    @elseif ($row_3['type'] == 'select2')
                    @php
                    $row_3['auto'] = $autoSelect;
                    $row_3['autosetup'] = $autosetup;
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::select2($row_3)}}
                    @elseif ($row_3['type'] == 'select2Multi')
                    @php
                    $row_3['auto'] = $autoSelect;
                    $row_3['autosetup'] = $autosetup;
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['original'] = $set['name'] . '[' . $row_3['value'] . ']';
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']['.$select2MultiIndex.']';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::select2Multi($row_3)}}
                    @elseif ($row_3['type'] == 'select2MultiNew')
                    @php
                    $row_3['auto'] = $autoSelect;
                    $row_3['autosetup'] = $autosetup;
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['original'] = $set['name'] . '[' . $row_3['value'] . ']';
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']['.$select2MultiIndex.']';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::select2MultiNew($row_3)}}
                    @elseif ($row_3['type'] == 'selectBydata')
                    @php
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::selectBydata($row_3)}}
                    @elseif ($row_3['type'] == 'textArea')
                    @php
                    $row_3['auto'] = $autoSelect;
                    $row_3['autosetup'] = $autosetup;
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::textArea($row_3)}}
                    @elseif ($row_3['type'] == 'lang_textArea')
                    @php
                    $row_3['sontable'] = true;
                    $row_3['model'] = $set['name'];
                    $row_3['name'] = $row_3['value'];
                    @endphp
                    {{UnitMaker::lang_textArea($row_3)}}
                    @elseif ($row_3['type'] == 'textSummernote')
                    @php
                    $data = [
                    'name' => "{$set['name']}[{$row_3['value']}][]",
                    'title' => $row_3['title'],
                    'value' => $row[$row_3['value']],
                    'disabled' => !empty($row_3['disabled']) ? $row_3['disabled'] : '',
                    'tip' => (!empty($row_3['tip'])) ? $row_3['tip'] : ''
                    ];
                    @endphp

                    {{UnitMaker::textSummernote($data)}}

                    @elseif ($row_3['type'] == 'sn_textArea')

                    @php
                    $row_3['sontable'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    $row_3['tips'] = (!empty($row_3['tip'])) ? $row_3['tip'] : '';
                    @endphp
                    {{UnitMaker::sn_textArea($row_3)}}

                    @elseif ($row_3['type'] == 'radio_btn')

                    @php
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = false;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::radio_btn($row_3)}}

                    @elseif ($row_3['type'] == 'image_group')
                    @php
                    $image_array = !empty($row_3['image_array']) ? $row_3['image_array'] : [];
                    @endphp
                    <li class="inventory productImage">
                        <p class="subtitle">{{!empty($row_3['title']) ? $row_3['title'] : ''}}</p>
                        <div class="picture_box">
                            @foreach ($image_array as $key_img => $value_img)
                            @php
                            $randomWord_img=\Illuminate\Support\Str::random(34);
                            if (isset($files_temp_array[$row[$value_img['value']]]) and !empty($files_temp_array[$row[$value_img['value']]])) {
                            $imgClass='has_img' ;
                            $imgSrc=$files_temp_array[$row[$value_img['value']]]['real_m_route'];
                            } else {
                            $imgClass='' ;
                            $imgSrc='' ;
                            }
                            if ($value_img['set_size']=='yes' ) {
                            $width=($value_img['width'] / $value_img['height']) * 100;
                            $width .='px;' ;
                            $img_style='' ;
                            } else {
                            $width='auto;' ;
                            $img_style='height:auto;max-width: 200px;min-height: 100px;' ;
                            }
                            if (isset($value_img['disabled']) and $value_img['disabled']=='disabled' ) {
                            $lbox_fms_open='' ;
                            } else {
                            $lbox_fms_open='lbox_fms_open' ;
                            }

                            $auto = (isset($value_img['auto'])) ? ' DataSync':'';
                            $autosetup = (isset($value_img['auto'])) ? 'AutoSet_'.$value_img['value']:'';

                            @endphp
                            <div class="frame open_fms_lightbox {{$imgClass}}">
                                <div class="box {{$auto}}" data-autosetup="{{$autosetup}}" style="width:{{$width}};height:auto;">
                                    <img src="{{$imgSrc}}" style="{{$img_style}}" class="img_{{$randomWord_img}}">
                                    <input type="hidden" name="{{$set['name']}}[{{$value_img['value']}}][]" value="{{$row[$value_img['value']]}}" class="value_{{$randomWord_img}}">
                                    <span class="icon fa fa-plus {{$lbox_fms_open}}" data-key="{{$randomWord_img}}" data-type="img"></span>

                                    <div class="tool">
                                        <span class="t_icon fa fa-folder file_detail_btn"></span>
                                        <span class="t_icon fa fa-pencil {{$lbox_fms_open}}" data-key="{{$randomWord_img}}" data-type="img"></span>
                                        <span class="t_icon fa fa-trash image_remove" data-key="{{$randomWord_img}}" data-type="img"></span>
                                    </div>
                                </div>

                                <div class="info">
                                    <p>{{$value_img['title']}}</p>
                                </div>

                                @if (isset($files_temp_array[$row[$value_img['value']]]) and !empty($files_temp_array[$row[$value_img['value']]]))
                                @php
                                $_this_file_path = BaseFunction::get_file_path($files_temp_array[$row[$value_img['value']]]);
                                @endphp

                                <div class="file_detail_box">
                                    <div class="info_detail">
                                        <p class="file_{{$randomWord_img}}"><span>FILE</span>{{$files_temp_array[$row[$value_img['value']]]['title']}}.{{$files_temp_array[$row[$value_img['value']]]['type']}}</p>
                                        <p class="folder_{{$randomWord_img}}"><span>FOLDER</span>{{$_this_file_path}}</p>
                                        <p class="type_{{$randomWord_img}}"><span>TYPE</span>{{$files_temp_array[$row[$value_img['value']]]['type']}}</p>
                                        <p class="size_{{$randomWord_img}}"><span>SIZE</span>{{$files_temp_array[$row[$value_img['value']]]['resolution']}}</p>
                                    </div>
                                </div>
                                @else
                                <div class="file_detail_box">
                                    <div class="info_detail">
                                        <p class="file_{{$randomWord_img}}"><span>FILE</span></p>
                                        <p class="folder_{{$randomWord_img}}"><span>FOLDER</span></p>
                                        <p class="type_{{$randomWord_img}}"><span>TYPE</span></p>
                                        <p class="size_{{$randomWord_img}}"><span>SIZE</span></p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        @if (!empty($row_3['tip']))
                        <div class="tips">
                            <span class="title">TIPS</span>
                            <p>{!!$row_3['tip']!!}</p>
                        </div>
                        @endif
                    </li>

                    @elseif ($row_3['type'] == 'selectMulti')

                    @php
                    $select_value = (!empty($row[$row_3['value']])) ? $row[$row_3['value']] : '';
                    $select_options = (!empty($row_3['options'])) ? $row_3['options'] : [];
                    $options_group_set = (!empty($row_3['options_group_set'])) ? $row_3['options_group_set'] : 'no';
                    $options_group = (!empty($row_3['options_group'])) ? $row_3['options_group'] : [];

                    // 隨機亂碼
                    $randomWord=\Illuminate\Support\Str::random(30);
                    if (!empty($select_value)) { $value_array=json_decode($select_value, true); } else { $value_array=[]; } $select_value=htmlentities($select_value); @endphp <li class="inventory">
                        <p class="subtitle">{{!empty($row_3['title']) ? $row_3['title'] : ''}}</p>

                        <div class="inner">
                            <div class="quill_select multi_select">
                                <div class="select_object">
                                    <p class="title" data-key="{{$randomWord}}"></p>
                                    <span class="arrow pg-arrow_down"></span>
                                </div>

                                @if (!empty($disabled) and $disabled == 'disabled')

                                @else
                                <input type="hidden" name="{{$set['name']}}[{{$row_3['value']}}][]" value="{{$select_value}}" class="multi_select_{{$randomWord}}">
                                <div class="select_wrapper">
                                    <ul class="select_list multi_sselect_list_{{$randomWord}}" data-key="{{$randomWord}}">

                                        @if ($options_group_set == 'yes')
                                        @foreach ($options_group as $key_1 => $row_1)
                                        <p class="category">{{$row_1['title']}}</p>

                                        @foreach ($row_1['key'] as $row_key)
                                        @foreach ($select_options as $keyy => $roww)
                                        @if ($value_o['key'] == $row_key)
                                        @php
                                        $value_on = '';
                                        foreach ($value_array as $keyy2 => $roww2) {
                                        if ($roww2 == $roww['key']) {
                                        $value_on = 'default';
                                        }
                                        }
                                        @endphp

                                        <li class="multi_select_fantasy option {{$value_on}}" data-id="{{$roww['key']}}">
                                            <p>{{$roww['title']}}</p>
                                        </li>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                        @else
                                        @foreach ($select_options as $keyy => $roww)
                                        @php
                                        $value_on = '';
                                        foreach ($value_array as $keyy2 => $roww2) {
                                        if ($roww2 == $roww['key']) {
                                        $value_on = 'default';
                                        }
                                        }
                                        @endphp

                                        <li class="multi_select_fantasy option {{$value_on}}" data-id="{{$roww['key']}}">
                                            <p>{{$roww['title']}}</p>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if (!empty($row_3['tip']))
                        <div class="tips">
                            <span class="title">TIPS</span>
                            <p>{!!$row_3['tip']!!}</p>
                        </div>
                        @endif
                    </li>

                    @elseif ($row_3['type'] == 'selectGroup')

                    @php
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = false;
                    $row_3['rand'] = $randomWord_va;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp

                    {{UnitMaker::selectGroup($row_3)}}

                    @elseif ($row_3['type'] == 'selectMultiBydata')

                    @php
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::selectMultiBydata($row_3)}}

                    @elseif ($row_3['type'] == 'datePicker')

                    @php
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    @endphp
                    {{UnitMaker::datePicker($row_3)}}

                    @elseif($row_3['type'] == 'dateRange')

                    @php
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = false;
                    $row_3['name'] = $set['name'].'['.$row_3['value'].'][]';
                    $row_3['name2'] = $set['name'].'['.$row_3['value2'].'][]';
                    $row_3['value'] = $row[$row_3['value']];
                    $row_3['value2'] = $row[$row_3['value2']];
                    @endphp
                    {{UnitMaker::dateRange($row_3)}}

                    @elseif ($row_3['type'] == 'colorPicker')
                    @php
                        $row_3['sontable'] = true;
                        $row_3['sontable_add'] = false;
                        $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                        $row_3['value'] = $row[$row_3['value']] ?: $row_3['default'] ?? '#000000';
                    @endphp
                    {{ UnitMaker::colorPicker($row_3) }}

                    @elseif ($row_3['type'] == 'filePicker')

                    @php
                    $title = (!empty($row_3['title'])) ? $row_3['title'] : '';
                    $tip = (!empty($row_3['tip'])) ? $row_3['tip'] : '';
                    $disabled = (!empty($row_3['disabled'])) ? $row_3['disabled'] : '';

                    if (!empty($disabled) and $disabled == 'disabled') {
                    $openClass = '';
                    } else {
                    $openClass = 'lbox_fms_open';
                    }

                    $fileInformationArray = [];
                    $fileIds = [];

                    array_push($fileIds, $row[$row_3['value']]);
                    if (!empty($fileIds)) {
                    $fileInformationArray = BaseFunction::getFilesArrayWithKey($fileIds);
                    }


                    $randomWord=\Illuminate\Support\Str::random(12); if (isset($fileInformationArray[$row[$row_3['value']]]) and !empty($fileInformationArray[$row[$row_3['value']]])) { $fileData=$fileInformationArray[$row[$row_3['value']]]['title'] . '.' . $fileInformationArray[$row[$row_3['value']]]['type']; $fileRoute=$fileInformationArray[$row[$row_3['value']]]['real_route']; } else { $fileData='' ; $fileRoute='' ; } @endphp <li class="inventory" style="display: block;">
                        <p class="subtitle">{{$title}}</p>

                        <input class="normal_input filepicker_input_{{$randomWord}}" type="text" value="{{$fileData}}" style="width:70%;" disabled>
                        <input class="normal_input {{$openClass}}" type="button" value="..." style="width:5%;cursor: pointer;" data-key="{{$randomWord}}" data-type="file">

                        @if ($fileData != "")
                        <input class="normal_input file_fantasy_download filepicker_src_{{$randomWord}} filepicker_title_{{$randomWord}}" type="button" value="⇩" style="width:5%;cursor: pointer;" data-src="{{$fileRoute}}" data-title="{{$fileData}}">
                        <input id="onlyfileremove" class="normal_input fa-remove" type="button" value="X" style="width:5%;cursor: pointer;">
                        @endif

                        <input type="hidden" value="{{$row[$row_3['value']]}}" name="{{$set['name']}}[{{$row_3['value']}}][]" class="filepicker_value_{{$randomWord}}">
                        @if (!empty($row_3['tip']))
                        <div class="tips">
                            <span class="title">TIPS</span>
                            <p>{!!$row_3['tip']!!}</p>
                        </div>
                        @endif
                    </li>

                    @elseif ($row_3['type'] == 'select_simple')

                    @php
                    $row_3['auto'] = $autoSelect;
                    $row_3['autosetup'] = $autosetup;
                    $row_3['sontable'] = true;
                    $row_3['sontable_add'] = true;
                    $row_3['name'] = $set['name'] . '[' . $row_3['value'] . '][]';
                    $row_3['value'] = $row[$row_3['value']];
                    $row_3['custom'] = true;
                    @endphp
                    {{UnitMaker::select($row_3)}}

                    @elseif ($row_3['type'] == 'html')

                    <li class="inventory row_style ">
                        {!!$row[$row_3['value']]!!}
                    </li>
                    @endif

                    @endforeach

                    @php
                    $is_three = (!empty($row_2['is_three'])) ? $row_2['is_three'] : 'no';
                    $is_three_create = (!empty($row_2['create'])) ? $row_2['create'] : 'yes';
                    $is_three_delete = (!empty($row_2['delete'])) ? $row_2['delete'] : 'yes';
                    $three = (!empty($row_2['three'])) ? $row_2['three'] : [];
                    @endphp

                    @if ($is_three == 'yes')
                    @php
                    $son_son_db = $row_2['three_model'];
                    $third_randomWord = \Illuminate\Support\Str::random(9) . $key_2;

                    $threeDataArray =[
                    'son_son_db' => $son_son_db,
                    'sort_field'=>$row_2['sort_field'] ?? '',
                    'three'=>$three,
                    ];
                    $add_html = View::make('Fantasy.cms_view.includes.template.WNsontable.add_html', $threeDataArray)->render();
                    @endphp

                    <li class="inventory" style="display:block">
                        <p class="subtitle">{{$three['title']}}</p>
                        @if(!empty($three['tip']))
                        <div class="tips">
                            <span class="title">TIPS</span>
                            <p>{!!$three['tip']!!}</p>
                        </div>
                        @endif

                        {{-- 編輯按鈕群 --}}
                        <div class="frame">
                            <!--photo，video點了打開FMS ， embed點了直接新增一個list-->
                            <ul class="table_head">
                                <li class="table_head_th">
                                    @if($is_three_create == 'yes')
                                    <div class="td tool_btn addInThirdTb" data-table="{{$third_randomWord}}" data-content="{{$add_html}}" toolBtn-id="1">
                                        <span class="fa fa-plus"></span>
                                        <p>Add</p>
                                    </div>
                                    @endif

                                    @if($is_three_delete == 'yes')
                                    <div class="td tool_btn deleteThirdTableDataGroup" data-table="{{$third_randomWord}}" data-model="{{$son_son_db}}" toolBtn-id="4">
                                        <span class="fa fa-trash"></span>
                                        <p>Delete</p>
                                    </div>
                                    @endif
                                </li>
                            </ul>
                            <ul>
                                <li class="tabulation_head three">
                                    <div class="list">
                                        <div class="item t-a-c check_box">
                                            <p>選擇</p>
                                        </div>
                                        <div class="item t-a-c sort_number">
                                            <p>順序</p>
                                        </div>
                                        @foreach($three['three_tableSet'] as $three_val)
                                        <div class="item t-a-c {{($three_val['type'] == 'radio_btn') ? 'switch_btn':'text'}}">
                                            <p>{{$three_val['title']}}</p>
                                        </div>
                                        @endforeach
                                        <div class="item t-a-c edit_btnGroup">
                                            <p>編輯</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="table_list quill_partImg table_box thirdTbNew_{{$third_randomWord}}">
                                @php
                                //抓第三層編輯的所有圖片
                                $three_file_field = collect($three['three_content'])->where('type','image_group')->pluck('image_array')->collapse()->pluck('value')->toArray();
                                $three_file_keys = (isset($row['son'])) ? collect($row['son'][$son_son_db])->map(function($model)use($three_file_field){
                                return collect($model)->only($three_file_field)->values();
                                })->values()->collapse()->toArray() : [];
                                $fileInformationArray = BaseFunction::getFilesArrayWithKey($three_file_keys);

                                @endphp

                                @foreach ($row['son'][$son_son_db] ?? [] as $key_son => $value_son)
                                @php
                                $keyRank = $key_son + 1;
                                $randomWord_son = \Illuminate\Support\Str::random(5) . $key_son;
                                @endphp

                                <form class="three-item item new_{{$randomWord_son}}" partImg-id="{{$value_son['id']}}" data-rank="{{$keyRank}}">
                                    <div class="wait-save-box {{($value_son['wait_save_del']) ? 'active':''}}">
                                        <input type="hidden" value="{{$value_son['wait_save_del']}}" name="{{$son_son_db}}[wait_save_del][]">
                                        <div class="wait-save-del">點擊Setting後刪除此筆資料<a class="wait-save-del-cancel"><span class="fa fa-remove"></span></a></div>
                                    </div>
                                    <div class="list_box">
                                        <div class="item check_box new_{{$randomWord_son}}" data-id="{{$value_son['id']}}" data-key="{{$randomWord_son}}">
                                            <input type="checkbox" class="content_input list_three_checkbox">
                                            <label class="content_inputBox">
                                                <span></span>
                                            </label>
                                        </div>
                                        <input type="hidden" value="{{$value_son['id']}}" name="{{$son_son_db}}[id][]" class="new_{{$randomWord_son}}">
                                        <input type="hidden" value="{{$randomWord_va}}" name="{{$son_son_db}}[quillSonFantasyKey][]">
                                        <input type="hidden" value="{{$value_son[$three['SecondIdColumn']]}}" name="{{$son_son_db}}[{{$three['SecondIdColumn']}}][]" class="addThirdSid">
                                        <div class="item sort_number">
                                            <input type="text" value="{{$value_son[$row_2['sort_field'] ?: 'w_rank']}}" name="{{$son_son_db}}[{{$row_2['sort_field'] ?: 'w_rank'}}][]">
                                        </div>
                                        @foreach($three['three_tableSet'] as $three_val)
                                        @if($three_val['type'] == 'just_show')
                                        <div class="item text btn_ctable">
                                            <p class="{{(isset($three_val['auto'])) ? 'AutoSet_'.$three_val['value']:''}}">{{$value_son[$three_val['value']]}}</p>
                                        </div>
                                        @endif

                                        @if ($three_val['type'] == 'select_just_show')

                                        @php
                                        $temp_options = $three_val['options'] ?? [];
                                        $this_value = $value_son[$three_val['value']] ?? 0;
                                        @endphp
                                        <div class="item text btn_ctable">
                                            <p class="{{(isset($three_val['auto'])) ? 'AutoSet_'.$three_val['value']:''}}">{{collect($temp_options)->where('key',$this_value)->first()['title'] ?? '-'}}</p>
                                        </div>
                                        @endif

                                        @if ($three_val['type'] == 'text_image')
                                        @if (isset($fileInformationArray[$value_son[$three_val['img']]]) && $fileInformationArray[$value_son[$three_val['img']]]['type'] != 'pdf')
                                        <div class="item text btn_ctable">
                                            <div class="s_img">
                                                <img class="{{(isset($three_val['auto'])) ? 'AutoSet_'.$three_val['img']:''}}" src="{{$fileInformationArray[$value_son[$three_val['img']]]['real_route']}}">
                                            </div>
                                            <p class="{{(isset($three_val['auto'])) ? 'AutoSet_'.$three_val['value']:''}}">{{$value_son[$three_val['value']] ?: '-'}}</p>
                                        </div>
                                        @else
                                        <div class="item text btn_ctable">
                                            <div class="s_img">
                                                <img src="">
                                            </div>
                                            <p class="{{(isset($three_val['auto'])) ? 'AutoSet_'.$three_val['value']:''}}">{{$value_son[$three_val['value']] ?: '-'}}</p>
                                        </div>
                                        @endif
                                        @endif

                                        @if($three_val['type'] == 'radio_btn')
                                        <div class="item ios_switch radio_btn_switch {{$value_son[$three_val['value']] ? 'on':''}}" style="min-width: 80px">
                                            <input type="text" name="{{$son_son_db}}[{{$three_val['value']}}][]" value="{{$value_son[$three_val['value']]}}">
                                            <div class="box" style="left: 23%;">
                                                <span class="ball"></span>
                                            </div>
                                        </div>
                                        @endif

                                        @endforeach

                                        <div class="item edit_btnGroup">
                                            <span class="fa fa-pencil-square-o btn_ctable three" data-key="{{$randomWord_son}}"></span>
                                            <span class="fa fa-trash deleteThirdTableData" data-id="{{$value_son['id']}}" data-key="{{$randomWord_son}}" data-model="{{$son_son_db}}"></span>
                                        </div>
                                    </div>
                                    <div class="list_frame">
                                        <ul class="ThreeContent" style="width:100%">
                                            {{-- @include('Fantasy.cms_view.includes.template.WNsontable.three_content',['randomWord_son'=>$randomWord_son,'three_select2MultiIndex'=>$three_select2MultiIndex]) --}}
                                        </ul>
                                    </div>
                                </form>
                                @php
                                $three_select2MultiIndex++;
                                @endphp
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endif
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</form>
@php
$select2MultiIndex++;
@endphp
@endforeach
