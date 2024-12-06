<div class="mainBody page-container extract-block">
    @include('Fantasy.includes.header')
    <div class="page-content-wrapper mainContent full-height">
        <div class="content full-height">
            <nav class="content-sidebar">
                <div class="sidebar-menu">
                    @include('Fantasy.cms_view.includes.list')
                    <div class="clearfix"></div>
                </div>
            </nav>
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
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb"></ol>
                                </nav>
                            </div>
                            <div class="total"></div>
                        </div>
                    </div>
                </div>
                <div class="content-scrollbox">
                    <div class="content-wrap main-table index-table-div" data-tableid="new_cms_table">
                        <div class="content-head cms-index_table">
                            <h1>WDD Design</h1>
                            <div class="content-nav">
                            </div>
                        </div>
                    </div>
                    <div class=" ag-theme-alpine" id="main" style="height: calc(100vh - 60px);padding-top: 130px;pointer-events: auto;"></div>
                    <div class="content-bottom">
                        <div class="content-bottom-info">
                            <span class="blod" id="d-index-s">-</span>
                            <span id="ag-26-to">to</span>
                            <span class="blod" id="d-index-e">-</span>
                            <span id="ag-26-of">of</span>
                            <span class="blod" id="d-index-t">-</span>
                        </div>
                        <div class="content-bottom-page ag-theme-alpine"></div>
                    </div>
                    <div class="hiddenArea editContentArea cms_hiddenArea cmsDetailAjaxArea">
                        {{-- Fantasy.cms.Edit.edit --}}
                    </div>
                    <div class="hiddenArea editContentArea cms_hiddenArea cmsDetailAjaxSearch"></div>
                </div>
            </div>
        </div>
    </div>
</div>
