                                
                                @if($role['need_review'] && $role['can_review'])
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[{$name}]',
                                    'title' => '{$title}',
                                    'tip' => '{$tip}',
                                    'value' => !empty($data['{$name}']) ? $data['{$name}'] : '',
                                    'disabled' => '{$disabled}',
                                    'class' => '',
                                ]) }}
                                @endif