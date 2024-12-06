@extends('Fantasy.template')
@section('bodySetting', 'uiv2 ams_theme')
@section('css')
    <link type="text/css" href="/vender/assets/css/ams_style.css" rel="stylesheet">
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
                        @include('Fantasy.ams.includes.sidebar')
                    </div>
                </nav>
                <!-- 左邊 SECONDARY SIDEBAR MENU -->
                <div class="inner-content" style="">
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
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{ url('Fantasy/Ams') }}">AMS Overview 資訊總覽</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Log 紀錄</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="total">
                                    <p>
                                        <span class="text">Total Data</span>
                                        <span class="num">{{ count($data) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-scrollbox" style="position: relative;">
                        <div class="content-wrap main-table index-table-div" data-tableid="new_cms_table">
                            <div class="content-head cms-index_table" data-edit="1" data-delete="1" data-create="1"
                                data-model="" data-page="1" data-pn="1" data-auth="0" data-pagetitle="Log 紀錄">
                                <h1>{{ $ShowTime }} - Log 紀錄</h1>
                                <div class="content-nav">
                                    <div class="navleft">
                                        @foreach ($M_list as $val)
                                            <a href="/Fantasy/Ams/log?date={{ $val }}"
                                                style="margin-right: 15px;">{{ $val }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="content-body">
                                <div class="datatable">
                                    <table class="tables">
                                        <thead>
                                            <tr>
                                                <th class="w_Check">
                                                    <div class="fake-thead">
                                                        <div class="fake-th first">

                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="w_TableMaintitle ">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="account">時間</span>
                                                    </div>
                                                </th>
                                                <th class="w_TableMaintitle ">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="account">使用者</span>
                                                    </div>
                                                </th>
                                                <th class="w_TableMaintitle ">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="account">單元</span>
                                                    </div>
                                                </th>
                                                <th class="w_TableMaintitle ">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="account">動作</span>
                                                    </div>
                                                </th>
                                                <th class="w_TableMaintitle ">
                                                    <div class="fake-th ">
                                                        <span class="" data-column="account">IP位址</span>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="ams_tbody" data-type="log">
                                            @foreach ($data as $key => $row)
                                                <tr>
                                                    <td class="text-center w_Check">
                                                        <div class="tableContent">

                                                        </div>
                                                    </td>
                                                    <td class="w_TableMaintitle edit_ams_wrapper" data-type="log"
                                                        data-id="{{ $row['id'] }}" data-ym="{{ $ShowTime }}">
                                                        <div class="tableMaintitle open_builder">
                                                            <span
                                                                class="title-name open_builder">{{ $row['create_time'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="w_TableMaintitle edit_ams_wrapper" data-type="log"
                                                        data-id="{{ $row['id'] }}" data-ym="{{ $ShowTime }}">
                                                        <div class="tableMaintitle open_builder">
                                                            <span
                                                                class="title-name open_builder">{{ $row['user_name'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="w_TableMaintitle edit_ams_wrapper" data-type="log"
                                                        data-id="{{ $row['id'] }}" data-ym="{{ $ShowTime }}">
                                                        <div class="tableMaintitle open_builder">
                                                            @php
                                                                if ($row['log_type'] == 'login') {
                                                                    $tableName = '後台登入';
                                                                } else {
                                                                    $tableName = $tables[$row['table_name']]->comment ?? $row['table_name'];
                                                                }
                                                                $tableName = $tableName;
                                                            @endphp
                                                            <span
                                                                class="title-name open_builder">{{ $tableName }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="w_TableMaintitle edit_ams_wrapper" data-type="log"
                                                        data-id="{{ $row['id'] }}" data-ym="{{ $ShowTime }}">
                                                        <div class="tableMaintitle open_builder">
                                                            <span
                                                                class="title-name open_builder">{{ $row['log_type'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="w_TableMaintitle edit_ams_wrapper" data-type="log"
                                                        data-id="{{ $row['id'] }}" data-ym="{{ $ShowTime }}">
                                                        <div class="tableMaintitle open_builder">
                                                            <span
                                                                class="title-name open_builder">{{ $row['ip'] }}</span>
                                                        </div>
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
        </div>
    </div>
    <article class="hiddenArea ams_hiddenArea amsDetailAjaxArea ">
        <div class="hiddenArea_frame ajaxItem ams">
            <!--AMS 編輯管理權限-->
            <form class="ajaxContainer" id="ams_edit_form" action="">
            </form>
        </div>
    </article>
@section('script')
@stop
@section('script_back')
    <script type="text/javascript" src="/vender/backend/js/ams/ams.js"></script>
    <script type="text/javascript" src="/vender/backend/js/cms/cms_unit.js"></script>
@stop
@stop
