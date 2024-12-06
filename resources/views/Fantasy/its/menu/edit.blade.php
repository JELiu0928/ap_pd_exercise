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
								'tip' => '選單名稱',
								'value' => ( !empty($data['title']) )? $data['title'] : ''
							])}}

						{{UnitMaker::textInput([
								'name' => $model.'[view_prefix]',
								'title' => '路徑',
								'tip' => '頁面路徑',
								'value' => ( !empty($data['view_prefix']) )? $data['view_prefix'] : ''
							])}}

						{{UnitMaker::textInput([
								'name' => $model.'[model]',
								'title' => 'Model Name',
								'tip' => '用記載在BackendController中的名稱',
								'value' => ( !empty($data['model']) )? $data['model'] : ''
							])}}

						{{UnitMaker::select([
								'name' => $model.'[type]',
								'title' => '類型',
								'options'=>$options['typeOptions'],
								'value' => ( !empty($data['type']) )? $data['type'] : ''
							])}}

						{{UnitMaker::select([
								'name' => $model.'[key_id]',
								'title' => '所屬網站key值',
								'tip' => '所屬網站key值',
								'explanation' => '請選擇所屬key值，單選',
								'empty'=>'yes',
								'options'=>$options['keyOptions'],
								'value' => ( !empty($data['key_id']) )? $data['key_id'] : ''
							])}}

						{{UnitMaker::select([
								'name' => $model.'[parent_id]',
								'title' => '層級',
								'tip' => '其歸屬於哪一層menu下',
								'explanation' => '其歸屬於哪一層menu下',
								'options'=>$options['menuOptions'],
								'empty'=>'yes',
								'value' => ( !empty($data['parent_id']) )? $data['parent_id'] : ''
							])}}

						{{UnitMaker::select([
								'name' => $model.'[use_type]',
								'title' => '用途',
								'options'=>$options['useOptions'],
								'value' => ( !empty($data['use_type']) )? $data['use_type'] : '',
								'disabled' => ''
							])}}

						{{UnitMaker::selectMulti([
								'name' => $model.'[options_group]',
								'title' => '選項多選',
								'options'=>$options['optionOptions'],
								'value' => ( !empty($data['options_group']) )? $data['options_group'] : '',
								'disabled' => ''
							])}}

						@elseif($formKey == 'ex2Form')

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

						{{UnitMaker::radio_btn([
								'name' => $model.'[is_parent]',
								'title' => 'P-是否應用父選項',
								'tip' => '應用父選項做分類選擇',
								'value' => ( !empty($data['is_parent']) )? $data['is_parent'] : ''
							])}}

						@elseif($formKey == 'sonForm')

						{{UnitMaker::sonTable([
								'sort' => 'no',
								'teach' => 'no',
								'hasContent' => 'no',
								'tip' => '其選單關聯之子資料表',
								'value' => ( !empty($associationData['son']['CmsChild']) )? $associationData['son']['CmsChild'] : [],
								'name' => 'CmsChild',
								'tableSet' => 
								[
									[
										'type' => 'textInput',
										'title' => 'Model名稱',
										'value' => 'child_model',
										'default' => ''
									],
									[
										'type' => 'textInput',
										'title' => '子資料表Foreign Key',
										'value' => 'child_key'
									],
									[
										'type' => 'radio_btn',
										'title' => '是否有rank',
										'value' => 'is_rank'
									]
								],
								'tabSet'=>
								[
								] 
							])}}
						@elseif($formKey == 'parentForm')

						{{UnitMaker::sonTable([
								'sort' => 'no',
								'teach' => 'no',
								'hasContent' => 'no',
								'tip' => '其選單關聯之父資料表',
								'value' => ( !empty($associationData['son']['CmsParent']) )? $associationData['son']['CmsParent'] : [],
								'name' => 'CmsParent',
								'tableSet' => 
								[
									[
										'type' => 'textInput',
										'title' => 'Model名稱',
										'value' => 'parent_model',
										'default' => ''
									],
									[
										'type' => 'textInput',
										'title' => '名稱欄位',
										'value' => 'parent_option'
									],
									[
										'type' => 'textInput',
										'title' => '連接key',
										'value' => 'foreign_key'
									],
									[
										'type' => 'textInput',
										'title' => '爺爺資料表',
										'value' => 'with'
									],
									[
										'type' => 'textInput',
										'title' => '爺爺DB Name',
										'value' => 'with_db'
									],
									[
										'type' => 'textInput',
										'title' => '爺爺資料表名稱欄位',
										'value' => 'with_name'
									],
								],
								'tabSet'=>
								[
								] 
							])}}

						@endif

					</ul>
				</section>
			</div>
		</section>
	</article>
</div>