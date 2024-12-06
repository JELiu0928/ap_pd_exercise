@php
    $select2MultiIndex = 0;
    $three_select2MultiIndex = 0;
@endphp
<li>
    <section class="composite_btn">
        @if (!empty($table_tip))
            <div class="for_ajax_tips">
                <div class="tips">
                    <span class="title">TIPS</span>
                    <p>{!! $table_tip !!}</p>
                </div>
            </div>
        @endif

        <div class="for_ajax_box">
            {{-- 按鈕框框 --}}
            @if ($create == 'yes' || $delete == 'yes' || $teach == 'yes')

                <ul class="{{ $MultiDatacreate == 'yes' ? 'box open_db_lightbox' : 'box' }}">
                    {{-- 新增按鈕 --}}
                    @if ($create == 'yes')
                        <li class="addValueInTable" data-table="{{ $randomWord }}" data-content="{{ $stack }}">
                            <span class="fa fa-plus"></span>
                            <p>Add</p>
                        </li>
                    @endif

                    {{-- 批次新增圖片按鈕 --}}
                    @if ($MultiImgcreate == 'yes')
                        <li class="lbox_fms_open" data-table="{{ $randomWord }}" data-key="{{ $randomWord }}"
                            data-model="{{ $set['name'] }}" data-type="sontable"
                            data-column="{{ $set['imageColumn'] }}" data-content="{{ $stack }}">
                            <span class="fa fa-plus"></span>
                            <p>Add multi image</p>
                        </li>
                    @endif

                    {{-- 批次新增單選按鈕 --}}
                    @if ($MultiDatacreate == 'yes')
                        <li class="ajax_open sontable" data-table="{{ $randomWord }}" data-key="{{ $randomWord }}"
                            data-sontablemodel="{{ $set['name'] }}" data-model="{{ $set['MultiDatamodel'] }}"
                            data-type="sontable" data-cls="sontable" data-column="{{ $set['DataColumn'] }}"
                            data-content="{{ $stack }}">
                            <span class="fa fa-plus"></span>
                            <p>Add multi By Data</p>
                        </li>
                    @endif

                    {{-- 複製按鈕 --}}
                    @if ($copy == 'yes')
                        <li class="CopySonTableDataGroup" data-table="{{ $randomWord }}"
                            data-model="{{ $set['name'] }}" data-setting="{{ $setting }}">
                            <span class="fa fa-files-o"></span>
                            <p>Copy</p>
                        </li>
                    @endif

                    {{-- 刪除按鈕 --}}
                    @if ($delete == 'yes')
                        <li class="deleteSonTableDataGroup" data-table="{{ $randomWord }}"
                            data-model="{{ $set['name'] }}">
                            <span class="fa fa-trash"></span>
                            <p>Delete</p>
                        </li>
                    @endif

                    {{-- 不知道是甚麼按鈕 --}}
                    @if ($teach == 'yes')
                        <li data-table="{{ $randomWord }}">
                            <span class="fa fa-question-circle"></span>
                            <p>Teaching</p>
                        </li>
                    @endif

                    <li class="controlSonTableDataGroup" data-table="{{ $randomWord }}">
                        <span class="fa fa-question-circle"></span>
                        <p>全開/全收</p>
                    </li>
                </ul>
            @endif
        </div>
    </section>
</li>

{{-- table內容 --}}
{{-- -- 表頭 -- --}}
@if (empty($value))
    <li class="emptyContent emptyContent_{{ $randomWord }}" data-table="{{ $randomWord }}">
        <div class="no_content">
            <p class="title">NO CONTENT</p>
            <p class="text"></p>
        </div>
    </li>
@endif

<li class="tabulation_head tabulation_head_{{ $randomWord }}" data-table="{{ $randomWord }}" style="{{ empty($value) ? 'display:none;' : '' }}">
    @if(!emptyy(collect($tableSet)->whereIn('value',['is_preview','is_visible'])))
    <div class="sontable_action">
        @if(!empty(collect($tableSet)->where('value','is_preview')->first()))
        <div class="sontable_action_area">
            <div class="title"><strong>預覽</strong></div>
            <div class="radio_action">
                <a class="radio_action_fuc enable" data-action="enable_all_preview">全開</a>
                <a class="radio_action_fuc" data-action="disable_all_preview">全關</a>
            </div>
        </div>
        @endif
        @if(!empty(collect($tableSet)->where('value','is_visible')->first()))
        <div class="sontable_action_area">
            <div class="title"><strong>顯示</strong></div>
            <div class="radio_action">
                <a class="radio_action_fuc enable" data-action="enable_all_visible">全開</a>
                <a class="radio_action_fuc " data-action="disable_all_visible">全關</a>
            </div>
        </div>
        @endif
    </div>
    @endif
    <div class="list">
        @if ($copy == 'yes' || $delete == 'yes')
        <div class="item t-a-c check_box">
            <p>選擇</p>
        </div>
        @endif
        @if ($sort == 'yes')
            <div class="item t-a-c sort_number">
                <p>順序</p>
            </div>
        @endif
        @foreach ($tableSet as $key => $row)
            <div class="item t-a-c {{ $row['type'] == 'radio_btn' ? 'switch_btn' : 'text' }}">
                <p>{{ $row['title'] }}</p>
            </div>
        @endforeach
        @if ($hasContent == 'yes')
            <div class="item t-a-c edit_btnGroup">
                <p>編輯</p>
            </div>
        @endif
    </div>
