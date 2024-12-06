@foreach($folder as $key => $row)
    <li class="list fms_lbox_gd_file_select_checkbox fms_list_folder_btn {{ $folderLevel }}" data-id="{{ $row['id'] }}" style="cursor: pointer;">
        <div class="grid_mode_box">
            <div class="content_box">
                <div class="tag">FOLDER</div>
                <div class="img">
                    <img src="/vender/assets/img/folder.png" alt="">
                    <p class="size"></p>
                </div>
                <div class="tool">
                    <span class="icon fa fa-pencil open_folder_edit"></span>
                    <span class="icon info fa fa-info-circle open_folder_detail"></span>
                    {{-- <span class="icon pg-download"></span>
                    <span class="icon fa fa-trash"></span> --}}
                </div>
            </div>
            <div class="title_box">
                <p>{{$row['title']}}</p>
                <div class="option">
                    {{-- <span class="icon_lock fa fa-lock"></span> --}}
                    <span class="icon_unlock fa fa-check" data-type="folder" data-level="{{ $folderLevel }}" data-id="{{ $row['id'] }}" data-title="{{ $row['title'] }}"></span>
                </div>
            </div>
        </div>
    </li>
@endforeach
@foreach($file as $key => $row)
    <li class="list fms_lbox_gd_file_select_checkbox fms_list">
        <input style="display:none;" type="checkbox" class="input_number" data-id="{{ $row['id'] }}" data-src="{{ $row['real_route'] }}" data-title="{{ $row['title'] }}" data-type="{{ $row['type'] }}">
        <div class="grid_mode_box">
            <div class="content_box">
                <div class="tag">{{ $row['type'] }}</div>
                <div class="img">
                    <img src="{{ (!empty($row['file_type']['img']))?$row['file_type']['img']:$row['real_m_route'] }} " @if($row['file_type']['title']=='影像') class="open_img_box"@endif alt="" data-src="{{ $row['real_route'] }}">
                    <p class="size">{{$row['resolution']}} , {{ $row['_this_size'] }}</p>
                </div>
                <div class="tool">
                    <span class="icon info fa fa-info-circle open_fms_detail"></span>
                    <span class="icon pg-download file_fantasy_download" data-src="{{ $row['real_route'] }}" data-title="{{ $row['title'].".".$row['type'] }}"></span>
                    <span class="icon fa fa-pencil open_file_edit"></span>
                    <span class="icon fa fa-trash localeToDeleteFiles" data-id="{{ $row['id'] }}" data-src="{{ $row['real_route'] }}" data-title="{{ $row['title'] }}"></span>
                </div>
            </div>
            <div class="title_box">
                <p>{{$row['title']}}.{{ $row['type'] }}</p>
                <div class="option">
                    {{-- <span class="icon_lock fa fa-lock"></span> --}}
                    <span class="icon_unlock fa fa-check" data-type="{{ $row['type'] }}"></span>
                </div>
            </div>
        </div>
    </li>
@endforeach
<input type="hidden" id="countFile" value="{{$countFile}}">
