<li class="inventory row_style">
    <div class="title">
        <div class="subtitle">
            @if ($batch || $search)
                <div>
                    <div class="radioSmall inventory sortStatusSet" style="padding: 0px !important;">
                        <div style="display:flex; align-items: center; padding: 8px">
                            <div class="ios_switch radio_btn_switch">
                                <input name="{{ 'batch_' . $name }}" type="text" value="">
                                <div class="box">
                                    <span class="ball"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div>{{ $title }}</div>
        </div>
    </div>
    <div class="inner">
        <input class="normal_input" data-autosetup="" name="{{ $disabled ? '' : $name }}" type="hidden" value="{{$value}}" {{ $disabled ? 'disabled' : '' }} autocomplete="off">
            <div class="select2MultiNew">
                @foreach( count($value_arr) > 0 ? collect($options)->whereIn('key',$value_arr)->all() : [] as $val)
                <span data-id="{{$val['key']}}" draggable="true"><a class="fa fa-remove"></a>{{$val['title']}}</span>
                @endforeach
            </div>
            <div class="select2MultiNew_option">
                @if(isset($set['options_model']) && !empty($set['options_model']) && count($options) >= 50)
                <div class="select2MultiNew_search" data-options_model="{{$set['options_model']}}" data-main_model="{{$set['main_model'] ?? ''}}">
                    <input name="search_keyword" type="text" autocomplete="off">
                    <a>Search</a>
                </div>
                @endif
                @if(isset($set['options_max']) && $set['options_max'] == count($options))
                <div class="tip">下列選項只會顯示最新{{$set['options_max']}}筆,若不在列表內請使用搜尋功能</div>
                @endif
                <div class="select2MultiNew_option_item_search hide">

                </div>
                <div class="select2MultiNew_option_item">
                @foreach($options as $val)
                <span data-id="{{$val['key']}}" class="{{ (in_array($val['key'],$value_arr)) ? 'active':'' }} ">{{$val['title']}}</span>
                @endforeach
                </div>
            </div>
        @if (!empty($tip))
            <div class="tips">
                @if (isset($set['search_tag']))
                    <span style="color: #ff0000;font-weight: 700;margin-right: 10px;">全站搜尋</span>
                @endif
                <div class="title">
                    <span>TIPS</span>
                </div>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>

</li>
