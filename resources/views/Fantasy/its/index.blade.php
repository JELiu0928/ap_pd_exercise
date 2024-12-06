@extends('Fantasy.template')

@section('bodySetting', 'fixed-header')

@section('css')
<link href="/vender/assets/css/cms_style.css" rel="stylesheet" type="text/css">
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
            {{-- <span class="line"></span> --}}
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
      <div class="inner-content" style="background-image:url(/vendor/assets/img/demo/chris.gif); background-size:cover;">
      </div>
    </div>
  </div>
</div>

@section('script')

@stop

@section('script_back')
<script type="text/javascript" src="/vender/backend/js/cms/cms_unit.js"></script>
@stop
@stop