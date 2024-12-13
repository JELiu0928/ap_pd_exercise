{{-- @dump('blade', $partItems) --}}
@if (!empty($partItems))

    @foreach ($partItems as $item)
        <div class="list bk-part-{{ $item['id'] }} bk-part-item" bk-part-id="{{ $item['id'] }}">
            <div class="row">
                <ul>
                    <li class="paragraphText-s">
                        <span>產品類別</span>
                        <span>{!! $item->item['banner_title'] !!}</span>
                    </li>
                    <li class="paragraphText-s">
                        <span>產品系列</span>
                        <span>{!! $item->item->series['title'] !!}</span>
                    </li>
                    <li class="paragraphText-s">
                        <span>產品項目</span>
                        <span>{!! $item->item->series->category['banner_title'] !!}</span>
                    </li>
                </ul>
                <div class="main">
                    <p class="itemTitle-w">{{ $item['title'] }}</p>
                </div>
                <div class="form-row">
                    <div class="form-grid">
                        <label class="form-group textarea small">
                            <div class="input-wrap">
                                <textarea class="textarea-scrollbar bk-part-description" form-field="part-description" type="text"
                                    placeholder="新增備註..." name="descriptione"></textarea>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="icon delete bk-delete-btn">
                <i class="icon-delete"></i>
            </div>
        </div>
    @endforeach
@endif
