{{-- 表名跟哪一筆資料 --}}
<form id="{{ $formKey }}">
    <input name="modelName" type="hidden" value="{{ $model }}">

    <div class="backEnd_quill">
        <article class="work_frame">
            <section class="content_box">
                <div class="for_ajax_content">
                    <section class="content_a">
                        <ul class="frame">
                            @php
                                $getList = [
                                    1 => ['key' => '1', 'title' => '分類1'],
                                    2 => ['key' => '2', 'title' => '分類2'],
                                    3 => ['key' => '3', 'title' => '分類3'],
                                    4 => ['key' => '4', 'title' => '分類4'],
                                    5 => ['key' => '5', 'title' => '分類5'],
                                    6 => ['key' => '6', 'title' => '分類6'],
                                    7 => ['key' => '7', 'title' => '分類7'],
                                    8 => ['key' => '8', 'title' => '分類8'],
                                    9 => ['key' => '9', 'title' => '分類9'],
                                    10 => ['key' => '10', 'title' => '分類10'],
                                    11 => ['key' => '11', 'title' => '分類11'],
                                    12 => ['key' => '12', 'title' => '分類12'],
                                    13 => ['key' => '13', 'title' => '分類13'],
                                    14 => ['key' => '14', 'title' => '分類14'],
                                ];
                                $getListMuti = [
                                    1 => ['key' => '1', 'title' => '多筆分類1'],
                                    2 => ['key' => '2', 'title' => '多筆分類2'],
                                    3 => ['key' => '3', 'title' => '多筆分類3'],
                                    4 => ['key' => '4', 'title' => '多筆分類4'],
                                ];
                            @endphp
                            @if ($formKey == 'search')
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[textInput]',
                                    'title' => 'textInput',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                                {{ UnitMaker::numberInput([
                                    'name' => $model . '[w_rank]',
                                    'title' => '排序',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[radio_area]',
                                    'title' => 'radio_area',
                                    'value' => '',
                                    'options' => OptionFunction::Datalist_radio_area(),
                                    'tip' => '',
                                ]) }}
                                {{ UnitMaker::select2([
                                    'name' => $model . '[select2]',
                                    'title' => 'select2',
                                    'value' => '',
                                    // 'options' => M('Dataoption')::getList(),
                                    'options' => $getList,
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::select2Multi([
                                    'name' => $model . '[select2Multi]',
                                    'title' => 'select2Multi',
                                    'value' => '',
                                    // 'options' => M('Dataoption')::getList(),
                                    'options' => $getListMuti,
                                    'tip' => '',
                                    'disabled' => '',
                                    'isAll' => true,
                                ]) }}
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[is_visible]',
                                    'title' => '是否顯示',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                                {{ UnitMaker::numberInput([
                                    'name' => $model . '[numberInput]',
                                    'title' => 'numberInput',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                                {{ UnitMaker::colorPicker([
                                    'name' => $model . '[colorPicker]',
                                    'title' => 'colorPicker',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                            @endif
                            @if ($formKey == 'batch')
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[textInput]',
                                    'title' => 'textInput',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                                {{ UnitMaker::radio_btn([
                                    'name' => $model . '[radio_btn]',
                                    'title' => 'radio_btn',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                                {{ UnitMaker::select2([
                                    'name' => $model . '[select2]',
                                    'title' => 'select2',
                                    'value' => '',
                                    // 'options' => M('Dataoption')::getList(),
                                    'options' => $getList,
                                    'tip' => '',
                                    'disabled' => '',
                                ]) }}
                                {{ UnitMaker::select2Multi([
                                    'name' => $model . '[select2Multi]',
                                    'title' => 'select2Multi',
                                    'value' => !empty($data['select2Multi']) ? $data['select2Multi'] : '',
                                    // 'options' => M('Dataoption')::getList(),
                                    'options' => $getListMuti,
                                    'tip' => '',
                                    'isAll' => true,
                                ]) }}
                                {{ UnitMaker::imageGroup([
                                    'title' => 'imageGroup',
                                    'image_array' => [
                                        [
                                            'name' => $model . '[o_img]',
                                            'title' => '電腦版',
                                            'value' => !empty($data['o_img']) ? $data['o_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '400',
                                            'height' => '370',
                                        ],
                                        [
                                            'name' => $model . '[o_img_m]',
                                            'title' => '手機版',
                                            'value' => !empty($data['o_img_m']) ? $data['o_img_m'] : '',
                                            'set_size' => 'yes',
                                            'width' => '400',
                                            'height' => '370',
                                        ],
                                    ],
                                    'tip' => '<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                ]) }}
                                {{ UnitMaker::textArea([
                                    'name' => $model . '[textArea]',
                                    'title' => 'textArea',
                                    'tip' => '',
                                    'value' => '',
                                ]) }}
                            @endif
                            {{-- 基本設定 --}}
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
                                {{ UnitMaker::numberInput([
                                    'name' => $model . '[w_rank]',
                                    'title' => '排序',
                                    'tip' => '顯示排序，由小至大；輸入 0 為置頂，排序將超越 1；多筆設定為 0 ，最後排序將取決於資料建立日期',
                                    'value' => !empty($data['w_rank']) ? $data['w_rank'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }}
                                {{ UnitMaker::textSummernote([
                                    'name' => $model . '[banner_title]',
                                    'title' => '標題',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['banner_title']) ? $data['banner_title'] : '',
                                    'toolbar' => 'simple',
                                ]) }}
                                {{ UnitMaker::textSummernote([
                                    'name' => $model . '[banner_intro]',
                                    'title' => '簡述',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['banner_intro']) ? $data['banner_intro'] : '',
                                    'toolbar' => 'simple',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[url_name]',
                                    'title' => '網址名稱',
                                    'tip' =>
                                        '此文章網址名稱，可使用中文，請輸入分類後網址<br>例如：' .
                                        BaseFunction::b_url('news') .
                                        '?category=<strong style="color: red;">abc123</strong>，填入 abc123<br><strong style="color: red;">不可留白有空格、不可重複、不可使用特殊符號如「;　/　?　:　@　=　&　<　>　"　#　%　{　}　|　\　^　~　[　]　`　」</strong><br><strong style="color: red;">網址名稱不能重複，若重複將有可能造成搜尋上的錯誤</strong><br>如果有多語系，請統一各語系的網址名稱（選擇一個主要的語系的網址名稱做代表，ex：英文），否則無法實現同一頁面切換語系的功能。<br>未輸入將產生隨機文字。',
                                    'value' => !empty($data['url_name']) ? $data['url_name'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                    'verify' => [
                                        'required' => null,
                                        // 'requiredIf' => [$model . '[is_visible]' => '1'],
                                        // 'unique' => M('NewsCategory')::getUrlName($data['url_name'] ?? ''),
                                    ],
                                ]) }}
                                {{ UnitMaker::imageGroup([
                                    'title' => '列表圖片',
                                    'image_array' => [
                                        [
                                            'name' => $model . '[list_img]',
                                            'title' => '',
                                            'value' => !empty($data['list_img']) ? $data['list_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '650',
                                            'height' => '450',
                                        ],
                                    ],
                                    'tip' => '建議尺寸：650 x 450 像素，圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                ]) }}
                                {{-- {{ UnitMaker::radio_btn([
                                    'name' => $model . '[is_list_img_show]',
                                    'title' => '是否顯示列表圖片',
                                    'tip' => '',
                                    'value' => !empty($data['is_list_img_show']) ? $data['is_list_img_show'] : '',
                                    'disabled' => '',
                                    'class' => '',
                                ]) }} --}}
                            @endif


                            @if ($formKey == 'ProductInner')
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[banner_title_color]',
                                    'title' => 'banner標題顏色',
                                    'value' => '',
                                    'options' => [
                                        ['key' => 'black', 'title' => '黑色'],
                                        ['key' => 'white', 'title' => '白色'],
                                        ['key' => 'gradient', 'title' => '漸層'],
                                    ],
                                    'tip' => '',
                                    'value' => !empty($data['banner_title_color']) ? $data['banner_title_color'] : '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[banner_intro_color]',
                                    'title' => 'banner簡述顏色',
                                    'value' => '',
                                    'options' => [
                                        [
                                            'key' => 'black',
                                            'title' => '黑色',
                                        ],
                                        [
                                            'key' => 'white',
                                            'title' => '白色',
                                        ],
                                    ],
                                    'tip' => '',
                                    'value' => !empty($data['banner_intro_color']) ? $data['banner_subtitle_color'] : '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[banner_text_location]',
                                    'title' => 'banner文字位置',
                                    'value' => '',
                                    'options' => [
                                        ['key' => 'left', 'title' => '置左'],
                                        ['key' => 'center', 'title' => '置中'],
                                        ['key' => 'right', 'title' => '置右'],
                                    ],
                                    'tip' => '',
                                    'value' => !empty($data['banner_text_location']) ? $data['banner_text_location'] : '',
                                ]) }}
                                {{ UnitMaker::imageGroup([
                                    'title' => 'banner',
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
                                            'width' => '1535',
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
                                        '電腦版建議尺寸：2880 x 750 像素<br>平板建議尺寸：1535 x 675 像素<br>手機版建議尺寸：560 x 675 像素<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                ]) }}
                                {{ UnitMaker::imageGroup([
                                    'title' => '產品圖片',
                                    'image_array' => [
                                        [
                                            'name' => $model . '[product_pc_img]',
                                            'title' => '電腦版',
                                            'value' => !empty($data['product_pc_img']) ? $data['product_pc_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '1080',
                                            'height' => '675',
                                        ],
                                        [
                                            'name' => $model . '[product_m_img]',
                                            'title' => '手機版',
                                            'value' => !empty($data['product_m_img']) ? $data['product_m_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '500',
                                            'height' => '315',
                                        ],
                                    ],
                                    'tip' =>
                                        '電腦版建議尺寸：1080 x 675 像素<br>手機版建議尺寸：500 x 315 像素。<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[banner_keyword_title]',
                                    'title' => 'banner關鍵字區標題',
                                    'tip' => '',
                                    'value' => !empty($data['banner_keyword_title']) ? $data['banner_keyword_title'] : '',
                                ]) }}
                                {{ UnitMaker::textSummernote([
                                    'name' => $model . '[banner_keyword_intro]',
                                    'title' => 'banner關鍵字區簡述',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['banner_keyword_intro']) ? $data['banner_keyword_intro'] : '',
                                    'toolbar' => 'simple',
                                ]) }}

                                <h5 style="margin-top: 1rem;font-weight: bold;">關鍵字標籤</h5>
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
                                    'SecondIdColumn' => 'item_id',
                                    'value' => !empty($associationData['son']['ProductItemKeyword'])
                                        ? $associationData['son']['ProductItemKeyword']
                                        : [],
                                    'name' => 'ProductItemKeyword',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '標題',
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
                                                    'title' => '標題',
                                                    'tip' => '',
                                                    'auto' => true,
                                                ],
                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'link',
                                                    'title' => '連結網址',
                                                    'tip' =>
                                                        '站內請填寫語系後的內容(包含語系)，如: /tw/product  |  站外請填寫完整網址，如: https://www.google.com.tw',
                                                    'auto' => true,
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) }}
                            @endif
                            @if ($formKey == 'article')
                                @include('Fantasy.cms_view.back_article_v3', [
                                    'Model' => 'ProductArticle',
                                    'ThreeModel' => 'ProductArticleImg',
                                ])
                            @endif
                            {{-- 產品概述彈性區 --}}
                            @if ($formKey == 'Overview')
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[overview_title]',
                                    'title' => '標題',
                                    'tip' => '',
                                    'value' => !empty($data['overview_title']) ? $data['overview_title'] : '',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[overview_intro]',
                                    'title' => '簡述',
                                    'tip' => '',
                                    'value' => !empty($data['overview_intro']) ? $data['overview_intro'] : '',
                                ]) }}
                                {{-- {{ UnitMaker::textSummernote([
                                    'name' => $model . '[overview_content_title]',
                                    'title' => '內容標題',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['overview_content_title']) ? $data['overview_content_title'] : '',
                                    'toolbar' => 'simple',
                                ]) }}
                                {{ UnitMaker::textSummernote([
                                    'name' => $model . '[series_intro]',
                                    'title' => '內容簡述',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['series_intro']) ? $data['series_intro'] : '',
                                    'toolbar' => 'simple',
                                ]) }} --}}
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
                                    'MultiImgcreate' => 'yes', //使用多筆圖片
                                    'imageColumn' => 'img', //預設圖片欄位
                                    'SecondIdColumn' => 'category_id', //關聯鍵
                                    'value' => !empty($associationData['son']['ProductCategoryOverview'])
                                        ? $associationData['son']['ProductCategoryOverview']
                                        : [],
                                    'name' => 'ProductCategoryOverview',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '標題',
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
                                                    'type' => 'textSummernote',
                                                    'value' => 'title',
                                                    'title' => '標題',
                                                    'tip' => '',
                                                    'auto' => true,
                                                    'toolbar' => 'simple',
                                                ],
                                                [
                                                    'type' => 'textSummernote',
                                                    'value' => 'intro',
                                                    'title' => '簡述',
                                                    'tip' => '',
                                                    'auto' => true,
                                                    'toolbar' => 'simple',
                                                ],
                                                [
                                                    'type' => 'radio_area',
                                                    'value' => 'type',
                                                    'title' => '圖片位置',
                                                    'tip' => '',
                                                    'options' => [
                                                        ['key' => 0, 'title' => '置左'],
                                                        ['key' => 1, 'title' => '置右'],
                                                        ['key' => 2, 'title' => '無圖'],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'image_group',
                                                    'title' => '概述區圖片',
                                                    'image_array' => [
                                                        [
                                                            'title' => '',
                                                            'value' => 'img',
                                                            'set_size' => 'yes',
                                                            'width' => '720',
                                                            'height' => '825',
                                                        ],
                                                    ],
                                                    'tip' => '建議尺寸：720 x 825 像素<br> 圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                                ],
                                                [
                                                    'type' => 'textInput',
                                                    'value' => 'img_intro',
                                                    'title' => '圖片描述',
                                                    'tip' => '',
                                                    'auto' => true,
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) }}
                            @endif
                            {{-- 產品優勢區 --}}
                            @if ($formKey == 'Advantages')
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[advantages_zone_title]',
                                    'title' => '標題',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['advantages_zone_title']) ? $data['advantages_zone_title'] : '',
                                    'toolbar' => 'simple',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[advantages_zone_intro]',
                                    'title' => '簡述',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['advantages_zone_intro']) ? $data['advantages_zone_intro'] : '',
                                    'toolbar' => 'simple',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[advantages_zone_title_color]',
                                    'title' => '標題顏色',
                                    'value' => '',
                                    'options' => [
                                        ['key' => 'black', 'title' => '黑色'],
                                        ['key' => 'white', 'title' => '白色'],
                                        ['key' => 'gradient', 'title' => '漸層'],
                                    ],
                                    'tip' => '若無選擇背景圖，標題顏色若選擇白色，前台將自動顯示為黑色',
                                    'value' => !empty($data['advantages_zone_title_color']) ? $data['advantages_zone_title_color'] : '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[advantages_zone_intro_color]',
                                    'title' => '簡述顏色',
                                    'value' => '',
                                    'options' => [
                                        [
                                            'key' => 'black',
                                            'title' => '黑色',
                                        ],
                                        [
                                            'key' => 'white',
                                            'title' => '白色',
                                        ],
                                    ],
                                    'tip' => '若無選擇背景圖，前台將自動顯示為黑色',
                                    'value' => !empty($data['advantages_zone_intro_color']) ? $data['advantages_zone_intro_color'] : '',
                                ]) }}
                                {{ UnitMaker::radio_area([
                                    'name' => $model . '[advantages_zone_bg_color]',
                                    'title' => '背景顏色',
                                    'value' => '',
                                    'options' => [
                                        [
                                            'key' => 'white',
                                            'title' => '白色',
                                        ],
                                        [
                                            'key' => 'gray',
                                            'title' => '灰色',
                                        ],
                                    ],
                                    'tip' => '',
                                    'value' => !empty($data['advantages_zone_bg_color']) ? $data['advantages_zone_bg_color'] : '',
                                ]) }}
                                {{ UnitMaker::imageGroup([
                                    'title' => '背景圖片',
                                    'image_array' => [
                                        [
                                            'name' => $model . '[advantages_zone_img]',
                                            'title' => '',
                                            'value' => !empty($data['advantages_zone_img']) ? $data['advantages_zone_img'] : '',
                                            'set_size' => 'yes',
                                            'width' => '1440',
                                            'height' => '1315',
                                        ],
                                    ],
                                    'tip' => '建議尺寸：1440 x 1315 像素，圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。',
                                ]) }}
                                {{ UnitMaker::WNsonTable([
                                    'sort' => 'yes', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '',
                                    'create' => 'yes', //是否可新增
                                    'delete' => 'yes', //是否可刪除
                                    'copy' => 'yes', //是否可複製
                                    'MultiImgcreate' => 'yes', //使用多筆圖片
                                    'imageColumn' => 'imageGroup', //預設圖片欄位
                                    'SecondIdColumn' => 'category_id', //第二層與第一層關聯
                                    'value' => !empty($associationData['son']['ProductCategoryAdvantagesTags'])
                                        ? $associationData['son']['ProductCategoryAdvantagesTags']
                                        : [], //第二層
                                    'name' => 'ProductCategoryAdvantagesTags',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '標題',
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
                                            'title' => '名稱編輯',
                                            'content' => [
                                                [
                                                    'type' => 'textSummernote',
                                                    'value' => 'title',
                                                    'title' => '標題',
                                                    // 'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                    'toolbar' => 'simple',
                                                ],
                                            ],
                                        ],
                                        [
                                            'title' => '內容編輯',
                                            'content' => [],
                                            'is_three' => 'yes',
                                            'create' => 'yes',
                                            'delete' => 'yes',
                                            'copy' => 'yes',
                                            'sort_field' => '', //自訂排序欄位
                                            'three_model' => 'ProductCategoryAdvantagesLists', //第三層關聯
                                            'three' => [
                                                'SecondIdColumn' => 'tag_id', //第三層與第二層關聯
                                                'title' => 'ProductCategoryAdvantagesLists',
                                                'tip' => '',
                                                'three_tableSet' => [
                                                    [
                                                        'type' => 'just_show',
                                                        'title' => '標題',
                                                        'value' => 'title',
                                                        'auto' => true,
                                                    ],
                                                ],
                                                'three_content' => [
                                                    [
                                                        'type' => 'textInput',
                                                        'value' => 'title',
                                                        'title' => '標題',
                                                        'tip' => '',
                                                        'default' => '',
                                                        'auto' => true,
                                                        'disabled' => '',
                                                        'class' => '',
                                                    ],
                                                    [
                                                        'type' => 'textSummernote',
                                                        'value' => 'intro',
                                                        'title' => '簡述',
                                                        'tip' => '',
                                                        'default' => '',
                                                        'auto' => true,
                                                        'disabled' => '',
                                                        'toolbar' => 'simple',
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) }}
                            @endif
                            @if ($formKey == 'CategorySeries')
                                {{ UnitMaker::textSummernote([
                                    'name' => $model . '[series_zone_title]',
                                    'title' => '標題',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['series_zone_title']) ? $data['series_zone_title'] : '',
                                    'toolbar' => 'simple',
                                ]) }}
                                {{ UnitMaker::textSummernote([
                                    'name' => $model . '[series_zone_intro]',
                                    'title' => '敘述',
                                    'tip' =>
                                        '單行輸入，如需使用上標，請使用&lt;sup&gt;內容&lt;/sup&gt;，內容不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。<br>同內頁banner標題。',
                                    'value' => !empty($data['series_zone_intro']) ? $data['series_zone_intro'] : '',
                                    'toolbar' => 'simple',
                                ]) }}
                                {{ UnitMaker::WNsonTable([
                                    'sort' => 'yes', //是否可以調整順序
                                    'sort_field' => 'w_rank', //自訂排序欄位
                                    'teach' => 'no',
                                    'hasContent' => 'yes', //是否可展開
                                    'tip' => '',
                                    'create' => 'yes', //是否可新增
                                    'delete' => 'yes', //是否可刪除
                                    'copy' => 'yes', //是否可複製
                                    'MultiImgcreate' => 'yes', //使用多筆圖片
                                    'imageColumn' => 'imageGroup', //預設圖片欄位
                                    'SecondIdColumn' => 'category_id',
                                    'value' => !empty($associationData['son']['ProductCategoryOverviewList'])
                                        ? $associationData['son']['ProductCategoryOverviewList']
                                        : [],
                                    'name' => 'ProductCategoryOverviewList',
                                    'tableSet' => [
                                        [
                                            'type' => 'just_show',
                                            'title' => '系列標題',
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
                                                    'type' => 'textSummernote',
                                                    'value' => 'title',
                                                    'title' => '系列標題',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                    'toolbar' => 'simple',
                                                ],
                                                [
                                                    'type' => 'textSummernote',
                                                    'value' => 'intro',
                                                    'title' => '系列簡述',
                                                    'tip' => '',
                                                    'default' => '',
                                                    'auto' => true,
                                                    'disabled' => '',
                                                    'class' => '',
                                                    'toolbar' => 'simple',
                                                ],
                                            ],
                                        ],
                                    ],
                                ]) }}
                            @endif
                            @if ($formKey == 'CategoryProduct')
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[product_title]',
                                    'title' => '標題',
                                    'tip' => '',
                                    'value' => !empty($data['product_title']) ? $data['product_title'] : '',
                                ]) }}
                                {{ UnitMaker::textInput([
                                    'name' => $model . '[product_intro]',
                                    'title' => '簡述',
                                    'tip' => '',
                                    'value' => !empty($data['product_intro']) ? $data['product_intro'] : '',
                                ]) }}
                            @endif

                            @if ($formKey == 'Form_1')
                                @include('Fantasy.cms_view.back_article_v3', [
                                    'Model' => 'Elite_business_dept_content',
                                    'ThreeModel' => 'Elite_business_dept_content_img',
                                ])
                            @endif

                            @if ($formKey == 'SEOForm')
                                @include('Fantasy.cms_view.includes.seo_form')
                            @endif
                        </ul>
                    </section>
                </div>
            </section>
        </article>
    </div>
</form>
