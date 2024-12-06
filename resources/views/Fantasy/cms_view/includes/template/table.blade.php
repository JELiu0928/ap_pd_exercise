<li class="inventory {!! $sontable ? '' : 'row_style' !!}">
    <div class="inner">
        <table class="edit_table edit_table_drag">
            <thead>
                <tr>
                    @if($set['add'])
                    <th>#</th>
                    @endif
                    <th>{{ $set['first_label'] ?? '編號' }}</th>
                    @foreach($set['label'] ?: [] as $val)
                    <th>{{$val}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for($index = 1;$index <= ( (isset($value[$set['field'][0]]) && count($value[$set['field'][0]]) >= $set['count']) ? count($value[$set['field'][0]]) : $set['count'] ) ;$index++)
                <tr draggable="true">
                    @if($set['add'])
                    <th><span class="icon-delete edit_delete"></span></th>
                    @endif
                    <th>{{$index}}</th>
                    @foreach($set['field'] ?: [] as $val)
                    <th><input class="normal_input" type="text" name="{{$name}}[{{$val}}][]" value="{{$value[$val][$index-1] ?? ''}}"></th>
                    @endforeach
                </tr>
                @endfor
            </tbody>
        </table>
        @if($set['add'])
        <div class="edit_table_add">
            <a><span class="icon-add"></span>新增一列</a>
        </div>
        @endif
        @if (!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
