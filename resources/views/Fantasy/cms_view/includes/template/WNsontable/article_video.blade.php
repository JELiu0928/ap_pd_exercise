@php
if(!empty($value_son)){
    $fileIds = [];
    foreach ($three['three_content'][0]['image_array'] as $key_img => $value_img)
    {
        array_push($fileIds, $value_son[$value_img['value']]);
    }
    $fileInformationArray = (!empty($fileIds)) ? BaseFunction::getFilesArrayWithKey($fileIds) : [];
}
@endphp
<div class="article_video_left">
    <div class="_a_image_group productImage">
        <div class="inner">
            <div class="picture_box">

                @foreach($three['three_content'][0]['image_array'] as $key_img => $value_img)
                @php
                $randomWord = \Illuminate\Support\Str::random(19);

                $imgClass = '';
                $imgSrc = '';
                if(!empty($value_son)){
                    if(isset($fileInformationArray[ $value_son[$value_img['value']] ]) AND !empty($fileInformationArray[ $value_son[$value_img['value']] ]))
                    {
                        $imgClass = 'has_img';
                        $imgSrc = $fileInformationArray[ $value_son[$value_img['value']] ]['real_route'];
                        $folder_level = 0;
                    }
                }

                $width = 'auto;';
                $img_style = 'height:auto;max-width: 200px;min-height: 100px;';
                if($value_img['set_size'] == 'yes')
                {
                    $width = ($value_img['width']/$value_img['height'])*100;
                    $width .= 'px;';
                    $img_style = '';
                }

                $lbox_fms_open = 'lbox_fms_open';
                if(isset($value_img['disabled']) AND $value_img['disabled'] == 'disabled')
                {
                    $lbox_fms_open = '';
                }
                @endphp
                <div class="frame open_fms_lightbox {{$imgClass}}">
                    <div class="box" style="width:158px;height:auto;">
                        <img src="{{ BaseFunction::imgSrc($imgSrc) }}" style="{{$img_style}}" class="img_key">
                        <input type="hidden" name="{{$son_son_db}}[{{$value_img['value']}}]" value="{{!empty($value_son) ? $value_son[$value_img['value']] : "0"}}" class="value_key">
                        <span class="icon fa fa-plus {{$lbox_fms_open}}" data-key="key" data-type="img"></span>

                        <div class="tool">
                            <span class="t_icon fa fa-folder file_detail_btn"></span>
                            <span class="t_icon fa fa-pencil {{$lbox_fms_open}}" data-key="key" data-type="img" @if(!empty($value_son)) @if(isset($fileInformationArray[ $value_son[$value_img['value']] ]) AND !empty($fileInformationArray[ $value_son[$value_img['value']] ])) data-l0="0" data-l1="0" data-l2="0" data-l3="0" data-s0="" data-s1="" data-s2="" data-s3="" @endif @endif></span>
                            <span class="t_icon fa fa-trash image_remove" data-key="key" data-type="img"></span>
                        </div>
                    </div>
                    <div class="info">
                        <p>{{$value_img['title']}}</p>
                    </div>
                    @if(!empty($value_son) && isset($fileInformationArray[ $value_son[$value_img['value']] ]) AND !empty($fileInformationArray[ $value_son[$value_img['value']] ]))
                    @php
                    $_this_file_path = BaseFunction::get_file_path($fileInformationArray[ $value_son[$value_img['value']] ]);
                    @endphp

                    <div class="file_detail_box">
                        <div class="info_detail">
                            <p class="file_key"><span>FILE</span>{{$fileInformationArray[ $value_son[$value_img['value']] ]['title']}}.{{$fileInformationArray[ $value_son[$value_img['value']] ]['type']}}</p>
                            <p class="folder_key"><span>FOLDER</span>{{$_this_file_path}}</p>
                            <p class="type_key"><span>TYPE</span>{{$fileInformationArray[ $value_son[$value_img['value']] ]['type']}}</p>
                            <p class="size_key"><span>SIZE</span>{{$fileInformationArray[ $value_son[$value_img['value']] ]['resolution']}}</p>
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
        </div>
    </div>
</div>
<div class="article_video_right">
    <div class="_a_textInput">
        <p class="type">{{$three['three_content'][1]['title']}}</p>
        <p>
            <input class="normal_input DataSync" data-autosetup="AutoSet_article_dec" type="text" value="{{!empty($value_son)?$value_son[$three['three_content'][1]['value']]:''}}" name="{{$son_son_db}}[{{$three['three_content'][1]['value']}}]">
        </p>
        @if(isset($three['three_content'][1]['tip']))
        <div class="tips">
            <span class="title">TIPS</span>
            <p>{!!$three['three_content'][1]['tip']!!}</p>
        </div>
        @endif
    </div>
    <div class="three_group">
        <div class="_a_radio_area">
            <p class="type">{{$three['three_content'][2]['title']}}</p>
            <div class="radio_area">
                <input type="hidden" name="{{$son_son_db . '[' . $three['three_content'][2]['value'] . ']'}}" value="{{$value_son[$three['three_content'][2]['value']] ?? 'youtube'}}">
                <div class="content">
                    @foreach ($three['three_content'][2]['options'] as $key => $row)
                    <label class="box {{(($value_son[$three['three_content'][2]['value']] ?? 'youtube') == $row['key']) ? 'active':''}}" data-autosetup="" data-value="{{ $row['key'] }}" data-hide="" data-hidetip="{{$row['hidetip']}}">
                    <div class="plan">
                        <span class="circle"></span>
                        <span class="yearly">{{ $row['title'] }}</span>
                    </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="_a_textInput">
            <p class="type">{{$three['three_content'][3]['title']}}</p>
            <p>
                <input class="normal_input" type="text" value="{{!empty($value_son)?$value_son[$three['three_content'][3]['value']]:''}}" name="{{$son_son_db}}[{{$three['three_content'][3]['value']}}]">
            </p>
        </div>
    </div>
    <div class="_a_textInput">
        <div class="tips youtube" id="youtube">
            <span class="title">TIPS</span>
            <p>影片代碼請輸入Youtube影片網址V後面的英文數字，若不啟用影片則保持空值即可。<br>例：https://www.youtube.com/watch?v=abcdef，請輸入<span style="color:#ff0000;">abcdef</span></p>
        </div>
        <div class="tips youku" id="youku" style="{{ (empty($value_son)) ? 'display: none;':'' }}">
            <span class="title">TIPS</span>
            <p>影片代碼請輸入YOUKU影片網址/id_後面到==.html前的英文數字，若不啟用影片則保持空值即可。<br>例：https://v.youku.com/v_show/id_abcdef==.html ，請輸入<span style="color:#ff0000;">abcdef</span</p>
        </div>
    </div>

</div>
