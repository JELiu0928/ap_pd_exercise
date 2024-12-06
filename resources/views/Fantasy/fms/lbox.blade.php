<div class="fixed-header fms_theme ajax_fms ajax_temp">
    <!-- 中間主區塊 -->
    <div class="mainBody page-container extract-block">
        <!-- 最上面的 header bar -->
        <div class="header">
            <div class="blockCover">
                <div class="blockLogo">
                    <p style="color: #775bc2;">fms</p>
                </div>
                <div class="blockName">
                    <p>File Management System</p>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="close_ajax_btn">
                    <span class="fa fa-remove"></span>
                </div>
            </div>
        </div>
        <!-- 最上面的 header bar -->
        <!-- 內容 CONTENT -->
        <div class="page-content-wrapper mainContent content-sidebar-open">
            @include('Fantasy.fms.lbox_full',['cms_open'=>$cms_open])
        </div>
        <!-- 內容 CONTENT -->
        <!--control_btn-->
        <ul class="ajax_control_btn hiddenArea_frame_controlBtn">
            @if($img_key!='undefined' && $unit_type!='undefined')
                <li class="list selected">
                    <p>YOU CAN SELECTED <span class="number">1</span> FILES</p>
                </li>
                <li class="list setting fms_lbox_current_btn" data-key="{{ $img_key }}" data-type="{{ $unit_type }}"><span class="fa fa-check"></span>
                    <p>SETTING</p>
                </li>
            @endif
            <li class="list close_ajax_btn fms_lbox_current_close"><span class="fa fa-remove"></span>
                <p>CANCEL</p>
            </li>
        </ul>
        <!--control_btn-->
    </div>
    <!-- 中間主區塊 -->
    <!-- 右邊滑動的 隱藏區塊 -->
    <!-- 右邊滑動的 隱藏區塊 -->
</div>
