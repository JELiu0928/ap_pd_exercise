                            {{ UnitMaker::imageGroup([
                                'title' => '{$title}',
                                'image_array' => [
                                    [
                                        'name' => $model . '[{$name}]',
                                        'title' => '電腦版',
                                        'value' => !empty($data['{$name}']) ? $data['{$name}'] : '',
                                        'set_size' => 'yes',
                                        'width' => '400',
                                        'height' => '370',
                                    ],
                                    [
                                        'name' => $model . '[{$name}_m]',
                                        'title' => '手機版',
                                        'value' => !empty($data['{$name}_m']) ? $data['{$name}_m'] : '',
                                        'set_size' => 'yes',
                                        'width' => '400',
                                        'height' => '370',
                                    ]
                                ],
                                'tip' => '{$tip}<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                            ]) }}