@extends('Fantasy.template')
@section('bodySetting', 'uiv2 ams_theme')
@section('css')
<link href="/vender/assets/css/ams_style.css" rel="stylesheet" type="text/css">
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
                                            <a href="{{url('Fantasy/Ams')}}">AMS Overview 資訊總覽</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Website Redirect 管理</li>
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
                        <div class="content-head cms-index_table" data-edit="1" data-delete="1" data-create="1" data-model="" data-page="1" data-pn="1" data-auth="0" data-pagetitle="Website Redirect 管理">
                            <h1>Website Redirect 管理</h1>
                            <div class="content-nav">
                                <div class="navleft">
                                    <div class="btn-item">
                                        <a href="javascript:void(0)" class="create_ams_wrapper" data-type="autoredirect" data-id="0">
                                            <span class="icon-add"></span>
                                            <span class="text">ADD DATA 新增</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-body">
                            <div class="datatable">
                                <table class="tables">
                                    <thead style="border-bottom: 1px solid #000;">
                                        <tr>
                                            <th class="w_TableMaintitle ">
                                                <div class="fake-th ">
                                                    <span class="" data-column="account">舊網址</span>
                                                </div>
                                            </th>
                                            <th class="w_TableMaintitle ">
                                                <div class="fake-th ">
                                                    <span class="" data-column="account">轉向網址</span>
                                                </div>
                                            </th>
                                            <th class="text-center w_Preview">
                                                <div class="fake-th ">
                                                    <span class="" data-column="is_active">類型</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="ams_tbody" data-type="autoredirect">
                                        @foreach($data as $key => $row)
                                        <tr>
                                            <td class="w_TableMaintitle edit_ams_wrapper" data-type="autoredirect" data-id="{{ $row['id'] }}">
                                                <div class="tableMaintitle open_builder">
                                                    <span class="title-name open_builder">{{ $row['old_url'] }}</span>
                                                </div>
                                            </td>
                                            <td class="w_TableMaintitle edit_ams_wrapper" data-type="autoredirect" data-id="{{ $row['id'] }}">
                                                <div class="tableMaintitle open_builder">
                                                    <span class="title-name open_builder">{{ $row['new_url'] }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center w_Preview edit_ams_wrapper" data-type="autoredirect" data-id="{{ $row['id'] }}">
                                                <div class="tableContent">{{ ($row['active301'] == 1) ? '301' : '302' }}</div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="pageCountContent">
                                <div class="page-count">Showing <span>1</span> to <span>10</span> of <span>1</span> Data</div>
                                <div class="page-select">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li class="page-item pn_btn active" data-type="page" data-page="1">
                                                <a class="page-link" href="javascript:void(0)">1</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div> --}}
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
        <form class="ajaxContainer" action="" id="ams_edit_form">
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