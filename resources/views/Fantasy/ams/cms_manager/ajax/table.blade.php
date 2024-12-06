@foreach($data as $key => $row)
<tr>
    <td class="w_TableMaintitle edit_ams_wrapper" data-type="cms-manager" data-id="{{ $row['id'] }}">
        <div class="tableMaintitle open_builder">
            <div class="title-img rwdhide">
                @if(!empty($row['UsersData']['_photo_image']))
                <img src="{{$row['UsersData']['_photo_image']['real_route']}}">
                @endif
            </div>
            <span class="title-name open_builder">{{ $row['UsersData']['name'] }}</span>
            @if(!empty($row['UsersData']['mail']))
            <div class="tool">
                <a href="mailto:{{$row['UsersData']['mail']}}"><span class="fa fa-envelope open_builder"></span></a>
            </div>
            @endif
        </div>
    </td>
    <td class=" w_Category edit_ams_wrapper" data-type="cms-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ collect($branch_unit_options)->where('key',$row['branch_unit_id'])->first()['branch'] ?? '-' }}
        </div>
    </td>
    <td class=" w_Category edit_ams_wrapper" data-type="cms-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ collect($branch_unit_options)->where('key',$row['branch_unit_id'])->first()['locale'] ?? '-' }}
        </div>
    </td>
    <td class="text-center w_Preview edit_ams_wrapper" data-type="cms-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ ($row['is_active'] == 1) ? '啟用' : '未啟用' }}</div>
    </td>
    <td class="w_Update open_builder" data-type="cms-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ $row['updated_at'] }}</div>
    </td>
</tr>
@endforeach