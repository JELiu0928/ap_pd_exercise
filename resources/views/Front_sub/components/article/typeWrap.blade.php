{{-- 
    文繞樣式    
--}}

<div class="_contentWrap">

    {!! $builder->buildImages() !!}
    
    <h4 class="_H">{{ $paragraph['article_title'] }}</h4>
    <h5 class="_subH">{{ $paragraph['article_sub_title'] }}</h5>
    
    <div class="_P"> 

        {!! $builder->buildContext() !!}

        {!! $builder->buildButton() !!}
    </div>
</div>