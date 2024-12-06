{{-- 表名跟哪一筆資料 --}}
<form id="{{ $formKey }}">
    <input name="modelName" type="hidden" value="{{ $model }}">

    <div class="backEnd_quill">
        <article class="work_frame">
            <section class="content_box">
                <div class="for_ajax_content">
                    <section class="content_a">
                        <ul class="frame">
                            @if($formKey == 'search')

                            @endif
                            @if($formKey == 'batch')

                            @endif
                            @if($formKey == 'Form_tab0')

                                @if($role['need_review'] && $role['can_review'])
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[is_reviewed]',
                                    'title' => '審核通過',
                                    'tip' => '',
                                    'value' => !empty($data['is_reviewed']) ? $data['is_reviewed'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                @endif
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[is_visible]',
                                    'title' => '是否顯示',
                                    'tip' => '',
                                    'value' => !empty($data['is_visible']) ? $data['is_visible'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[is_visible]',
                                    'title' => '是否顯示於預覽站',
                                    'tip' => '',
                                    'value' => !empty($data['is_visible']) ? $data['is_visible'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::numberInput([
                                    'name' => $model . '[w_rank]',
                                    'title' => '排序',
                                    'tip' => '',
                                    'value' => !empty($data['w_rank']) ? $data['w_rank'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[textInput]',
                                    'title' => 'textInput',
                                    'tip' => '',
                                    'value' => !empty($data['textInput']) ? $data['textInput'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::lang_textInput([
                                    'model' => $model,
                                    'name' => 'lang_textInput',
                                    'title' => 'lang_textInput',
                                    'tip' => '',
                                    'value' => $data,
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::textInputTarget([
                                    'name' => $model . '[textInputTarget]',
                                    'title' => 'textInputTarget',
                                    'tip' => '',
                                    'value' => !empty($data['textInputTarget']) ? $data['textInputTarget'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                    'target' => ['name' => $model . '[textInputTarget_target]', 'value' => $data['textInputTarget_target'] ?? ''],
                                ]) }}
                                {{ UnitMaker::textInputTargetAcc([
                                    'name' => $model . '[textInputTargetAcc]',
                                    'title' => 'textInputTargetAcc',
                                    'tip' => '',
                                    'value' => !empty($data['textInputTargetAcc']) ? $data['textInputTargetAcc'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                    'target' => ['name' => $model . '[textInputTargetAcc_target]', 'value' => $data['textInputTargetAcc_target'] ?? ''],
                                    'accessible' => ['name' => $model . '[textInputTargetAcc_acc]', 'value' => $data['textInputTargetAcc_acc'] ?? ''],
                                ]) }}
                                {{ UnitMaker::textArea([
                                    'name' => $model . '[textArea]',
                                    'title' => 'textArea',
                                    'tip' => '',
                                    'value' => !empty($data['textArea']) ? $data['textArea'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::lang_textArea([
                                    'model' => $model,
                                    'name' => 'lang_textArea',
                                    'title' => 'lang_textArea',
                                    'tip' => '',
                                    'value' => $data,
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[radio_btn]',
                                    'title' => 'radio_btn',
                                    'tip' => '',
                                    'value' => !empty($data['radio_btn']) ? $data['radio_btn'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[radio_area]',
                                    'title' => 'radio_area',
                                    'value' => !empty($data['radio_area']) ? $data['radio_area'] : '',
                                    'options' => OptionFunction::Datalist_radio_area(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::select2([
                                    'name' => $model . '[select2]',
                                    'title' => 'select2',
                                    'value' => !empty($data['select2']) ? $data['select2'] : '',
                                    'options' => OptionFunction::Datalist_select2(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::select2Multi([
                                    'name' => $model . '[select2Multi]',
                                    'title' => 'select2Multi',
                                    'value' => !empty($data['select2Multi']) ? $data['select2Multi'] : '',
                                    'options' => OptionFunction::Datalist_select2Multi(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::imageGroup([
                                    'title' => 'imageGroup',
                                    'image_array' => [
                                        [
                                            'name' => $model . '[imageGroup]',
                                            'title' => '電腦版',
                                            'value' => !empty($data['imageGroup']) ? $data['imageGroup'] : '',
                                            'set_size' => 'yes',
                                            'width' => '400',
                                            'height' => '370',
                                        ]
                                    ],
                                    'tip' => '<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                ]) }}
								{{ UnitMaker::colorPicker([
									'name' => $model . '[colorPicker]',
									'title' => 'colorPicker',
									'tip' => '',
									'value' => !empty($data['colorPicker']) ? $data['colorPicker'] : '',
									'disabled' => '',
									'class' => '',
								])}}
                                {{ UnitMaker::datePicker([
                                    'name' => $model . '[datePicker]',
                                    'title' => 'datePicker',
                                    'tip' => '',
                                    'value' => !empty($data['datePicker']) ? $data['datePicker'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::filePicker([
                                    'name' => $model . '[filePicker]',
                                    'title' => 'filePicker',
                                    'tip' => '',
                                    'value' => !empty($data['filePicker']) ? $data['filePicker'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::numberInput([
                                    'name' => $model . '[numberInput]',
                                    'title' => 'numberInput',
                                    'tip' => '',
                                    'value' => !empty($data['numberInput']) ? $data['numberInput'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
								{{ UnitMaker::dateRange([
									'name' => $model . '[dateRange_start]',
									'name2' => $model . '[dateRange_end]',
									'title' => 'dateRange',
									'tip' => '',
									'value' => !empty($data['dateRange_start']) ? $data['dateRange_start'] : '',
									'value2' => !empty($data['dateRange_end']) ? $data['dateRange_end'] : '',
									'disabled' => '',
									'class' => '',
								]) }}@endif

@if($formKey == 'Form_datalist_content')
@include('Fantasy.cms_view.back_article_v3',['Model'=>'Datalist_content','ThreeModel'=>'Datalist_content_img'])
@endif
@if($formKey == 'Form_datalist_son')
                                {{ UnitMaker::WNsonTable([
                                    'sort' => 'yes', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '資料集son',
                                    'create' => 'yes', //是否可新增
                                    'delete' => 'yes', //是否可刪除
                                    'copy' => 'yes', //是否可複製
                                    'MultiImgcreate' => 'yes', //使用多筆圖片
                                    'imageColumn' => 'imageGroup', //預設圖片欄位
                                    'SecondIdColumn' => 'parent_id',
                                    'value' => !empty($associationData['son']['Datalist_son']) ? $associationData['son']['Datalist_son'] : [],
                                    'name' => 'Datalist_son',
                                    'tableSet' => [
                                        ['type' => 'just_show','title' => 'textInput','value' => 'textInput','auto' => true],['type' => 'radio_btn','title' => '預覽','value' => 'is_preview'],['type' => 'radio_btn','title' => '是否顯示','value' => 'is_visible']
                                    ],
                                    'tabSet' => [
                                        [
                                            'title' => '內容編輯',
                                            'content' => [

                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'textInput',
                                                    'title' => 'textInput',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                                [
                                                    'type' => 'lang_textInput',
                                                    'value' => 'lang_textInput',
                                                    'title' => 'lang_textInput',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
								                [
                                                    'type' => 'textInputTarget',
                                                    'value' => 'textInputTarget',
                                                    'title' => 'textInputTarget',
													'target' => ['name' => 'textInputTarget_target'],
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'textInputTargetAcc',
                                                    'value' => 'textInputTargetAcc',
                                                    'title' => 'textInputTargetAcc',
                                                    'tip' => '可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                    'target' => ['name' => 'textInputTargetAcc_target'],
                                                    'accessible' => ['name' => 'textInputTargetAcc_acc'],
                                                ],
								                [
                                                    'type' => 'textArea',
                                                    'value' => 'textArea',
                                                    'title' => 'textArea',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'lang_textArea',
                                                    'value' => 'lang_textArea',
                                                    'title' => 'lang_textArea',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'radio_btn',
                                                    'value' => 'radio_btn',
                                                    'title' => 'radio_btn',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'radio_area',
                                                    'value' => 'radio_area',
                                                    'title' => 'radio_area',
													'options' => OptionFunction::Datalist_son_radio_area(),
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'select2',
                                                    'value' => 'select2',
                                                    'title' => 'select2',
													'options' => OptionFunction::Datalist_son_select2(),
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
								                [
                                                    'type' => 'select2Multi',
                                                    'value' => 'select2Multi',
                                                    'title' => 'select2Multi',
													'options' => OptionFunction::Datalist_son_select2Multi(),
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'image_group',
                                                    'title' => 'imageGroup',
                                                    'image_array' => [
                                                        [
                                                            'title' => '電腦版',
                                                            'value' => 'imageGroup',
                                                            'set_size' => 'yes',
                                                            'width' => '400',
                                                            'height' => '370',
                                                        ]
                                                    ],
                                                    'tip' => '<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                                ],
                                                [
                                                    'type' => 'colorPicker',
                                                    'value' => 'colorPicker',
                                                    'title' => 'colorPicker',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                                [
                                                    'type' => 'datePicker',
                                                    'value' => 'datePicker',
                                                    'title' => 'datePicker',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                                [
                                                    'type' => 'filePicker',
                                                    'value' => 'filePicker',
                                                    'title' => 'filePicker',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                            ],
                                        ],
										                                        [
                                            'title' => '資料集son_son',
                                            'content' => [],
                                            'is_three' => 'yes',
                                            'create' => 'yes',
                                            'delete' => 'yes',
                                            'copy' => 'yes',
                                            'sort_field' => '', //自訂排序欄位
                                            'three_model' => 'Datalist_three',
                                            'three' => [
                                                'SecondIdColumn' => 'second_id',
                                                'title' => '資料集son_son',
                                                'tip' => '',
                                                'three_tableSet' => [
                                                    ['type' => 'just_show','title' => 'textInput','value' => 'textInput','auto' => true],
                                                ],
                                                'three_content' => [

                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'textInput',
                                                    'title' => 'textInput',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                                [
                                                    'type' => 'lang_textInput',
                                                    'value' => 'lang_textInput',
                                                    'title' => 'lang_textInput',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
								                [
                                                    'type' => 'textInputTarget',
                                                    'value' => 'textInputTarget',
                                                    'title' => 'textInputTarget',
													'target' => ['name' => 'textInputTarget_target'],
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'textInputTargetAcc',
                                                    'value' => 'textInputTargetAcc',
                                                    'title' => 'textInputTargetAcc',
                                                    'tip' => '可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                    'target' => ['name' => 'textInputTargetAcc_target'],
                                                    'accessible' => ['name' => 'textInputTargetAcc_acc'],
                                                ],
								                [
                                                    'type' => 'textArea',
                                                    'value' => 'textArea',
                                                    'title' => 'textArea',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'lang_textArea',
                                                    'value' => 'lang_textArea',
                                                    'title' => 'lang_textArea',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'radio_btn',
                                                    'value' => 'radio_btn',
                                                    'title' => 'radio_btn',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'radio_area',
                                                    'value' => 'radio_area',
                                                    'title' => 'radio_area',
													'options' => OptionFunction::Datalist_son_radio_area(),
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'select2',
                                                    'value' => 'select2',
                                                    'title' => 'select2',
													'options' => OptionFunction::Datalist_son_select2(),
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
								                [
                                                    'type' => 'select2Multi',
                                                    'value' => 'select2Multi',
                                                    'title' => 'select2Multi',
													'options' => OptionFunction::Datalist_son_select2Multi(),
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                ],
                                                [
                                                    'type' => 'image_group',
                                                    'title' => 'imageGroup',
                                                    'image_array' => [
                                                        [
                                                            'title' => '電腦版',
                                                            'value' => 'imageGroup',
                                                            'set_size' => 'yes',
                                                            'width' => '400',
                                                            'height' => '370',
                                                        ]
                                                    ],
                                                    'tip' => '<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                                ],
                                                [
                                                    'type' => 'colorPicker',
                                                    'value' => 'colorPicker',
                                                    'title' => 'colorPicker',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                                [
                                                    'type' => 'datePicker',
                                                    'value' => 'datePicker',
                                                    'title' => 'datePicker',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                                [
                                                    'type' => 'filePicker',
                                                    'value' => 'filePicker',
                                                    'title' => 'filePicker',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ])}}@endif
                            @if($formKey == 'Form_1')
                                @include('Fantasy.cms_view.back_article_v3', [
                                'Model' => 'Elite_business_dept_content',
                                'ThreeModel' => 'Elite_business_dept_content_img',
                                ])

                            @endif
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
