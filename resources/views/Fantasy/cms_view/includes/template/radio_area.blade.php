<li class="inventory">
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
    <div class="title">
        <p class="subtitle">{{ $title }}</p>
    </div>
    <div class="inner">
        <div class="radio_area">
            <div class="content">
                <input name="{{ $disabled ? '' : $name }}" type="hidden" value="{{ $value }}">
                @php
                    $active = (!empty($options)) ? collect($options)->where('key',$value)->first() : "";
                    $active = (empty($active)) ? ['key'=>$options[array_key_first($options)]['key']] : $active;
                @endphp
                @foreach ($options as $key => $row)
                    <label
                        class="box {{ ($active['key'] == $row['key']) ? 'active' : '' }} {{ $disabled ? 'disables' : '' }}"
                        data-value="{{ $row['key'] }}" data-hide="{{ $row['hide'] ?? '' }}">
                        <div class="plan">
                            <span class="circle"></span>
                            <span class="yearly">{{ $row['title'] }}</span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
        @if (!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
