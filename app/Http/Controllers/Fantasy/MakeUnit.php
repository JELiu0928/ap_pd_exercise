<?php

namespace App\Http\Controllers\Fantasy;

use App\Http\Controllers\BaseFunctions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


use function Symfony\Component\VarDumper\Cloner\dump;

class MakeUnit extends BackendController
{
    public static function FIELD_TIPS($key = "")
    {
        $tips = [
            'is_reviewed' => '主要決定資料是否於前台網頁發佈的設定，設定不發佈，資料將不會出現在任一頁面上，也無法被搜尋引擎尋找。',
            'is_visible' => '主要決定資料是否於前台網頁發佈的設定，設定不發佈，資料將不會出現在任一頁面上，也無法被搜尋引擎尋找。',
            'is_preview' => '主要決定資料是否於預覽站發佈的設定，與是否顯示於正式網頁無關。',
            'rank' => '列表顯示排序，由小至大；輸入 0 為置頂，排序將超越 1；多筆設定為 0 ，最後排序將取決於資料建立日期。',
            'url_name' => '此網址名稱，可使用中文<br>例如：' . b_url('demo') . '/<strong style="color: red;">abc123</strong>，填入 abc123<br><strong style="color: red;">不可留白有空格、不可重複、不可使用特殊符號如「;　/　?　:　@　=　&　<　>　""　#　%　{　}　|　\　^　~　[　]　`　」</strong><br><strong style="color: red;">網址名稱不能重複，若重複將有可能造成搜尋上的錯誤</strong><br>如果有多語系，請統一各語系的網址名稱（選擇一個主要的語系的網址名稱做代表，ex：英文），否則無法實現同一頁面切換語系的功能。',
            'url_title' => '此分類網址名稱，可使用中文，請輸入分類後網址<br>例如：' . b_url('demo') . '/<strong style="color: red;">abc123</strong>，填入 abc123<br><strong style="color: red;">不可留白有空格、不可重複、不可使用特殊符號如「;　/　?　:　@　=　&　<　>　""　#　%　{　}　|　\　^　~　[　]　`　」</strong><br><strong style="color: red;">網址名稱不能重複，若重複將有可能造成搜尋上的錯誤</strong><br>如果有多語系，請統一各語系的網址名稱（選擇一個主要的語系的網址名稱做代表，ex：英文），否則無法實現同一頁面切換語系的功能。',
            'is_always' => '若開啟後，無視上下架日期設定。',
            'post_date' => '前台資料排序以此欄位為主，日期相同時以排序為輔，此欄位顯示於列表日期區塊。',
            'up_date' => '請填寫資料上架時間。',
            'down_date' => '請填寫資料下架時間。',
            'open_action' => '如需控制資料上架下架時間,請啟用並填寫下方日期',
            'open_date' => '若為空值則會直接上架，否則將於設定的日期才會顯示資料',
            'close_date' => '若為空值則不會下架，否則將於設定的日期才會隱藏資料',
        ];
        return $tips[$key] ?? "";
    }
    public static function DEFAULT_TIPS($key = "")
    {
        $tips = [
            'textInputTargetAcc' => '請填入連結網址，若未填寫連結則不顯示本連結。如須於新視窗開啟網址，請啟用於新視窗開啟。<br>站內請填寫語系後的內容(包含語系)，如: /tw/product  |  站外請填寫完整網址，如: https://www.google.com.tw<br>無障礙內容設定請符合無障礙規範',
            'textInputTarget' => '請填入連結網址，若未填寫連結則不顯示本連結。如須於新視窗開啟網址，請啟用於新視窗開啟。<br>站內請填寫語系後的內容(包含語系)，如: /tw/product  |  站外請填寫完整網址，如: https://www.google.com.tw',
            'textInput' => '單行輸入，內容不支援HTML及CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。',
            'lang_textInput' => '單行輸入，內容不支援HTML及CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。',
            'textArea' => '可輸入多行文字，內容不支援HTML及CSS、JQ、JS等語法，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放。',
            'lang_textArea' => '可輸入多行文字，內容不支援HTML及CSS、JQ、JS等語法，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放。',
            'textSummernote' => '可顯示多行文字，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放，<br>若欲於文字間穿插超連結，請直接寫入 html 語法。',
            'colorPicker' => '點擊可打開色盤選擇其他顏色',
            'datePicker' => '點擊可打開日曆選擇日期',
            'dateRange' => '點擊可打開日曆選擇日期，請選擇起始日與截止日',
            'timePicker' => '點擊可開編輯時間，格式為 時:分:秒，24小時制。',
            'dateTime' => '點擊第一格可打開日曆選擇日期，第二格可編輯時間，時間格式為 時:分:秒，24小時制。',
            'numberRange' => '請填寫數字區間',
            'numberInput' => '此欄位僅支援數字格式',
            'filePicker' => '檔案類型僅支援：' . implode(",", collect(\App\Http\Controllers\Fantasy\FmsController::$allowFileMimeType)->flatten()->unique()->toArray()),
            'imageGroup' => '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。<br>建議在上傳前先將圖片進行壓縮，可參考如 <a href="https://tinypng.com/" style="color:blue" target="_blank">tinypng</a>',
        ];
        return $tips[$key] ?? "";
    }
    public static $options = [
        'action' => ''
    ];
    public static function setAction($options = [])
    {
        self::$options = array_merge(self::$options, $options);
    }
    public static function inputHidden($set = [])
    {
        $html = '<input type="hidden" value="' . ($set['value'] ?? '') . '" name="' . $set['name'] . '">';
        echo ($html);
    }
    public static function initial($element, $set = [])
    {
        $batch = (self::$options['action'] == 'batch');
        $search = (self::$options['action'] == 'search');
        $disabled = isset($set['disabled']) && intval($set['disabled']) === 1;
        $name = $set['name'] ?? '';
        $name2 = $set['name2'] ?? '';
        $title = $set['title'] ?? '';
        $value = $set['value'] ?? "";
        $value2 = $set['value2'] ?? '';
        if (!is_array($value) && is_array(json_decode($value, true))) {
            $value = json_decode($value, true);
        }
        // 是否為sontable用
        $sontable = (!empty($set['sontable'])) ? true : false;
        $tip = $set['tip'] ?? '';
        //選項
        $options = $set['options'] ?? [];

        $re = '/\[(.*)\]/m';
        preg_match_all($re, $name, $matches, PREG_SET_ORDER, 0);
        $tip_key = $matches[0][1] ?? '';
        $auto = isset($set['auto']) ? $set['auto'] : '';
        $autosetup = $auto ? 'AutoSet_' . $tip_key : '';
        if (empty($tip)) {
            $tip = self::FIELD_TIPS($tip_key) ?: self::DEFAULT_TIPS($element);
        }
        $tip = ($tip == 'none') ? '' : $tip;
        return [$batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup];
    }

