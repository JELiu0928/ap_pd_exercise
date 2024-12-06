@foreach($data as $key => $row)
<tr>
    <td class="w_TableMaintitle edit_ams_wrapper" data-type="autoredirect" data-id="{{ $row['id'] }}">
        <div class="tableMaintitle open_builder">
            <span class="title-name open_builder">{{ $row['old_url'] }}</span>
        </div>
    </td>
    <td class="w_TableMaintitle edit_ams_wrapper" data-type="autoredirect" data-id="{{ $row['id'] }}">
        <div class="tableMaintitle open_builder">
            <span class="title-name open_builder">{{ $row['new_url'] }}</span>
        </div>
    </td>
    <td class="text-center w_Preview edit_ams_wrapper" data-type="autoredirect" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ ($row['active301'] == 1) ? '301' : '302' }}</div>
    </td>
</tr>
@endforeach