</li>


<li class="tabulation_body contnetParagraph tabulation_body_{{ $randomWord }} son-table"
    data-table="{{ $randomWord }}">
    @php
        //抓第三層編輯的所有圖片
        $second_file_keys = [];
        foreach ($tabSet as $tabSetVal) {
            $second_img_field = collect($tabSetVal['content'])
                ->where('type', 'image_group')
                ->pluck('image_array')
                ->collapse()
                ->pluck('value')
                ->toArray();

            $second_file_field = collect($tabSetVal['content'])
                ->where('type', 'filePicker')
                ->pluck('value')
                ->toArray();

            $second_file_keys = array_merge($second_file_keys,collect($value)->map(function ($model) use ($second_img_field,$second_file_field) {
                return collect($model)->only(array_merge($second_img_field,$second_file_field))->values();
            })->values()->collapse()->toArray());
        }

        foreach(collect($tableSet)->where('type','imgText')->pluck('img')->toArray() as $val){
            foreach($val as $v){
                $second_file_keys = array_merge($second_file_keys,collect($value)->map(function ($model) use ($v) {
                    return collect($model)->only([$v])->values();
                })->values()->collapse()->toArray());
            }
        }

        $files_temp_array = BaseFunction::getFilesArrayWithKey($second_file_keys);
        //如果有自訂排序欄位
        $sort_field = empty($set['sort_field']) ? 'w_rank' : $set['sort_field'];
        $value = collect($value)
            ->sortBy($sort_field)
            ->values()
            ->all();
    @endphp
    @foreach ($value as $key => $row)
        @php
            $keyRank = $key + 1;
            $randomWord_va = \Illuminate\Support\Str::random(5);
        @endphp
        <div class="covertoform list stack_state cms_new_{{ $randomWord_va }}" data-key="{{ $randomWord_va }}"
            data-id="{{ $row['id'] }}" data-rank="{{ $row[$sort_field] }}">
            <div class="wait-save-box {{ $row['wait_del'] ? 'active' : '' }}">
                <input name="{{ $set['name'] }}[wait_save_del]" type="hidden" value="{{ $row['wait_del'] }}">
                <div class="wait-save-del">點擊Setting後刪除此筆資料<a class="wait-save-del-cancel"><span
                            class="fa fa-remove"></span></a></div>
            </div>
            <div class="list_box">
                @if ($copy == 'yes' || $delete == 'yes')
                <div class="item check_box cms_new_{{ $randomWord_va }}" data-id="{{ $row['id'] }}"
                    data-key="{{ $randomWord_va }}">
                    <input class="content_input list_checkbox" type="checkbox">
                    <label class="content_inputBox">
                        <span></span>
                    </label>
                </div>
                @endif
                <input class="cms_new_{{ $randomWord_va }}" name="{{ $set['name'] }}[id]" type="hidden"
                    value="{{ $row['id'] }}">
                <input name="{{ $set['name'] }}[quillFantasyKey]" type="hidden" value="{{ $randomWord_va }}">
                <input name="modelName" type="hidden" value="{{ $set['name'] }}">
                <input name="SecondIdColumn" type="hidden" value="{{ $set['SecondIdColumn'] }}">

                @if ($sort == 'yes')
                    <div class="item sort_number">
                        <input name="{{ $set['name'] }}[{{ $sort_field }}]" type="text"
                            value="{{ $row[$sort_field] }}">
                    </div>
                @endif

                {{-- 表格內容 --}}
                @foreach ($tableSet as $key2 => $row2)
                    @if ($row2['type'] == 'textInput')
                        <div class="item text">
                            <input name="{{ $set['name'] }}[{{ $row2['value'] }}]" type="text"
                                value="{{ $row[$row2['value']] ?? ($row2['default'] ?? '') }}"
                                style="border-style:none;background-color: #efefef;border: solid 1px #c7c7c7;width: 90%;"
                                placeholder="Please enter here">
                        </div>
                    @elseif ($row2['type'] == 'text_image')
                        @if (isset($files_temp_array[$row[$row2['value']]]))
                            <div class="item text btn_ctable">
                                <div class="s_img">
                                    <img class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}" src="{{ $files_temp_array[$row[$row2['value']]]['real_m_route'] }}">
                                </div>
                                <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                                    {{ $files_temp_array[$row[$row2['value']]]['title'] . '.' . $files_temp_array[$row[$row2['value']]]['type'] }}
                                </p>
                            </div>
                        @else
                            <div class="item text btn_ctable">
                                <div class="s_img">
                                    <img class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}" src="">
                                </div>
                                <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">{{ $row[$row2['value']] }}</p>
                            </div>
                        @endif
                    @elseif ($row2['type'] == 'filesText')
                        @php
                        $ImageType = collect(\App\Http\Controllers\Fantasy\FmsController::$allowFileMimeType)->filter(function ($item,$key) {return (explode('/',$key)[0] == 'image');})->collapse()->unique()->values()->all();
                        @endphp
                        @if (isset($files_temp_array[$row[$row2['value']]]))
                            @if(in_array(strtolower($files_temp_array[$row[$row2['value']]]['type']),$ImageType))
                            <div class="item text btn_ctable filesText">
                                <div class="s_img">
                                    <img src="{{ $files_temp_array[$row[$row2['value']]]['real_m_route'] }}" alt="">
                                </div>
                                <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">{{ $files_temp_array[$row[$row2['value']]]['title'] .'.'. $files_temp_array[$row[$row2['value']]]['type'] }}</p>
                            </div>
                            @else
                            <div class="item text btn_ctable">
                                <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">{{ $files_temp_array[$row[$row2['value']]]['title'].'.'.$files_temp_array[$row[$row2['value']]]['type'] }}</p>
                            </div>
                            @endif
                        @else
                            <div class="item text btn_ctable">
                                <p class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}"></p>
                            </div>
                        @endif
                    @elseif ($row2['type'] == 'imgText')
                    <div class="item text btn_ctable imgText">
                        @foreach($row2['img'] as $imgKey)
                        <div class="s_img">
                            <img name="{{$set['name']}}[{{$imgKey}}][]" src="{{$files_temp_array[$row[$imgKey]]['real_route'] ?? ''}}" alt="">
                        </div>
                        @endforeach
                        <p class="{{(isset($row2['auto'])) ? 'AutoSet_'.$row2['value']:''}}">{{$row[$row2['value']] ?? ''}}</p>
                    </div>
                    @elseif ($row2['type'] == 'radio_btn')
                        <div class="item ios_switch radio_btn_switch {{ $row[$row2['value']] == 1 ? 'on' : '' }}"
                            style="min-width: 80px">
                            <input name="{{ $set['name'] }}[{{ $row2['value'] }}]" type="text"
                                value="{{ $row[$row2['value']] }}">
                            <div class="box" style="left: 23%;">
                                <span class="ball"></span>
                            </div>
                        </div>
                    @elseif ($row2['type'] == 'select_just_show')
                        @php
                            $temp_options = !empty($row2['options']) ? $row2['options'] : [];
                            $this_value = !empty($row[$row2['value']]) ? $row[$row2['value']] : 0;

                            $findkey = findkey($temp_options, 'key', $this_value);
                            $key = $findkey !== null ? $findkey : 'typeBasic';
                        @endphp
                        <div class="item text btn_ctable">
                            <p
                                class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                                {{ $temp_options[$key]['title'] ?? '-' }}</p>
                        </div>
                    @elseif ($row2['type'] == 'select_article4_show')
                        @php
                            $temp_options = !empty($row2['options']) ? $row2['options'] : [];
                            $this_value = !empty($row[$row2['value']]) ? $row[$row2['value']] : 0;
                            $findkey = findkey($temp_options, 'key', $this_value);
                            $key = $findkey !== null ? $findkey : 'typeBasic';
                        @endphp
                        <div class="item text btn_ctable">
                            <div class="s_img">
                                <img src="/vender/assets/img/article4/{{ $key }}.jpg " alt="">
                            </div>
                            <p
                                class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                                {{ $temp_options[$key]['title'] }}</p>
                        </div>
                    @elseif ($row2['type'] == 'select2')
                        @php
                            $temp_options = !empty($row2['options']) ? $row2['options'] : [];
                            $options_group_set = !empty($row2['options_group_set']) ? $row2['options_group_set'] : 'no';
                            $options_group = !empty($row2['options_group']) ? $row2['options_group'] : [];
                            $this_value = in_array($this_value, array_column($temp_options, 'key')) ? array_search($this_value, array_column($temp_options, 'key')) : 0;
                        @endphp

                        <div class="item text">
                            <div class="quill_select" style="width:100%;">
                                <div class="select_object" style="border-style: none;">
                                    @if (isset($temp_options[$this_value]['title']) and !empty($temp_options[$this_value]['title']))
                                        <p class="title">{{ $temp_options[$this_value]['title'] }}</p>
                                    @else
                                        <p class="title"></p>
                                    @endif
                                    <span class="arrow pg-arrow_down"></span>
                                </div>

                                <div class="select_wrapper">
                                    <ul class="select_list edit_select">
                                        @if ($options_group_set == 'yes')
                                            @foreach ($options_group as $key_1 => $row_1)
                                                <p class="category">{{ $row_1['title'] }}</p>

                                                @foreach ($row_1['key'] as $row2)
                                                    @foreach ($temp_options as $key3 => $row3)
                                                        @if ($row3['key'] == $row2)
                                                            <li class="option single_select_fantasy"
                                                                data-id="{{ $row3['key'] }}">
                                                                <p>{{ $row3['title'] }}</p>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @else
                                            @foreach ($temp_options as $key3 => $row3)
                                                <li class="option single_select_fantasy"
                                                    data-id="{{ $row3['key'] }}">
                                                    <p>{{ $row3['title'] }}</p>
                                                </li>
                                            @endforeach
                                        @endif

                                        <input name="{{ $set['name'] }}[{{ $row2['value'] }}]" type="hidden"
                                            value="{{ $this_value }}">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @elseif ($row2['type'] == 'just_show')
                        @if (!empty($row[$row2['value']]))
                            <div class="item text btn_ctable">
                                <p
                                    class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                                    {{ $row[$row2['value']] }}</p>
                            </div>
                        @else
                            <div class="item text btn_ctable">
                                <p
                                    class="{{ isset($row2['auto']) ? 'AutoSet_' . $row2['value'] : '' }}">
                                    {{ !empty($row2['default']) ? $row2['default'] : '' }}</p>
                            </div>
                        @endif
                    @endif
                @endforeach


                {{-- 編輯按鈕群 --}}
                @if ($hasContent == 'yes' || $delete == 'yes')
                    <div class="item edit_btnGroup">

                        @if ($hasContent == 'yes')
                            <span class="fa fa-pencil-square-o btn_ctable" data-key="{{ $randomWord_va }}"></span>
                        @endif

                        @if ($delete == 'yes')
                            <span class="fa fa-trash deleteSonTableData" data-id="{{ $row['id'] }}"
                                data-key="{{ $randomWord_va }}" data-model="{{ $set['name'] }}"></span>
                        @endif

                        @if ($is_link == 'yes')
                            <a class="{{ $link_class }}" href="javascript:;"
                                @foreach ($link_key as $dataSet) data-{{ $dataSet }}="{{ $row[$dataSet] }}" @endforeach>
                                <span class="fa fa-link"></span>
                            </a>
                        @endif
                    </div>
                @endif
                {{-- 編輯按鈕群 --- END --}}
            </div>

            @if ($hasContent == 'yes')
                <div class="list_frame list_frame_{{ $randomWord_va }}">
                    @if (count($tabSet) > 0)
                        <ul class="list_headBar">
                            @foreach ($tabSet as $key_2 => $row_2)
                                <li class="{{ $key_2 == 0 ? 'now' : '' }}" bar-id="{{ $key_2 }}">
                                    <p>{{ $row_2['title'] }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <ul class="list_body">
                        @foreach ($tabSet as $key_2 => $row_2)
                            <li class="list_bodyL part_content" body-id="{{ $key_2 }}">
                                <ul class="list_part_body">
                                    @foreach ($row_2['content'] as $key_3 => $row_3)
                                        @php
                                            $auto = isset($row_3['auto']) ? ' DataSync' : '';
                                            $autoSelect = isset($row_3['auto']) ? 'DataSyncSelect' : '';
                                            $autosetup = isset($row_3['auto']) ? 'AutoSet_' . $row_3['value'] : '';
                                        @endphp
                                        @if ($row_3['type'] == 'multiLocal')
                                            <li class="inventory">
                                                <div class="list_frame" style="display: block;">
                                                    <ul class="list_headBar">
                                                        @foreach ($langArray as $multiLocalKey => $multiLocalVal)
                                                            <li @if ($multiLocalKey == array_key_first($langArray)) class="now" @endif
                                                                bar-id="multiLocal_{{ $multiLocalKey }}">
                                                                <p>{{ $multiLocalVal['title'] }}</p>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <ul class="list_body" style="padding: 30px 15px;">
                                                        @foreach ($langArray as $multiLocalKey => $multiLocalVal)
                                                            <li class="list_bodyL part_content"
                                                                body-id="multiLocal_{{ $multiLocalKey }}">
                                                                <ul class="list_part_body">
                                                                    @foreach ($row_3['content'] as $mkey_3 => $mrow_3)
                                                                        @if ($mrow_3['type'] == 'textInput')
                                                                            <li class="inventory">
                                                                                <p class="subtitle">
                                                                                    {{ !empty($mrow_3['title']) ? $mrow_3['title'] : '' }}
                                                                                </p>
                                                                                <input
                                                                                    class="normal_input {{ $auto }}"
                                                                                    name="{{ $set['name'] }}[{{ $multiLocalVal['key'] . '_' . $mrow_3['value'] }}]"
                                                                                    data-autosetup="{{ $autosetup }}"
                                                                                    type="text"
                                                                                    value="{{ $row[$multiLocalVal['key'] . '_' . $mrow_3['value']] }}"
                                                                                    {{ !empty($mrow_3['disabled']) ? $mrow_3['disabled'] : '' }}>
                                                                                @if (!empty($mrow_3['tip']))
                                                                                    <div class="tips">
                                                                                        <span
                                                                                            class="title">TIPS</span>
                                                                                        <p>{!! $mrow_3['tip'] !!}</p>
                                                                                    </div>
                                                                                @endif
                                                                            </li>
                                                                        @elseif ($mrow_3['type'] == 'textSummernote')
                                                                            @php
                                                                                $data = [
                                                                                    'name' => $set['name'] . '[' . $multiLocalVal['key'] . '_' . $mrow_3['value'] . ']',
                                                                                    'title' => $mrow_3['title'],
                                                                                    'disabled' => !empty($mrow_3['disabled']) ? $mrow_3['disabled'] : '',
                                                                                    'value' => $row[$multiLocalVal['key'] . '_' . $mrow_3['value']],
                                                                                    'tip' => !empty($mrow_3['tip']) ? $mrow_3['tip'] : '',
                                                                                ];
                                                                            @endphp
                                                                            {{ UnitMaker::textSummernote($data) }}
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
                                            {{ UnitMaker::lang_textInput($row_3) }}
                                        @elseif ($row_3['type'] == 'article_select')
                                        <li class="inventory">
                                            <p class="subtitle">{{(!empty($row_3['title'])) ? $row_3['title'] : ''}}</p>
                                            <div class="inner">
                                                <div class="article_select" data-option="{{ implode(",", array_keys($row_3['options'])) }}" >
                                                    <input type="hidden" value="{{$row[$row_3['value']]}}" name="{{$set['name']}}[{{$row_3['value']}}]">
                                                    <div class="article_img"><img src="/vender/assets/img/article4/{{$row_3['options'][$row[$row_3['value']]]['key']}}.jpg"></div>
                                                    <p class="article_dec AutoSet_article_style">{{$row_3['options'][$row[$row_3['value']]]['title']}}</p>
                                                    <span class="fa fa-pencil-square-o btn_ctable" data-key=""></span>
                                                </div>
                                            </div>
                                        </li>
                                        @elseif (in_array($row_3['type'], ['textInput', 'textInputTarget', 'textInputTargetAcc']))
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];

                                                if (isset($row_3['target'])) {
                                                    $row_3['target']['value'] = $row[$row_3['target']['name']] ?? '0';
                                                    $row_3['target']['name'] = $set['name'] . '[' . $row_3['target']['name'] . ']';
                                                }

                                                if (isset($row_3['accessible'])) {
                                                    $row_3['accessible']['value'] = $row[$row_3['accessible']['name']] ?? '';
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
                                            $row_3['value'] = $row[$row_3['value']];
                                        @endphp
                                        {{ UnitMaker::table($row_3) }}
                                        @elseif ($row_3['type'] == 'radio_area')
                                            @php
                                                $row_3['auto'] = $autoSelect;
                                                $row_3['autosetup'] = $autosetup;
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
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
                                        @elseif ($row_3['type'] == 'select2')
                                            @php
                                                $row_3['auto'] = $autoSelect;
                                                $row_3['autosetup'] = $autosetup;
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::select2($row_3) }}
                                        @elseif ($row_3['type'] == 'select2Multi')
                                            @php
                                                $row_3['auto'] = $autoSelect;
                                                $row_3['autosetup'] = $autosetup;
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['original'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::select2Multi($row_3) }}
                                        @elseif ($row_3['type'] == 'select2MultiNew')
                                            @php
                                                $row_3['auto'] = $autoSelect;
                                                $row_3['autosetup'] = $autosetup;
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['original'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::select2MultiNew($row_3) }}
                                        @elseif ($row_3['type'] == 'selectBydata')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::selectBydata($row_3) }}
                                        @elseif ($row_3['type'] == 'textArea')
                                            @php
                                                $row_3['auto'] = $autoSelect;
                                                $row_3['autosetup'] = $autosetup;
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::textArea($row_3) }}
                                        @elseif ($row_3['type'] == 'lang_textArea')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['model'] = $set['name'];
                                                $row_3['name'] = $row_3['value'];
                                            @endphp
                                            {{ UnitMaker::lang_textArea($row_3) }}
                                        @elseif ($row_3['type'] == 'textSummernote')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::textSummernote($row_3) }}
                                        @elseif ($row_3['type'] == 'sn_textArea')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                                $row_3['tips'] = $row_3['tip'] ?? '';
                                            @endphp
                                            {{ UnitMaker::sn_textArea($row_3) }}
                                        @elseif ($row_3['type'] == 'radio_btn')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::radio_btn($row_3) }}
                                        @elseif ($row_3['type'] == 'image_group')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                if(isset($row_3['input'])){
                                                    foreach($row_3['input'] as $k=>$v){
                                                        $row_3['inputData'][$k] = json_decode($row[$row_3['input'][$k]['value']],true) ?: [];
                                                        $row_3['input'][$k]['value'] = $set['name'] . '[' . $row_3['input'][$k]['value'] . '][]';
                                                    }
                                                    // $row_3['input'] = $set['name'] . '[' . $row_3['input'] . '][]';
                                                }
                                                $row_3['image_array'] = array_map(function ($inner) use ($set, $row) {
                                                    $inner['name'] = $set['name'] . '[' . $inner['value'] . ']';
                                                    $inner['value'] = $row[$inner['value']];
                                                    return $inner;
                                                }, $row_3['image_array'] ?? []);
                                            @endphp
                                            {{ UnitMaker::imageGroup($row_3) }}
                                        @elseif ($row_3['type'] == 'selectGroup')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['rand'] = $randomWord_va;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp

                                            {{ UnitMaker::selectGroup($row_3) }}
                                        @elseif ($row_3['type'] == 'selectMultiBydata')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::selectMultiBydata($row_3) }}
                                        @elseif ($row_3['type'] == 'datePicker')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::datePicker($row_3) }}
                                        @elseif ($row_3['type'] == 'timePicker')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::timePicker($row_3) }}
                                        @elseif($row_3['type'] == 'dateRange')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['name2'] = $set['name'] . '[' . $row_3['value2'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                                $row_3['value2'] = $row[$row_3['value2']];
                                            @endphp
                                            {{ UnitMaker::dateRange($row_3) }}
                                        @elseif($row_3['type'] == 'dateTime')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['name2'] = $set['name'] . '[' . $row_3['value2'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                                $row_3['value2'] = $row[$row_3['value2']];
                                            @endphp
                                            {{ UnitMaker::dateTime($row_3) }}
                                        @elseif($row_3['type'] == 'timeRange')
                                            @php
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['name2'] = $set['name'] . '[' . $row_3['value2'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                                $row_3['value2'] = $row[$row_3['value2']];
                                            @endphp
                                            {{ UnitMaker::timeRange($row_3) }}
                                      
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
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = false;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                            @endphp
                                            {{ UnitMaker::filePicker($row_3) }}
                                        @elseif ($row_3['type'] == 'select_simple')
                                            @php
                                                $row_3['auto'] = $autoSelect;
                                                $row_3['autosetup'] = $autosetup;
                                                $row_3['sontable'] = true;
                                                $row_3['sontable_add'] = true;
                                                $row_3['name'] = $set['name'] . '[' . $row_3['value'] . ']';
                                                $row_3['value'] = $row[$row_3['value']];
                                                $row_3['custom'] = true;
                                            @endphp
                                            {{ UnitMaker::select($row_3) }}
                                        @elseif ($row_3['type'] == 'html')
                                            <li class="inventory row_style ">
                                                {!! $row[$row_3['value']] !!}
                                            </li>
                                        @elseif ($row_3['type'] == 'selectMulti')
                                            @php
                                                $select_value = !empty($row[$row_3['value']]) ? $row[$row_3['value']] : '';
                                                $select_options = !empty($row_3['options']) ? $row_3['options'] : [];
                                                $options_group_set = !empty($row_3['options_group_set']) ? $row_3['options_group_set'] : 'no';
                                                $options_group = !empty($row_3['options_group']) ? $row_3['options_group'] : [];

                                                // 隨機亂碼
                                                $randomWord = \Illuminate\Support\Str::random(30);
                                                if (!empty($select_value)) {
                                                    $value_array = json_decode($select_value, true);
                                                } else {
                                                    $value_array = [];
                                                }
                                            $select_value = htmlentities($select_value); @endphp
                                            <li class="inventory">
                                                <p class="subtitle">
                                                    {{ !empty($row_3['title']) ? $row_3['title'] : '' }}</p>

                                                <div class="inner">
                                                    <div class="quill_select multi_select">
                                                        <div class="select_object">
                                                            <p class="title" data-key="{{ $randomWord }}"></p>
                                                            <span class="arrow pg-arrow_down"></span>
                                                        </div>

                                                        @if (!empty($disabled) and $disabled == 'disabled')
                                                        @else
                                                            <input class="multi_select_{{ $randomWord }}"
                                                                name="{{ $set['name'] }}[{{ $row_3['value'] }}]"
                                                                type="hidden" value="{{ $select_value }}">
                                                            <div class="select_wrapper">
                                                                <ul class="select_list multi_sselect_list_{{ $randomWord }}"
                                                                    data-key="{{ $randomWord }}">

                                                                    @if ($options_group_set == 'yes')
                                                                        @foreach ($options_group as $key_1 => $row_1)
                                                                            <p class="category">{{ $row_1['title'] }}
                                                                            </p>

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

                                                                                        <li class="multi_select_fantasy option {{ $value_on }}"
                                                                                            data-id="{{ $roww['key'] }}">
                                                                                            <p>{{ $roww['title'] }}
                                                                                            </p>
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

                                                                            <li class="multi_select_fantasy option {{ $value_on }}"
                                                                                data-id="{{ $roww['key'] }}">
                                                                                <p>{{ $roww['title'] }}</p>
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
                                                        <p>{!! $row_3['tip'] !!}</p>
                                                    </div>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach

                                    @php
                                        $is_three = !empty($row_2['is_three']) ? $row_2['is_three'] : 'no';
                                        $is_three_create = !empty($row_2['create']) ? $row_2['create'] : 'yes';
                                        $is_three_delete = !empty($row_2['delete']) ? $row_2['delete'] : 'yes';
                                        $is_three_copy = !empty($row_2['copy']) ? $row_2['copy'] : 'yes';
                                        $MultiImgcreate = !empty($row_2['three']['MultiImgcreate']) ? $row_2['three']['MultiImgcreate'] : 'no';
                                        $imageColumn = !empty($row_2['three']['imageColumn']) ? $row_2['three']['imageColumn'] : '';
                                        $three = !empty($row_2['three']) ? $row_2['three'] : [];
                                    @endphp

                                    @if ($is_three == 'yes')
                                        @php
                                            $son_son_db = $row_2['three_model'];
                                            $third_randomWord = \Illuminate\Support\Str::random(9) . $key_2;
                                            $son_sort_field = empty($row_2['sort_field']) ? 'w_rank' : $row_2['sort_field'];

                                            $threeDataArray = [
                                                'son_son_db' => $son_son_db,
                                                'sort_field' => $son_sort_field,
                                                'three' => $three,
                                            ];
                                            $add_html = View::make('Fantasy.cms_view.includes.template.WNsontable.add_html', $threeDataArray)->render();
                                        @endphp

                                        <li class="inventory" style="display:block">
                                            @if (!empty($three['tip']))
                                                <div class="tips">
                                                    <span class="title">TIPS</span>
                                                    <p>{!! $three['tip'] !!}</p>
                                                </div>
                                            @endif

                                            {{-- 編輯按鈕群 --}}
                                            <div class="frame">
                                                <!--photo，video點了打開FMS ， embed點了直接新增一個list-->
                                                <ul class="table_head">
                                                    <li class="table_head_th">
                                                        @if ($is_three_create == 'yes')
                                                            <div class="td tool_btn addInThirdTb addValueInTable"
                                                                data-table="{{ $third_randomWord }}"
                                                                data-content="{{ $add_html }}" toolBtn-id="1">
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

                                                        @if ($is_three_copy == 'yes')
                                                            <div class="td tool_btn threeTableCopy CopySonTableDataGroup"
                                                                data-table="{{ $third_randomWord }}"
                                                                data-setting="{{ $setting }}" toolBtn-id="1">
                                                                <span class="fa fa-files-o"></span>
                                                                <p>Copy</p>
                                                            </div>
                                                        @endif

                                                        @if ($is_three_delete == 'yes')
                                                            <div class="td tool_btn deleteThirdTableDataGroup"
                                                                data-table="{{ $third_randomWord }}"
                                                                data-model="{{ $son_son_db }}" toolBtn-id="4">
                                                                <span class="fa fa-trash"></span>
                                                                <p>Delete</p>
                                                            </div>
                                                        @endif


                                                    </li>
                                                </ul>
                                                <ul @if (count($row['son'][$son_son_db]) === 0) style="display: none" @endif>
                                                    <li class="tabulation_head three">
                                                        <div class="list">
                                                            <div class="item t-a-c check_box">
                                                                <p>選擇</p>
                                                            </div>
                                                            <div class="item t-a-c sort_number">
                                                                <p>順序</p>
                                                            </div>
                                                            @foreach ($three['three_tableSet'] as $three_val)
                                                                <div
                                                                    class="item t-a-c {{ $three_val['type'] == 'radio_btn' ? 'switch_btn' : 'text' }}">
                                                                    <p>{{ $three_val['title'] }}</p>
                                                                </div>
                                                            @endforeach
                                                            <div class="item t-a-c edit_btnGroup">
                                                                <p>編輯</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <ul
                                                    class="table_list quill_partImg table_box thirdTbNew_{{ $third_randomWord }} {{($three['article_video'] ?? '')}} son-table">
                                                    @php
                                                        //抓第三層編輯的所有圖片
                                                        $three_file_field = collect($three['three_content'])
                                                            ->where('type', 'image_group')
                                                            ->pluck('image_array')
                                                            ->collapse()
                                                            ->pluck('value')
                                                            ->toArray();
                                                        $three_file_keys = collect($row['son'][$son_son_db])
                                                            ->map(function ($model) use ($three_file_field) {
                                                                return collect($model)
                                                                    ->only($three_file_field)
                                                                    ->values();
                                                            })
                                                            ->values()
                                                            ->collapse()
                                                            ->toArray();
                                                        $fileInformationArray = BaseFunction::getFilesArrayWithKey($three_file_keys);

                                                    @endphp

                                                    @foreach ($row['son'][$son_son_db] as $key_son => $value_son)
                                                        @php
                                                            $sonRank = $key_son + 1;
                                                            $randomWord_son = \Illuminate\Support\Str::random(5) . $key_son;
                                                        @endphp
                                                        <div class="covertoform three-item item new_{{ $randomWord_son }}"
                                                            data-rank="{{ $sonRank }}"
                                                            partImg-id="{{ $value_son['id'] }}">
                                                            <div
                                                                class="wait-save-box {{ $value_son['wait_del'] ? 'active' : '' }}">
                                                                <input name="{{ $son_son_db }}[wait_save_del]"
                                                                    type="hidden"
                                                                    value="{{ $value_son['wait_del'] }}">
                                                                <div class="wait-save-del">點擊Setting後刪除此筆資料<a
                                                                        class="wait-save-del-cancel"><span
                                                                            class="fa fa-remove"></span></a></div>
                                                            </div>
                                                            <div class="list_box">
                                                                <div class="item check_box new_{{ $randomWord_son }}"
                                                                    data-id="{{ $value_son['id'] }}"
                                                                    data-key="{{ $randomWord_son }}">
                                                                    <input
                                                                        class="content_input list_three_checkbox list_checkbox"
                                                                        type="checkbox">
                                                                    <label class="content_inputBox">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                                <input class="new_{{ $randomWord_son }}"
                                                                    name="{{ $son_son_db }}[id]" type="hidden"
                                                                    value="{{ $value_son['id'] }}">
                                                                <input name="{{ $son_son_db }}[quillSonFantasyKey]"
                                                                    type="hidden" value="{{ $randomWord_va }}">
                                                                <input name="modelName" type="hidden"
                                                                    value="{{ $son_son_db }}">
                                                                <input name="SecondIdColumn" type="hidden"
                                                                    value="{{ $three['SecondIdColumn'] }}">
                                                                <input class="addThirdSid"
                                                                    name="{{ $son_son_db }}[{{ $three['SecondIdColumn'] }}]"
                                                                    type="hidden"
                                                                    value="{{ $value_son[$three['SecondIdColumn']] }}">

                                                                <div class="item sort_number">
                                                                    <input
                                                                        name="{{ $son_son_db }}[{{ $son_sort_field }}]"
                                                                        type="text" value="{{ $value_son[$son_sort_field] }}">
                                                                </div>
                                                                @foreach ($three['three_tableSet'] as $three_val)
                                                                    @if ($three_val['type'] == 'just_show')
                                                                        <div class="item text btn_ctable">
                                                                            <p
                                                                                class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}">
                                                                                {{ $value_son[$three_val['value']] }}
                                                                            </p>
                                                                        </div>
                                                                    @endif

                                                                    @if ($three_val['type'] == 'select_just_show')
                                                                        @php
                                                                            $temp_options = $three_val['options'] ?? [];
                                                                            $this_value = $value_son[$three_val['value']] ?? 0;
                                                                        @endphp
                                                                        <div class="item text btn_ctable">
                                                                            <p
                                                                                class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}">
                                                                                {{ collect($temp_options)->where('key', $this_value)->first()['title'] ?? '-' }}
                                                                            </p>
                                                                        </div>
                                                                    @endif

                                                                    @if ($three_val['type'] == 'text_image')
                                                                        @if (isset($fileInformationArray[$value_son[$three_val['value']]]) &&
                                                                                $fileInformationArray[$value_son[$three_val['value']]]['type'] != 'pdf')
                                                                            <div class="item text btn_ctable">
                                                                                <div class="s_img">
                                                                                    <img class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}"
                                                                                        src="{{ $fileInformationArray[$value_son[$three_val['value']]]['real_route'] }}">
                                                                                </div>
                                                                                <p
                                                                                    class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}">
                                                                                    {{ (isset($three_val['text'])) ? $value_son[$three_val['text']] :  $fileInformationArray[$value_son[$three_val['value']]]['title'] . '.' . $fileInformationArray[$value_son[$three_val['value']]]['type'] }}
                                                                                </p>
                                                                            </div>
                                                                        @else
                                                                            <div class="item text btn_ctable">
                                                                                <div class="s_img">
                                                                                    <img src="">
                                                                                </div>
                                                                                <p
                                                                                    class="{{ isset($three_val['auto']) ? 'AutoSet_' . $three_val['value'] : '' }}">
                                                                                    {{ $value_son[$three_val['text'] ?? $three_val['value']] ?: '' }}
                                                                                </p>
                                                                            </div>
                                                                        @endif
                                                                    @endif

                                                                    @if ($three_val['type'] == 'article_text_image')
                                                                        @if (isset($fileInformationArray[$value_son[$three_val['value']]]) && $fileInformationArray[$value_son[$three_val['value']]]['type'] != 'pdf')
                                                                            <div class="item text btn_ctable">
                                                                                <div class="s_img">
                                                                                    <img class="AutoSet_article_img" src="{{ BaseFunction::imgSrc($fileInformationArray[$value_son[$three_val['value']]]['real_route']) }}">
                                                                                </div>
                                                                                <p class="AutoSet_article_dec">{{$value_son['title']}}</p>
                                                                            </div>
                                                                        @else
                                                                            <div class="item text btn_ctable">
                                                                                <div class="s_img">
                                                                                    <img class="AutoSet_article_img" src="">
                                                                                </div>
                                                                                <p class="AutoSet_article_dec">{{$value_son['title']}}</p>
                                                                            </div>
                                                                        @endif
                                                                    @endif


                                                                    @if ($three_val['type'] == 'radio_btn')
                                                                        <div class="item ios_switch radio_btn_switch {{ $value_son[$three_val['value']] ? 'on' : '' }}"
                                                                            style="min-width: 80px">
                                                                            <input
                                                                                name="{{ $son_son_db }}[{{ $three_val['value'] }}]"
                                                                                type="text"
                                                                                value="{{ $value_son[$three_val['value']] }}">
                                                                            <div class="box" style="left: 23%;">
                                                                                <span class="ball"></span>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach

                                                                <div class="item edit_btnGroup">
                                                                    <span
                                                                        class="fa fa-pencil-square-o btn_ctable three"
                                                                        data-key="{{ $randomWord_son }}">
                                                                    </span>
                                                                    @if ($is_three_delete == 'yes')
                                                                        <span class="fa fa-trash deleteThirdTableData"
                                                                            data-id="{{ $value_son['id'] }}"
                                                                            data-key="{{ $randomWord_son }}"
                                                                            data-model="{{ $son_son_db }}">
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="list_frame">
                                                                <ul class="ThreeContent" style="width:100%">
                                                                    @include(
                                                                        'Fantasy.cms_view.includes.template.WNsontable.'.($three['article_video'] ?? 'three_content'),
                                                                        [
                                                                            'value_son' => $value_son,
                                                                            'randomWord_son' => $randomWord_son,
                                                                            'three_select2MultiIndex' => $three_select2MultiIndex,
                                                                            'files_temp_array' => $fileInformationArray,
                                                                        ]
                                                                    )
                                                                </ul>
                                                            </div>
                                                        </div>
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
        </div>
        @php
            $select2MultiIndex++;
        @endphp

    @endforeach
</li>
