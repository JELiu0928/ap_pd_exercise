<li class="inventory row_style">
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
    <div class="title">
        <p class="subtitle">{{ $title }}</p>
    </div>
    <div class="inner">
        <textarea class="____normal_textarea}" name="{{ $disabled ? '' : $name }}" type="text" @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif {{ $disabled ? 'disabled' : '' }}>{{ gettype($value)!="string" ? json_encode($value) : $value}}</textarea>
        @if(!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
