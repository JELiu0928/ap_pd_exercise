@php
    $article_options = [
        // 樣式
        'Style' => [
            'typeBasic' => [
                'title' => '基本段落樣式，由上至下排列，依序為主標題 > 影像+描述 > 副標題 > 內文＋按鈕。',
                'key' => 'typeBasic',
            ],
            // 'typeSL'=> ["title" => "由上至下排列，依序為主標題 > 影像+描述 > 副標題置左 > 內文＋按鈕置右。","key" => 'typeSL'],
            // 'typeSR'=> ["title" => "由上至下排列，依序為主標題 > 影像+描述 > 副標題置右 > 內文＋按鈕置左。","key" => 'typeSR'],

            'typeU' => ['title' => '由上至下排列，依序為主標題 > 副標題 > 內文＋按鈕 > 影像+描述。', 'key' => 'typeU'],
            // 'typeUL'=> ["title" => "由上至下排列，依序為主標題置左 > 副標題 + 內文＋按鈕置右 > 影像+描述。","key" => 'typeUL'],
            // 'typeUR'=> ["title" => "由上至下排列，依序為主標題置右 > 副標題 + 內文＋按鈕置左 > 影像+描述。","key" => 'typeUR'],

            'typeD' => ['title' => '由上至下排列，依序為影像+描述 > 主標題 > 副標題 > 內文＋按鈕。', 'key' => 'typeD'],
            // 'typeDL'=> ["title" => "由上至下排列，依序為影像+描述 > 主標題置左 > 副標題 + 內文＋按鈕置右。","key" => 'typeDL'],
            // 'typeDR'=> ["title" => "由上至下排列，依序為影像+描述 > 主標題置右 > 副標題 + 內文＋按鈕置左。","key" => 'typeDR'],

            'typeL' => ['title' => '依序為主標題 + 副標題 + 內文＋按鈕置左 > 影像+描述置右。', 'key' => 'typeL'],
            'typeR' => ['title' => '依序為影像+描述置左 > 主標題 + 副標題 + 內文＋按鈕置右。', 'key' => 'typeR'],

            'typeLR' => ['title' => '依序為主標題 + 副標題 + 內文＋按鈕置左圍繞影像+描述置右。', 'key' => 'typeLR'],
            'typeRR' => ['title' => '依序為主標題 + 副標題 + 內文＋按鈕置右圍繞影像+描述置左。', 'key' => 'typeRR'],

            'typeF' => [
                'title' => '滿版背景，段落垂直置中，由上至下依序為影像+描述 > 主標題 > 副標題 > 內文＋按鈕。',
                'key' => 'typeF',
            ],
            'typeFL' => [
                'title' => '滿版背景，段落垂直置左，由上至下依序為影像+描述 > 主標題 > 副標題 > 內文＋按鈕。',
                'key' => 'typeFL',
            ],
            'typeFR' => [
                'title' => '滿版背景，段落垂直置右，由上至下依序為影像+描述 > 主標題 > 副標題 > 內文＋按鈕。',
                'key' => 'typeFR',
            ],

            'typeFBox' => [
                'title' =>
                    '滿版背景並使段落區塊中的內文區域產生色塊，段落垂直置中，由上至下依序為影像+描述 > 主標題 > 副標題 > 內文＋按鈕。',
                'key' => 'typeFBox',
            ],
            // 'typeFBoxL' => ['title' => '滿版背景並使段落區塊中的內文區域產生色塊，段落垂直置左，由上至下依序為影像+描述 > 主標題 > 副標題 > 內文＋按鈕。', 'key' => 'typeFBoxL'],
            // 'typeFBoxR' => ['title' => '滿版背景並使段落區塊中的內文區域產生色塊，段落垂直置右，由上至下依序為影像+描述 > 主標題 > 副標題 > 內文＋按鈕。', 'key' => 'typeFBoxR'],

            // '_article -typeFull-BoxSlice'=> ["title" => "滿版背景，區塊預設為左右置中對齊，段落區塊左右置中垂直切割區塊，，由上至下依序為主標題 > 影像+描述 > 副標題 > 內文＋按鈕。","key" => '_article -typeFull-BoxSlice'],
            // '_article -typeFull-BoxSlice-L'=> ["title" => "滿版背景，區塊預設為置左對齊，段落區塊置左垂直切割區塊，由上至下依序為主標題 > 影像+描述 > 副標題 > 內文＋按鈕。","key" => '_article -typeFull-BoxSlice-L'],
            // '_article -typeFull-BoxSlice-R'=> ["title" => "滿版背景，區塊預設為置右對齊，段落區塊置右垂直切割區塊，由上至下依序為主標題 > 影像+描述 > 副標題 > 內文＋按鈕。","key" => '_article -typeFull-BoxSlice-R'],

            // '_article -typeSwiper-L'=> ["title" => "設定段落為 Swiper 模式，段落內容由左至右依序為影像 > 主標題＋副標題＋內文＋按鈕","key" => '_article -typeSwiper-L'],
            // '_article -typeSwiper-R'=> ["title" => "設定段落為 Swiper 模式，段落內容由左至右依序為主標題＋副標題＋內文＋按鈕 > 影像","key" => '_article -typeSwiper-R'],

            // '_article -typeOverlap-LU'=> ["title" => "段落區塊由上至下編排，依序為影像*2-大圖置左小圖置右下 > 主標題 > 副標題 > 內文 > 按鈕","key" => '_article -typeOverlap-LU'],
            // '_article -typeOverlap-LD'=> ["title" => "段落區塊由上至下編排，依序為主標題 > 副標題 > 內文 > 按鈕 > 影像*2-大圖置左小圖置右上","key" => '_article -typeOverlap-LD'],
            // '_article -typeOverlap-RU'=> ["title" => "段落區塊由上至下編排，依序為影像*2-大圖置右小圖置左下 > 主標題 > 副標題 > 內文 > 按鈕","key" => '_article -typeOverlap-RU'],
            // '_article -typeOverlap-RD'=> ["title" => "段落區塊由上至下編排，依序為影像*2-大圖置右小圖置左上 > 主標題 > 副標題 > 內文 > 按鈕","key" => '_article -typeOverlap-RD'],
        ],
        //文字黑白色
        'textColor' => [
            '#000' => ['title' => '黑色', 'key' => '#000'],
            '#fff' => ['title' => '白色', 'key' => '#fff'],
        ],
        // 標題對齊設定
        'AlignHorizontal4Title' => [
            'left' => ['title' => '靠左對齊', 'key' => 'left'],
            'center' => ['title' => '置中', 'key' => 'center'],
            'right' => ['title' => '靠右對齊', 'key' => 'right'],
        ],

        // 副標題對齊設定
        'AlignHorizontal4SubTitle' => [
            'left' => ['title' => '靠左對齊', 'key' => 'left'],
            'center' => ['title' => '置中', 'key' => 'center'],
            'right' => ['title' => '靠右對齊', 'key' => 'right'],
        ],

        // 內文區塊對齊設定
        'AlignHorizontal4Text' => [
            'left' => ['title' => '靠左對齊', 'key' => 'left'],
            'center' => ['title' => '置中', 'key' => 'center'],
            'right' => ['title' => '靠右對齊', 'key' => 'right'],
        ],

        // 按鈕連結開啟方式
        'LinkType' => [
            '1' => ['key' => '1', 'title' => '本頁開啟'],
            '2' => ['key' => '2', 'title' => '另開新頁'],
        ],

        // 按鈕位置 - 對齊方式
        'AlignHorizontal4Btn' => [
            'left' => ['title' => '靠左對齊', 'key' => 'left'],
            'center' => ['title' => '置中', 'key' => 'center'],
            'right' => ['title' => '靠右對齊', 'key' => 'right'],
        ],

        // 影片來源
        'VideoType' => [
            'youtube' => ['title' => 'YouTube', 'key' => 'youtube', 'hidetip' => 'youku'],
            'youku' => ['title' => 'YOUKU', 'key' => 'youku', 'hidetip' => 'youtube'],
        ],

        // 圖片每列數量設定
        'isRow4Img' => [
            'x1' => ['title' => '一張圖', 'key' => 'x1'],
            'x2' => ['title' => '兩張圖', 'key' => 'x2'],
            'x3' => ['title' => '三張圖', 'key' => 'x3'],
            'x4' => ['title' => '四張圖', 'key' => 'x4'],
            'x5' => ['title' => '五張圖', 'key' => 'x5'],
        ],

        // 圖片比例設定
        'imgSize' => [
            '' => ['title' => '不指定', 'key' => ''],
            'x11' => ['title' => '1:1', 'key' => 'x11'],
            'x34' => ['title' => '3:4', 'key' => 'x34'],
            'x43' => ['title' => '4:3', 'key' => 'x43'],
            'x169' => ['title' => '16:9', 'key' => 'x169'],
        ],

        // 文字與圖片垂直對齊設定
        'AlignVertical4TextWithImg' => [
            'up' => ['title' => '置上', 'key' => 'up'],
            'center' => ['title' => '置中', 'key' => 'center'],
            'down' => ['title' => '置下', 'key' => 'down'],
        ],

        // 圖片垂直對齊設定
        'CommonAlignVertical4Img' => [
            'up' => ['title' => '置上', 'key' => 'up'],
            'center' => ['title' => '置中', 'key' => 'center'],
            'down' => ['title' => '置下', 'key' => 'down'],
        ],

        // 圖片描述文字對齊
        'CommonAlignHorizontal4ImgText' => [
            'left' => ['title' => '靠左對齊', 'key' => 'left'],
            'center' => ['title' => '置中', 'key' => 'center'],
            'right' => ['title' => '靠右對齊', 'key' => 'right'],
        ],

        // 圖片輪播 - 出現圖片數量
        'isRow4Swiper' => [
            'x1' => ['title' => '一張圖', 'key' => '1'],
            'x2' => ['title' => '兩張圖', 'key' => '2'],
            'x3' => ['title' => '三張圖', 'key' => '3'],
            'x4' => ['title' => '四張圖', 'key' => '4'],
            'x5' => ['title' => '五張圖', 'key' => '5'],
        ],

        // 內文寬度設定
        'fullSize' => [
            's' => ['title' => '小', 'key' => 's'],
            'm' => ['title' => '中', 'key' => 'm'],
            'l' => ['title' => '大', 'key' => 'l'],
        ],

        //手機版排版
        'mobileRWD' => [
            'off' => ['title' => '與電腦版順序一致', 'key' => 'off'],
            'on' => ['title' => '圖片統一置上', 'key' => 'on'],
        ],
        'BtnAction' => [
            '0' => ['title' => '超連結', 'key' => '0', 'hide' => 'button_file'],
            '1' => ['title' => '檔案下載', 'key' => '1', 'hide' => 'button_link'],
        ],
        'button_visible' => [
            '1' => ['title' => '是', 'key' => '1', 'hide' => ''],
            '0' => [
                'title' => '否',
                'key' => '0',
                'hide' =>
                    'button,button_action,button_link,button_file,button_align,button_textcolor,button_color,button_color_hover',
            ],
        ],
    ];
