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
                                        <li class="breadcrumb-item active" aria-current="page">Cover Page Review 權限管理
                                        </li>
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
                <!-- 上面區塊 -->
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
                <div class="container-fluid bg-white" style="width:100%;">
                    <div class="table-box card card-transparent main-table no_left" data-tableID="ams_table"
                        style="position: relative;">
                        <div class="card-header">
                            <div class="subtitle">
                                <!--按鈕群-->
                                <ul class="btn-group">
                                    <li class="open_builder" style="background-color: #3a9eea;">
                                        <a href="javascript:void(0)" class="create_ams_wrapper" data-type="crs-overview"
                                            data-id="0">
                                            <span class="fa fa-plus"></span>
                                        </a>
                                    </li>
                                    <li style="background-color: #464646; display:none;">
                                        <a href="javascript:void(0)">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </li>
                                    <li class="open_builder" style="background-color: #000000; display:none;">
                                        <a href="javascript:void(0)">
                                            <span class="fa fa-search"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block">
                            <!--view MODE:List + Pic-->
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:20px" class="text-center">
                                            <button class="btn btn-link">
                                                <i class="pg-unordered_list"></i>
                                            </button>
                                        </th>
                                        <th style="width:35%">帳號名稱</th>
                                        <th style="width:35%">分館-語系</th>
                                        <th style="width:9%">狀態</th>
                                        <th style="width:20%">最後異動日期</th>
                                    </tr>
                                </thead>
                                <tbody class="ams_tbody" data-type="crs-overview">
                                    @foreach($data as $key => $row)
                                    <tr class="tbody_tick">
                                        <td class="v-align-middle">
                                            <div class="checkbox text-center">
                                                <input type="checkbox" id="" class="input_number">
                                                <label for="" class="no-padding no-margin">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="v-align-middle tool_ctrl edit_ams_wrapper" data-type="crs-overview"
                                            data-id="{{ $row['id'] }}">
                                            <div class="box text_pic">
                                                <div class="head_img open_builder">
                                                    @if(isset($fileInformationArray[ $row['users_data']['photo_image']
                                                    ]) AND !empty($fileInformationArray[
                                                    $row['users_data']['photo_image'] ]))
                                                    <img src="{{ $fileInformationArray[ $row['users_data']['photo_image'] ]['real_route'] }}"
                                                        alt="">
                                                    @endif
                                                </div>
                                                <p class="bold open_builder">{{ $row['users_data']['name'] }}</p>
                                                @if(!empty($row['users_data']['mail']))
                                                <div class="tool">
                                                    <a href="mailto:{{$row['users_data']['mail']}}"><span
                                                            class="fa fa-envelope open_builder"></span></a>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="v-align-middle edit_ams_wrapper" data-type="crs-overview"
                                            data-id="{{ $row['id'] }}">
                                            <div class="box text">
                                                @if(!empty($row['branch_id']))
                                                @foreach($branch_unit_options as $key2 => $row2)
                                                @if($row2['key'] == $row['branch_id'])
                                                <p>{{$row2['title']}}</p>
                                                @endif
                                                @endforeach
                                                @else
                                                <p>-</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="v-align-middle">
                                            <div class="box multi">
                                                <ul>
                                                    <li class="{{ ($row['is_active'] == 1) ? 'ch' : '' }} rabioAmsBtn" data-id="{{$row['id']}}"
                                                        data-model="CmsRole" data-column="is_active">
                                                        <p>P</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="v-align-middle">
                                            <div class="box text">
                                                <p>{{ $row['updated_at'] }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- 下面列表 -->
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