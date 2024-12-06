<table class="table table-hover">
    <thead>
        <tr>
            <th style="width:20px" class="text-center">
                <button class="btn btn-link">
                    <i class="pg-unordered_list"></i>
                </button>
            </th>
            <th style="width:33%">資料夾/檔案名稱</th>
            <th style="width:10%">檔案格式</th>
            <th style="width:10%">檔案類型</th>
            <th style="width:10%">檔案容量</th>
            <th style="width:11%">檔案尺寸</th>
            <th style="width:12%">最後異動時間</th>
            <th style="width:10%">檔案擁有者</th>
        </tr>
    </thead>
    <tbody class="fms_lbox_lt_tbody">
        @foreach($folder as $key => $row)
        <tr class="tbody_tick fms_list_folder_btn {{ $folderLevel }}" data-id="{{ $row['id'] }}" style="cursor: pointer;">
            <td class="v-align-middle">
                {{-- <div class="box icon">
                    <span class="fa fa-lock"></span>
                    </div> --}}
                <div class="checkbox text-center">
                    <input type="checkbox" class="input_number fms_lbox_file_select_checkbox" data-type="folder" data-level="{{ $folderLevel }}" data-id="{{ $row['id'] }}" data-title="{{ $row['title'] }}">
                    <label for="" class="no-padding no-margin">
                        <span></span>
                    </label>
                </div>
            </td>
            <td class="v-align-middle tool_ctrl">
                <div class="box text_pic">
                    <div class="head_icon">
                        <span class="fa fa-folder"></span>
                    </div>
                    <p class="bold">{{ $row['title'] }}</p>
                    <div class="tool">
                        <span class="fa fa-exclamation-circle open_folder_detail"></span>
                        <span class="icon fa fa-pencil open_folder_edit"></span>
                    </div>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>Folder</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>資料夾</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p></p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p></p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>{{ $row['updated_at'] }}</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>{{$row['create_user']['name'] ?? ''}}</p>
                </div>
            </td>
        </tr>
        @endforeach
        @foreach($file as $key => $row)
        <tr class="tbody_tick fms_list">
            <td class="v-align-middle">
                <div class="checkbox text-center">
                    <input type="checkbox" class="input_number fms_lbox_file_select_checkbox" data-id="{{ $row['id'] }}" data-src="{{ $row['real_route'] }}" data-title="{{ $row['title'].".".$row['type'] }}" data-type="{{ $row['type'] }}" data-key="{{ $row['file_key'] }}">
                    <label for="" class="no-padding no-margin">
                        <span></span>
                    </label>
                </div>
            </td>
            <td class="v-align-middle tool_ctrl">
                <div class="box text_pic">
                    <div class="head_icon @if($row['file_type']['title']=='影像') open_img_box @endif" data-src="{{ $row['real_route'] }}">
                        <span class="fa {{ $row['file_type']['cls'] }}"></span>
                    </div>
                    <p class="bold">{{ $row['title'] }}.{{ $row['type'] }}</p>
                    <div class="tool">
                        <span class="fa fa-exclamation-circle open_fms_detail"></span>
                        <span class="fa fa-pencil open_file_edit"></span>
                    </div>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>{{ $row['type'] }}</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>{{ $row['file_type']['title'] }}</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>{{ $row['_this_size'] }}</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>{{ $row['resolution'] }}</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p>{{ $row['updated_at'] }}</p>
                </div>
            </td>
            <td class="v-align-middle">
                <div class="box text">
                    <p></p>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<input type="hidden" id="countFile" value="{{$countFile}}">
