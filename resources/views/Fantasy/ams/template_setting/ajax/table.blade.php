@foreach($data as $key => $row)
<tr>
    <td class="w_TableMaintitle edit_ams_wrapper" data-type="template-setting" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ collect($branch_options)->where('key',$row['origin_id'])->first()['title'] ?? '-' }}
        </div>
    </td>
    <td class="w_Category w180 edit_ams_wrapper" data-type="template-setting" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ collect($locale_options)->where('key',$row['locale'])->first()['title'] ?? '-' }}
        </div>
    </td>
    <td class="text-center w_Preview edit_ams_wrapper" data-type="template-setting" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ ($row['is_active'] == 1) ? '啟用' : '未啟用' }}</div>
    </td>
    <td class="w_Update open_builder" data-type="template-setting" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ $row['updated_at'] }}</div>
    </td>
</tr>
@endforeach