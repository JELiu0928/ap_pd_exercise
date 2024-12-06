<div class="sidebar-menu">
    <!--語系-->
    <ul class="head-bar">
        <li class="level-1">
            <!---->
            <a href="javascript:void(0);" class="display-title">
                <span class="title">檔案管理</span>
                {{-- <span class="arrow"></span> --}}
            </a>
            <!--==============================-->
        </li>
    </ul>
    <!--列表list-->
    <div class="filetree body-list content-scrollbox">
        {{-- 資料夾樹 --}}
        @include('Fantasy.fms.son_folder_rev',['for_son_folder'=>$folderAll,'firstTime'=>1])

    </div>

    <div class="clearfix"></div>
</div>