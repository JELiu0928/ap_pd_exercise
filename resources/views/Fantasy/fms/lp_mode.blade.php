<div class="datatable">
    <table class="tables">
        <thead>
            <tr>
                <th class="w_Check">
                    <div class="fake-thead">
                        <div class="fake-th first">
                            <label class="select-item">
                                <input type="checkbox">
                                <span class="check-circle icon-check"></span>
                            </label>
                        </div>
                    </div>
                </th>

                <th class=" ">
                    <div class="fake-th ">
                        <span class="sort theadSortBtn" data-column="w_title">資料夾/檔案名稱</span>
                    </div>
                </th>
                <th class=" " style="width: 120px;">
                    <div class="fake-th ">
                        <span class="sort theadSortBtn" data-column="w_title">檔案格式</span>
                    </div>
                </th>
                <th class=" " style="width: 120px;">
                    <div class="fake-th ">
                        <span class="sort theadSortBtn" data-column="w_title">檔案類型</span>
                    </div>
                </th>
                <th class=" " style="width: 120px;">
                    <div class="fake-th ">
                        <span class="sort theadSortBtn" data-column="w_title">檔案容量</span>
                    </div>
                </th>
                <th class=" " style="width: 120px;">
                    <div class="fake-th ">
                        <span class="sort theadSortBtn" data-column="w_title">檔案尺寸</span>
                    </div>
                </th>
                <th class=" " style="width: 120px;">
                    <div class="fake-th ">
                        <span class="sort theadSortBtn" data-column="w_title">最後異動時間</span>
                    </div>
                </th>
                <th class=" " style="width: 120px;">
                    <div class="fake-th ">
                        <span class="sort theadSortBtn" data-column="w_title">檔案擁有者</span>
                    </div>
                </th>

            </tr>
        </thead>


        <tbody class="multi_shot">
            @foreach($folder as $key => $row)
            <tr class="tbody_tick fms_list_folder_btn {{ $folderLevel }}" data-id="{{ $row['id'] }}" style="cursor: pointer;">
                <td class="text-center w_Check">
                    <div class="tableContent">
                        <label class="select-item">
                            <input type="checkbox" class="input_number fms_lbox_file_select_checkbox" data-type="folder" data-level="{{ $folderLevel }}" data-id="{{ $row['id'] }}" data-title="{{ $row['title'] }}">
                            <span class="check-circle icon-check"></span>
                        </label>
                    </div>
                </td>
                <td class="tool_ctrl">
                    <div class="tableMaintitle">
                        <img src="/vender/assets/img/folder.png" alt="" class="title-img rwdhide">
                        <span class="title-name bold">{{ $row['title'] }}</span>
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
                    <div class="tableContent">{{ $row['updated_at'] }}</div>
                </td>
                <td class="text-center">
                    <div class="tableContent">{{$row['create_user']['name'] ?? ''}}</div>
                </td>
            </tr>
            @endforeach
            @foreach($file as $key => $row)
            <tr class="tbody_tick fms_list Leon-f Leon-in-f-{{$row['zero_id']}}-{{$row['first_id']}}-{{$row['second_id']}}-{{$row['third_id']}}" style="cursor: pointer;">
                <td class="text-center w_Check">
                    <div class="tableContent">
                        <label class="select-item">
                            <input type="checkbox" class="input_number fms_lbox_file_select_checkbox" data-id="{{ $row['id'] }}" data-src="{{ $row['real_route'] }}" data-title="{{ $row['title'].".".$row['type'] }}" data-type="{{ $row['type'] }}" data-key="{{ $row['file_key'] }}">
                            <span class="check-circle icon-check"></span>
                        </label>
                    </div>
                </td>
                <td class="tool_ctrl open_file_edit">
                    <div class="tableMaintitle">
                        <img src="{{ (!empty($row['file_type']['img']))?$row['file_type']['img']:$row['real_m_route'] }}" alt="" class="title-img rwdhide">
                        <span class="title-name bold">{{ $row['title'] }}.{{ $row['type'] }}</span>
                    </div>
                </td>

                <td class="text-center">
                    <div class="tableContent">{{ $row['type'] }}</div>
                </td>
                <td class="text-center">
                    <div class="tableContent">{{ $row['file_type']['title'] }}</div>
                </td>
                <td class="text-center">
                    <div class="tableContent">{{ $row['_this_size'] }}</div>
                </td>
                <td class="text-center">
                    <div class="tableContent">{{ $row['resolution'] }}</div>
                </td>
                <td class="text-center">
                    <div class="tableContent">{{ $row['updated_at'] }}</div>
                </td>
                <td class="text-center">
                    <div class="tableContent">-</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
