{{-- 表名跟哪一筆資料 --}}
<form id="{{ $formKey }}">
    <input name="modelName" type="hidden" value="{{ $model }}">

    <div class="backEnd_quill">
        <article class="work_frame">
            <section class="content_box">
                <div class="for_ajax_content">
                    <section class="content_a">
                        <ul class="frame">

                            @if ($formKey == 'search')
                            @endif
                            @if ($formKey == 'batch')
                            @endif
                            @if ($formKey == 'ContactJob')
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
                                    'title' => '職務名稱',
                                    'tip' => '',
                                    'value' => !empty($data['title']) ? $data['title'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                    'verify' => ['except' => ';/?:@=&<>"#%{}|\^~[]`', 'requiredIf' => [$model . '[w_rank]' => '1']],
                                ]) }}
                                {{-- {{ UnitMaker::WNsonTable([
                                    'sort' => 'yes', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '',
                                    'hidden_create' => 'yes', //是否可新增
                                    'create' => 'yes', //是否可新增
                                    'delete' => 'yes', //是否可刪除
                                    'copy' => 'yes', //是否可複製
                                    'MultiImgcreate' => 'no', //使用多筆圖片
                                    'imageColumn' => 'img', //預設圖片欄位
                                    'SecondIdColumn' => 'parent_id',
                                    'value' => !empty($associationData['son']['ContactJob']) ? $associationData['son']['ContactJob'] : [],
                                    'name' => 'ContactJob',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '職稱',
                                            'value' => 'title',
                                            'auto' => true,
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
                                            'value' => 'is_visible',
                                        ],
                                    ],
                                    'tabSet' => [
                                        [
                                            'title' => '內容編輯',
                                            'content' => [
                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'title',
                                                    'title' => '職稱',
                                                    'tip' => '',
                                                    'auto' => true,
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) }} --}}
                            @endif
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