@endphp

{{ UnitMaker::WNsonTable([
    'sort' => 'yes', //是否可以調整順序
    'teach' => 'no',
    'hasContent' => 'yes', //是否可展開
    'tip' => '文章段落編輯',
    'sort_field' => 'w_rank',
    'copy' => 'yes',
    'create' => 'yes', //是否可新增
    'delete' => 'yes', //是否可刪除
    'SecondIdColumn' => 'parent_id',
    'value' => !empty($associationData['son'][$Model]) ? $associationData['son'][$Model] : [],
    'name' => $Model,
    'multiLocal' => $multiLocal ?? false,
    'tableSet' => [
        //tableSet元件
        [
            'type' => 'select_article4_show',
            'title' => '段落樣式',
            'value' => 'article_style',
            'options' => $article_options['Style'],
            'auto' => true,
        ],
        [
            'type' => 'radio_btn',
            'title' => '預覽',
            'value' => 'is_preview',
        ],
        [
            'type' => 'radio_btn',
            'title' => '是否顯示',
            'value' => 'is_visible',
        ],
    ],
    'tabSet' => [
        [
            'title' => '基本內容編輯',
            'content' => [
                //內容元件
                [
                    'type' => 'article_select',
                    'title' => '段落樣式',
                    'value' => 'article_style',
                    'default' => '',
                    'options' => $article_options['Style'],
                    'article4' => true,
                    'auto' => true,
                ],
                // [
                //     'type' => 'multiLocal',
                //     'content'=>[
                //         [
                //             'type' => 'textInput',
                //             'title' => '標題欄位',
                //             'value' => 'article_title',
                //             'tip' => '單行輸入，內容不支援HTML及CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。'
                //         ],
                //         [
                //             'type' => 'textSummernote',
                //             'title' => '內文欄位',
                //             'value' => 'article_inner',
                //             'tip' => '若有使用列點樣式，以內文區塊對齊需以置左樣式為主',
                //         ],

                //     ]
                // ],
                [
                    'type' => 'radio_area',
                    'title' => 'rwd排版設定',
                    'value' => 'mobile_rwd',
                    // 'tip' => '若啟用後則圖文排版於手機版顯示與電腦版相反。如原本為圖上文下，開啟後則會變為文上圖下<br>
                    //     原始圖文配置為由左至右對應至手機版由上至下<br>
                    //     滿版圖文於手機版預設皆為圖上文下',
                    'default' => '',
                    'options' => $article_options['mobileRWD'],
                ],
                [
                    'type' => 'textSummernote',
                    'title' => '標題欄位',
                    'value' => 'article_title',
                    'tip' =>
                        '可顯示多行文字，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放，<br>若欲於文字間穿插超連結，請直接寫入 html 語法。',
                    'toolbar' => 'simple',
                ],
                // [
                //     'type' => 'textInput',
                //     'title' => '副標題欄位',
                //     'value' => 'article_sub_title',
                //     'tip' => '單行輸入，內容不支援HTML及CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。',
                // ],
                [
                    'type' => 'textSummernote',
                    'title' => '內文欄位',
                    'value' => 'article_inner',
                    'tip' => '若有使用列點樣式，以內文區塊對齊需以置左樣式為主',
                    'toolbar' => 'article_news',
                ],
                // [
                //     'type' => 'textArea',
                //     'title' => 'instagram內嵌結構',
                //     'value' => 'instagram_content',
                //     'tip' => '請填入ig官方提供的內嵌結構',
                // ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '標題對齊設定',
                    'value' => 'h_align',
                    'tip' => '標題對齊設定，預設為靠左對齊。',
                    'options' => $article_options['AlignHorizontal4Title'],
                ],
                // [
                //     'type' => 'radio_area',
                //     'empty' => 'yes',
                //     'title' => '副標題對齊設定',
                //     'value' => 'subh_align',
                //     'tip' => '副標題對齊設定，預設為靠左對齊。',
                //     'options' => $article_options['AlignHorizontal4SubTitle'],
                // ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '內文區塊對齊設定',
                    'value' => 'p_align',
                    'tip' => '內文區塊左右對齊設定，預設為靠左對齊。',
                    'options' => $article_options['AlignHorizontal4Text'],
                ],
                [
                    'type' => 'colorPicker',
                    'title' => '標題文字顏色',
                    'value' => 'h_color',
                    'tip' => '標題文字顏色設定',
                    'default' => '#000',
                ],
                // [
                //     'type' => 'colorPicker',
                //     'title' => '副標題文字顏色',
                //     'value' => 'subh_color',
                //     'tip' => '副標題文字顏色設定',
                // ],
                [
                    'type' => 'radio_area',
                    'title' => '內文文字顏色',
                    'value' => 'p_color',
                    'tip' => '內文文字顏色設定',
                    'options' => $article_options['textColor'],
                ],
            ],
        ],
        [
            'title' => '按鈕設定',
            'content' => [
                [
                    'type' => 'radio_area',
                    'title' => '是否啟用按鈕',
                    'value' => 'button_visible',
                    'tip' => '啟用後請務必輸入按鈕文字並填寫網址或選擇檔案',
                    'options' => $article_options['button_visible'],
                    'default' => 1,
                ],
                [
                    'type' => 'textInput',
                    'title' => '按鈕文字',
                    'value' => 'button',
                    'tip' =>
                        '此欄位為選填，單行輸入，內容不支援HTML及CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。',
                ],
                [
                    'type' => 'radio_area',
                    'empty' => 'no',
                    'title' => '按鈕行為',
                    'value' => 'button_action',
                    'tip' => '請選擇按鈕點擊後的動作，並填寫對應的資料',
                    'options' => $article_options['BtnAction'],
                ],
                [
                    'type' => 'textInput',
                    'title' => '按鈕連結',
                    'value' => 'button_link',
                    'target' => ['name' => 'link_type'],
                    'tip' => '請填入連結網址，此欄位為選填，若未填寫連結則不顯示按鈕。<br>
                     站內請填寫如: tw/product<br>
                     站外請填寫完整網址如: https://www.google.com.tw/',
                ],
                [
                    'type' => 'filePicker',
                    'title' => '檔案下載',
                    'value' => 'button_file',
                    'tip' => '請選擇要提供下載的檔案，例如RAR、ZIP、PDF、DOC、XLSX、圖檔類型',
                ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '按鈕位置 - 對齊方式',
                    'value' => 'button_align',
                    'tip' => '按鈕位置對齊方式設定，預設為靠左對齊。',
                    'options' => $article_options['AlignHorizontal4Btn'],
                ],
                // [
                //     'type' => 'colorPicker',
                //     'title' => '按鈕文字 - 顏色',
                //     'value' => 'button_textcolor',
                //     'tip' => '按鈕文字顏色設定。',
                // ],
                // [
                //     'type' => 'colorPicker',
                //     'title' => '按鈕底色 - 顏色',
                //     'value' => 'button_color',
                //     'tip' => '按鈕顏色設定。',
                //     'default'=>'#ffffff'
                // ],
                // [
                //     'type' => 'colorPicker',
                //     'title' => '按鈕底色 - hover顏色',
                //     'value' => 'button_color_hover',
                //     'tip' => '按鈕滑鼠移至顏色設定。',
                //     'default'=>'#eeeeee'
                // ],
            ],
        ],
        [
            'title' => '圖片 / 影片管理',
            'content' => [],
            'is_three' => 'yes',
            'copy' => 'yes',
            'sort_field' => 'w_rank',
            'three_model' => $ThreeModel,
            'SecondIdColumn' => 'parent_id',
            'three' => [
                'title' => '圖片 / 影片管理',
                'tip' =>
                    '可設定多張圖片 / 影片的編排格式，其中靠上圖片、靠下圖片、圖片 / 影片的段落類型編排為橫向並排，而文繞圖、靠左圖片、靠右圖片段落類型的編排為重直排列。',
                'SecondIdColumn' => 'second_id', //存放第二層ID的欄位
                'MultiImgcreate' => 'yes', //使用多筆圖片
                'imageColumn' => 'image', //預設圖片欄位
                'article_video' => 'article_video',
                'three_tableSet' => [
                    [
                        'type' => 'article_text_image',
                        'title' => '圖片',
                        'value' => 'image',
                    ],
                ],
                'three_content' => [
                    [
                        'type' => 'image_group',
                        'title' => '圖片',
                        'tip' => '請選擇圖片，若需多張圖請再增加一筆圖片 / 影片資料。',
                        'image_array' => [
                            [
                                'title' => '圖片',
                                'value' => 'image',
                                'set_size' => 'no',
                            ],
                        ],
                    ],
                    [
                        'type' => 'textInput',
                        'title' => '圖片描述',
                        'value' => 'title',
                        'tip' =>
                            '單行輸入，內容不支援HTML及CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。',
                    ],

                    [
                        'type' => 'radio_area',
                        'title' => '影片來源',
                        'value' => 'video_type',
                        'options' => $article_options['VideoType'],
                        'tip' => '請務必選擇影片來源，預設為YouTube。',
                    ],
                    [
                        'type' => 'textInput',
                        'title' => '影片代碼',
                        'value' => 'video',
                        'tip' =>
                            '若來源選擇YouTube，在欄位內輸入Youtube影片網址V後面的英文數字。<br>例：https://www.youtube.com/watch?v=abcdef，請輸入abcdef<br><br>若來源選擇YOUKU，在欄位內輸入YOUKU影片網址/id_後面到==.html前的英文數字。<br>例：https://v.youku.com/v_show/id_abcdef==.html ，請輸入abcdef。',
                    ],
                ],
            ],
        ],
        [
            'title' => '圖片樣式設定',
            'content' => [
                [
                    'type' => 'radio_btn',
                    'title' => '是否為拼圖模式',
                    'value' => 'img_merge',
                    'tip' =>
                        '使用後會隱藏圖片間距及描述，以拼接方式呈現，<br>若段落選擇Swiper模式，或選擇圖片為輪播不適用此規則。',
                ],
                [
                    'type' => 'radio_btn',
                    'title' => '首圖是否放大',
                    'value' => 'img_firstbig',
                    'tip' => '使用後對首圖強制100%放大，<br>若段落選擇Swiper模式，或選擇圖片為輪播不適用此規則。',
                ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '圖片每列數量設定',
                    'value' => 'img_row',
                    'tip' => '圖片每列數量設定，預設為一張圖，<br>若段落選擇Swiper模式，或選擇圖片為輪播不適用此規則。',
                    'default' => '',
                    'options' => $article_options['isRow4Img'],
                ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '圖片比例設定',
                    'value' => 'img_size',
                    'tip' =>
                        '圖片比例設定，預設為依照圖片大小，<br>若設定比例，圖片不足部分將呈現淺灰色底，並將圖片自動置中。',
                    'options' => $article_options['imgSize'],
                ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '文字與圖片垂直對齊設定',
                    'value' => 'article_flex',
                    'tip' => '內文區塊上下對齊設定，預設為靠上對齊。',
                    'options' => $article_options['AlignVertical4TextWithImg'],
                ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '圖片垂直對齊設定',
                    'value' => 'img_flex',
                    'tip' => '圖片垂直對齊設定，預設為置上。',
                    'options' => $article_options['CommonAlignVertical4Img'],
                ],

                [
                    'type' => 'radio_area',
                    'title' => '圖片描述文字顏色',
                    'value' => 'description_color',
                    'tip' => '圖片描述文字顏色，預設為黑色。',
                    'options' => $article_options['textColor'],
                ],

                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '圖片描述文字對齊',
                    'value' => 'description_align',
                    'tip' => '圖片描述文字對齊，預設為靠左對齊。',
                    'options' => $article_options['CommonAlignHorizontal4ImgText'],
                ],
                [
                    'type' => 'radio_btn',
                    'title' => '圖片是否為輪播',
                    'value' => 'is_swiper',
                    'tip' => '開啟後圖片為輪播方式呈現，需填入圖片輪播相關設定。',
                ],
                [
                    'type' => 'radio_area',
                    'empty' => 'yes',
                    'title' => '圖片輪播 - 出現圖片數量',
                    'value' => 'swiper_num',
                    'tip' => '選取輪播一次出現圖片數量',
                    'options' => $article_options['isRow4Swiper'],
                ],
                [
                    'type' => 'radio_btn',
                    'title' => '圖片輪播 - 是否開啟自動播放',
                    'value' => 'swiper_autoplay',
                    'tip' => '是否開啟自動播放',
                ],
                [
                    'type' => 'radio_btn',
                    'title' => '圖片輪播 - 是否開啟循環播放',
                    'value' => 'swiper_loop',
                    'tip' => '是否開啟循環播放',
                ],
                // [
                //     'type' => 'radio_btn',
                //     'title' => '圖片輪播 - 是否啟用左右箭頭按鈕',
                //     'value' => 'swiper_arrow',
                //     'tip' => '是否啟用左右箭頭按鈕',
                // ],
                // [
                //     'type' => 'radio_btn',
                //     'title' => '圖片輪播 - 是否啟用下方切換選單',
                //     'value' => 'swiper_nav',
                //     'tip' => '是否啟用下方切換選單',
                // ],
            ],
        ],
        [
            'title' => '滿版背景 樣式',
            'content' => [
                [
                    'type' => 'radio_area',
                    'title' => '內文寬度設定',
                    'value' => 'full_size',
                    'empty' => 'yes',
                    'tip' => '若段落樣式選擇滿版背景，才需填寫此欄位。',
                    'options' => $article_options['fullSize'],
                ],
                [
                    'type' => 'colorPicker',
                    'title' => '段落底色設定',
                    'value' => 'article_color',
                    'default' => 'rgba(255, 255, 255, 0)',
                    'tip' => '若段落樣式選擇滿版背景，才需填寫此欄位。',
                ],
                [
                    'type' => 'colorPicker',
                    'title' => '內文底色設定',
                    'value' => 'full_box_color',
                    'default' => '#ffffff',
                    'tip' => '只適用於"滿版背景有色塊"的樣式',
                ],
                [
                    'type' => 'radio_btn',
                    'title' => '內文色塊是否對齊邊際',
                    'value' => 'is_slice',
                    'tip' =>
                        '只適用於"滿版背景有色塊"的樣式, 對齊方式依照所選的"滿版背景有色塊樣式", ex: 段落置左則色塊貼齊左邊邊際',
                ],
                [
                    'type' => 'image_group',
                    'title' => '背景圖片',
                    'tip' => '若段落樣式選擇滿版背景，才需選擇背景圖片，沒有圖片則會以段落底色代替，建議尺寸 寬度1455',
                    'image_array' => [
                        [
                            'title' => '背景圖片',
                            'value' => 'full_img',
                            'set_size' => 'no',
                            'width' => '',
                            'height' => '',
                        ],
                        [
                            'title' => '背景圖片-手機版',
                            'value' => 'full_img_rwd',
                            'set_size' => 'no',
                            'width' => '',
                            'height' => '',
                        ],
                    ],
                ],
            ],
        ],
    ],
]) }}
