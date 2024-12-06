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

						{{UnitMaker::select([
								'name' => $model.'[key_id]',
								'title' => '所屬網站key值',
								'tip' => '所屬網站key值',
								'explanation' => '請選擇所屬key值，單選',
								'options'=>$options['keyOptions'],
								'value' => ( !empty($data['key_id']) )? $data['key_id'] : ''
							])}}

						{{UnitMaker::select([
								'name' => $model.'[type]',
								'title' => '資料夾用處',
								'tip' => '資料夾用處',
								'options'=>$options['filesOptions'],
								'value' => ( !empty($data['type']) )? $data['type'] : ''
							])}}

						{{UnitMaker::numberInput([
								'name' => $model.'[w_rank]',
								'title' => '排序',
								'tip' => '顯示排序，輸入 0 為置頂，排序將超越 1 ，多筆設定為 0 ，最後排序將取決於最後更新日期。',
								'value' => ( !empty($data['w_rank']) )? $data['w_rank'] : ''
							])}}

						{{UnitMaker::radio_btn([
								'name' => $model.'[is_active]',
								'title' => 'A-是否啟用',
								'value' => ( !empty($data['is_active']) )? $data['is_active'] : ''
							])}}


						@endif

					</ul>
				</section>
			</div>
		</section>
	</article>
</div>