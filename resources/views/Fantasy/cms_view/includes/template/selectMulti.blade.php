<li class="inventory row_style">
	<div class="title">
		<p class="subtitle">{{ $title }}</p>
	</div>
	<div class="inner">
		<div class="quill_select multi_select">
			<div class="select_object">
				<p class="title" data-key="{{ $randomWord }}"></p>
				<span class="arrow pg-arrow_down"></span>
			</div>
			@if($disabled===false)
				<input type="hidden" name="{{ $name }}" value="{{ $value }}" class="multi_select_{{ $randomWord }}">
				<div class="select_wrapper">
					<ul class="select_list multi_sselect_list_{{ $randomWord }}" data-key="{{ $randomWord }}">
						@if($select_all)
						<li class="multi_select_fantasy option" data-id="all" ><p>全選 / 全不選</p></li>
						@endif	
						@foreach($options as $key => $row)
							<li class="multi_select_fantasy option{{ $row['default']==true?' default':'' }}" data-id="{{ $row['key'] }}"><p>{{ $row['title'] }}</p></li>
						@endforeach
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
		