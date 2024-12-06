<li class="inventory row_style productImage">
    <div class="title">
        <p class="subtitle">{{ $title }}</p>
    </div>

    <div class="inner">
        <div class="picture_box {{ isset($set['auto_add']) && $set['auto_add'] ? 'img_list':''}} {{ (isset($set['input'])) ? 'has_input':'' }}">

            @foreach($image_array as $key_img => $value_img)
                @if($batch || $search)
                    <div>
                        <div class="radioSmall inventory sortStatusSet" style="padding: 0px !important;">
                            <div style="display:flex; align-items: center; padding: 8px">
                                <div class="ios_switch radio_btn_switch">
                                    <input name="{{ 'batch_' .  $value_img['name'] }}" type="text" value="">
                                    <div class="box">
                                        <span class="ball"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @php
                    if (!empty($fileInformationArray[$value_img['value']])) {
                    $imgClass = 'has_img';
                    $imgSrc = $fileInformationArray[$value_img['value']]['real_route'];
                    } else {
                    $imgClass = '';
                    $imgSrc = '';
                    }
                    if ($value_img['set_size'] == 'yes') {
                    $width = ($value_img['width'] / $value_img['height']) * 100;
                    $width .= 'px;';
                    $img_style = '';
                    } else {
                    $width = 'auto;';
                    $img_style = 'height:auto;max-width: 200px;min-height: 100px;';
                    }
                    if ($disabled = isset($value_img['disabled']) ? (intval($value_img['disabled']) === 1 ? true : false) : false) {
                    $lbox_fms_open = '';
                    } else {
                    $lbox_fms_open = 'lbox_fms_open';
                    }
                @endphp
                <div class="frame open_fms_lightbox {{ $imgClass }}">

                    @if(isset($set['auto_add']) && $set['auto_add'])
                    <div class="rank text-center">{{ (!empty($value_img['value'])) ? ($key_img + 1) : '選擇圖片(可多選)'}}</div>
                    @endif
                    <div class="box" style="width:{{ $width }} ;height:auto;">
                        <img class="img_key" src="{{ (!empty($imgSrc)) ? BaseFunction::imgSrc($imgSrc) : '' }}" style="{{ $img_style }}">
                        <input class="value_key" name="{{ $disabled ? '' : $value_img['name'] }}{{ isset($set['auto_add']) && $set['auto_add'] ? '[]':''}}" type="hidden" value="{{ $value_img['value'] }}" @if(!empty($set['verify']) && !$disabled) data-verify="{{json_encode($set['verify'])}}" @endif>
                        <span class="icon fa fa-plus {{ $lbox_fms_open }}" data-key="key" data-type="{{ isset($set['auto_add']) && $set['auto_add'] ? 'img_list':'img'}}"></span>

                        <div class="tool">
                            @if(!isset($set['auto_add']) || (isset($set['auto_add']) && !$set['auto_add']))
                            <span class="t_icon fa fa-folder file_detail_btn"></span>
                            @endif
                            @if(!$disabled)
                                <span class="t_icon fa fa-pencil lbox_fms_open" data-key="key" data-type="{{ isset($set['auto_add']) && $set['auto_add'] ? 'img_list':'img'}}"></span>
                                <span class="t_icon fa fa-trash image_remove" data-key="key" data-type="{{ isset($set['auto_add']) && $set['auto_add'] ? 'img_list':'img'}}"></span>
                            @endif
                        </div>
                    </div>

                    <div class="info">
                        <p>{{ $value_img['title'] ?? '' }}</p>
                    </div>

                    @if(isset($set['input']))
                    <div class="input_area">
                    @foreach($set['input'] as $k=>$inputVal)
                    <div class="img_list_title" @if(empty($value_img['value'])) style="display: none;" @endif>{{$inputVal['title']}}</div>
                    <input class="img_list_input" type="text" name="{{$inputVal['value']}}" value="{{$value_img['input'][$k]['val'] ?? ''}}" @if(empty($value_img['value'])) style="display: none;" @endif>
                    @endforeach
                    </div>
                    @endif
                    @if(!empty($fileInformationArray[$value_img['value']]))
                        @php
                            $_this_file_path = BaseFunction::get_file_path($fileInformationArray[$value_img['value']]);
                        @endphp

                        <div class="file_detail_box">
                            <div class="info_detail">
                                <p class="file_key">
                                    <span>FILE</span>{{ $fileInformationArray[$value_img['value']]['title'] }}.{{ $fileInformationArray[$value_img['value']]['type'] }}
                                </p>
                                <p class="folder_key"><span>FOLDER</span>{{ $_this_file_path }}</p>
                                <p class="type_key">
                                    <span>TYPE</span>{{ $fileInformationArray[$value_img['value']]['type'] }}
                                </p>
                                <p class="size_key">
                                    <span>SIZE</span>{{ $fileInformationArray[$value_img['value']]['resolution'] }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="file_detail_box">
                            <div class="info_detail">
                                <p class="file_key"><span>FILE</span></p>
                                <p class="folder_key"><span>FOLDER</span></p>
                                <p class="type_key"><span>TYPE</span></p>
                                <p class="size_key"><span>SIZE</span></p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>


        @if(!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
