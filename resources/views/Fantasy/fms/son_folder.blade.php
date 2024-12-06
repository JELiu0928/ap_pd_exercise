@if ($type == 'fms_unlimited_list')
    <ul class="sub-menus" style="">
        @foreach ($for_son_folder as $val)
            <li class="fms_unlimited_list">
                <a href="javascript:void(0);" class="" data-id="{{ $val['id'] }}">
                    <span class="iconFolder _close fa fa-folder"></span>
                    <span class="iconFolder _open fa fa-folder-open"></span>
                    <span class="title">{{ $val['title'] }}</span>
                </a>
                @if (!empty($val['son_folder_withSession']))
                    @include('Fantasy.fms.son_folder', [
                        'type' => 'fms_unlimited_list',
                        'for_son_folder' => $val['son_folder_withSession'],
                    ])
                @endif
            </li>
        @endforeach
    </ul>
@endif
@if ($type == 'fms_list')
    @php
        $cms_open = false;
    @endphp
    @foreach ($for_son_folder as $val)
        <tr class="tbody_tick fms_folder fms_folder_{{ $val['parent_id'] }} {{ $val['use_auth'] }} @if ($val['is_delete']) is_delete @endif"
            style="cursor: pointer;display: none;" data-folder-id="{{ $val['parent_id'] }}">
            @if ($val['use_auth'] == 'can_use' && !$cms_open)
                <td class="text-center w_Check">
                    <div class="tableContent">
                        <label class="select-item">
                            <input type="checkbox" class="input_number fms_lbox_file_select_checkbox" data-type="folder"
                                data-id="{{ $val['id'] }}" data-title="{{ $val['title'] }}">
                            <span class="check-circle icon-check"></span>
                        </label>
                    </div>
                </td>
            @else
                <td class="text-center w_Check"></td>
            @endif
            <td class="tool_ctrl">
                <div class="tableMaintitle fms_folder_on_list" data-id="{{ $val['id'] }}" data-parent-id="{{ $val['parent_id'] }}">
                    <div class="title-img rwdhide">
                        <img src="/vender/assets/img/folder.png" alt="">
                    </div>
                    <span class="title-name bold">{{ $val['title'] }}</span>
                    <div class="fms_bulider_new edit file-edit" data-id="{{ $val['id'] }}">
                        <span class="fa fa-pencil"></span>
                    </div>
                </div>
            </td>
            <td class="text-center">
                <div class="tableContent">Folder</div>
            </td>
            <td class="text-center">
                <div class="tableContent">資料夾</div>
            </td>
            <td class="text-center">
                <div class="tableContent"></div>
            </td>
            <td class="text-center">
                <div class="tableContent"></div>
            </td>
            <td class="text-center">
                <div class="tableContent">{{ $val['updated_at'] }}</div>
            </td>
            <td class="text-center">
                <div class="tableContent">{{ $val['create_user']['name'] }}</div>
            </td>
        </tr>
        @if (!empty($val['son_folder_withSession']))
            @include('Fantasy.fms.son_folder', ['type' => 'fms_list', 'for_son_folder' => $val['son_folder_withSession']])
        @endif
    @endforeach

@endif
