{{--
    通用模板
--}}

<div class="_contentWrap">

    @if(!empty($paragraph['article_title']))<h4 class="_H">{{ $paragraph['article_title'] }}</h4>@endif

    {!! $builder->buildImages() !!}

    <div class="_wordCover">
        @if(!empty($paragraph['article_sub_title']))<h5 class="_subH">{{ $paragraph['article_sub_title'] }}</h5>@endif
        <div class="_P">

            {!! $builder->buildContext() !!}

            {!! $builder->buildButton() !!}

        </div>
    </div>
</div>
