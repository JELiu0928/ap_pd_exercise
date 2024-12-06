<li class="inventory{{ $sontable === false ? ' row_style' : '' }}">
    {!! $sontable === false ? '<div class="title">' : '' !!}
    <p class="subtitle">{{ $title }}</p>
    {!! $sontable === false ? '</div>' : '' !!}

    {!! $sontable === false ? '<div class="inner">' : '' !!}
    <div class="summernote_box" style="width:100%;">
        <textarea class="box" name="{{ $name }}">
          {!! $value !!}
      </textarea>
    </div>
    @if ($tip != '')
        <div class="tips">
            <span class="title">TIPS</span>
            <p>{{ $tip }}</p>
        </div>
    @endif
    {!! $sontable === false ? '</div>' : '' !!}
</li>
