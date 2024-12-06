<li class="inventory row_style">
    <div class="title">
        <p class="subtitle">{{ $title }}</p>
    </div>

    <div class="inner">
        <textarea class="summernote-area" name="{{ $disabled ? '' : $name }}"
            @if (!empty($set['toolbar'])) data-toolbar="{{ $set['toolbar'] }}" @endif
            @if (!empty($set['verify']) && !$disabled) data-verify="{{ json_encode($set['verify']) }}" @endif
            {{ $disabled ? 'disabled' : '' }}>{{ $value }}</textarea>
        @if (!empty($tip))
            <div class="tips">
                <span class="title">TIPS</span>
                <p>{!! $tip !!}</p>
            </div>
        @endif
    </div>
</li>
