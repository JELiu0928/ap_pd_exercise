<!--語系-->
@php
    $index = 0;
@endphp
<ul class="head-bar">
    <li class="level-1">
        <!---->
        <a href="javascript:;" class="display-title" style="cursor: auto;">
            <span class="title">AMS Overview 資訊總覽</span>
        </a>
        <!---->
    </li>
</ul>
<!--列表list-->
<ul class="body-list ams-list-doyouwanttobeagoodman">
    @if ($amsRoleArray['is_fantasy'] == '1')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/fantasy-account') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">Fantasy Account 帳號管理</span>
            </a>
        </li>
    @endif
    @if ($amsRoleArray['is_ams'] == '1')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/ams-manager') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">AMS 權限管理</span>
            </a>
        </li>
    @endif

    {{-- <li class="level-1 level_list" style="display:none;">
    <a href="javascript:;" class="content">
      <span class="icon">01.</span>
      <span class="title">CMS 權限管理</span>
      <span class="arrow"></span>
    </a>
    <ul class="sub-menu">
      <li class="level-2 level_list">
        <a href="javascript:;">
          <span class="icon">01.</span>
          <span class="title">Cover Page 權限管理</span>
        </a>
      </li>
      <li class="level-2 level_list">
        <a href="javascript:;">
          <span class="icon">01.</span>
          <span class="title">Template 權限管理</span>
        </a>
      </li>
    </ul>
    </li> --}}

    {{-- 只有Leon帳號有權限開分館語系 ?? basic_ams_role => is_cover_page --}}
    @if ($amsRoleArray['is_cover_page'] == '1')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/template-manager') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">CMS Template 分館語系設定</span>
            </a>
        </li>
    @endif


    @if ($amsRoleArray['is_cms_template'] == '1')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/template-setting') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">CMS Template 分館資料設定</span>
            </a>
        </li>
    @endif
    @if ($amsRoleArray['is_cms_template_ma'] == '1')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/cms-manager') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">CMS Template 帳號權限管理</span>
            </a>
        </li>
    @endif
    @if ($amsRoleArray['is_cms_template_setting'] == '100')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/crs-template') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">CMS Template Review 權限管理</span>
            </a>
        </li>
    @endif

    {{-- <li class="level-1 level_list" style="display:none;">
    <a href="javascript:;" class="content">
      <span class="icon">01.</span>
      <span class="title">Cover Page 功能設定</span>
    </a>
    </li> --}}

    {{-- @if ($amsRoleArray['is_crs_role'] == '1' && $configSet['setBranchs']) --}}
    {{-- <li class="level-1 level_list">
      <a href="{{ url('Fantasy/Ams/cms-overview') }}" class="content">
  <span class="icon">01.</span>
  <span class="title">Cover Page 權限管理</span>
  </a>
  </li> --}}
    {{-- @endif --}}
    {{-- @if ($amsRoleArray['is_overview_crs'] == '10' && $configSet['isReview'])
  <li class="level-1 level_list">
    <a href="{{ url('Fantasy/Ams/crs-overview') }}" class="content">
      <span class="icon">01.</span>
      <span class="title">Cover Page Review 權限管理</span>
    </a>
  </li>
  @endif --}}

    {{-- <li class="level-1 level_list" style="display:none;">
    <a href="javascript:;" class="content">
      <span class="icon">01.</span>
      <span class="title">FMS 管理與設定</span>
    </a>
    </li> --}}

    {{-- <li class="level-1 level_list" style="display:none;">
    <a href="javascript:;" class="content">
      <span class="icon">01.</span>
      <span class="title">Message 權限管理</span>
    </a>
    </li> --}}

    {{-- <li class="level-1 level_list" style="display:none;">
    <a href="javascript:;" class="content">
      <span class="icon">01.</span>
      <span class="title">Analytics-Website 權限管理</span>
    </a>
    </li> --}}

    {{-- <li class="level-1 level_list" style="display:none;">
    <a href="javascript:;" class="content">
      <span class="icon">01.</span>
      <span class="title">Analytics-Google 權限管理</span>
    </a>
    </li> --}}

    @if ($amsRoleArray['is_folder'] == '1' && 0)
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/fms-folder') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">Fms Folder 基本目錄管理</span>
            </a>
        </li>
    @endif


    @if ($amsRoleArray['is_autoredirect'] == '1')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/autoredirect') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">Website Redirect 管理</span>
            </a>
        </li>
    @endif
    @if ($amsRoleArray['is_log'] == '1')
        <li class="level-1 level_list">
            <a href="{{ url('Fantasy/Ams/log') }}" class="content">
                <span class="icon">{{ ++$index }}.</span>
                <span class="title">Log 紀錄</span>
            </a>
        </li>
    @endif
    <li class="level-1 level_list" style="display:none;">
        <a href="javascript:;" class="content">
            <span class="icon">{{ ++$index }}.</span>
            <span class="title">Fantasy Setting 權限管理</span>
        </a>
    </li>
</ul>
<div class="clearfix"></div>
