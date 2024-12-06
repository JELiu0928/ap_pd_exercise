@extends('Fantasy.template')
@section('bodySetting', 'fixed-header cms_theme uiv2 ')
@section('css')
    <style>
        .ag-watermark{
            display: none!important;
        }
    </style>
@stop
@section('css_back')
@stop
@section('content')
    <!-- mainNav 系統主選單 -->
    @include('Fantasy.includes.sidebar')
    <!-- mainNav 系統主選單 -->
    @include('Fantasy.cms_view.Table.cms_ag_table')

    <!-- 圖片 / 影片管理 燈箱 -->
    @include('Fantasy.cms_view.includes.partImg_lightbox')
    <!-- 圖片 / 影片管理 燈箱 -->

@section('script')
    <script type="text/javascript" src="/vender/backend/js/cms/cms.js"></script>

@stop
@section('script_back')
    {{-- 20230221 ag-grid --}}
    @if (true)
        <script src="/vender/ag-grid/ag-grid-cdn-enterprise.js"></script>
    @else
        <script src="/vender/ag-grid/ag-grid-cdn.js"></script>
    @endif
    <script defer type="module" src="/vender/backend/js/cms/cms_table.js"></script>
@stop
@stop
