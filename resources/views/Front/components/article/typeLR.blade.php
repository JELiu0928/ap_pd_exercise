{{--
    專門給圖右文左,圖左文右的樣式使用
--}}

<div class="_contentWrap">

    {!! $builder->buildImages() !!}

    <div class="_wordCover">
        @if(!empty($paragraph['article_title']))<h4 class="_H">{{ $paragraph['article_title'] }}</h4>@endif
        @if(!empty($paragraph['article_sub_title']))<h5 class="_subH">{{ $paragraph['article_sub_title'] }}</h5>@endif
        <div class="_P">

            {!! $builder->buildContext() !!}

            {!! $builder->buildButton() !!}

        </div>
    </div>
</div>
