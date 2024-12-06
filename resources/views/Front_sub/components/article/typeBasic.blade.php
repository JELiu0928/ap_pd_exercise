{{-- 
    通用模板    
--}}

<div class="_contentWrap">

    <h4 class="_H">{{ $paragraph['article_title'] }}</h4>

    {!! $builder->buildImages() !!}
    
    <div class="_wordCover">
        <h5 class="_subH">{{ $paragraph['article_sub_title'] }}</h5>
        <div class="_P">

            {!! $builder->buildContext() !!}

            {!! $builder->buildButton() !!}

        </div>
    </div>
</div>