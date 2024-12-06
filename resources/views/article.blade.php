@foreach ($data as $key => $item)
    <article class="{{$item['article_style']}} @if($item['is_row']!='0'){{$item['is_row']}}@endif @if($item['is_ex'] ==1)--ex @endif @if($item['is_vcenter'] ==1) --vcenter @endif @if($item['is_wauto'] ==1)--wauto @endif" data-aos="fade-up" data-aos-duration="1200" data-aos-offset="300" data-aos-once="true">        
        <div class="_imgcoverOut">
                @foreach ($item[$three] as $item2)
                    @if(!empty($item2['video']))
                        {{-- <div class="-video">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$item2['video']}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div> --}}
                        <div class="-video" data-youtube="{{$item2['video']}}">
                            <div class="img_wrap video_btn_wrap">
                            {{-- 如果客戶沒有設定圖片 img src請保留空值 --}}
                                @if($item2['image'] == 0)
                                    <img src="">
                                @else
                                    <img src="{{BaseFunction::RealFiles($item2['image'])}}">
                                @endif
                                <span class="video_btn" style="display: block;"></span>
                            </div>
                        </div>
                    @else
                        <div class="_photo">
                            <img class="_img b-lazy" src="{{BaseFunction::RealFiles($item2['image'])}}" data-src="{{BaseFunction::RealFiles($item2['image'])}}" alt=""/>
                            <span class="_description text-center">{{$item2['title']}}</span>
                        </div>
                    @endif
                @endforeach                    
        </div>

        <div class="_articlecontent">
            <h4 class="_H title title_type">{{$item['article_title']}}</h4>
            <div class="_imgcover">
                @foreach ($item[$three] as $item2)
                    @if(!empty($item2['video']))
                        {{-- <div class="-video">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$item2['video']}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div> --}}
                        <div class="-video" data-youtube="{{$item2['video']}}">
                            <div class="img_wrap video_btn_wrap">
                            {{-- 如果客戶沒有設定圖片 img src請保留空值 --}}
                                @if($item2['image'] == 0)
                                    <img src="">
                                @else
                                    <img src="{{BaseFunction::RealFiles($item2['image'])}}">
                                @endif
                                <span class="video_btn" style="display: block;"></span>
                            </div>
                        </div>
                    @else
                        <div class="_photo">
                            <img class="_img b-lazy" src="{{BaseFunction::RealFiles($item2['image'])}}" data-src="{{BaseFunction::RealFiles($item2['image'])}}" alt=""/>
                            <span class="_description text-center">{{$item2['title']}}</span>
                        </div>
                    @endif
                @endforeach                    
            </div>
            <p class="_P text mb cont_type">{!!nl2br($item['article_inner'])!!}</p>
        </div>
    </article>
@endforeach
