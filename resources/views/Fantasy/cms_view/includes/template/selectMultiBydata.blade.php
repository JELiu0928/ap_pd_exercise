<li class="inventory {!! $sontable===false?'row_style':'' !!} open_db_lightbox">
	{!! $sontable===false?'<div class="title">':'' !!}
		<p class="subtitle">{{ $title }}</p>
	{!! $sontable===false?'</div>':'' !!}
	<div class="inner">
		<div class="quill_select multi_select no_effect">
			<div class="select_object ajax_open multi_shot" data-model="{{ $model }}" data-cls="multi_shot" data-empty="{{ $empty }}">
				<p class="title" data-key="{{ $randomWord }}">
					<?php $count=0; ?>
					@foreach($options as $key => $row)
						@if($row['default']==true)
							<?php $count++; ?>
							<span class="item multiOption_{{ $key }}" option-id="{{ $row['key'] }}">
								<i class="number">{{ sprintf('%02d', $count) }}.</i>
								<i class="name">{{ $row['title'] }}</i>
							</span>
						@endif
					@endforeach
				</p>
				<span class="arrow pg-arrow_down"></span>
			</div>
			@if($disabled===false)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                <div class="select_wrapper">
                    <ul class="select_list multi_sselect_list_{{ $randomWord }}" data-key="{{ $randomWord }}">
                        
                    </ul>
                </div>
			@endif
		</div>
		@if(!empty($tip))
			<div class="tips">
				<span class="title">TIPS</span>
				<p>{!! $tip !!}</p>
			</div>
		@endif
	</div>
</li>
		