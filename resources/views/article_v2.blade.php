@foreach ($data as $key => $item)
    @php
        $item['swiper_arrow'] = 1;
    @endphp
        <article class="waypoint {{ $item['article_style'] }}"
        @if (strpos($item['article_style'], '-typeFull') !== false)
            typeFull-img="{{ BaseFunction::RealFiles($item['full_img'],false) }}"
            typeFull-img-rwd="{{ BaseFunction::RealFiles($item['full_img'],false) }}"
            {!! $item['full_size']!=''? 'typeFull-size="'.$item['full_size'].'"' : '' !!}
            {!! $item['full_box_color']!=''? 'typeFull-box-color="'.$item['full_box_color'].'"' : '' !!}
            {!! $item['full_box_border']!=''? 'typeFull-box-border="'.$item['full_box_border'].'"' : '' !!}
        @endif
        {!! $item['article_color']!=''? 'article-color="'.$item['article_color'].'"' : '' !!}
        {!! $item['article_border']!=''? 'article-border="'.$item['article_border'].'"' : '' !!}
        {!! $item['article_align']!=''? 'article-flex="'.$item['article_align'].'"' : '' !!}
        {!! $item['h_color']!=''? 'h-color="'.$item['h_color'].'"' : '' !!}
        {!! $item['h_align']!=''? 'h-align="'.$item['h_align'].'"' : '' !!}
        {!! $item['subh_color']!=''? 'subh-color="'.$item['subh_color'].'"' : '' !!}
        {!! $item['subh_align']!=''? 'subh-align="'.$item['subh_align'].'"' : '' !!}
        {!! $item['p_color']!=''? 'p-color="'.$item['p_color'].'"' : '' !!}
        {!! $item['p_align']!=''? 'p-align="'.$item['p_align'].'"' : '' !!}
        {!! $item['img_size']!=''? 'img-size="'.$item['img_size'].'"' : '' !!}
        {!! $item['is_row']!=''? 'img-row="'.$item['is_row'].'"' : '' !!}
        {!! $item['img_flex']!=''? 'img-flex="'.$item['img_flex'].'"' : '' !!}
        {!! $item['is_firstbig']==1? 'img-firstbig="on"' : '' !!}
        {!! $item['is_ex']==1? 'img-merge="on"' : '' !!}
        {!! $item['des_color']!=''? 'description-color="'.$item['des_color'].'"' : '' !!}
        {!! $item['des_align']!=''? 'description-align="'.$item['des_align'].'"' : '' !!}
        {!! $item['btn_textcolor']!=''? 'button-textcolor="'.$item['btn_textcolor'].'"' : '' !!}
        {!! $item['btn_textcolor_hover']!=''? 'button-textcolor-hover="'.$item['btn_textcolor_hover'].'"' : '' !!}
        {!! $item['btn_textalign']!=''? 'button-textalign="'.$item['btn_textalign'].'"' : '' !!}
        {!! $item['btn_color']!=''? 'button-color="'.$item['btn_color'].'"' : '' !!}
        {!! $item['btn_color_hover']!=''? 'button-color-hover="'.$item['btn_color_hover'].'"' : '' !!}
        {!! $item['btn_border']!=''? 'button-border-="'.$item['btn_border'].'"' : '' !!}
        {!! $item['btn_border_hover']!=''? 'button-border-hover="'.$item['btn_border_hover'].'"' : '' !!}
        {!! $item['btn_align']!=''? 'button-align="'.$item['btn_align'].'"' : '' !!}
        {!! ($item['is_slick']==1 || strpos($item['article_style'], '-typeSwiper') !== false)? 'articleSwiper="on"' : '' !!}
        data-aost data-aost-fade-up data-aost-offset="15"
		>
            <div class="_contentWrap">
                @if (strpos($item['article_style'], '-typeSwiper') !== false)
                    <div class="swiper-container" data-swiper-num="{{ ($item['swiper_num'] > 1)? $item['swiper_num']:'1' }}" data-swiper-autoplay="{{ ($item['swiper_autoplay'] == 1)? '':'' }}" data-swiper-loop="{{ ($item['swiper_loop'] == 1)? 'on':'off' }}" data-swiper-arrow="{{ ($item['swiper_arrow'] == 1)? '':'off' }}" data-swiper-nav="{{ ($item['swiper_nav'] == 1)? '':'off' }}">
                        <div class="swiper-wrapper">
                            @foreach ($item['contentimg'] as $item2)
                            <div class="_cover swiper-slide" data-aost data-aost-clip>
                                <div class="_wordWrap">
                                    <h5 class="_subH">{{ $item2['sw_title'] }}</h5>
                                    <p class="_P">{!! nl2br($item2['content']) !!}</p>
                                </div>
                                <div class="_photoWrap">
                                    <div class="_photo" @if ($item2['video']!='')
                                        video-id="{{ $item2['video'] }}" video-type="{{ ($item2['video_type']!=''&&$item2['video_type']!='0')?$item2['video_type']:'youtube' }}"
                                    @endif>
                                        <img src="{{ (!empty($item2['image'])) ? BaseFunction::RealFiles($item2['image']) : '' }}" alt="{{ (!empty($item2['image'])) ? $item2['title'] : ''}}"/>
                                    </div>
                                    <span class="_description">{{ $item2['title'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    @if (!empty($item['contentimg']))
                        <div class="_imgCover">
                            @if ($item['is_slick']==1)
                            <div class="swiper-container" data-swiper-num="{{ ($item['swiper_num'] > 1)? $item['swiper_num']:'1' }}" data-swiper-autoplay="{{ ($item['swiper_autoplay'] == 1)? 'on':'off' }}" data-swiper-loop="{{ ($item['swiper_loop'] == 1)? 'on':'off' }}" data-swiper-arrow="{{ ($item['swiper_arrow'] == 1)? '':'off' }}" data-swiper-nav="{{ ($item['swiper_nav'] == 1)? '':'off' }}">
                                <div class="swiper-wrapper">
                            @endif
                                @foreach ($item['contentimg'] as $item2)
                                    <div class="_cover {{ $item['is_slick']==1? 'swiper-slide':'' }}">
                                        <div class="_photo" @if ($item2['video']!='')
                                            video-id="{{ $item2['video'] }}" video-type="{{ ($item2['video_type']!=''&&$item2['video_type']!='0')?$item2['video_type']:'youtube' }}"
                                        @endif>
                                        
                                            <img src="{{ (!empty($item2['image'])) ? BaseFunction::RealFiles($item2['image']) : '' }}" alt="{{ (!empty($item2['image'])) ? $item2['title'] : '' }}"/>
                                        </div>
                                        <span class="_description">{{ $item2['title'] }}</span>
                                    </div>
                                @endforeach
                            @if ($item['is_slick']==1)
                                </div>
                            </div>
                            @endif
                        </div>
                    @endif
                    @if ($item['article_title'] != ''||$item['article_sub_title'] != ''||$item['article_inner'] != ''||$item['button_link'] != '')
                        <div class="_wordWrap">
                            @if ($item['article_title'] != '')
                                <h4 class="_H">
                                    {{ $item['article_title'] }}
                                </h4>
                            @endif
                            @if ($item['article_sub_title'] != '')
                                <h5 class="_subH">
                                    {{ $item['article_sub_title'] }}
                                </h5>
                            @endif
                            @if ($item['article_inner'] != '' || $item['button_link'] != '')
                            <p class="_P">{!! nl2br($item['article_inner']) !!}
                                @if ($item['button_link'] != '')
                                    <span class="_buttonCover">
                                        <a class="_button" href="{{ $item['button_link'] }}" @if($item['link_type']==2) target="_blank" @endif>{{ $item['button'] }}<span class="icon-arrow"></span></a>
                                    </span>
                                @endif
                            </p>
                            @endif
                        </div>
                    @endif
                @endif

            </div>
        </article>
    
@endforeach