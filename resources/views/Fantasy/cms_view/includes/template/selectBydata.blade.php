<li class="inventory open_db_lightbox {!! $sontable===false?'row_style':'' !!} {{ ($search===true)? 'card_search_input':''}}" {!! ($search===true)?'data-search_type="single_select" data-search_field="'.$search_field.'"':'' !!}>
    {!! $sontable===false?'<div class="title">':'' !!}
        <p class="subtitle">{{ $title }}</p>
    {!! $sontable===false?'</div>':'' !!}
    <div class="inner">
        <div class="quill_select">
            <div class="select_object ajax_open one_shot" data-model="{{ $model }}" data-cls="one_shot" data-empty="{{ $empty }}">
                {!! $sontable===false?'':'<span class="fa fa-warning h_icon"></span>' !!}
           
                @if(isset($options[$value]['title']) AND !empty($options[$value]['title']))
                    <p class="title">{{ $options[$value]['title'] }}</p>
                @else
                    <p class="title">{{ (!empty($explanation)) ? $explanation : '-' }}</p>
                @endif
                    <span class="arrow pg-arrow_down"></span>
                </div>

                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        </div>

        @if(!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                    <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>