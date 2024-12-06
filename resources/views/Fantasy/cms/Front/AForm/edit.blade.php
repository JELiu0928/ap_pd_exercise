{{-- 表名跟哪一筆資料 --}}
<form id="{{ $formKey }}">
    <input name="modelName" type="hidden" value="{{ $model }}" data-id='{{ $data['id'] ?? 0 }}'>

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

                            @if($formKey == 'Form0')

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
                                    'name' => $model . '[is_preview]',
                                    'title' => '是否顯示於預覽站',
                                    'tip' => '',
                                    'value' => !empty($data['is_preview']) ? $data['is_preview'] : '',
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
                                    'name' => $model . '[title]',
                                    'title' => '表格名稱',
                                    'tip' => '',
                                    'value' => !empty($data['title']) ? $data['title'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[first_col]',
                                    'title' => '第一欄文字(固定單層)',
                                    'tip' => '',
                                    'value' => !empty($data['first_col']) ? $data['first_col'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}

                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[head_type]',
                                    'title' => '表頭類型',
                                    'value' => !empty($data['head_type']) ? $data['head_type'] : '',
                                    'options' => config('models.AForm')::headType(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[cell_type]',
                                    'title' => '儲存格類型',
                                    'value' => !empty($data['cell_type']) ? $data['cell_type'] : '',
                                    'options' => config('models.AForm')::cellType(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::select2Multi([
                                    'name' => $model . '[data_select]',
                                    'title' => '產品選擇',
                                    'value' => !empty($data['data_select']) ? $data['data_select'] : '',
                                    'options' => config('models.AData')::getList(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{-- {{ UnitMaker::select2([
                                    'name' => $model . '[head_type]',
                                    'title' => '表頭型別',
                                    'value' => !empty($data['head_type']) ? $data['head_type'] : '',
                                    'options' => config('models.AForm')::headType(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }} --}}

                                {{ UnitMaker::WNsonTable([
                                    'sort' => 'yes', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '表頭編輯',
                                    'create' => 'yes', //是否可新增
                                    'delete' => 'yes', //是否可刪除
                                    'copy' => 'yes', //是否可複製
                                    'MultiImgcreate' => 'no', //使用多筆圖片
                                    'imageColumn' => 'imageGroup', //預設圖片欄位
                                    'SecondIdColumn' => 'form_id',
                                    'value' => !empty($associationData['son']['AFormHead']) ? $associationData['son']['AFormHead'] : [],
                                    'name' => 'AFormHead',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '表頭名稱',
                                            'value' => 'title',
                                            'auto' => true
                                        ],
                                        [
                                            'type' => 'radio_btn',
                                            'title' => '預覽',
                                            'value' => 'is_preview',
                                            'default' => 1,
                                        ],
                                        [
                                            'type' => 'radio_btn',
                                            'title' => '是否顯示',
                                            'value' => 'is_visible'
                                        ]
                                    ],
                                    'tabSet' => [
                                        [
                                            'title' => '內容編輯',
                                            'content' => [

                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'title',
                                                    'title' => '表頭名稱',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],

                                            ],
                                        ],
                                        [
                                            'title' => '子表頭(雙層表頭用)',
                                            'content' => [],
                                            'is_three' => 'yes',
                                            'create' => 'yes',
                                            'delete' => 'yes',
                                            'copy' => 'yes',
                                            'sort_field' => '', //自訂排序欄位
                                            'three_model' => 'AFormHeadSub',
                                            'three' => [
                                                'SecondIdColumn' => 'head_id',
                                                'title' => '子表頭編輯',
                                                'tip' => '',
                                                'three_tableSet' => [
                                                    [
                                                        'type' => 'just_show',
                                                        'title' => '子表頭名稱',
                                                        'value' => 'title',
                                                        'auto' => true
                                                    ],
                                                ],
                                                'three_content' => [

                                                    [
                                                        'type' => 'textInput',
                                                        'value' => 'title',
                                                        'title' => '子表頭名稱',
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
                                ])}}

                            @endif

                            @if($formKey == 'Form_tabSEO')
                                @include('Fantasy.cms_view.includes.seo_form')
                            @endif
                            {{-- @if($formKey == 'Form1')
                                {{ UnitMaker::WNsonTable([
                                    'sort' => 'yes', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '表頭編輯',
                                    'create' => 'yes', //是否可新增
                                    'delete' => 'yes', //是否可刪除
                                    'copy' => 'yes', //是否可複製
                                    'MultiImgcreate' => 'no', //使用多筆圖片
                                    'imageColumn' => 'imageGroup', //預設圖片欄位
                                    'SecondIdColumn' => 'form_id',
                                    'value' => !empty($associationData['son']['AFormData']) ? $associationData['son']['AFormData'] : [],
                                    'name' => 'AFormData',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '表頭名稱',
                                            'value' => 'title',
                                            'auto' => true
                                        ],
                                        [
                                            'type' => 'radio_btn',
                                            'title' => '預覽',
                                            'value' => 'is_preview',
                                            'default' => 1,
                                        ],
                                        [
                                            'type' => 'radio_btn',
                                            'title' => '是否顯示',
                                            'value' => 'is_visible'
                                        ]
                                    ],
                                    'tabSet' => [
                                        [
                                            'title' => '內容編輯',
                                            'content' => [

                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'title',
                                                    'title' => '資料名稱(第一欄)',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                ],

                                            ],
                                        ],
                                    ],
                                ])}}
                            @endif --}}
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
