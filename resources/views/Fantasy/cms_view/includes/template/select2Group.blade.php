@dump($options)
    @dump($value)
        <?php
$is_tableData = !empty($tableData) ? 'is_tableData' : '';
?>
        <li class="inventory {!! $sontable === false ? 'row_style' : '' !!}">
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
            {!! $sontable === false ? '<div class="title">' : '' !!}
                <p class="subtitle">{{ $title }}</p>
                {!! $sontable === false ? '</div>' : '' !!}
            <div class="inner">
                <select class="____select2" name="{{ $disabled ? '' : $name }}" data-model="{{ $tableData['model'] }}" @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif {{ $disabled ? 'disabled' : '' }}>

                    <optgroup label="目前選項為">
                        @include('Fantasy.cms_view.includes.template.select2GroupOption', [
                        'cur' => 1,
                        'level' => $set['level'] ?? 1,
                        'options' => $options,
                        'value' => $value,
                        'groupTitle' => '',
                        'selected' => 'selected',
                        ])
                    </optgroup>
                    <optgroup label="可選擇下列選項">
                        @include('Fantasy.cms_view.includes.template.select2GroupOption', [
                        'cur' => 1,
                        'level' => $set['level'] ?? 1,
                        'options' => $options,
                        'value' => $value,
                        'groupTitle' => '',
                        'selected' => '',
                        ])
                    </optgroup>

                </select>

                @if(!empty($tip))
                    <div class="tips">
                        <span class="title">TIPS</span>
                        <p>{!! $tip !!}</p>
                    </div>
                @endif
            </div>
        </li>
