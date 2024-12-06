@php
$formarr = [
];
@endphp

@extends('Fantasy.template')

@section('bodySetting', 'fixed-header cms_theme')

@section('css')
<link href="/vender/assets/css/cms_style.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="{{ asset('/vender/assets/css/FantasyAllcss.css') }}" />
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
          <!--語系-->
          <ul class="head-bar">
            <li class="level-1 open active">
              <a href="javascript:;" class="display-title">
                <span class="title">技術設定</span>
                <span class="icon-open-menu"></span>
              </a>
            </li>
          </ul>


          <!--列表list-->
          @include('Fantasy.its.includes.list')

          <div class="clearfix"></div>
        </div>

      </nav>
      <!-- 左邊 SECONDARY SIDEBAR MENU -->
      <div class="inner-content">

        <!-- 上面區塊 (佈告欄)-->
        <div class="jumbotron">
          <div class="container-fluid">
            {{-- 2.0NEW --}}
            {{-- 2.0NEW --}}
            <div class="inner">
              <div class="inner-left shake-vertical">
                <div class="switch-menu">
                  <span class="bar"></span>
                  <span class="bar"></span>
                  <span class="bar"></span>
                </div>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">技術設定</a></li>
                    <li class="breadcrumb-item active" aria-current="page">單元鍵值設定</li>
                  </ol>
                </nav>
              </div>
              <div class="total shake-chunk">
                <p>
                  <span class="text">Total Data</span>
                  <span class="num">&nbsp;{{ number_format($count) }}</span>
                </p>
              </div>

            </div>
            {{-- 2.0NEW END --}}
            {{-- 2.0NEW END --}}
          </div>
        </div>
        <!-- 上面區塊 -->
        <!-- 下面列表 -->

        <div class="content-scrollbox">
          <div class="content-wrap main-table index-table-div" data-tableid="new_cms_table">
            @include($viewRoute.'.table')
          </div>
        </div>
        <!-- 下面列表 -->
        <!-- 下面列表END -->
      </div>
      <!-- 右邊 PAGE CONTENT -->
    </div>
  </div>
  <!-- 內容 CONTENT -->
</div>
<!-- 中間主區塊 -->

<!-- 右邊滑動的 隱藏區塊 -->

<div class="hiddenArea editContentArea cms_hiddenArea cmsDetailAjaxArea" data-id="" data-model="" data-mod="" data-page="{{ $pageKey }}" data-route="{{ $viewRoute }}">
  <!---->
  <div class="hiddenArea_frame ajaxItem cms">
    <!--表格-->
    <div class="hiddenArea_frame_box">
      <div class="detailEditor">
        <div class="editorBody">
          <div class="editorHeader">

            <div class="info">
              <div class="title">
                <p class="editTypeTitle"></p>
              </div>
              <h3 class="dataEditTitle"></h3>
              <p class="form-name editFormName">-</p>
            </div>



          </div>

          <div class="editorContent editContentFormArea">
            <!--搜尋Form-->
            <form id="searchForm">
              {{-- <!-- @include($viewRoute.'.search') --> --}}
            </form>

            <!--基本內容Form-->
            <form id="contentForm">
            </form>

          </div>
        </div>
        <!--menu-->
        <div class="editorNav">
          <div class="control">
            <ul class="btnGroup">
              <li class="check editSentBtn">
                <a href="javascript:void(0)">
                  <span class="fa fa-check"></span>
                </a>
              </li>
              @if($isDelete == 1)
              <li class="trash cms-delete-btn">
                <a href="javascript:void(0)">
                  <span class="fa fa-trash"></span>
                </a>
              </li>
              @endif
              @if($isCreate == 1)
              {{-- <li class="file">
                              <a href="javascript:void(0)">
                                <span class="fa fa-files-o"></span>
                              </a>
                            </li> --}}
              @endif
              <li class="remove">
                <a href="javascript:void(0)" class="close_btn">
                  <span class="fa fa-remove"></span>
                </a>
              </li>
            </ul>
            <p class="sub_title">
              內容管理選項
            </p>
          </div>
          <ul class="editContentMenu navGroup" data-route="{{ $viewRoute }}">
            <li data-form="searchForm">
              <a href="javascript:;">
                <p class="editorNavName">資料搜尋</p>
              </a>
            </li>
            {{-- Menu-Content select --}}

            <li data-form="contentForm">
              <a href="javascript:;">
                <p class="menu_listName">基本內容編輯</p>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>

    <!--區塊功能按鈕-->
    <div class="hiddenArea_frame_controlBtn">
      <ul class="btnGroup">
        <li class="check editSentBtn">
          <a href="javascript:void(0)">
            <span class="fa fa-check"></span>
            <p>setting</p>
          </a>
        </li>
        @if($isDelete == 1)
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
            <p>cancel</p>
          </a>
        </li>
      </ul>
    </div>

  </div>
</div>

@include('Fantasy.cms_view.includes.partImg_lightbox')
@section('script')
<script type="text/javascript" src="/vender/backend/js/cms/cms.js"></script>
@stop
@section('script_back')
<script type="text/javascript" src="/vender/backend/js/cms/cms_unit.js"></script>
{{-- <script type="text/javascript" src="{{ asset('/vender/assets/js/fantasy_main.js') }}"></script> --}}

@stop
@stop