<li class="inventory row_style">
    @if($batch || $search)
        <div>
            <div class="radioSmall inventory sortStatusSet" style="padding: 0px !important;">
                <div style="display:flex; align-items: center; padding: 8px">
                    <div class="ios_switch radio_btn_switch">
                        <input name="{{ 'batch_' .  $name }}" type="text" value="">
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

    <div class="inner file-picker">
        @php
            if (isset($fileInformationArray[$value]) and !empty($fileInformationArray[$value])) {
            $fileData = $fileInformationArray[$value]['title'] . '.' . $fileInformationArray[$value]['type'];
            $fileRoute = $fileInformationArray[$value]['real_route'];
            } else {
            $fileData = '';
            $fileRoute = '';
            }
        @endphp

        <input class="normal_input filepicker_input_key" type="text" value="{{ $fileData }}" style="width:70%;" disabled>
        <input class="normal_input{{ $disabled ? '' : ' lbox_fms_open' }}" data-key="key" data-type="file" type="button" value="..." style="width:5%;cursor: pointer;">

        <input class="normal_input file_fantasy_download filepicker_src_key filepicker_title_key" data-src="{{ $fileRoute }}" data-title="{{ $fileData }}" type="button" value="⇩" style="width:5%;cursor: pointer;">
        <input class="normal_input fa-remove" type="button" value="X" style="width:5%;cursor: pointer;" @if (!$disabled) id="onlyfileremove" @endif>
        <input class="filepicker_value_key" name="{{ $disabled ? '' : $name }}" type="hidden" value="{{ $value }}" @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif>

        @if(!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
