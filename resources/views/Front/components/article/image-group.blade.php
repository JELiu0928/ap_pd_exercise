@if (! $imageGroup->isEmpty())

<div class="_imgCover">

    @if ($isSwiper)

    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach ($imageGroup as $key=>$item)
            <div class="_cover swiper-slide ">
                <div class="_photo" {{ !empty($item['video']) ? 'video-target-route='.b_url('article/video/'.$item['video']).'  video-type='.$item['video_type'].' video-id='.$item['video'] : '' }}>
                    <img src="{{ BaseFunction::RealFiles($item['image'],false) }}" alt="test">
                </div>
                <p class="_description">{{ $item['title'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="swiper-button-cover"></div>

    @else

    @foreach ($imageGroup as $key=>$item)
    <div class="_cover flip-in-ver-right delay{{($key+1)*2}}" data-aost data-aost-clip>
        <div class="_photo" {{ !empty($item['video']) ? 'video-target-route='.b_url('article/video/'.$item['video']).' video-type='.$item['video_type'].' video-id='.$item['video'] : '' }}>
            <img src="{{ BaseFunction::RealFiles($item['image'],false) }}" alt="test">
        </div>
        <p class="_description">{{ $item['title'] }}</p>
    </div>
    @endforeach

    @endif
</div>

@endif