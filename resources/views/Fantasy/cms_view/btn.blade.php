<div class="navleft">
    {{-- 若需要開啟search 在各自的xxxApi內新增 $role['search'] = true; --}}
    @if(isset($roles['search']) && $roles['search'])
        <div class="btn-item">
            <a class="searchBtn" href="javascript:void(0)">
                <span class="icon-search"></span>
                <span class="text">Filter 資料篩選</span>
            </a>
        </div>
    @endif
    @if($roles['create'])
        <div class="btn-item {{$hideCreate}}">
            <a class="createBtn" href="javascript:void(0)" data-max="{{$roles['maxAddCount'] ?? ''}}">
                <span class="icon-add"></span>
                <span class="text">ADD DATA 新增</span>
            </a>
        </div>
    @endif
    @if($roles['delete'])
        <div class="btn-item">
            <a class="remove-data-btn" id="leon-cms-delete-list" href="javascript:void(0)">
                <span class="icon-delete"></span>
                <span class="text">DELETE 刪除</span>
            </a>
        </div>
    @endif
    @if($roles['edit'] && $roles['canBatch'])
        <div class="btn-item dropdown">
            <a class="" data-toggle="dropdown" href="javascript:void(0)" aria-haspopup="true" aria-expanded="false">
                <span class="icon-batch"></span>
                <span class="text">BATCH 批次修改</span>
            </a>
            <div class="dropdown-menu dropdown-menu-left profile-dropdown" role="menu">
                <a class="dropdown-item batchBtn" data-action="1" href="javascript:void(0)"><i class="pg-outdent"></i>
                    選取資料</a>
                {{-- <a class="dropdown-item batchBtn" data-action="2" href="javascript:void(0)"><i class="pg-outdent"></i>
                    當前列表資料</a> --}}
                <a class="clearfix bg-master-lighter dropdown-item" href="javascript:void(0)">
                    <span class="pull-left">關閉選單</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                </a>
            </div>
        </div>
    @endif
    @if($roles['canExport'] || $roles['create'])
        <div class="btn-item dropdown btn-role">
            <a class="" data-toggle="dropdown" href="javascript:void(0)" aria-haspopup="true" aria-expanded="false">
                <span class="icon-option"></span>
                <span class="text">OPTION 選項</span>
            </a>
            <div class="dropdown-menu dropdown-menu-left profile-dropdown" role="menu">
                @if($roles['canExport'])
                    <a class="dropdown-item ExportBtnCheck" href="javascript:void(0)" title="下載勾選項目">
                        <i class="pg-outdent"></i> 匯出Excel : 選取資料</a>
                    <a class="dropdown-item ExportBtnSrh" data-href="javascript:;" href="javascript:void(0)" title="目前篩選資料">
                        <i class="pg-outdent"></i>匯出Excel : 當前列表資料</a>
                @endif
                @if($roles['create'])
                    <a class="dropdown-item cloneBtn {{$hideCreate}}" href="javascript:void(0)"><i class="pg-refresh_new"></i>
                        複製資料</a>
                @endif
                <a class="clearfix bg-master-lighter dropdown-item" href="javascript:void(0)">
                    <span class="pull-left">關閉選單</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                </a>
            </div>
        </div>
    @endif
</div>
<div class="navright">
    <div class="btn-item">
        <a class="saveSort" href="javascript:void(0)">
            <span class="fa fa-floppy-o"></span>
            <span class="text">儲存自訂列表</span>
        </a>
    </div>
    <div class="btn-item">
        <a class="sortCustom" href="javascript:void(0)">
            <span class="fa fa-refresh"></span>
            <span class="text">重載自訂列表</span>
        </a>
    </div>
    <div class="btn-item">
        <a class="sortDefault" href="javascript:void(0)">
            <span class="fa fa-refresh"></span>
            <span class="text">恢復預設列表</span>
        </a>
    </div>
</div>
