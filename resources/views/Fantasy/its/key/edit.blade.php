{{-- 表名跟哪一筆資料 --}}
<input type="hidden" name="modelName" value="{{ $model }}">
@if(isset($data['id']))
	<input type="hidden" name="dataId" value="{{ $data['id'] }}" class="editContentDataId">
@else
	<input type="hidden" name="dataId" value="" class="editContentDataId">
@endif
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

<!--內容-->
<div class="backEnd_quill">
	<article class="work_frame">
		<section class="content_box">
		    <div class="for_ajax_content">
		      	<section class="content_a">
		        	<ul class="frame">

						@if($formKey == 'contentForm')

							{{UnitMaker::textInput([
								'name' => $model.'[title]',
								'title' => '名稱',
								'tip' => '辨認、顯示用名稱',
								'value' => ( !empty($data['title']) )? $data['title'] : ''
							])}}

							{{UnitMaker::textInput([
								'name' => $model.'[key]',
								'title' => '鍵值',
								'tip' => '程式用key',
								'value' => ( !empty($data['key']) )? $data['key'] : ''
							])}}


						@endif

					</ul>
				</section>
			</div>
		</section>
	</article>
</div>