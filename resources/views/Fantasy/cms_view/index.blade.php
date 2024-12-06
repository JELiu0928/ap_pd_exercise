@extends('Fantasy.template')

@section('bodySetting', 'fixed-header cms_theme uiv2')

@section('css')

@stop

    @section('css_back')

    @stop

        @section('content')

        <!-- 左邊滑動的 sidebar -->
        @include('Fantasy.includes.sidebar')
        <!-- 左邊滑動的 sidebar -->


        <!-- 中間主區塊 -->
        <div class="mainBody page-container extract-block">

            <!-- 最上面的 header bar -->
            @include('Fantasy.includes.header')
            <!-- 最上面的 header bar -->

            <div class="page-content-wrapper mainContent full-height">
                <div class="content full-height">
                    <!-- 左邊 SECONDARY SIDEBAR MENU-->
                    <nav class="content-sidebar">

                        <div class="sidebar-menu">

                            @include('Fantasy.cms_view.includes.list')

                            <div class="clearfix"></div>
                        </div>

                    </nav>
                    <!-- 左邊 SECONDARY SIDEBAR MENU -->
                    <div class="inner-content">
                        <div class="jumbotron">
                            <div class="container-fluid">
                                <div class="inner">
                                    <div class="inner-left">
                                        <div class="switch-menu">
                                            <span class="bar"></span>
                                            <span class="bar"></span>
                                            <span class="bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="scroll-wrapper content-scrollbox" style="position: relative;">
                            <div class="content-scrollbox scroll-content" style="height: 877px; margin-bottom: 0px; margin-right: 0px; max-height: none;">
                                <div class="content-wrap main-table index-table-div" data-tableid="new_cms_table">
                                    <div class="content-head cms-index_table" data-can_review="1" data-edit="1" data-delete="1" data-create="1" data-model="Class_faq" data-page="1" data-pn="1" data-auth="206" data-pagetitle="常見問題分類" data-issearch="1" data-isbatch="1" data-isclone="1" data-isexport="">
                                        <h1>品牌總覽</h1>
                                    </div>
                                    <div class="content-body">
                                        <section class="content_a">
                                            <ul class="frame">
                                                @foreach($branchMenuList['list'] as $key => $row)
                                                    <li class="inventory row_style">
                                                        <div class="title">
                                                            <p class="subtitle">{{ $row['title'] }}</p>
                                                        </div>
                                                        <div class="inner">
                                                            @foreach($row['list'] as $key2 => $row2)
                                                                <div style="padding: 15px 0px;"><a href="{{ $row2['link'] }}">{{ $row2['title'] }}</a></div>
                                                            @endforeach
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </section>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- 右邊 PAGE CONTENT -->
                </div>
            </div>
            <!-- 內容 CONTENT -->
        </div>
        <!-- 中間主區塊 -->

        @section('script')
        <script type="text/javascript" src="{{ asset('/vender/backend/js/cms/cms.js') }}"></script>
        @stop

            @section('script_back')

            @stop
                @stop
