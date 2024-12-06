                                {{ UnitMaker::WNsonTable([
                                    'sort' => '{$sort}', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '{$title}',
                                    'create' => '{$create}', //是否可新增
                                    'delete' => '{$delete}', //是否可刪除
                                    'copy' => '{$copy}', //是否可複製
                                    'MultiImgcreate' => '{$MultiImgcreate}', //使用多筆圖片
                                    'imageColumn' => 'imageGroup', //預設圖片欄位
                                    'SecondIdColumn' => 'parent_id',
                                    'value' => !empty($associationData['son']['{$son_model}']) ? $associationData['son']['{$son_model}'] : [],
                                    'name' => '{$son_model}',
                                    'tableSet' => [
                                        {$tableSet}
                                    ],
                                    'tabSet' => [
                                        [
                                            'title' => '內容編輯',
                                            'content' => [
                                                {$son_unit}
                                            ],
                                        ],
										{$three_unit}
                                    ],
                                ])}}