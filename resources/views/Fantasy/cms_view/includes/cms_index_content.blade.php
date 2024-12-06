<!-- cms主要內容區 -->
<div class="mainBody page-container extract-block">
    <!-- header -->
    @include('Fantasy.includes.header')
    <!-- header -->

    <!-- 內容 CONTENT -->
    <div class="page-content-wrapper mainContent full-height">
        <div class="content full-height">
            <!-- SIDEBAR MENU-->
            <nav class="content-sidebar">
                <div class="sidebar-menu">
                    <!--分館/語系 head-bar-->
                    @include('Fantasy.cms_view.includes.list')
                    <!--分館/語系 head-bar-->
                    <div class="clearfix"></div>
                </div>
            </nav>
            <!-- SIDEBAR MENU-->

            <!-- 右邊 inner-content -->
            <div class="inner-content">
                <!-- 目前路徑 jumbotron -->
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
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{Basefunction::cms_url('/')}}">{{$nowBranchData['title']}} - {{$nowLocale['title']}}</a>
                                        </li>

                                        @if(is_object($parentMenu))
                                        <li class="breadcrumb-item"><a>{{$parentMenu['title']}}</a></li>
                                        @endif

                                        <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                                    </ol>
                                </nav>
                            </div>

                            <div class="total">
                                <p>
                                    <span class="text">Total Data</span>
                                    <span class="num">&nbsp;{{ number_format($count) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 目前路徑 jumbotron -->
                <!-- 上面區塊 -->

                <!-- 下面列表 -->
                <div class="content-scrollbox">
                    <div class="content-wrap main-table index-table-div" data-tableid="new_cms_table">
                        @include($viewRoute.'.table')
                    </div>
                    <div class="hiddenArea editContentArea cms_hiddenArea cmsDetailAjaxArea" data-id="" data-model="" data-mod="" data-review-edit="{{$is_review_edit}}" data-page="{{ $pageKey }}" data-route="{{ $viewRoute }}" data-need_review="{{$need_Review}}" data-can_review="{{$can_review}}" data-isContent="{{$isContent}}">
                        <div class="hiddenArea_frame ajaxItem cms">
                            <!--表格-->
                            <!--表格內容-->
                            <div class="detailEditor">
                                <!--Body-->
                                <div class="editorBody">
                                    <!--Header-->
                                    <div class="editorHeader">
                                        <div class="info">
                                            <div class="title">
                                                <p class="editTypeTitle"></p>
                                            </div>
                                            <h3 class="dataEditTitle"></h3>
                                            {{-- <span class="SonDataEditTitle"></span> --}}
                                        </div>
                                        <div class="control">
                                            <ul class="btnGroup">

                                            </ul>
                                        </div>
                                    </div>
                                    <!--editorContent-->
                                    <div class="editorContent editContentFormArea">
                                        <form id="batchForm">
                                            @include($viewRoute.'.batch')
                                        </form>
                                        <!--搜尋Form-->
                                        <form id="searchForm">
                                            @include($viewRoute.'.search')
                                        </form>
                                        <!--基本內容Form-->
                                        @foreach ($menuList as $menukey => $menuname)
                                        <form id={{$menukey}}></form>
                                        @endforeach
                                    </div>
                                </div>
                                <!--menu-->
                                <div class="editorNav">
                                    <div class="control">
                                        <ul class="btnGroup">
                                            <li class="check editSentBtn">
                                                <a href="javascript:;">
                                                    <span class="fa fa-check"></span>
                                                </a>
                                            </li>
                                            @if($isDelete == 1)
                                            @if($need_Review && $can_review == 0)
                                            <li class="trash cms-delete-btn leon-cms-delete" id="leon-cms-delete"><a href="javascript:void(0)"><span class="fa fa-trash"></span></a></li>
                                            @else
                                            <li class="trash cms-delete-btn"><a href="javascript:void(0)"><span class="fa fa-trash"></span></a></li>
                                            @endif
                                            @endif
                                            @if($isCreate == 1)
                                            {{-- <li class="file">
                                                        <a href="javascript:;">
                                                            <span class="fa fa-files-o"></span>
                                                        </a>
                                                    </li> --}}
                                            @endif
                                            <li class="remove">
                                                <a href="javascript:;" class="close_btn">
                                                    <span class="fa fa-remove"></span>
                                                </a>
                                            </li>
                                        </ul>
                                        <p class="sub_title">MANAGEMENT OPTIONS</p>
                                    </div>
                                    <ul class="editContentMenu navGroup" data-route="{{ $viewRoute }}">
                                        <li data-form="batchForm">
                                            <a href="javascript:void(0);">
                                                <p class="editorNavName">批次修改</p>
                                            </a>
                                        </li>
                                        <li data-form="searchForm">
                                            <a href="javascript:void(0);">
                                                <p class="editorNavName">資料搜尋</p>
                                            </a>
                                        </li>
                                        {{-- Menu-Content select --}}
                                        @foreach ($menuList as $menukey => $menuname)
                                        <li data-form={{$menukey}}>
                                            <a href="javascript:void(0);">
                                                <p class="menu_listName">{{$menuname}}</p>
                                            </a>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>


                            <!--區塊功能按鈕-->
                            <div class="hiddenArea_frame_controlBtn">
                                <ul class="btnGroup">
                                    <li class="check editSentBtn">
                                        <a href="javascript:void(0)">
                                            <span class="fa fa-check"></span>
                                            <p>Setting</p>
                                        </a>
                                    </li>
                                    @if($can_review && $isDelete == 1)
                                    <li class="trash cms-delete-btn">
                                        <a href="javascript:void(0)">
                                            <span class="fa fa-trash"></span>
                                            <p>delete</p>
                                        </a>
                                    </li>
                                    @endif
                                    <li class="remove">
                                        <a href="javascript:void(0)" class="close_btn">
                                            <span class="fa fa-remove"></span>
                                            <p>Cancel</p>
                                        </a>
                                    </li>

                                    @if($need_Review && $can_review == 0)
                                    <li style="background-color: #ee4c4c;" class="notify_admin" data-action="review">
                                        <a href="javascript:void(0)">
                                            <span class="fa fa-envelope"></span>
                                            <p>通知管理者審核</p>
                                        </a>
                                    </li>
                                    @endif
                                    @if($need_Review && $can_review == 0 && $isDelete == 1)
                                    <li style="background-color: #424242;" class="notify_admin" data-acion="remove">
                                        <a href="javascript:void(0)">
                                            <span class="fa fa-trash"></span>
                                            <p>通知管理者刪除</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 下面列表 -->
                <!-- 下面列表END -->
            </div>
            <!-- 右邊 inner-content -->
        </div>
    </div>
    <!-- 內容 CONTENT -->
</div>
<!-- cms主要內容區 -->

<!-- cms DeatilEditor -->
