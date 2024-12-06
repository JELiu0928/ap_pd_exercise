@if ($level == $cur)
    @if ($selected === 'selected')
        <?php $count = 0; ?>
        @foreach ($options as $option => $inner)
            @if ($value === $inner['key'] || (empty($value) && $count++ === 0))
                <optGroup label="{{ $groupTitle }}">
                    <option value="{{ $inner['key'] }}" selected>
                        {{ $inner['title'] }}</option>
                </optGroup>
            @endif
        @endforeach
    @else
        <optGroup label="{{ $groupTitle }}">
            <?php $count = 0; ?>
            @foreach ($options as $option => $inner)
                @if ($value !== $inner['key'])
                    @if (empty($value) && $count++ === 0)
                    @else
                        <option value="{{ $inner['key'] }}">
                            {{ $inner['title'] }}</option>
                    @endif
                @endif
            @endforeach
        </optGroup>
    @endif
@else
    @foreach ($options as $option => $inner)
        @include('Fantasy.cms_view.includes.template.select2GroupOption', [
            'cur' => $cur + 1,
            'level' => $level,
            'options' => $inner,
            'value' => $value,
            'groupTitle' => empty($groupTitle) ? $option : $groupTitle . '　→　' . $option,
        ])
    @endforeach
@endif
