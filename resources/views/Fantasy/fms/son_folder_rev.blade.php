@if ($firstTime)
    <div class="folder-tree">
        <ul class="main-tree">
            <li class="tree-title ready-tree active" data-folder-id="0" data-parent-id="-1"><span class="title">根目錄</span><span
                    class="arrow"></span></li>
            @foreach ($folderAll as $val)
                <ul class="main-tree tree">
                    <li class="tree-title {{ $val['open_class'] ?? '' }} {{ $val['use_auth'] }} @if ($val['is_delete']) is_delete @endif"
                        style="display: none;" data-folder-id="{{ $val['id'] }}" data-parent-id="{{ $val['parent_id'] }}">
                        {{-- <li class="tree-title {{ $val['open_class'] }} {{ $val['use_auth'] }} @if ($val['is_delete']) is_delete @endif" style="display: none;" data-folder-id="{{ $val['id'] }}" data-parent-id="{{ $val['parent_id'] }}"> --}}
                        <div class="title">
                            <span class="text">{{ $val['title'] }}</span>
                        </div>
                        <span class="arrow"></span>
                    </li>
                    @if (!empty($val['son_folder_withSession']))
                        @include('Fantasy.fms.son_folder_rev', ['for_son_folder' => $val['son_folder_withSession'], 'firstTime' => 0])
                    @endif
                </ul>
            @endforeach
        </ul>

        <ul class="main-tree">
            <li class="tree-title trash" data-folder-id=""><span class="title">垃圾桶</span></li>
        </ul>
    </div>
@else
    @foreach ($for_son_folder as $val)
        <ul class="tree @if ($val['is_delete']) is_delete @endif">
            <li class="tree-title {{ $val['open_class'] ?? '' }} {{ $val['use_auth'] }} @if ($val['is_delete']) is_delete @endif"
                style="display: none;" data-folder-id="{{ $val['id'] }}" data-parent-id="{{ $val['parent_id'] }}">
                {{-- <li class="tree-title {{ $val['open_class'] }} {{ $val['use_auth'] }} @if ($val['is_delete']) is_delete @endif" style="display: none;" data-folder-id="{{ $val['id'] }}" data-parent-id="{{ $val['parent_id'] }}"> --}}
                <div class="title">
                    <span class="text">{{ $val['title'] }}</span>
                </div>
                <span class="arrow"></span>
            </li>
            @if (!empty($val['son_folder_withSession']))
                @include('Fantasy.fms.son_folder_rev', ['for_son_folder' => $val['son_folder_withSession'], 'firstTime' => 0])
            @endif
        </ul>
    @endforeach
@endif
