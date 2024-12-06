<li class="radioSmall inventory sortStatusSet"
    style="width: 33.33%; border-bottom: solid 1px #c7c7c7 !important; padding: 0px !important;">

    <div style="display:flex; align-items: center; padding: 15px">
        {!! $sontable === false ? '<div class="title">' : '' !!}
        <p class="subtitle" style="margin: 0 10px 0 0 !important">{{ $title }}</p>
        {!! $sontable === false ? '</div>' : '' !!}

        {!! $sontable === false ? '<div class="inner">' : '' !!}
        <div class="ios_switch {{ $disabled == 'disabled' ? '' : 'radio_btn_switch' }} {{ $value == '1' ? 'on' : '' }}">
            <input name="{{ $name }}" type="text" value="{{ $value }}">
            <div class="box">
                <span class="ball"></span>
            </div>
        </div>

        @if ($tip != '')
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
        {!! $sontable === false ? '</div>' : '' !!}
    </div>
</li>
