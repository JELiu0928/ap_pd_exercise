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
    <ul class="body-list">
        @foreach($folder as $val)
        <li class="{{$folder_id==$val['id'] ? 'open2' : ''}} fms_unlimited_list">
            <a href="javascript:void(0);" class="" data-id="{{$val['id']}}">
                <span class="iconFolder _close fa fa-folder"></span>
                <span class="iconFolder _open fa fa-folder-open"></span>
                <span class="title">{{ $val['title'] }}</span>
                <span class="arrow"></span>
            </a>
            @if(!empty($val['son_folder']))
            @include('Fantasy.fms.son_folder',['type'=>'fms_unlimited_list','for_son_folder'=>$val['son_folder']])
            @endif
        </li>
        @endforeach
    </ul>
    <div class="clearfix"></div>
</div>