<div class="hiddenArea_frame ajaxItem cms">
    <div class="detailEditor">
        <div class="editorBody">
            <div class="editorHeader">
                <div class="info">
                    {!! $title !!}
                </div>
                <div class="control">
                    <ul class="btnGroup"></ul>
                </div>
            </div>
            <div class="editorContent editContentFormArea">
                {{-- forms --}}
                {{-- @foreach ($menuList as $menukey => $menuname)
                    <form id={{ $menukey }}></form>
                @endforeach --}}
                {!! $content !!}
            </div>
        </div>
        <div class="editorNav">
            <div class="control">
                <ul class="btnGroup">
                    @if ($role['edit'] || ($action === 'create' && $role['create']))
                        <li class="check editSentBtn">
                            <a href="javascript:;">
                                <span class="fa fa-check"></span>
                            </a>
                        </li>
                    @endif

                    @if ($role['delete'] && $action === 'edit' && !$menu['is_content'])
                        <li class="trash cms-delete-btn">
                            <a href="javascript:void(0)">
                                <span class="fa fa-trash"></span>
                            </a>
                        </li>
                    @endif
                    @if (!$menu['is_content'])
                        <li class="remove">
                            <a class="close_btn" href="javascript:;">
                                <span class="fa fa-remove"></span>
                            </a>
                        </li>
                    @endif
                </ul>
                <p class="sub_title">MANAGEMENT OPTIONS</p>
            </div>
            <ul class="editContentMenu navGroup">
                @php
                    $count = 0;
                @endphp
                @foreach ($tabs as $key => $tab)
                    <li data-form="{{ $key }}"
                        @if (($count++ === 0 && empty($active)) || $active === $key) class="active opened wait-sent" @endif>
                        <a href="javascript:void(0);">
                            <p class="menu_listName">{{ $tab }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="hiddenArea_frame_controlBtn">
        @if ($action == 'edit')
            <div
                class="review_info review_info_push {{ isset($ReviewNotify) && !empty($ReviewNotify) && $ReviewNotify['action'] == '審核' ? 'active' : '' }}">
                <div>
                    <p>目前資料正在等待發佈審核中<span class="notify_admin_cancel"
                            style="cursor: pointer;margin-left: 20px;color: #c90a0a;">取消審核</span></p>
                </div>
            </div>
            <div
                class="review_info review_info_del {{ isset($ReviewNotify) && !empty($ReviewNotify) && $ReviewNotify['action'] == '刪除' ? 'active' : '' }}">
                <div>
                    <p>目前資料正在等待刪除審核中<span class="notify_admin_cancel"
                            style="cursor: pointer;margin-left: 20px;color: #c90a0a;">取消審核</span></p>
                </div>
            </div>
        @endif
        <ul class="btnGroup">
            @if ($role['edit'] || ($action === 'create' && $role['create']))
                <li class="check editSentBtn" data-reviewed="{{ $is_reviewed }}"
                    data-reviewed-pass="{{ $role['can_review'] }}">
                    <a href="javascript:void(0)">
                        <span class="fa fa-check"></span>
                        <p>Setting</p>
                    </a>
                </li>
            @endif
            @if ($role['delete'] && $action === 'edit' && !$menu['is_content'])
                <li class="trash cms-delete-btn">
                    <a href="javascript:void(0)">
                        <span class="fa fa-trash"></span>
                        <p>delete</p>
                    </a>
                </li>
            @endif
            @if (!$menu['is_content'])
                <li class="remove">
                    <a class="close_btn" href="javascript:void(0)">
                        <span class="fa fa-remove"></span>
                        <p>Cancel</p>
                    </a>
                </li>
            @endif
            @if ($role['need_review'] && !$role['can_review'] && ($action === 'edit' || $action === 'batch'))
                <li class="notify_admin {{ $is_reviewed && $action == 'edit' ? 'hide' : '' }}" data-action="review"
                    style="background-color: #ee4c4c;">
                    <a href="javascript:void(0)">
                        <span class="fa fa-envelope"></span>
                        <p>通知管理者審核</p>
                    </a>
                </li>
                @if (!$role['delete'])
                    <li class="notify_admin {{ $is_reviewed && $action == 'edit' ? 'hide' : '' }}" data-acion="remove"
                        style="background-color: #424242;">
                        <a href="javascript:void(0)">
                            <span class="fa fa-trash"></span>
                            <p>通知管理者刪除</p>
                        </a>
                    </li>
                @endif
                @if ($action == 'batch')
                    <li class="notify_admin_cancel" data-action="review" style="background-color: #424242;">
                        <a href="javascript:void(0)">
                            <span class="fa fa-trash"></span>
                            <p>取消審核</p>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>
