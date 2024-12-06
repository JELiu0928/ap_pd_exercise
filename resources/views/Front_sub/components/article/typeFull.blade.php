<div class="_backgroundWrap" data-aost data-aot-clip>

    @if ($paragraph['full_img'])
    <div class="_pc" style="background-image: url('{{ BaseFunction::RealFiles($paragraph['full_img'], false) }}')"></div>
    @endif

    @if ($paragraph['full_img_rwd'])
    <div class="_mobile" style="background-image: url('{{ BaseFunction::RealFiles($paragraph['full_img_rwd'], false) }}')"></div>
    @endif

</div>

<div class="_contentWrap">

    {!! $builder->buildImages() !!}

    <div class="_wordCover">

        <h4 class="_H">{{ $paragraph['article_title'] }}</h4>

        <h5 class="_subH">{{ $paragraph['article_sub_title'] }}</h5>

        <div class="_P">

            {!! $builder->buildContext() !!}

            {!! $builder->buildButton() !!}

        </div>
    </div>
</div>