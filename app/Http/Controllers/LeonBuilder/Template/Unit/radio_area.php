                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[{$name}]',
                                    'title' => '{$title}',
                                    'value' => !empty($data['{$name}']) ? $data['{$name}'] : '',
                                    'options' => {$options},
                                    'tip' => '{$tip}',
                                    'disabled' => '{$disabled}',
                                ]) }}