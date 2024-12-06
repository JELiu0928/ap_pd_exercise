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
                                <div class="content-wrap main-table index-table-div" data-tableid="new_cms_table" style="">
                                    <div class="content-head cms-index_table" data-can_review="1" data-edit="1" data-delete="1" data-create="1" data-model="Class_faq" data-page="1" data-pn="1" data-auth="206" data-pagetitle="常見問題分類" data-issearch="1" data-isbatch="1" data-isclone="1" data-isexport="">
                                        <h1>Access Denied 拒絕訪問</h1>
                                    </div>
                                    <div class="content-body" style="display: flex;flex-direction: column;align-items: center;height: calc(100vh - 60px);justify-content: center;">
                                        <section class="content_a">
                                            <svg style="width: 80px;fill:#8c8c8c;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H392.6c-5.4-9.4-8.6-20.3-8.6-32V352c0-2.1 .1-4.2 .3-6.3c-31-26-71-41.7-114.6-41.7H178.3zM528 240c17.7 0 32 14.3 32 32v48H496V272c0-17.7 14.3-32 32-32zm-80 32v48c-17.7 0-32 14.3-32 32V480c0 17.7 14.3 32 32 32H608c17.7 0 32-14.3 32-32V352c0-17.7-14.3-32-32-32V272c0-44.2-35.8-80-80-80s-80 35.8-80 80z"/></svg>
                                        </section>
                                        <section class="content_b" style="text-align: center;">
                                            <h4>您沒有權限預覽此頁面</h4>
                                            <p>請聯繫管理者確認是否有設定權限</p>
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
