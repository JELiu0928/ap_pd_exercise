@if(isset($folderAll))
@if(!isset($loop))
<li class="option @if(empty($row['son_folder_withSession'])) last-option @endif" data-id="0" data-level="-1" data-branch="1">
	<p class="title">根目錄</p>
	@foreach($folderAll as $key => $row)
	@if(isset($json_folder))
	@if(!in_array($row['id'],$json_folder) && $row['is_delete'] == 0)
<li class="option @if(empty($row['son_folder_withSession'])) last-option @endif" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}">
	<p class="title">{{ $row['title'] }}<span class="arrow"></span></p>
	@if(!empty($row['son_folder_withSession']))
	<ul class="option_list" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}" style="display: none;">
		@include('Fantasy.fms.folder_all_select',['folderAll'=>$row['son_folder_withSession'],'json_folder'=>$json_folder,'loop'=>1])
	</ul>
	@endif
</li>
@endif
@else
@if($row['is_delete'] == 0)
<li class="option @if(empty($row['son_folder_withSession'])) last-option @endif" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}">
	<p class="title">{{ $row['title'] }}<span class="arrow"></span></p>
	@if(!empty($row['son_folder_withSession']))
	<ul class="option_list" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}" style="display: none;">
		@include('Fantasy.fms.folder_all_select',['folderAll'=>$row['son_folder_withSession'],'loop'=>1])
	</ul>
	@endif
</li>
@endif
@endif
@endforeach
</li>
@else
@foreach($folderAll as $key => $row)
@if(isset($json_folder))
@if(!in_array($row['id'],$json_folder) && $row['is_delete'] == 0)
<li class="option @if(empty($row['son_folder_withSession'])) last-option @endif" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}">
	<p class="title">{{ $row['title'] }}<span class="arrow"></span></p>
	@if(!empty($row['son_folder_withSession']))
	<ul class="option_list" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}" style="display: none;">
		@include('Fantasy.fms.folder_all_select',['folderAll'=>$row['son_folder_withSession'],'json_folder'=>$json_folder,'loop'=>1])
	</ul>
	@endif
</li>
@endif
@else
@if($row['is_delete'] == 0)
<li class="option @if(empty($row['son_folder_withSession'])) last-option @endif" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}">
	<p class="title">{{ $row['title'] }}<span class="arrow"></span></p>
	@if(!empty($row['son_folder_withSession']))
	<ul class="option_list" data-id="{{ $row['id'] }}" data-level="{{ $row['self_level'] }}" data-branch="{{ $row['branch_id'] }}" style="display: none;">
		@include('Fantasy.fms.folder_all_select',['folderAll'=>$row['son_folder_withSession'],'loop'=>1])
	</ul>
	@endif
</li>
@endif
@endif
@endforeach
@endif

@endif