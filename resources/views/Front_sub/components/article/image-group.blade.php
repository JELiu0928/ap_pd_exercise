@if (! $imageGroup->isEmpty())

<div class="_imgCover">

    @if ($isSwiper)

    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($imageGroup as $item)
            <div class="_cover swiper-slide">
                <div class="_photo" {{ $item['video'] ? "video-type={$item['video_type']} video-id={$item['video']}" : '' }}>
                    <img src="{{ BaseFunction::RealFiles($item['image'],false) }}" alt="">
                </div>
                <p class="_description">{{ $item['title'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="swiper-button-cover" data-aost data-aost-fade-up data-aost-offset="15"></div>

    @else

    @foreach ($imageGroup as $item)
    <div class="_cover" data-aost data-aost-clip>
        <div class="_photo" {{ $item['video'] ? "video-type={$item['video_type']} video-id={$item['video']}" : '' }}>
            <img src="{{ BaseFunction::RealFiles($item['image'],false) }}" alt="">
        </div>
        <p class="_description">{{ $item['title'] }}</p>
    </div>
    @endforeach

    @endif
</div>

@endif