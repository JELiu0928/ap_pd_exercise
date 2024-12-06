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
                                    'title' => '產品名稱',
                                    'tip' => '',
                                    'value' => !empty($data['title']) ? $data['title'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{-- {{ UnitMaker::select2([
                                    'name' => $model . '[form_id]',
                                    'title' => '表格選用',
                                    'value' => !empty($data['form_id']) ? $data['form_id'] : '',
                                    'options' => config('models.AForm')::getList(),
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }} --}}

                            @endif
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
