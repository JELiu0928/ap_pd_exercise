                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[{$name}]',
                                    'title' => '{$title}',
                                    'tip' => '{$tip}',
                                    'value' => !empty($data['{$name}']) ? $data['{$name}'] : '',
                                    'disabled' => '{$disabled}',
                                    'class' => '',
                                ]) }}