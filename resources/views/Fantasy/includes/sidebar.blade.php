@php
    $sideBar = [
        'Dashbord' => 0,
        'CMS' => 1,
        'FMS' => 1,
        'TABLES' => 0,
        'PHOTOS' => 0,
        'SEOTOOL' => 0,
        'LOGS' => 0,
        'AMS' => 1,
        'Support' => 0,
        'Setting' => 0,
        'System' => 0,
        'ITS' => 1,
    ];
@endphp
<nav class="mainNav" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="navHeader">
        <img class="fantasyLogo" src="{{ asset('/vender/assets/img/Fantasy-icon.svg') }}" alt="logo">
        <h2>fantasy</h2>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
    <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
            @if ($sideBar['Dashbord'])
                <li>
                    <a href="javascript:;">
                        <span class="sidebar-icon icon-dashbord"></span>
                        <span class="title">Dashbord</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['CMS'])
                <li>
                    <a href="{{ url('Fantasy/Cms') }}">
                        <span class="sidebar-icon icon-cms"></span>
                        <span class="title">CMS</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['FMS'])
                <li>
                    <a href="{{ url('Fantasy/Fms') }}">
                        <span class="sidebar-icon icon-fms"></span>
                        <span class="title">FMS</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['TABLES'])
                <li>
                    <a href="javascript:;">
                        <span class="sidebar-icon icon-tables"></span>
                        <span class="title">TABLES</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['PHOTOS'])
                <li>
                    <a href="{{ url('Fantasy/Photos') }}">
                        <span class="sidebar-icon icon-photos"></span>
                        <span class="title">PHOTOS</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['SEOTOOL'])
                <li>
                    <a href="javascript:;">
                        <span class="sidebar-icon icon-seo-tool"></span>
                        <span class="title">SEO TOOL</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['LOGS'])
                <li>
                    <a href="javascript:;">
                        <span class="sidebar-icon icon-logs"></span>
                        <span class="title">LOGS</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['AMS'])
                <li>
                    <a href="{{ url('Fantasy/Ams') }}">
                        <span class="sidebar-icon icon-ams"></span>
                        <span class="title">AMS</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['Support'])
                <li>
                    <a href="javascript:;">
                        <span class="sidebar-icon icon-support"></span>
                        <span class="title">Support</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['Setting'])
                <li>
                    <a href="javascript:;">
                        <span class="sidebar-icon icon-setting"></span>
                        <span class="title">Setting</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['System'])
                <li>
                    <a href="javascript:;">
                        <span class="sidebar-icon icon-system"></span>
                        <span class="title">System</span>
                        <span class="icon-arrow"></span>
                    </a>
                </li>
            @endif
            @if ($sideBar['ITS'])
                <!--<li>
        <a href="{{ url('Fantasy/Its') }}">
          <span class="sidebar-icon icon-system"></span>
          <span class="title">ITS</span>
          <span class="icon-arrow"></span>
        </a>
      </li>-->
            @endif
        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</nav>
