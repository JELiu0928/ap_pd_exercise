@foreach($data as $key => $row)
<tr>
    <td class="w_TableMaintitle edit_ams_wrapper" data-type="fantasy-account" data-id="{{ $row['id'] }}">
        <div class="tableMaintitle open_builder">
            <div class="title-img rwdhide">
                @if(!empty($row['_photo_image']))
                <img src="{{$row['_photo_image']['real_route']}}">
                @endif
            </div>
            <span class="title-name open_builder">{{ $row['account'] }}</span>
            @if(!empty($row['mail']))
            <div class="tool">
                <a href="mailto:{{$row['mail']}}">
                    <span class="fa fa-envelope open_builder"></span>
                </a>
            </div>
            @endif
        </div>
    </td>
    <td class=" w_Category edit_ams_wrapper" data-type="fantasy-account" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ !empty($row['name']) ? $row['name'] : '-'}}</div>
    </td>
    <td class=" w_Category edit_ams_wrapper" data-type="fantasy-account" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ !empty($row['mail']) ? $row['mail'] : ''}}</div>
    </td>
    <td class="text-center w_Preview edit_ams_wrapper" data-type="fantasy-account" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ ($row['is_active'] == 1) ? '啟用' : '未啟用' }}</div>
    </td>
    <td class="w_Update open_builder" data-type="fantasy-account" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ $row['updated_at'] }}</div>
    </td>
</tr>
@endforeach