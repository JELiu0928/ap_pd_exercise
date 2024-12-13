{{-- 表格body --}}
<div class="tbody-outer">
    <div class="scroller">
        <div class="tbody">
            {{-- <!-- 加入諮詢, 在 tr 加上 added 的 class--> --}}
            {{-- <!-- 下載檔案 / 加入諮詢 有兩組結構(電腦版與手機版), 再麻煩同步串接--> --}}
            @foreach ($specParts as $part)
                {{-- @dump($part) --}}
                <div class="tr bk-tr {{ 'bk-part-' . $part['id'] }} {{ is_array($sessionPartIDs) && in_array($part['id'], $sessionPartIDs) ? 'added' : '' }} "
                    bk-part-id="{{ $part['id'] }}">
                    <div class="td fixed-left">
                        <p>{{ $part['title'] }}</p>
                        <div class="row-flex rwd action">
                            @if (!empty($part->file))
                                <a class="flex" href="{{ BaseFunction::b_url('downloadFiles') . '/' . $part->file }}"
                                    target="_blank">
                                    <div class="icon">
                                        <i class="icon-download"> </i>
                                    </div>
                                </a>
                            @endif
                            {{-- rwd --}}
                            <div class="flex addConsult bk-add-consult-btn" {{-- onclick="document.body.fesd.addConsult()"> --}}>
                                <div class="icon">
                                    <i class="icon-plus"></i>
                                    <i class="icon-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($specTitles as $title)
                        {{-- @dump($title) --}}
                        <div class="td" bk-title-spec-id="{{ $title['id'] }}">
                            <p>{!! isset($specContentArr[$title->id][$part->id]) ? $specContentArr[$title->id][$part->id] : '' !!}</p>
                        </div>
                    @endforeach
                    <div class="td action fixed-right">
                        @if (!empty($part->file))
                            <a class="flex" href="{{ BaseFunction::b_url('downloadFile') . '/' . $part->file }}"
                                target="_blank">
                                <div class="icon"><i class="icon-download"></i></div>
                                <p class="paragraphText">下載檔案</p>
                            </a>
                        @endif

                        {{-- <div class="flex addConsult" onclick="document.body.fesd.addConsult()"> --}}
                        <div class="flex addConsult bk-add-consult-btn">
                            <div class="icon">
                                <i class="icon-plus"></i>
                                <i class="icon-check"></i>
                            </div>
                            <p class="paragraphText">加入諮詢</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
