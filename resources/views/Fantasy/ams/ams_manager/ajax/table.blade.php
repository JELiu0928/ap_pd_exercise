@foreach($data as $key => $row)
<tr>
    <td class="w_Category edit_ams_wrapper" data-type="ams-manager" data-id="{{ $row['id'] }}">
        <div class="tableMaintitle ">
            <div class="title-img rwdhide">
                @if(!empty($row['UsersData']['_photo_image']))
                <img src="{{$row['UsersData']['_photo_image']['real_route']}}">
                @endif
            </div>
            <span class="title-name ">{{ $row['UsersData']['name'] }}</span>
            @if(!empty($row['UsersData']['mail']))
            <div class="tool">
                <a href="mailto:{{$row['UsersData']['mail']}}"><span class="fa fa-envelope "></span></a>
            </div>
            @endif
        </div>
    </td>
    <td class=" w_Category edit_ams_wrapper" data-type="ams-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ $row['role_identity'] ?: '-'}}
        </div>
    </td>
    <td class=" w_TableMaintitle edit_ams_wrapper" data-type="ams-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ $row['role_group'] ?: '-'}}
        </div>
    </td>
    <td class="text-center w_Preview edit_ams_wrapper" data-type="ams-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ ($row['is_active'] == 1) ? '啟用' : '未啟用' }}</div>
    </td>
    <td class="w_Update " data-type="ams-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ $row['updated_at'] }}</div>
    </td>
</tr>
@endforeach