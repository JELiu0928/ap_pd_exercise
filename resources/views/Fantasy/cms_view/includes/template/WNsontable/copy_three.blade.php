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
            <p class="{{(isset($three_val['auto'])) ? 'AutoSet_'.$three_val['value']:''}}">{{$value_son[$three_val['value']]}}</p>
        </div>
        @else
        <div class="item text btn_ctable">
            <div class="s_img">
                <img src="">
            </div>
            <p class="{{(isset($three_val['auto'])) ? 'AutoSet_'.$three_val['value']:''}}">{{$value_son[$three_val['value']]}}</p>
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
            @include('Fantasy.cms_view.includes.template.WNsontable.three_content',['randomWord_son'=>$randomWord_son,'three_select2MultiIndex'=>$three_select2MultiIndex])
        </ul>
    </div>
</form>
@php
$three_select2MultiIndex++;
@endphp
@endforeach
