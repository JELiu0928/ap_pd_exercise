{{
    UnitMaker::textInput([
        'name' => $model.'[seo_title]',
        'title' => '網頁名稱',
        'tip' => '上限100字元，單行輸入，內容不支援HTML及CSS、JQ、JS等語法。',
        'value' => ( !empty($data['seo_title']) )? $data['seo_title'] : ''
    ])
}}

{{
    UnitMaker::textInput([
        'name' => $model.'[seo_h1]',
        'title' => 'h1 標籤',
        'tip' => '上限300字元，關鍵字請用逗號(,)區隔，內容不支援HTML及CSS、JQ、JS等語法。',
        'value' => ( !empty($data['seo_h1']) )? $data['seo_h1'] : ''
    ])
}}

{{
    UnitMaker::textInput([
        'name' => $model.'[seo_keyword]',
        'title' => 'meta keyword',
        'tip' => '上限300字元，關鍵字請用逗號(,)區隔，內容不支援HTML及CSS、JQ、JS等語法。',
        'value' => ( !empty($data['seo_keyword']) )? $data['seo_keyword'] : ''
    ])
}}

{{
    UnitMaker::textArea([
        'name' => $model.'[seo_meta]',
        'title' => 'meta description',
        'tip' => '上限300字元，內容不支援HTML及CSS、JQ、JS等語法。',
        'value' => ( !empty($data['seo_meta']) )? $data['seo_meta'] : ''
    ])
}}

{{
    UnitMaker::textInput([
        'name' => $model.'[seo_og_title]',
        'title' => '社群分享標題',
        'tip' => '單行輸入，內容不支援HTML及CSS、JQ、JS等語法。',
        'value' => ( !empty($data['seo_og_title']) )? $data['seo_og_title'] : ''
    ])
}}

{{
    UnitMaker::textArea([
        'name' => $model.'[seo_description]',
        'title' => '社群分享敘述',
        'tip' => '上限300字元，內容不支援HTML及CSS、JQ、JS等語法。',
        'value' => ( !empty($data['seo_description']) )? $data['seo_description'] : ''
    ])
}}

{{
    UnitMaker::imageGroup([
        'title' => '社群分享圖片',
        'image_array' =>
        [
            [
                'name' => $model.'[seo_img]',
                'title' => '',
                'value' => ( !empty($data['seo_img']) )? $data['seo_img'] : '',
                'set_size' => 'yes',
                'width' => '600',
                'height' => '600',
            ],
        ],
        'tip' => '圖片建議尺寸 600*600',
    ])
}}

{{
    UnitMaker::textInput([
        'name' => $model.'[seo_ga]',
        'title' => 'ga code',
        'tip' => '輸入編號即可，不需要整段程式碼。ex: UA-123456789-1 即可',
        'value' => ( !empty($data['seo_ga']) )? $data['seo_ga'] : ''
    ])
}}

{{
    UnitMaker::textInput([
        'name' => $model.'[seo_gtm]',
        'title' => 'gtm code',
        'tip' => '輸入編號即可，不需要整段程式碼。ex: GTM-ABCEDFG 即可',
        'value' => ( !empty($data['seo_gtm']) )? $data['seo_gtm'] : ''
    ])
}}

{{
    UnitMaker::textInput([
        'name' => $model.'[seo_pixel]',
        'title' => 'fb pixel',
        'tip' => '單行輸入，內容不支援HTML及CSS、JQ、JS等語法。',
        'value' => ( !empty($data['seo_pixel']) )? $data['seo_pixel'] : ''
    ])
}}

{{
    UnitMaker::textArea([
        'name' => $model.'[seo_structured]',
        'title' => '結構化標籤',
        'tip' => '請自行填入結構化標籤json語法；<br>
        語法可參考：<a href="https://schema.org/docs/full.html" target="_blank">Schema</a><br>
        測試網址或代碼：可至google提供 <a href="https://search.google.com/test/rich-results" target="_blank">複合式搜尋結果</a>',
        'value' => ( !empty($data['seo_structured']) )? $data['seo_structured'] : '',
        'verify' => [
            'json'=>'',
        ],
    ])
}}	