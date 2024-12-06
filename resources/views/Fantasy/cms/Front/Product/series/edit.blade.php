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
                            @if ($formKey == 'MainForm')
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
                                {{ UnitMaker::select2([
                                    'name' => $model . '[category_id]',
                                    'title' => '類別',
                                    'value' => !empty($data['category_id']) ? $data['category_id'] : '',
                                    'options' => M('ProductCategory')::getList(),
                                    'tip' => '請選擇所屬類別',
                                    'disabled' => '',
                                ]) }}
                                {{-- @dd(M('ProductCategory')::getList()) --}}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[title]',
                                    'title' => '標題',
                                    'tip' => '',
                                    'value' => !empty($data['title']) ? $data['title'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                            @endif
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
