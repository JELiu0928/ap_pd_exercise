@if($disabled)
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
        <div class="color_picker">
            <div class="sp-replacer sp-light">
                <div class="sp-preview">
                    <div class="sp-preview-inner" style="background-color: {{ $value }};"></div>
                </div>
            </div>

            <div class="ticket_field" style="">
                <p>{{ $value }}</p>
            </div>
        </div>
        @if(!empty($tip))
        <div class="tips">
            <span class="title">TIPS</span>
            <p>{!! $tip !!}</p>
        </div>
        @endif
    </div>
</li>
@else
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
        <div class="color_picker">
            <input class="palette" name="{{ $name }}" type="text" value="{{ $value }}" data-color="{{$color}}" @if (!empty($set['verify'])) data-verify="{{ json_encode($set['verify']) }}" @endif />
        </div>
        @if(!empty($tip))
        <div class="tips">
            <span class="title">TIPS</span>
            <p>{!! $tip !!}</p>
        </div>
        @endif
    </div>
</li>
@endif
