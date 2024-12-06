<li class="inventory {!! $sontable===false?'row_style':'' !!} {{ ($search===true)? 'card_search_input':''}}" {!! ($search===true)?'data-search_type="single_select" data-search_field="'.$search_field.'"':'' !!}>
    {!! $sontable===false?'<div class="title">':'' !!}
        <p class="subtitle">{{ $title }}</p>
    {!! $sontable===false?'</div>':'' !!}
    <div class="inner">
        <div class="quill_select">
            <div class="select_object">
                {!! $sontable===false?'':'<span class="fa fa-warning h_icon"></span>' !!}
                
                @if(isset($options[$value]['title']) AND !empty($options[$value]['title']))
                    <p class="title">{{ $options[$value]['title'] }}</p>
                @else
                    <p class="title">{{ (!empty($explanation)) ? $explanation : '-' }}</p>
                @endif
                    <span class="arrow pg-arrow_down"></span>
                </div>

                @if(!(!empty($disabled) AND $disabled == 'disabled'))
                <div class="select_wrapper">
                    <ul class="select_list {{ $sontable===false?'edit_select':'' }}">
                        {!! $empty == 'yes'?'<li class="option single_select_fantasy" data-id="0"><p>-</p></li>':'' !!}

                        @if($options_group_set == 'yes')

                            @foreach ($options_group as $key_1 => $row_1) 
                                <p class="category">{{ $row_1['title'] }}</p>
                                @foreach($row_1['key'] as $row_key)
                                    @foreach ($options as $key_o => $value_o) 
                                        @if($value_o['key'] == $row_key)
                                            <li class="option single_select_fantasy" data-id="{{ $value_o['key'] }}"><p>{{ $value_o['title'] }}</p></li>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        
                        @else
                        
                            @foreach ($options as $key => $row) 
                                <li class="option single_select_fantasy" data-id="{{ $row['key'] }}"><p>{{ $row['title'] }}</p></li>
                            @endforeach

                        @endif
                        <input type="hidden" class="{{$auto}}" data-autosetup="{{$autosetup}}" name="{{ $name }}" value="{{ $value }}">
                    </ul>
                </div>
                @endif
        </div>

        @if(!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                    <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>