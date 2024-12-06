@if ($totalPage > 1)
    <select class="page" id="page" name="page">
        @for ($i = 1; $i <= $totalPage; $i++)
            <option value="{{ $i }}" @if ($i == $page) selected @endif>
                {{ ($i - 1) * $perPage + 1 . ' ~ ' . $i * $perPage }}</option>
        @endfor
    </select>
@endif
