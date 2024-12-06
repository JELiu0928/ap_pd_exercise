<table class="table table-hover">
    <thead>
    <tr>
        <th style="width:20px" class="text-center">
        <button class="btn btn-link">
            <i class="pg-unordered_list"></i>
        </button>
        </th>
        @foreach($table as $key => $value)
        <th style="width:{{ $value['width'] }}">{{ $value['title'] }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($detail as $key => $value)
    <tr class="tbody_tick">
        <td class="v-align-middle">
        <div class="checkbox text-center">
            <input type="checkbox" id="{{ $value['id'] }}" class="input_number db_lbox_select_checkbox" data-title="{{ $value['show_title'] }}" @if($value['selected']==1) checked="true" @endif>
            <label for="" class="no-padding no-margin">
            <span></span>
            </label>
        </div>
        </td>
        @foreach ($table as $key1 => $value1)
        @if($value1['type']=='text_img')
            <td class="v-align-middle">
            <div class="box text_pic">
                <div class="head_img open_builder">
                <img src="{{ $imageAry[ $value['image'] ] }}" alt="">
                </div>
                <p class="bold open_builder">{{ $value[ $value1['value'] ] }}</p>
            </div>
            </td>
        @elseif($value1['type']=='select')
            <td class="v-align-middle">
            <div class="box text">
                <p class="box text">{{ $value['re_title'] }}</p>
            </div>
            </td>
        @elseif($value1['type']=='selectMulti')
            <td class="v-align-middle">
            <div class="box text">
                <p class="box text">{{ $value['re_title'] }}</p>
            </div>
            </td>
        @elseif($value1['type']=='radio_btn')
            <td class="v-align-middle">
            <div class="box multi">
                <ul>
                <li @if($value[ $value1['value'] ]==1) class="ch" @endif>
                    <p>S</p>
                </li>
                </ul>
            </div>
            </td>
        @else
            <td class="v-align-middle">
            <div class="box text">
                <p class="box text">{{ $value[ $value1['value'] ] }}</p>
            </div>
            </td>
        @endif
        @endforeach
    </tr>
    @endforeach
    @foreach($sel_data as $key => $value)
        <input style="display: none;" type="checkbox" id="{{ $value['id'] }}" class="input_number db_lbox_select_checkbox" data-title="{{ $value['show_title'] }}" checked="true">
    @endforeach
    </tbody>
</table>