<li class="inventory {!! $sontable ? '' : 'row_style' !!}">
    @if ($batch || $search)
        <div>
            <div class="radioSmall inventory sortStatusSet" style="padding: 0px !important;">
                <div style="display:flex; align-items: center; padding: 8px">
                    <div class="ios_switch radio_btn_switch">
                        <input name="{{ 'batch_' . $name }}" type="text" value="">
                        <div class="box">
                            <span class="ball"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {!! $sontable ? '' : '<div class="title">' !!}
    <p class="subtitle">{{ $title }}</p>
    {!! $sontable ? '' : '</div>' !!}
    <div class="inner">
        <select class="____select2 {{ $auto }}" search-type="select2" name="{{ $disabled ? '' : $name }}" data-autosetup="{{ $autosetup }}" @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif {{ $disabled ? 'disabled' : '' }}>
            @if(!empty(collect($options)->where('key',$value)->first()))
            <optgroup label="目前選項為">
                <option value="{{ $value }}" selected>{{ collect($options)->where('key',$value)->first()['title']}}</option>
            </optgroup>
            @endif
            @if(!empty(collect($options)->whereNotIn('key',$value)->all()))
            <optgroup label="可選擇下列選項">
                @foreach ($options as $key => $row)
                    @if($row['key'] != $value))
                        <option value="{{ $row['key'] }}">{{ $row['title'] }}</option>
                    @endif
                @endforeach
            </optgroup>
            @endif
        </select>
        @if (!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
