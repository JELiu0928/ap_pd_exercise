@foreach($data as $key => $row)
<tr>
    <td class="w_TableMaintitle edit_ams_wrapper" data-type="template-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ $row['title'] ?: '-' }}
        </div>
    </td>
    <td class="w_Category w180 edit_ams_wrapper" data-type="template-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ $row['en_title'] ?: '-' }}
        </div>
    </td>
    <td class="w_Category w180 edit_ams_wrapper" data-type="template-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">
            {{ $row['url_title'] ?: '-' }}
        </div>
    </td>
    <td class="text-center w_Preview edit_ams_wrapper" data-type="template-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ ($row['is_active'] == 1) ? '啟用' : '未啟用' }}</div>
    </td>
    <td class="w_Update open_builder" data-type="template-manager" data-id="{{ $row['id'] }}">
        <div class="tableContent">{{ $row['updated_at'] }}</div>
    </td>
</tr>
@endforeach