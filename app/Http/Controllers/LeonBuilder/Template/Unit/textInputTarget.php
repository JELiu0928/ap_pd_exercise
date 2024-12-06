                                {{ UnitMaker::textInputTarget([
                                    'name' => $model . '[{$name}]',
                                    'title' => '{$title}',
                                    'tip' => '{$tip}',
                                    'value' => !empty($data['{$name}']) ? $data['{$name}'] : '',
                                    'disabled' => '{$disabled}',
                                    'class' => '',
                                    'target' => ['name' => $model . '[{$name}_target]', 'value' => $data['{$name}_target'] ?? ''],
                                ]) }}