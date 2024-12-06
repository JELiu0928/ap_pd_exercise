@extends('Fantasy.template')
@section('bodySetting', 'fixed-header fms_theme uiv2')
@section('css')
<link href="/vender/assets/css/fms_style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/vender/assets/font/fmsIcon/style.css">
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
    <!-- 內容 CONTENT -->
    <div class="page-content-wrapper mainContent">
        @include('Fantasy.fms.lbox_full')
    </div>
    <!-- 內容 CONTENT -->
</div>
<!-- 中間主區塊 -->
<!-- 右邊滑動的 隱藏區塊 -->
<article class="hiddenArea inforArea">
</article>
<!-- 燈箱圖片 -->
<!-- 燈箱圖片 -->
@section('script')
{{-- <script type="text/javascript" src="/vender/backend/js/fms/fms.js"></script> --}}
@stop
@section('script_back')
<script>
    //$(".page-content-wrapper").load($('.base-url').val() + "/Ajax/fms-lbox-full/0/0/0?table=true", function () {
    // var _area = $('input.fileAreaSupportSet');
    // var _area_zero = _area.data('zero');
    // var _area_first = _area.data('first');
    // var _area_second = _area.data('second');
    // var _area_third = _area.data('third');
    // var _area_branch = _area.data('branch');
    // //需啟動的JS
    // change_fms_file_lp_table(_area_zero, _area_first, _area_second, _area_third, 1);
    //fms_lightbox();
    //});
    set_fms_basic();
</script>

{{-- <script type="text/javascript" src="/vender/backend/js/fms/file_upload.js"></script> --}}
@stop
@stop