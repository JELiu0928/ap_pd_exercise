{{-- 表名跟哪一筆資料 --}}
<form id="{{ $formKey }}">
    <input name="modelName" type="hidden" value="{{ $model }}" data-id='{{ $data['id'] ?? 0 }}'>

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
                                {{-- @if ($role['need_review'] && $role['can_review'])
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
                                ]) }} --}}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[title]',
                                    'title' => '標題',
                                    'tip' => '',
                                    'value' => !empty($data['title']) ? $data['title'] : '',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[subtitle]',
                                    'title' => '副標題',
                                    'tip' => '',
                                    'value' => !empty($data['subtitle']) ? $data['subtitle'] : '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[title_color]',
                                    'title' => 'banner標題顏色',
                                    'value' => !empty($data['title_color']) ? $data['title_color'] : '',
                                    'options' => [
                                        ['key' => 'black', 'title' => '黑色'],
                                        ['key' => 'white', 'title' => '白色'],
                                        ['key' => 'gradient', 'title' => '漸層'],
                                    ],
                                    'tip' => '預設選項為黑色。',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[subtitle_color]',
                                    'title' => '副標題顏色',
                                    'value' => !empty($data['subtitle_color']) ? $data['subtitle_color'] : '',
                                    'options' => [
                                        ['key' => 'black', 'title' => '黑色'],
                                        ['key' => 'white', 'title' => '白色'],
                                        ['key' => 'gradient', 'title' => '漸層'],
                                    ],
                                    'tip' => '預設選項為黑色。',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[text_align]',
                                    'title' => 'banner文字對齊方式',
                                    'value' => !empty($data['text_align']) ? $data['text_align'] : '',
                                    'options' => [
                                        ['key' => 'left', 'title' => '置左'],
                                        ['key' => 'center', 'title' => '置中'],
                                        ['key' => 'right', 'title' => '置右'],
                                    ],
                                    'tip' => '預設選項為置左。',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::imageGroup([
                                    'title' => 'banner圖片',
                                    'image_array' => [
                                        [
                                            'name' => $model . '[banner_pc_img]',
                                            'title' => '電腦版',
                                            'value' => !empty($data['banner_pc_img']) ? $data['banner_pc_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '2880',
                                            'height' => '750',
                                        ],
                                        [
                                            'name' => $model . '[banner_pad_img]',
                                            'title' => '平板',
                                            'value' => !empty($data['banner_pad_img']) ? $data['banner_pad_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '1537',
                                            'height' => '675',
                                        ],
                                        [
                                            'name' => $model . '[banner_m_img]',
                                            'title' => '手機版',
                                            'value' => !empty($data['banner_m_img']) ? $data['banner_m_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '560',
                                            'height' => '675',
                                        ],
                                    ],
                                    'tip' =>
                                        '圖片建議尺寸: 電腦 2880x750(px), 平板 1535x675(px), 手機 560x675(px)<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[content_subtitle]',
                                    'title' => '內容副標題',
                                    'tip' => '',
                                    'value' => !empty($data['content_subtitle']) ? $data['content_subtitle'] : '',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[content_title]',
                                    'title' => '內容標題',
                                    'tip' => '',
                                    'value' => !empty($data['content_title']) ? $data['content_title'] : '',
                                ]) }}
                            @endif
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
