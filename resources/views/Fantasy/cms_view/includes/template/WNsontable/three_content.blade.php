@foreach ($three['three_content'] as $item)
    @php
        $three_select2MultiIndex = $three_select2MultiIndex ?? 0;
        $auto = isset($item['auto']) ? ' DataSync' : '';
        $autoSelect = isset($item['auto']) ? 'DataSyncSelect' : '';
        $autosetup = isset($item['auto']) ? 'AutoSet_' . $item['value'] : '';

    @endphp
    @if ($item['type'] == 'multiLocal')
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
                        <li class="list_bodyL part_content" body-id="multiLocal_{{ $multiLocalKey }}">
                            <ul class="list_part_body">
                                @foreach ($item['content'] as $mkey_3 => $mrow_3)
                                    @if ($mrow_3['type'] == 'textInput')
                                        <li class="inventory">
                                            <p class="subtitle">{{ !empty($mrow_3['title']) ? $mrow_3['title'] : '' }}
                                            </p>
                                            <input class="normal_input {{ $auto }}"
                                                name="{{ $son_son_db }}[{{ $multiLocalVal['key'] . '_' . $mrow_3['value'] }}]"
                                                data-autosetup="{{ $autosetup }}" type="text"
                                                value="{{ $value_son[$multiLocalVal['key'] . '_' . $mrow_3['value']] ?? '' }}"
                                                {{ !empty($mrow_3['disabled']) ? $mrow_3['disabled'] : '' }}>
                                            @if (!empty($mrow_3['tip']))
                                                <div class="tips">
                                                    <span class="title">TIPS</span>
                                                    <p>{!! $mrow_3['tip'] !!}</p>
                                                </div>
                                            @endif
                                        </li>
                                    @elseif ($mrow_3['type'] == 'textSummernote')
                                        @php
                                            $data = [
                                                'name' => $son_son_db . '[' . $multiLocalVal['key'] . '_' . $mrow_3['value'] . ']',
                                                'title' => $mrow_3['title'],
                                                'disabled' => !empty($mrow_3['disabled']) ? $mrow_3['disabled'] : '',
                                                'value' => $value_son[$multiLocalVal['key'] . '_' . $mrow_3['value']],
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
    @elseif ($item['type'] == 'lang_textInput')
        @php
            $item['model'] = $son_son_db;
            $item['name'] = $item['value'];
        @endphp
        {{ UnitMaker::lang_textInput($item) }}
    @elseif (in_array($item['type'], ['textInput', 'textInputTarget', 'textInputTargetAcc']))
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';

            if (isset($item['target'])) {
                $item['target']['value'] = $value_son[$item['target']['name']] ?? '0';
                $item['target']['name'] = $son_son_db . '[' . $item['target']['name'] . ']';
            }

            if (isset($item['accessible'])) {
                $item['accessible']['value'] = $value_son[$item['accessible']['name']] ?? '';
                $item['accessible']['name'] = $son_son_db . '[' . $item['accessible']['name'] . ']';
            }
        @endphp
        {{ UnitMaker::textInput($item) }}
    @elseif ($item['type'] == 'radio_area')
        @php
            $item['auto'] = $autoSelect;
            $item['autosetup'] = $autosetup;
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::radio_area($item) }}
    @elseif ($item['type'] == 'select2')
        @php
            $item['auto'] = $autoSelect;
            $item['autosetup'] = $autosetup;
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::select2($item) }}
    @elseif ($item['type'] == 'select2Multi')
        @php
            $item['auto'] = $autoSelect;
            $item['autosetup'] = $autosetup;
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['original'] = $son_son_db . '[' . $item['value'] . ']';
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::select2Multi($item) }}
    @elseif ($item['type'] == 'select2MultiNew')
        @php
            $item['auto'] = $autoSelect;
            $item['autosetup'] = $autosetup;
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['original'] = $son_son_db . '[' . $item['value'] . ']';
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::select2MultiNew($item) }}
    @elseif ($item['type'] == 'selectBydata')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::selectBydata($item) }}
    @elseif ($item['type'] == 'textArea')
        @php
            $item['auto'] = $autoSelect;
            $item['autosetup'] = $autosetup;
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::textArea($item) }}
    @elseif ($item['type'] == 'numberInput')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '0';
        @endphp
        {{ UnitMaker::numberInput($item) }}
    @elseif ($item['type'] == 'lang_textArea')
        @php
            $item['model'] = $son_son_db;
            $item['name'] = $item['value'];
        @endphp
        {{ UnitMaker::lang_textArea($item) }}
    @elseif ($item['type'] == 'textSummernote')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::textSummernote($item) }}
    @elseif ($item['type'] == 'sn_textArea')
        @php
            $item['sontable'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
            $item['tips'] = !empty($item['tip']) ? $item['tip'] : '';
        @endphp
        {{ UnitMaker::sn_textArea($item) }}
    @elseif ($item['type'] == 'radio_btn')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = false;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '0';
        @endphp
        {{ UnitMaker::radio_btn($item) }}
    @elseif ($item['type'] == 'image_group')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = false;
            $item['image_array'] = array_map(function ($inner) use ($son_son_db, $value_son) {
                $inner['name'] = $son_son_db . '[' . $inner['value'] . ']';
                $inner['value'] = $value_son[$inner['value']] ?? '';
                return $inner;
            }, $item['image_array'] ?? []);
        @endphp
        {{ UnitMaker::imageGroup($item) }}
    @elseif ($item['type'] == 'selectMulti')
        @php
            $select_value = !empty($value_son[$item['value']]) ? $value_son[$item['value']] : '';
            $select_options = !empty($item['options']) ? $item['options'] : [];
            $options_group_set = !empty($item['options_group_set']) ? $item['options_group_set'] : 'no';
            $options_group = !empty($item['options_group']) ? $item['options_group'] : [];

            // 隨機亂碼
            $randomWord = \Illuminate\Support\Str::random(30);
            if (!empty($select_value)) {
                $value_array = json_decode($select_value, true);
            } else {
                $value_array = [];
            }
        $select_value = htmlentities($select_value); @endphp <li class="inventory">
            <p class="subtitle">{{ !empty($item['title']) ? $item['title'] : '' }}</p>

            <div class="inner">
                <div class="quill_select multi_select">
                    <div class="select_object">
                        <p class="title" data-key="{{ $randomWord }}"></p>
                        <span class="arrow pg-arrow_down"></span>
                    </div>

                    @if (!empty($disabled) and $disabled == 'disabled')
                    @else
                        <input class="multi_select_{{ $randomWord }}"
                            name="{{ $son_son_db }}[{{ $item['value'] }}]" type="hidden"
                            value="{{ $select_value }}">
                        <div class="select_wrapper">
                            <ul class="select_list multi_sselect_list_{{ $randomWord }}"
                                data-key="{{ $randomWord }}">

                                @if ($options_group_set == 'yes')
                                    @foreach ($options_group as $key_1 => $value_son_1)
                                        <p class="category">{{ $value_son_1['title'] }}</p>

                                        @foreach ($value_son_1['key'] as $value_son_key)
                                            @foreach ($select_options as $keyy => $value_sonw)
                                                @if ($value_o['key'] == $value_son_key)
                                                    @php
                                                        $value_on = '';
                                                        foreach ($value_array as $keyy2 => $value_sonw2) {
                                                            if ($value_sonw2 == $value_sonw['key']) {
                                                                $value_on = 'default';
                                                            }
                                                        }
                                                    @endphp

                                                    <li class="multi_select_fantasy option {{ $value_on }}"
                                                        data-id="{{ $value_sonw['key'] }}">
                                                        <p>{{ $value_sonw['title'] }}</p>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @else
                                    @foreach ($select_options as $keyy => $value_sonw)
                                        @php
                                            $value_on = '';
                                            foreach ($value_array as $keyy2 => $value_sonw2) {
                                                if ($value_sonw2 == $value_sonw['key']) {
                                                    $value_on = 'default';
                                                }
                                            }
                                        @endphp

                                        <li class="multi_select_fantasy option {{ $value_on }}"
                                            data-id="{{ $value_sonw['key'] }}">
                                            <p>{{ $value_sonw['title'] }}</p>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            @if (!empty($item['tip']))
                <div class="tips">
                    <span class="title">TIPS</span>
                    <p>{!! $item['tip'] !!}</p>
                </div>
            @endif
        </li>
    @elseif ($item['type'] == 'selectGroup')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = false;
            $item['rand'] = '';
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp

        {{ UnitMaker::selectGroup($item) }}
    @elseif ($item['type'] == 'selectMultiBydata')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::selectMultiBydata($item) }}
    @elseif ($item['type'] == 'datePicker')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::datePicker($item) }}
    @elseif ($item['type'] == 'timePicker')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::timePicker($item) }}
    @elseif($item['type'] == 'dateRange')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = false;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['name2'] = $son_son_db . '[' . $item['value2'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
            $item['value2'] = $value_son[$item['value2']] ?? '';
        @endphp
        {{ UnitMaker::dateRange($item) }}
    @elseif($item['type'] == 'timeRange')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = false;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['name2'] = $son_son_db . '[' . $item['value2'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
            $item['value2'] = $value_son[$item['value2']] ?? '';
        @endphp
        {{ UnitMaker::timeRange($item) }}
    @elseif($item['type'] == 'dateTime')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = false;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['name2'] = $son_son_db . '[' . $item['value2'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
            $item['value2'] = $value_son[$item['value2']] ?? '';
        @endphp
        {{ UnitMaker::dateTime($item) }}
    @elseif ($item['type'] == 'colorPicker')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? ($item['default'] ?? '#000000');
        @endphp
        {{ UnitMaker::colorPicker($item) }}
    @elseif ($item['type'] == 'filePicker')
        @php
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
        @endphp
        {{ UnitMaker::filePicker($item) }}
    @elseif ($item['type'] == 'select_simple')
        @php
            $item['auto'] = $autoSelect;
            $item['autosetup'] = $autosetup;
            $item['sontable'] = true;
            $item['sontable_add'] = true;
            $item['name'] = $son_son_db . '[' . $item['value'] . ']';
            $item['value'] = $value_son[$item['value']] ?? '';
            $item['custom'] = true;
        @endphp
        {{ UnitMaker::select($item) }}
    @elseif ($item['type'] == 'html')
        <li class="inventory row_style ">
            {!! $value_son[$item['value']] ?? '' !!}
        </li>
    @endif


@endforeach
