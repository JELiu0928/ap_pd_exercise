<li class="inventory{{ $sontable ? '' : ' row_style' }}">
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
    {!! $sontable ? '' : '<div class="title">' !!}
        <p class="subtitle">{{ $title }}</p>
        {!! $sontable ? '' : '</div>' !!}

    {!! $sontable ? '' : '<div class="inner">' !!}
        <div class="datetime-group">
            <input class="input-sm form-control timepicker-input"
                name="{{ $disabled ? '' : $name }}"
                @if (!empty($set['toolbar_date'])) data-toolbar="{{ $set['toolbar_date'] }}" @endif
                type="text" value="{{ $value }}"
                @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif
                {{ $disabled ? 'disabled' : '' }}
            >
            <div class="input-group-addon"><span>to</span></div>
            <input class="input-sm form-control timepicker-input"
                name="{{ $disabled ? '' : $name2 }}"
                @if (!empty($set['toolbar_date'])) data-toolbar="{{ $set['toolbar_date'] }}" @endif
                type="text" value="{{ $value2 }}"
                {{ $disabled ? 'disabled' : '' }}
            >
        </div>

        @if(!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{{ $tip }}</p>
            </div>
        @endif
        {!! $sontable ? '' : '
    </div>' !!}
</li>
