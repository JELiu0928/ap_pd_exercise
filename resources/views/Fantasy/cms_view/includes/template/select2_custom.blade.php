<?php
$explanation = (!empty($explanation)) ? $explanation : '-';
foreach($options as $val){if($value == $val['key']){$explanation = $val['title'];break;}}
?>
<li class="inventory {!! $sontable===false?'row_style':'' !!} {{ ($search===true)? 'card_search_input':''}}" {!! ($search===true)?'data-search_type="single_select" data-search_field="'.$search_field.'"':'' !!}>
    @if($batch)
    <div>
        <div class="radioSmall inventory sortStatusSet" style="padding: 0px !important;">
            <div style="display:flex; align-items: center; padding: 8px">
                <div class="ios_switch radio_btn_switch">
                    <input type="text" name="{{ 'batch_'.$name }}" value="">
                    <div class="box">
                        <span class="ball"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    {!! $sontable===false?' <div class="title">':'' !!}
    <p class="subtitle">{{ $title }}</p>
    {!! $sontable===false?'</div>':'' !!}
    <div class="inner">
        @if($article4)
        <select class="____select2 article4" name="{{ $name }}">
            {!! $empty == 'yes'?'<option value="">-</option>':'' !!}
            @foreach ($options as $key => $row)
            <option data-img="/vender/assets/img/article4/{{ $row['key'] }}.jpg" value="{{ $row['key'] }}" {{($value!='' && $value!='0' && $value == $row['key'])? 'selected':''}}>{{ $row['title'] }}</option>
            @endforeach
        </select>
        @else
        <select class="____select2" name="{{ $name }}">
            {!! $empty == 'yes'?'<option value="">-</option>':'' !!}
            @foreach ($options as $key => $row)
            <option value="{{ $row['key'] }}" {{($value!='' && $value!='0' && $value == $row['key'])? 'selected':''}}>{{ $row['title'] }}</option>
            @endforeach
        </select>
        @endif
    </div>
</li>