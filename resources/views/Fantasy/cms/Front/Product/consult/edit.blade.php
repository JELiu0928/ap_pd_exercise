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
                            @if ($formKey == 'FormContent')
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[is_read]',
                                    'title' => '是否已處理',
                                    'tip' => 'none',
                                    'value' => $data['is_read'] ?? '0',
                                ]) }}
                                {{ UnitMaker::textArea([
                                    'name' => $model . '[other_require]',
                                    'title' => '其他需求',
                                    'tip' => 'none',
                                    'value' => !empty($data['other_require']) ? $data['other_require'] : '',
                                    'disabled' => true,
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[companyName]',
                                    'title' => '公司名稱',
                                    'tip' => 'none',
                                    'value' => !empty($data['companyName']) ? $data['companyName'] : '',
                                    'disabled' => true,
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[job]',
                                    'title' => '主要職務',
                                    'tip' => 'none',
                                    'value' => !empty($data['job']) ? $data['job'] : '',
                                    'disabled' => true,
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[name]',
                                    'title' => '姓名',
                                    'tip' => 'none',
                                    'value' => !empty($data['name']) ? $data['name'] : '',
                                    'disabled' => true,
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[service]',
                                    'title' => '稱謂',
                                    'tip' => 'none',
                                    'value' => !empty($data['service']) ? $data['service'] : '',
                                    'disabled' => true,
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[mail]',
                                    'title' => '電子信箱',
                                    'tip' => 'none',
                                    'value' => !empty($data['mail']) ? $data['mail'] : '',
                                    'disabled' => true,
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[tel]',
                                    'title' => '電話',
                                    'tip' => 'none',
                                    'value' => !empty($data['tel']) ? $data['tel'] : '',
                                    'disabled' => true,
                                ]) }}
                                {{ UnitMaker::textArea([
                                    'name' => $model . '[description]',
                                    'title' => '備註',
                                    'tip' => 'none',
                                    'value' => !empty($data['description']) ? $data['description'] : '',
                                    'disabled' => true,
                                ]) }}
                            @endif


                            @php
                                $secondTable = M('ProductConsultList')
                                    ::where('consult_id', $data['id'])
                                    ->with('ProductItemPart.ProductItem')
                                    ->get();
                                // dd($secondTable);
                                foreach ($secondTable as $consult) {
                                    $consult->part_title = $consult->ProductItemPart
                                        ? $consult->ProductItemPart['title']
                                        : '';
                                    $consult->item_title = $consult->ProductItemPart->ProductItem
                                        ? $consult->ProductItemPart->ProductItem['simple_title']
                                        : '';
                                }

                            @endphp
                            @if ($formKey == 'AskProduct')
                                {{ UnitMaker::WNsonTable([
                                    'sort' => 'no', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '',
                                    'hidden_create' => 'no', //是否可新增
                                    'create' => 'no', //是否可新增
                                    'delete' => 'no', //是否可刪除
                                    'copy' => 'no', //是否可複製
                                    'MultiImgcreate' => 'no', //使用多筆圖片
                                    'imageColumn' => 'img', //預設圖片欄位
                                    'SecondIdColumn' => 'consult_id',
                                    'value' => !empty($secondTable) ? $secondTable : [],
                                    'name' => 'ProductConsultList',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '次項目名稱',
                                            'value' => 'part_title',
                                            'auto' => true,
                                            'disabled' => true,
                                        ],
                                    ],
                                    'tabSet' => [
                                        [
                                            'title' => '內容',
                                            'content' => [
                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'item_title',
                                                    'title' => '主項目',
                                                    'tip' => 'none',
                                                    'auto' => true,
                                                    'disabled' => true,
                                                ],
                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'part_title',
                                                    'title' => '次項目',
                                                    'tip' => 'none',
                                                    'auto' => true,
                                                    'disabled' => true,
                                                ],
                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'description',
                                                    'title' => '備註',
                                                    'tip' => 'none',
                                                    'auto' => true,
                                                    'disabled' => true,
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) }}
                            @endif
                            {{-- @if ($formKey == 'ContactJob')
                                {{ UnitMaker::WNsonTable([
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
                                ]) }}
                            @endif --}}
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
