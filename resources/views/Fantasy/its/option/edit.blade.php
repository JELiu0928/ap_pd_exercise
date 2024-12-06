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
								'value' => ( !empty($data['title']) )? $data['title'] : ''
							])}}

							{{UnitMaker::textInput([
								'name' => $model.'[key]',
								'title' => 'PHP用',
								'tip' => '建議英文，用法:call 變數 options[key]',
								'value' => ( !empty($data['key']) )? $data['key'] : ''
							])}}

							{{UnitMaker::sonTable([
								'sort' => 'no',
								'teach' => 'no',
								'hasContent' => 'yes',
								'tip' => '子選項',
								'value' => ( !empty($associationData['son']['OptionItem']) )? $associationData['son']['OptionItem'] : [],
								'name' => 'OptionItem',
								'tableSet' => 
								[
									[
										'type' => 'just_show',
										'title' => 'key值',
										'value' => 'key_value',
										'default' => ''
									],
									[
										'type' => 'just_show',
										'title' => '名稱',
										'value' => 'title',
										'default' => ''
									],
									[
										'type' => 'radio_btn',
										'title' => '是否!?',
										'value' => 'is_active',
										'default' => ''
									]
								],
								'tabSet'=>
								[
									[
										'title' => '選項設定',
										'content' => 
										[
											[
												'type' => 'textInput',
												'title' => 'key值',
												'value' => 'key_value',
												'tip'=> 'key值',
												'default' => ''
											],
											[
												'type' => 'textInput',
												'title' => '名稱',
												'value' => 'title',
												'default' => ''
											],
										],
									],
								] 
							])}}

						@endif

					</ul>
				</section>
			</div>
		</section>
	</article>
</div>