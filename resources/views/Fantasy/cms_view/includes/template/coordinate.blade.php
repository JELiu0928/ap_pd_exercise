<li class="inventory row_style">
    <div class="title">
        <div class="subtitle">
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
            <div>{{ $title }}</div>
        </div>
    </div>
    <div class="inner {{ isset($set['target']) && !empty($set['target']) ? 'url_target' : '' }}">
        <input class="normal_input coordinate_modal" class="title" data-return="{{$set['return']}}" data-image="{{$set['image']}}" data-width="{{$set['size']['width']}}" data-height="{{$set['size']['height']}}" name="{{ $disabled ? '' : $name }}" type="text" value="{{ $value }}" {{ $disabled ? 'disabled' : '' }} autocomplete="off">
        @if (!empty($tip))
            <div class="tips">
                <div class="title">
                    <span>TIPS</span>
                </div>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