    public static function radio_area($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $options = $options ?: [["key" => 0, "title" => "否"], ["key" => 1, "title" => "是"]];
        $value = $value == "" ? ($set['default'] ?? $options[array_key_first($options)]['key']) : $value;

        echo (View::make(
            'Fantasy.cms_view.includes.template.radio_area',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'options' => $options,
                'disabled' => $disabled,
                'auto' => $auto,
                'autosetup' => $autosetup
            ]
        )->Render());
    }
    public static function lang_textInput($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.lang_textInput', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'set' => $set,
        ])->render());
    }
    public static function lang_textArea($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.lang_textArea', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'set' => $set,
        ])->render());
    }
    public static function textInput($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.textInput', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'auto' => $auto,
            'autosetup' => $autosetup,
            'set' => $set,
        ])->render());
    }
    public static function textInputTarget($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.textInput', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'auto' => $auto,
            'autosetup' => $autosetup,
            'set' => $set,
        ])->render());
    }
    public static function textInputTargetAcc($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.textInput', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'auto' => $auto,
            'autosetup' => $autosetup,
            'set' => $set,
        ])->render());
    }
    public static function textArea($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.textArea', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'set' => $set,
        ])->render());
    }
    public static function textSummernote($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.textSummernote', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'set' => $set,
        ])->render());
    }
    public static function numberInput($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make('Fantasy.cms_view.includes.template.numberInput', [
            'batch' => $batch,
            'search' => $search,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'set' => $set,
        ])->render());
    }
    public static function radio_btn($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        echo (View::make(
            'Fantasy.cms_view.includes.template.radio_btn',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'disabled' => $disabled,
            ]
        )->Render());
    }
    public static function radio_btn_small($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $view = View::make(
            'Fantasy.cms_view.includes.template.radio_btn_small',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'disabled' => $disabled,
            ]
        )->Render();

        echo $view;
    }
    public static function colorPicker($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        // $color = $set['color'] ?? [];
        $color = [];
        $value = $set['value'] ?: '#000000';
        // dd(Color::pluck('color'));

        echo (View::make('Fantasy.cms_view.includes.template.colorPicker', [
            'batch' => $batch,
            'search' => $search,
            'set' => $set,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'color' => json_encode($color)
        ])->render());
    }
    public static function datePicker($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $value = isset($set['value']) ? ($set['value'] == '0000-00-00' ? '' : $set['value']) : '';

        echo (View::make('Fantasy.cms_view.includes.template.datePicker', [
            'batch' => $batch,
            'search' => $search,
            'set' => $set,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
        ])->render());
    }
    public static function timePicker($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $value = isset($set['value']) ? ($set['value'] == '00:00:00' ? '' : $set['value']) : '';

        echo (View::make('Fantasy.cms_view.includes.template.timePicker', [
            'batch' => $batch,
            'search' => $search,
            'set' => $set,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
        ])->render());
    }
    public static function dateRange($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        if ($search) {
            $re = '/(.*?)\[/';
            $re1 = '/\[(.*?)\]/';

            preg_match_all($re, $name, $matches, PREG_SET_ORDER, 0);
            preg_match_all($re1, $name, $matches1, PREG_SET_ORDER, 0);
            $getModel = $matches[0][1];
            $getName = $matches1[array_key_last($matches1)][1];
            $name = $getModel . '[' . $getName . '_range_start]';
            $name2 = $getModel . '[' . $getName . '_range_end]';
        }

        $value = isset($set['value']) ? ($set['value'] == '0000-00-00' ? '' : $set['value']) : '';
        $value2 = isset($set['value2']) ? ($set['value2'] == '0000-00-00' ? '' : $set['value2']) : '';

        echo (View::make(
            'Fantasy.cms_view.includes.template.dateRange',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'name2' => $name2,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'value2' => $value2,
                'disabled' => $disabled,
                'set' => $set,
            ]
        )->Render());
    }
    public static function dateTime($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $value = isset($set['value']) ? ($set['value'] == '0000-00-00' ? '' : $set['value']) : '';
        $value2 = isset($set['value2']) ? $set['value2'] : '00:00:00';

        echo (View::make(
            'Fantasy.cms_view.includes.template.dateTime',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'name2' => $name2,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'value2' => $value2,
                'disabled' => $disabled,
                'set' => $set,
            ]
        )->Render());
    }
    //座標選擇 只能用在第一層
    public static function imageCoordinate($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $value = isset($set['value']) ? $set['value'] : '';
        $imgSrc = BaseFunctions::RealFiles($value);

        echo (View::make(
            'Fantasy.cms_view.includes.template.imageCoordinate',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'imgSrc' => $imgSrc,
                'disabled' => $disabled,
                'set' => $set,
            ]
        )->Render());
    }
    public static function numberRange($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        if ($search) {
            $re = '/(.*?)\[/';
            $re1 = '/\[(.*?)\]/';

            preg_match_all($re, $name, $matches, PREG_SET_ORDER, 0);
            preg_match_all($re1, $name, $matches1, PREG_SET_ORDER, 0);
            $getModel = $matches[0][1];
            $getName = $matches1[array_key_last($matches1)][1];
            $name = $getModel . '[' . $getName . '_range_start]';
            $name2 = $getModel . '[' . $getName . '_range_end]';
        }

        echo (View::make(
            'Fantasy.cms_view.includes.template.numberRange',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'name2' => $name2,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'value2' => $value2,
                'disabled' => $disabled,
                'set' => $set,
            ]
        )->Render());
    }
    public static function imageGroup($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $image_array = (!empty($set['image_array'])) ? $set['image_array'] : [];
        $fileIds = collect(array_map(function ($imgSet) {
            $value = $imgSet['value'] ?? 'none';
            $value = json_decode($value,true) ?: $value;
            return $value;
        }, $image_array))->flatten();
        $fileInformationArray = empty($fileIds) ? [] : BaseFunctions::getFilesArrayWithKey($fileIds);
        if(isset($set['auto_add']) && $set['auto_add'] && count($image_array) > 0 && !empty($image_array[0]['value'])){
            $new_image_array = [];
            foreach($fileIds as $k=>$val){
                if(isset($set['input'])){
                    foreach($set['input'] as $k2=>$v2){
                        $image_array[0]['input'][$k2]['val'] = $set['inputData'][$k2][$k];
                    }
                }
                $image_array[0]['value'] = $val;
                $new_image_array[] = $image_array[0];
            }

            //空的一筆
            if(isset($set['input'])){
                foreach($set['input'] as $k2=>$v2){
                    $image_array[0]['input'][$k2] = ['title'=>'','value'=>''];
                }
            }
            // $image_array[0]['input'] = '';
            $image_array[0]['value'] = '';
            $new_image_array[] = $image_array[0];
            $image_array = $new_image_array;
        }
        echo (View::make('Fantasy.cms_view.includes.template.imageGroup', [
            'batch' => $batch,
            'search' => $search,
            'set' => $set,
            'title' => $title,
            'tip' => $tip,
            'image_array' => $image_array,
            'fileInformationArray' => $fileInformationArray,
            'fileIds' => $fileIds,
        ])->render());
    }
    public static function filePicker($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $fileInformationArray = (!empty($value)) ? BaseFunctions::getFilesArrayWithKey([$value]) : [];

        echo (View::make('Fantasy.cms_view.includes.template.filePicker', [
            'batch' => $batch,
            'search' => $search,
            'set' => $set,
            'name' => $name,
            'title' => $title,
            'tip' => $tip,
            'value' => $value,
            'disabled' => $disabled,
            'fileInformationArray' => $fileInformationArray,
        ])->render());
    }
    public static function select2($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);
        //權限篩選
        if(isset($set['filter']) && !empty($set['filter']) && !in_array("pass", $set['filter'])){
            $options = collect($options)->whereIn('key',$set['filter'])->all();
        }
        //預設不選
        if(isset($set['empty']) && $set['empty']){
            array_unshift($options, ['key'=>-1,'title'=>'-']);
        }
        $view = View::make(
            'Fantasy.cms_view.includes.template.select2',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'options' => $options,
                'disabled' => $disabled,
                'auto' => $auto,
                'autosetup' => $autosetup,
                'set' => $set,
            ]
        )->Render();

        echo $view;
    }
    public static function select2Multi($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $original = $set['original'] ?? '';
        $isEcho = (isset($set['is_echo'])) ? $set['is_echo'] : true;
        //新增全選按鈕
        $isAll = isset($set['isAll']) && intval($set['isAll']) === 1;
        $value = $value ?: [];
        //權限篩選
        if(isset($set['filter']) && !empty($set['filter']) && !in_array("pass", $set['filter'])){
            $options = collect($options)->whereIn('key',$set['filter'])->all();
        }

        $view = View::make(
            'Fantasy.cms_view.includes.template.select2Multi',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'original' => $original,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'options' => $options,
                'disabled' => $disabled,
                'isAll' => $isAll,
                'set' => $set,
            ]
        )->Render();

        if ($isEcho) {
            echo $view;
        } else {
            return $view;
        }
    }
    public static function select2MultiNew($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $original = $set['original'] ?? '';
        $isEcho = (isset($set['is_echo'])) ? $set['is_echo'] : true;
        //新增全選按鈕
        $isAll = isset($set['isAll']) && intval($set['isAll']) === 1;

        //權限篩選
        if(isset($set['filter']) && !empty($set['filter']) && !in_array("pass", $set['filter'])){
            $options = collect($options)->whereIn('key',$set['filter'])->all();
        }
        $value = $value ?: [];
        if(!is_array($value)){
            $value = [];
        }
        $view = View::make(
            'Fantasy.cms_view.includes.template.select2MultiNew',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'original' => $original,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => (!empty($value) ? json_encode($value) : '[]'),
                'value_arr' => $value,
                'options' => $options,
                'disabled' => $disabled,
                'isAll' => $isAll,
                'set' => $set,
            ]
        )->Render();

        if ($isEcho) {
            echo $view;
        } else {
            return $view;
        }
    }
    public static function table($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        $view = View::make(
            'Fantasy.cms_view.includes.template.table',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'options' => $options,
                'disabled' => $disabled,
                'auto' => $auto,
                'autosetup' => $autosetup,
                'set' => $set,
            ]
        )->Render();

        echo $view;
    }
    public static function WNsonTable($set = [])
    {
        $value = (!empty($set['value'])) ? $set['value'] : [];
        $table_tip = (!empty($set['tip'])) ? $set['tip'] : '';
        $sort = (!empty($set['sort'])) ? $set['sort'] : 'yes';
        $create = (!empty($set['create'])) ? $set['create'] : 'yes';
        $MultiImgcreate = (!empty($set['MultiImgcreate'])) ? $set['MultiImgcreate'] : 'no';
        $MultiDatacreate = (!empty($set['MultiDatacreate'])) ? $set['MultiDatacreate'] : 'no';
        $copy = (!empty($set['copy'])) ? $set['copy'] : 'no';
        $delete = (!empty($set['delete'])) ? $set['delete'] : 'yes';
        $teach = (!empty($set['teach'])) ? $set['teach'] : 'no';
        $is_link = (!empty($set['is_link'])) ? $set['is_link'] : 'no';
        $link_class = (!empty($set['link_class'])) ? $set['link_class'] : '';
        $link_key = (!empty($set['link_key'])) ? $set['link_key'] : [];
        $hasContent = (!empty($set['hasContent'])) ? $set['hasContent'] : 'no';
        $tableSet = (!empty($set['tableSet'])) ? $set['tableSet'] : [];
        $tabSet = (!empty($set['tabSet'])) ? $set['tabSet'] : [];
        $multiLocal = $set['multiLocal'] ?? false;
        $langArray = Config::get('cms.langArray', []);
        foreach ($tabSet[0]['content'] as $key => $val) {
            $val['value'] = $val['value'] ?? '';
            if ($multiLocal) {
                if ($val['value'] == 'article_title') {
                    unset($tabSet[0]['content'][$key]);
                }
                if ($val['value'] == 'article_inner') {
                    unset($tabSet[0]['content'][$key]);
                }
            } else {
                if ($val['type'] == 'multiLocal') {
                    unset($tabSet[0]['content'][$key]);
                }
            }
        }
        /*隨機亂碼*/
        $randomWord = Str::random(9);
        $setting = [
            'set' => $set,
            'value' => [],
            'table_tip' => $table_tip,
            'sort' => $sort,
            'create' => $create,
            'MultiImgcreate' => $MultiImgcreate,
            'MultiDatacreate' => $MultiDatacreate,
            'copy' => $copy,
            'delete' => $delete,
            'teach' => $teach,
            'is_link' => $is_link,
            'link_class' => $link_class,
            'link_key' => $link_key,
            'hasContent' => $hasContent,
            'tableSet' => $tableSet,
            'tabSet' => $tabSet,
            'randomWord' => $randomWord,
            'langArray' => $langArray,
        ];
        $json_setting = json_encode($setting, JSON_UNESCAPED_UNICODE);
        $setting['setting'] = $json_setting;
        $stack = View::make('Fantasy.cms_view.includes.template.WNsontable.stack', $setting)->render();


        $sontable = View::make('Fantasy.cms_view.includes.template.WNsontable.index', [
            'set' => $set,
            'value' => $value,
            'table_tip' => $table_tip,
            'sort' => $sort,
            'create' => $create,
            'MultiImgcreate' => $MultiImgcreate,
            'MultiDatacreate' => $MultiDatacreate,
            'copy' => $copy,
            'delete' => $delete,
            'teach' => $teach,
            'is_link' => $is_link,
            'link_class' => $link_class,
            'link_key' => $link_key,
            'hasContent' => $hasContent,
            'tableSet' => $tableSet,
            'tabSet' => $tabSet,
            'randomWord' => $randomWord,
            'stack' => $stack,
            'langArray' => $langArray,
            'setting' => $setting['setting'],
        ])->render();
        echo ($sontable);
    }

    public static function timeRange($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        if ($search) {
            $re = '/(.*?)\[/';
            $re1 = '/\[(.*?)\]/';

            preg_match_all($re, $name, $matches, PREG_SET_ORDER, 0);
            preg_match_all($re1, $name, $matches1, PREG_SET_ORDER, 0);
            $getModel = $matches[0][1];
            $getName = $matches1[array_key_last($matches1)][1];
            $name = $getModel . '[' . $getName . '_range_start]';
            $name2 = $getModel . '[' . $getName . '_range_end]';
        }

        $value = isset($set['value']) ? ($set['value'] == '0000-00-00' ? '' : $set['value']) : '';
        $value2 = isset($set['value2']) ? ($set['value2'] == '0000-00-00' ? '' : $set['value2']) : '';

        echo (View::make(
            'Fantasy.cms_view.includes.template.timeRange',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'name2' => $name2,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'value2' => $value2,
                'disabled' => $disabled,
                'set' => $set,
            ]
        )->Render());
    }
    public static function coordinate($set = [])
    {
        list($batch, $search, $disabled, $name, $name2, $title, $value, $value2, $sontable, $tip, $options, $auto, $autosetup) = self::initial(__FUNCTION__, $set);

        //圖片抓取
        if(is_array($set['image'])){
            $images = M($set['image']['model'])::first()[$set['image']['field']] ?? "";
            $set['image'] = \BaseFunction::RealFiles($images);
        }



        $view = View::make(
            'Fantasy.cms_view.includes.template.coordinate',
            [
                'batch' => $batch,
                'search' => $search,
                'sontable' => $sontable,
                'name' => $name,
                'title' => $title,
                'tip' => $tip,
                'value' => $value,
                'options' => $options,
                'disabled' => $disabled,
                'auto' => $auto,
                'autosetup' => $autosetup,
                'set' => $set,
            ]
        )->Render();

        echo $view;
    }
}
