{{-- 是否有父層 --}}
@if (!empty($nowFolderPath['top_folder']))
    @include('Fantasy.fms.breadcrumb', ['active' => 0, 'nowFolderPath' => $nowFolderPath['top_folder']])
@endif
{{-- active 當下點開的資料夾 --}}
{{-- 增加判斷根目錄 --}}
@if (!empty($nowFolderPath))
    @if ($active == 1)
        <li class="breadcrumb-item active" aria-current="page" data-folder-id="{{ $nowFolderPath['id'] }}">
            <a href="javascript:;">{{ $nowFolderPath['title'] }}</a>
        </li>
    @else
        <li class="breadcrumb-item" aria-current="page" data-folder-id="{{ $nowFolderPath['id'] }}">
            <a href="javascript:;">{{ $nowFolderPath['title'] }}</a>
        </li>
    @endif
@endif
