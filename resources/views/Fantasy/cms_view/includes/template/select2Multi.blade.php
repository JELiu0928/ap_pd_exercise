<li class="inventory {!! $sontable ? '' : 'row_style' !!}">
    @if($batch || $search)
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
    {!! $sontable ? '' : ' <div class="title">' !!}
        <p class="subtitle">{{ $title }}</p>
        {!! $sontable ? '' : '</div>' !!}
    <div class="inner">
        @if($isAll)
            <a class="__multiple2all" href="javascript:void(0)" style="padding: 6px 8px;margin-bottom: 10px;display: inline-flex;align-items:center;background-color: #434343;color: #fff;">
                <span class="icon-check" style="margin-right: 6px;"></span>
                <span>全選</span>
            </a>
            <a class="__multiple2all_close" href="javascript:void(0)" style="padding: 6px 8px;margin-bottom: 10px;display: inline-flex;align-items:center;background-color: #434343;color: #fff;">
                <span class="fa fa-remove" style="margin-right: 6px;"></span>
                <span>全不選</span>
            </a>
        @endif

        <select class="____select2 {{ isset($auto) ? $auto : '' }} __leonselect2multiple" name="{{ $disabled ? '' : $name . '[]' }}" data-original="{{ $original }}" data-autosetup="{{ isset($autosetup) ? $autosetup : '' }}" @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif multiple="multiple" {{ $disabled ? 'disabled' : '' }}>
            @if(!empty(collect($options)->whereNotIn('key',$value)->all()))
            <optgroup label="可選擇下列選項">
                @foreach(collect($options)->whereNotIn('key',$value)->all() as $key => $row)

                        <option value="{{ $row['key'] }}">{{ $row['title'] }}</option>

                @endforeach
            </optgroup>
            @endif
            @if(!empty(collect($options)->whereIn('key',$value)->all()))
            <optgroup label="已選擇選項">
                @foreach($value as $item)
                    @if(isset($options[$item]))
                        <option value="{{ $item }}" selected>{{ $options[$item]['title'] }}</option>
                    @endif
                @endforeach
            </optgroup>
            @endif
        </select>

        @if(!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
