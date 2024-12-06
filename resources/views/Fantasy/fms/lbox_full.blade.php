        <!-- 內容 CONTENT -->
        <div class="content">
            <!-- 左邊 SECONDARY SIDEBAR MENU-->
            <nav class="content-sidebar">
                {{-- @include('Fantasy.fms.sidebar') --}}
                @include('Fantasy.fms.sidebar_rev')
            </nav>
            <div class="quill_sidebarWall close"></div>
            <!-- 左邊 SECONDARY SIDEBAR MENU -->
            <!-- 右邊 PAGE CONTENT -->
            <div class="inner-content">
                <!-- 上面區塊 (佈告欄)-->
                <div class="jumbotron">
                    <div class="container-fluid">
                        <div class="inner">
                            <div class="inner-left">
                                <div class="switch-menu">
                                    <span class="bar"></span>
                                    <span class="bar"></span>
                                    <span class="bar"></span>
                                </div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb files-breadcrumb">
                                        @include('Fantasy.fms.breadcrumb',['active'=>1])
                                        {{-- <li class="breadcrumb-item"><a href="#">品牌總覽</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">第一層</li> --}}
                                    </ol>
                                </nav>
                            </div>
                            <div class="total">
                                <p>
                                    <span class="text">Total Data</span>
                                    <span class="num">&nbsp;123</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 上面區塊 (佈告欄) -->
                <!-- search_bar -->
                {{-- <div class="search_area">
                    <div class="frame">
                        <div class="title">
                            <span class="fa fa-search"></span>
                            <p>SEARCH FILTER</p>
                        </div>
                        <div class="bar"></div>
                        <div class="close_search_btn">
                            <span class="fa fa-remove"></span>
                        </div>
                    </div>
                </div> --}}
                <!-- search_bar -->
                <!-- 下面列表 -->
                <!-- no_left 是針對這個table沒有 fixedColumns:left 的時候的checkbox數字順序計算 -->
                <div class="container-fluid bg-white content-scrollbox">

                    <div class="table-box content-wrap card card-transparent no_left" data-tableID="fms_table" style="position: relative;">
                        <div class="content-head cms-index_table">
                            <h1 class="select_folder_name">根目錄</h1>
                            <div class="content-nav">
                                <div class="navleft">
                                    <div class="btn-item leon-trash-show" style="display: none;">
                                        <a href="javascript:;" class="fms_recovery_data" data-model="All_colunm">
                                            <span class="fms-upload"></span>
                                            <span class="text">復原資料</span>
                                        </a>
                                    </div>
                                    <div class="btn-item leon-trash-hide">
                                        <a href="javascript:;" class="fms_bulider_upload" data-model="All_colunm">
                                            <span class="fms-upload"></span>
                                            <span class="text">新增檔案</span>
                                        </a>
                                    </div>
                                    <div class="btn-item leon-trash-hide">
                                        <a href="javascript:;" class="fms_bulider_new" id="leon-cms-delete-list" data-model="All_colunm">
                                            <span class="fms-folder-add"></span>
                                            <span class="text">新增資料夾</span>
                                        </a>
                                    </div>
                                    <div class="btn-item ">
                                        <a href="javascript:;" class="LeonMoveFiles delete" id="leon-cms-delete-list" data-model="All_colunm">
                                            <span class="fms-delete"></span>
                                            <span class="text">刪除檔案</span>
                                        </a>
                                    </div>
                                    <div class="btn-item">
                                        <a href="javascript:;" class="localeToDownloadFiles" id="leon-cms-delete-list" data-model="All_colunm">
                                            <span class="fms-download"></span>
                                            <span class="text">下載檔案</span>
                                        </a>
                                    </div>
                                    @if(!isset($cms_open) || !$cms_open)
                                    <div class="btn-item leon-trash-hide">
                                        <a href="javascript:;" class="LeonMoveFiles" id="leon-cms-delete-list" data-model="All_colunm">
                                            <span class="fms-move"></span>
                                            <span class="text">移動檔案</span>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                <div class="navright leon-trash-hide">
                                    <a href="javascript:void(0)" class="btn-item searchbar" data-quick="textInput">
                                        <span class="icon-search LeonSearchBtn"></span>
                                        <input type="text" class="search-data LeonSearchInput">
                                        <span class="text LeonSearchBtn">SEARCH</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="content-body card-block table_mode lp_mode open">
                            <!--view MODE:List + Pic-->
                            <div class="datatable">
                                <table id="LeonSortTable" class="tables">
                                    <thead>
                                        <tr>
                                            <th class="w_Check w_Check_all">
                                                <div class="fake-thead">
                                                    <div class="fake-th first">
                                                        <label class="select-item">
                                                            <span class="check-circle icon-check Leon-fms-check-all"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </th>
                                            {{-- <th class=" " style="width: 100px;">
                                                <div class="fake-th ">
                                                    <span data-column="w_title"></span>
                                                </div>
                                            </th> --}}
                                            <th class=" ">
                                                <div class="fake-th ">
                                                    <span class="sort theadSortBtn" data-column="1" data-sort="0">資料夾/檔案名稱</span>
                                                </div>
                                            </th>
                                            <th class=" " style="width: 120px;">
                                                <div class="fake-th" style="width: 120px;">
                                                    <span class="sort theadSortBtn" data-column="2" data-sort="0">檔案格式</span>
                                                </div>
                                            </th>
                                            <th class=" " style="width: 120px;">
                                                <div class="fake-th" style="width: 120px;">
                                                    <span class="" data-column="3" data-sort="0">檔案類型</span>
                                                </div>
                                            </th>
                                            <th class=" " style="width: 120px;">
                                                <div class="fake-th" style="width: 120px;">
                                                    <span class="sort theadSortBtn" data-column="4" data-sort="0">檔案容量</span>
                                                </div>
                                            </th>
                                            <th class=" " style="width: 120px;">
                                                <div class="fake-th" style="width: 120px;">
                                                    <span class="sort theadSortBtn" data-column="5" data-sort="0">檔案尺寸</span>
                                                </div>
                                            </th>
                                            <th class=" " style="width: 120px;">
                                                <div class="fake-th" style="width: 120px;">
                                                    <span class="sort theadSortBtn" data-column="6" data-sort="0">最後異動時間</span>
                                                </div>
                                            </th>
                                            <th class=" " style="width: 120px;">
                                                <div class="fake-th" style="width: 120px;">
                                                    <span class="" data-column="7" data-sort="0">擁有者</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="multi_shot Leon_fms_table">
                                        <tr class="tbody_tick Leon_folder_back" style="cursor: pointer;display: none;" data-folder-id="0">
                                            <td class="text-center w_Check">
                                                <div class="tableContent">

                                                </div>
                                            </td>
                                            {{-- <td class="text-center">
                                                <div class="tableContent"></div>
                                            </td> --}}
                                            <td class="tool_ctrl fms_folder_on_list fms_folder_back" data-id="0" data-parent_id="0">
                                                <div class="tableMaintitle">
                                                    <div class="title-img rwdhide">
                                                        <div class="fms-back" style="font-size: 17px;color: #735ebc"></div>
                                                    </div>
                                                    <span class="title-name bold">BACK 上一層資料夾</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">-</div>
                                            </td>
                                        </tr>
                                        {{-- @dd($folder) --}}
                                        @foreach($folderAll as $key => $row)
                                        <tr class="tbody_tick fms_folder fms_folder_{{$row['parent_id']}} {{ $row['use_auth'] }} @if($row['is_delete']) is_delete @endif" style="cursor: pointer;display: none;" data-folder-id="{{$row['parent_id']}}">
                                            @if($row['use_auth'] == 'can_use')
                                            <td class="text-center w_Check">
                                                <div class="tableContent">
                                                    <label class="select-item">
                                                        <input type="checkbox" class="input_number fms_lbox_file_select_checkbox" data-type="folder" data-id="{{ $row['id'] }}" data-title="{{ $row['title'] }}">
                                                        <span class="check-circle icon-check"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            @else
                                            <td class="text-center w_Check"></td>
                                            @endif
                                            <td class="tool_ctrl">
                                                <div class="tableMaintitle fms_folder_on_list @if($row['is_delete']) is_delete @endif" data-id="{{$row['id']}}" data-parent-id="{{$row['parent_id']}}">
                                                    <div class="title-img rwdhide">
                                                        <img src="/vender/assets/img/folder.png" alt="">
                                                    </div>
                                                    <div class="title-name bold">{{ $row['title'] }}</div>
                                                    <div class="fms_bulider_new edit file-edit" data-id="{{$row['id']}}">
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
                                                <div class="tableContent">{{ $row['updated_at'] }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">{{$row['create_user']['name'] ?? ''}}</div>
                                            </td>
                                        </tr>
                                        @if(!empty($row['son_folder_withSession']))
                                        @include('Fantasy.fms.son_folder',['type'=>'fms_list','for_son_folder'=>$row['son_folder_withSession']])
                                        @endif
                                        @endforeach
                                        {{-- @dd($file) --}}
                                        @foreach($file as $key=> $row)
                                        <tr class="tbody_tick fms_list fms_list_{{$row['folder_id']}} can_use @if($row['is_delete']) is_delete @endif" style="cursor: pointer;display: none;" data-folder-id="{{$row['folder_id']}}">
                                            <td class="text-center w_Check">
                                                <div class="tableContent">
                                                    <label class="select-item">
                                                        <input type="checkbox" class="input_number fms_lbox_file_select_checkbox" data-id="{{ $row['id'] }}" data-file-key="{{ $row['file_key']}}" data-src="{{ $row['real_route'] }}" data-title="{{ $row['title'].".".$row['type'] }}" data-type="{{ $row['type'] }}" data-key="{{ $row['file_key'] }}">
                                                        <span class="check-circle icon-check"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="tool_ctrl @if(!isset($cms_open)) open_file_edit @endif" @if(isset($cms_open)) onclick="Leon_open_file_edit(this);" @endif>
                                                <div class="tableMaintitle">
                                                    @php
                                                    $ext = strtolower(pathinfo($row['real_m_route'],PATHINFO_EXTENSION));
                                                    $filepath = $row['real_m_route'];
                                                    $NotImg = false;

                                                    if(in_array($ext,['pdf','doc','docx','ppt','pptx','xls','xlsx','txt','zip','rar','video','mpg','mpeg','avi','mp4','webm'])){
                                                    $filepath = '/vender/assets/img/icon/'.$ext.'.png';
                                                    $NotImg = true;
                                                    }
                                                    @endphp
                                                    <div class="title-img rwdhide">
                                                        <img @if(!$NotImg) class="open_img_box" @endif src="{{ BaseFunction::imgSrc($filepath) }}" data-src="{{ BaseFunction::imgSrc($filepath) }}" alt="" loading="lazy">
                                                    </div>
                                                    <span class="title-name bold">{{ $row['title'] }}.{{ $row['type'] }}</span>
                                                    <div class="cms_open_file_edit file-edit" data-id="{{$row['id']}}">
                                                        <span class="fa fa-pencil"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">{{ $row['type'] }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">檔案</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">{{ formatBytes($row['size']) }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">
                                                    {{ (!empty($row['img_w'])) ? $row['img_w'] .' x '.$row['img_h'] : '' }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">{{ $row['updated_at'] }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="tableContent">{{ isset($row['create_user']) ? $row['create_user']['name'] : 'N/A' }} </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <div class="card-block table_mode gd_mode fms_gd_datatb">
                            <!--view MODE:Grid-->
                            <!--有分lock跟unlock-->
                            <article class="grid_mode {{ $one_class }}">
                        <ul class="frame fms_lbox_gd_tbody">
                        </ul>
                        </article>
                    </div> --}}
                </div>
            </div>
            <!-- 下面列表 -->
        </div>
        <!-- 右邊 PAGE CONTENT -->
        <!-- 內容 CONTENT -->
