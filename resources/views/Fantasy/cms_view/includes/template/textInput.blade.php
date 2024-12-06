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
        @if (isset($set['accessible']))
            <div style="height: 10px"></div>
            <div class="subtitle">
                @if ($batch || $search)
                    <div>
                        <div class="radioSmall inventory sortStatusSet" style="padding: 0px !important;">
                            <div style="display:flex; align-items: center; padding: 8px">
                                <div class="ios_switch radio_btn_switch">
                                    <input name="{{ 'batch_' . $set['accessible']['name'] }}" type="text"
                                        value="">
                                    <div class="box">
                                        <span class="ball"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div>無障礙讀音內容</div>
            </div>
        @endif
    </div>
    <div class="inner {{ isset($set['target']) && !empty($set['target']) ? 'url_target' : '' }}">
        <input class="normal_input {{ $set['class'] ?? '' }} {{ $auto ? 'DataSync':'' }}" data-autosetup="{{ $autosetup }}" class="title" name="{{ $disabled ? '' : $name }}"
            type="text" value="{{ $value }}"
            @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif
            {{ $disabled ? 'disabled' : '' }} autocomplete="off">
        @if (isset($set['accessible']))
            <div style="height: 10px"></div>
            <input class="normal_input {{ $set['class'] ?? '' }}"
                name="{{ $disabled ? '' : $set['accessible']['name'] ?? '' }}" type="text"
                value="{{ $set['accessible']['value'] ?? '' }}"
                @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif
                {{ $disabled ? 'disabled' : '' }} autocomplete="off">
        @endif
        @if (isset($set['target']) && !empty($set['target']))
            <div class="checkbox_area ">
                <div class="content">
                    <label class="box {{ $set['target']['value'] == 1 ? 'active' : '' }}" data-hide=""> <input
                            name="{{ $disabled ? '' : $set['target']['name'] }}" type="hidden"
                            value="{{ $set['target']['value'] ?: '0' }}">
                        <div class="plan">
                            <span class="circle"></span>
                            <span class="yearly">於新視窗開啟</span>
                        </div>
                    </label>
                </div>
            </div>
        @endif
        @if (!empty($tip))
            <div class="tips">
                @if (isset($set['search_tag']))
                    <span style="color: #ff0000;font-weight: 700;margin-right: 10px;">全站搜尋</span>
                @endif
                <div class="title">
                    <span>TIPS</span>
                </div>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>

</li>
