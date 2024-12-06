@extends('Fantasy.template')

@section('bodySetting', 'fixed-header cms_theme uiv2')

@section('css')
<link href="{{ asset('/vender/assets/css/cms_style.css') }}" rel="stylesheet" type="text/css">
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
                                        <h1>待審核資料列表</h1>
                                    </div>
                                    <div class="content-body">

                                        <div class="datatable">
                                            <table class="tables">
                                                <thead>
                                                    <tr>
                                                        <th class="w_Check" style="width:0;">
                                                            <div class="fake-thead" style="pointer-events: none;">
                                                                <div class="fake-th first" style="display:none;">
                                                                    <label class="select-item">
                                                                        <input type="checkbox">
                                                                        <span class="check-circle icon-check"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th class="w150">
                                                            <div class="fake-th">
                                                                <span>分館</span>
                                                            </div>
                                                        </th>
                                                        <th style="width:200px;">
                                                            <div class="fake-th">
                                                                <span>單元</span>
                                                            </div>
                                                        </th>
                                                        <th style="width:100px;">
                                                            <div class="fake-th">
                                                                <span>語系</span>
                                                            </div>
                                                        </th>
                                                        <th style="width:100px;">
                                                            <div class="fake-th">
                                                                <span>申請類型</span>
                                                            </div>
                                                        </th>
                                                        <th style="">
                                                            <div class="fake-th">
                                                                <span>資料標題</span>
                                                            </div>
                                                        </th>
                                                        <th class="w_Update">
                                                            <div class="fake-th">
                                                                <span>申請時間</span>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($ReviewNotify as $val)
                                                        <tr>
                                                            <td class="text-center w_Check" style="width:0;">
                                                                <div class="tableContent" style="display:none;">
                                                                    <label class="select-item">
                                                                        <input type="checkbox" data-id="5">
                                                                        <span class="check-circle icon-check"></span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td class="w150">
                                                                <a class="tableContent" href="{{ $val['data_url'] }}" target="_blank">{{ $val['branch_title'] }}</a>
                                                            </td>
                                                            <td style="width:200px;">
                                                                <a class="tableContent" href="{{ $val['data_url'] }}" target="_blank">{{ $val['unit_title'] }}</a>
                                                            </td>
                                                            <td style="width:100px;">
                                                                <a class="tableContent" href="{{ $val['data_url'] }}" target="_blank">{{ $val['locale'] }}</a>
                                                            </td>
                                                            <td style="width:100px;">
                                                                <a class="tableContent" href="{{ $val['data_url'] }}" target="_blank">{{ $val['action'] }}</a>
                                                            </td>
                                                            <td>
                                                                <a class="tableContent" href="{{ $val['data_url'] }}" target="_blank">{{ $val['data_title'] }}</a>
                                                            </td>
                                                            <td class="w_Update">
                                                                <a class="tableContent" href="{{ $val['data_url'] }}" target="_blank">{{ $val['created_at'] }}</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
