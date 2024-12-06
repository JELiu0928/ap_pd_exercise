<?php

namespace App\Http\Controllers\LeonBuilder;

use Config;
use Illuminate\Http\Request;
use Route;
use View;
use DB;
use voku\helper\HtmlDomParser;
use Schema;

class LeonBuilderController
{
    public function __construct()
    {
        $this->UrlList = [];
        $branch = str_replace(["www."], "", Route::current()->parameter('branch'));
        $branch = explode(".", $branch)[0] ?? '';
        $branch_url = Route::current()->parameter('branch_url');
        $locale = Route::current()->parameter('locale');
        $locale = str_replace('preview_', '', $locale);
       
        app()->setLocale($locale);

        /*補上資料庫語系前綴*/
        if (isset($locale) and !empty($locale)) {
            Config::set('app.dataBasePrefix', '' . $locale . '_');
            View::share('baseLocale', $locale);
        }
    }
    public $cms_menu_index = 0;
    public $bladeTab = '';
    public function autorun(Request $request)
    {
        $this->cms_menu_index = 1;
        $langArray = Config::get('cms.langArray');
        //建立model
        $leon_database = json_decode(json_encode(DB::table('leon_database')->get()), true);

        $leon_menu = json_decode(json_encode(DB::table('leon_menu')->first()), true);
        $leon_menu_data = json_decode($leon_menu['db_data'],true);
        foreach ($leon_database as $key => $val) {
            $db_data = json_decode($val['db_data'], true);
            $other_data = json_decode($val['other_data'], true);
            $language = (isset($other_data['is_share']) && $other_data['is_share'] == "1") ? 'all_' : '';
            $content = '';
            $filepath = app_path() . '\Models\PHP\\'.ucfirst($val['db_name']) . ".php";
            $Template = app_path() . '/Http/Controllers/LeonBuilder/Template/Model.php';
            $tempdata = fopen($Template, "r");
            $tempdata_html = fread($tempdata, filesize($Template));
            $tempdata_html = str_replace('{$Model}', ucfirst($val['db_name']), $tempdata_html);
            $tempdata_html = str_replace('{$TableName}', $language . $val['db_name'], $tempdata_html);

            $tempFunction = [];
            if (is_file($filepath)) {
                $readfile = fopen($filepath, "r+");
                $is_find = false;
                while (!feof($readfile)) {
                    $str = fgets($readfile);
                    if ((strpos($str, '//自訂區塊，不覆蓋-End') !== false)) {
                        $is_find = false;
                    }
                    if ($is_find) {
                        $temp_str = $str;
                        $temp_str = str_replace("\n", "", $temp_str);
                        $temp_str = str_replace("\r", "", $temp_str);
                        $temp_str = str_replace("\t", "", $temp_str);
                        $temp_str = str_replace(PHP_EOL, "", $temp_str);
                        if ((strpos($temp_str, 'function') !== false)) {
                            $tempFunction[] = preg_replace('/\s| /', "", str_replace("public function ", "", $temp_str));
                        }
                        if (!empty($temp_str) && $temp_str != "") {
                            $content .= $str;
                        }
                    }
                    if ((strpos($str, '//自訂區塊，不覆蓋-Star') !== false)) {
                        $is_find = true;
                    }
                }
                fclose($readfile);
            }
            $tempdata_html = str_replace('{$Custom}', $content, $tempdata_html);
            $file = fopen($filepath, "w");
            fwrite($file, $tempdata_html);
            fclose($file);
            //建立資料表
            foreach($langArray as $lang){
                $language = (isset($other_data['is_share']) && $other_data['is_share'] == "1") ? 'all_' : $lang['key'].'_';
                $copyData = [];
                // if (Schema::hasTable($language . $val['db_name'])) {
                //     $copyData = json_decode(json_encode(DB::table($language . $val['db_name'])->get()), true);
                //     \DB::statement("DROP TABLE " . $language . $val['db_name']);
                // }
                $clearNames = ['top_id'];
                // Schema::create($language . $val['db_name'], function ($table) use ($db_data, $other_data, $clearNames, $val, $language) {
                //     $table->engine = 'InnoDB';
                //     $table->bigIncrements('id')->comment('編號');
                //     $table->integer('w_rank')->comment('排序');
                //     $table->integer('is_reviewed')->comment('審核');
                //     $table->integer('is_preview')->comment('預覽');
                //     $table->integer('is_visible')->comment('顯示');
                //     $table->integer('wait_del')->comment('申請刪除');
                //     $table->integer('branch_id')->comment('分館');
                //     $table->integer('parent_id')->comment('第一層');
                //     $table->integer('second_id')->comment('第二層');
                //     foreach ($db_data as $v) {
                //         if($v['lang'] == 'true'){
                //             self::tableType($table, $v['type'], 'tw_' .$v['name'], $v['note']);
                //             self::tableType($table, $v['type'], 'en_' .$v['name'], $v['note']);
                //             self::tableType($table, $v['type'], 'cn_' .$v['name'], $v['note']);
                //             self::tableType($table, $v['type'], 'jp_' .$v['name'], $v['note']);
                //             self::tableType($table, $v['type'], 'kr_' .$v['name'], $v['note']);
                //         }else{
                //             if (!in_array($v['name'], $clearNames)) {
                //                 self::tableType($table, $v['type'], $v['name'], $v['note']);
                //             }
                //             if($v['formtype']=='textInputTarget'){
                //                 self::tableType($table, $v['type'], $v['name'].'_target', $v['note']);
                //             }
                //             if($v['formtype']=='textInputTargetAcc'){
                //                 self::tableType($table, $v['type'], $v['name'].'_target', $v['note']);
                //                 self::tableType($table, $v['type'], $v['name'].'_acc', $v['note']);
                //             }
                //             if(in_array($v['formtype'],['dateRange','numberRange'])){
                //                 self::tableType($table, $v['type'], $v['name'].'_start', $v['note']);
                //                 self::tableType($table, $v['type'], $v['name'].'_end', $v['note']);
                //             }
                //         }
                //     }
                //     if ($other_data['isSeo'] == "1") {
                //         self::tableType($table, 'text', 'url_name', 'Seo-自訂網址');
                //         self::tableType($table, 'text', 'seo_title', 'Seo-網頁標題');
                //         self::tableType($table, 'text', 'seo_h1', 'Seo-H1');
                //         self::tableType($table, 'text', 'seo_keyword', 'Seo-關鍵字');
                //         self::tableType($table, 'text', 'seo_meta', 'Seo-描述');
                //         self::tableType($table, 'text', 'seo_og_title', 'Seo-社群分享標題');
                //         self::tableType($table, 'text', 'seo_description', 'Seo-社群分享敘述');
                //         self::tableType($table, 'text', 'seo_img', 'Seo-社群分享圖片');
                //         self::tableType($table, 'text', 'seo_ga', 'Seo-網頁GA碼');
                //         self::tableType($table, 'text', 'seo_gtm', 'Seo-網頁GTM碼');
                //         self::tableType($table, 'text', 'seo_pixel', 'Seo-pixel');
                //         self::tableType($table, 'text', 'seo_structured', 'Seo-結構化標籤程式碼');
                //     }
                //     if ($other_data['isArticleImg'] == "1") {
                //         self::tableType($table, 'varchar', 'title', '');
                //         self::tableType($table, 'text', 'image', '');
                //         self::tableType($table, 'text', 'w_type', '');
                //         self::tableType($table, 'text', 'video', '');
                //         self::tableType($table, 'text', 'video_image', '');
                //         self::tableType($table, 'varchar', 'video_type', '');
                //         self::tableType($table, 'text', 'content', '');
                //     }
                //     if ($other_data['isArticle'] == "1") {
                //         self::tableType($table, 'int', 'is_swiper', '');
                //         self::tableType($table, 'int', 'is_slice', '');
                //         self::tableType($table, 'varchar', 'img_row', '');
                //         self::tableType($table, 'int', 'img_firstbig', '');
                //         self::tableType($table, 'int', 'img_merge', '');
                //         self::tableType($table, 'varchar', 'img_size', '');
                //         self::tableType($table, 'varchar', 'img_flex', '');
                //         self::tableType($table, 'varchar', 'description_color', '');
                //         self::tableType($table, 'varchar', 'description_align', '');
                //         self::tableType($table, 'varchar', 'article_style', '');
                //         self::tableType($table, 'varchar', 'mobile_rwd', '');
                //         self::tableType($table, 'varchar', 'article_title', '');
                //         self::tableType($table, 'varchar', 'article_sub_title', '');
                //         self::tableType($table, 'text', 'article_inner', '');
                //         self::tableType($table, 'text', 'instagram_content', '');
                //         self::tableType($table, 'varchar', 'article_color', '');
                //         self::tableType($table, 'varchar', 'article_flex', '');
                //         self::tableType($table, 'varchar', 'full_img', '');
                //         self::tableType($table, 'varchar', 'full_img_rwd', '');
                //         self::tableType($table, 'varchar', 'full_size', '');
                //         self::tableType($table, 'varchar', 'full_box_color', '');
                //         self::tableType($table, 'varchar', 'h_color', '');
                //         self::tableType($table, 'varchar', 'h_align', '');
                //         self::tableType($table, 'varchar', 'subh_color', '');
                //         self::tableType($table, 'varchar', 'subh_align', '');
                //         self::tableType($table, 'varchar', 'p_color', '');
                //         self::tableType($table, 'varchar', 'p_align', '');
                //         self::tableType($table, 'varchar', 'button', '');
                //         self::tableType($table, 'text', 'button_link', '');
                //         self::tableType($table, 'int', 'button_visible', '');
                //         self::tableType($table, 'int', 'button_action', '');
                //         self::tableType($table, 'varchar', 'button_file', '');
                //         self::tableType($table, 'text', 'accessible_txt', '');
                //         self::tableType($table, 'int', 'link_type', '');
                //         self::tableType($table, 'varchar', 'button_color', '');
                //         self::tableType($table, 'varchar', 'button_color_hover', '');
                //         self::tableType($table, 'varchar', 'button_textcolor', '');
                //         self::tableType($table, 'varchar', 'button_align', '');
                //         self::tableType($table, 'int', 'swiper_num', '');
                //         self::tableType($table, 'int', 'swiper_autoplay', '');
                //         self::tableType($table, 'int', 'swiper_loop', '');
                //         self::tableType($table, 'int', 'swiper_arrow', '');
                //         self::tableType($table, 'int', 'swiper_nav', '');

                //     }
                //     $table->integer('create_id')->comment('建立者');
                //     $table->nullableTimestamps();
                // });
                // \DB::statement("ALTER TABLE " . $language . $val['db_name'] . " comment '" . $val['db_note'] . "'");

                if(!empty($copyData)){
                    $saveKeys = [];
                    foreach($copyData[0] as $k=>$v){
                        if (!Schema::hasColumn($language . $val['db_name'], $k)){
                            foreach ($copyData as $index => $v) {
                                unset($copyData[$index][$k]);
                            }
                        }
                    }
                    foreach($copyData as $k=>$v){
                        DB::table($language . $val['db_name'])->updateOrInsert(['id' => $v['id']], $v);
                    }
                }
            }
        }
        $leon_database = collect($leon_database)->keyby('db_name')->all();

        //建立選單
        $this->createCmsMenu($leon_menu_data, $leon_database);
        return 'ok';
    }
    public function getchildrenModel($data){
        $model  = [];
        foreach($data['children'] ?? [] as $v){
            $model[] = $v['id'];
            $model = array_merge($model,$this->getchildrenModel($v));
        }
        return  $model;
    }
    public function updataModel($data,$son = false){
        $model  = [];
        foreach($data['children'] ?? [] as $v){
            $file = $son ? 'hasMany_son.php':'hasMany.php';
            $Template = app_path() . '/Http/Controllers/LeonBuilder/Template/'.$file;
            $tempdata = fopen($Template, "r");
            $tempdata_html = fread($tempdata, filesize($Template));
            $tempdata_html = str_replace('{$model}', $v['id'], $tempdata_html);
            $tempdata_html = str_replace('{$ucmodel}', ucfirst($v['id']), $tempdata_html);
            $model[] = ['model'=>$data['id'],'data'=>$tempdata_html];
            $model = array_merge($model,$this->updataModel($v,true));
        }
        return  $model;
    }
    public function getformatModel($data,$son = false){
        $model = [];
        foreach($data['children'] ?? [] as $v){
            if(isset($v['children']) && !empty($v['children'])){
                $html = '->with([\''.$v['id'].'\' => function ($q) {$q->with([';
                foreach($v['children'] as $s){
                    $html .= '\''.$s['id'].'\' => function ($q2) {$q2->orderBy(\'w_rank\');},';
                }
                $html .= '])->orderBy(\'w_rank\');}])';
                
                $model[] = $html;

            }else{
                $model[] = '->with(\''.$v['id'].'\')';
            }
        }
        return  $model;
    }
    public function copyArrayString($data,$son = false){
        $copyArray = [];
        $children = [];
        foreach($data['children'] ?? [] as $v){
            $tag = ($son) ? 'second_id':'parent_id';
            $children[] = "'".$v['id']."'=>'".$tag."'";
            if(isset($data['children'])){
                $temp = $this->copyArrayString($v,true);
                if(!empty($temp)){
                    $copyArray = array_merge($copyArray,$temp);
                }
            }
        }
        if(count($children) > 0){
            $copyArray[] = "'".$data['id']."' => [".implode(",",$children)."],";
        }
        return $copyArray;
    }

    public function createCmsMenu($leon_menu_data, $leon_database,$top_id = 0,$level2_menu = false,$level = 1)
    {
        $this->bladeTab = '';
        $unit_set = [];
        foreach($leon_menu_data as $val){
            //第一層
            $keep_menu_index = $this->cms_menu_index;
            $db_data = json_decode($leon_database[strtolower($val['id'])]['db_data'], true);
            $other_data = json_decode($leon_database[strtolower($val['id'])]['other_data'], true);
            $is_content = json_decode($leon_database[strtolower($val['id'])]['other_data'],true)['is_onepage'];
            if($top_id > 0){
                $type = ($level2_menu) ? 5 : 3;
                if(!$level2_menu){
                    if($level == 2){
                        $data = [
                            'id'=>$this->cms_menu_index,
                            'menu_id'=>$top_id,
                            'is_rank'=>1,
                            'child_model'=>$val['id'],
                            'child_key'=>'parent_id',
                        ];
                        DB::table('basic_cms_child')->updateOrInsert(['id' => $this->cms_menu_index], $data);
                    }
                    if($level == 3){
                        $data = [
                            'id'=>$this->cms_menu_index,
                            'is_active'=>1,
                            'model_name'=>$val['id'],
                            'child_id'=>$top_id,
                            'child_key'=>'second_id',
                        ];
                        DB::table('basic_cms_child_son')->updateOrInsert(['id' => $this->cms_menu_index], $data);
                    }
                }
            }else{
                $type = (empty($val['id'])) ? 1 : 2;
                $basic_web_key = [
                    'id'=>$this->cms_menu_index,
                    'title'=>$val['contenta'],
                    'branch_id'=>'[1]',
                ];
                DB::table('basic_web_key')->updateOrInsert(['id' => $this->cms_menu_index], $basic_web_key);
                $unit_set[$this->cms_menu_index] = 1;
                //關聯model
                $childrenModel = $this->getchildrenModel($val);
                $editContentString = implode(PHP_EOL,$this->getformatModel($val));
                $copyArrayString = $this->copyArrayString($val);
 
                if(!empty($editContentString)){
                    $editContentString = '$builder'.$editContentString.';';
                }
                $modelArraySonString = '';
                foreach($childrenModel as  $v){
                    $modelArraySonString .= "'".ucfirst($v)."' => \App\Models\PHP\\".ucfirst($v)."::class,".PHP_EOL;
                }
                //更新model檔案
                $updataModel = $this->updataModel($val);
                $updataModel = collect($updataModel)->groupBy('model')->all();
                foreach($updataModel as $k=>$v){
                    $ModelHtml = implode(PHP_EOL,$v->pluck('data')->toArray());
                    $Template = app_path() . '\Models\\PHP\\'.ucfirst($k) . ".php";
                    $tempdata = fopen($Template, "r");
                    $tempdata_html = fread($tempdata, filesize($Template));
                    $tempdata_html = str_replace('{$ModelHtml}', $ModelHtml , $tempdata_html);
                    $file = fopen($Template, "w");
                    fwrite($file, $tempdata_html);
                    fclose($file);
                }
                $files = glob(app_path('Models\PHP\\') . '*');
                foreach($files as $v){
                    $Template = $v;
                    $tempdata = fopen($Template, "r");
                    $tempdata_html = fread($tempdata, filesize($Template));
                    $tempdata_html = str_replace('{$ModelHtml}', $ModelHtml , $tempdata_html);
                    $file = fopen($Template, "w");
                    fwrite($file, $tempdata_html);
                    fclose($file);
                }

                //建立API檔案
                $filepath = app_path() . '\Cms\Api\\'.ucfirst($val['id']) . "Api.php";
                $Template = app_path() . '/Http/Controllers/LeonBuilder/Template/Api.php';
                $tempdata = fopen($Template, "r");
                $tempdata_html = fread($tempdata, filesize($Template));
                $tempdata_html = str_replace('{$Model}', ucfirst($val['id']), $tempdata_html);
                $tempdata_html = str_replace('{$Title}', $leon_database[strtolower($val['id'])]['db_note'], $tempdata_html);
                $modelArrayString = "'".ucfirst($val['id'])."' => \App\Models\PHP\\".ucfirst($val['id'])."::class,";
                $tempdata_html = str_replace('{$modelArray}', $modelArrayString, $tempdata_html);
                //列表結構
                $getData = collect($db_data)->where('show','true')->sortBy('show_rank')->all();
                $getDataList = $this->tableListType($getData,$other_data,ucfirst($val['id']));
                $imageGroup = collect($db_data)->where('formtype','imageGroup')->pluck('name')->all();
                $imageCol = (!empty($imageGroup)) ? '$builder->imageCol([\''. implode('\',\'',$imageGroup) .'\']);' : '';

                $tempdata_html = str_replace('{$getDataList}', $getDataList, $tempdata_html);
                $tempdata_html = str_replace('return $this->cmsMenu->use_id === 0', 'return $this->cmsMenu->use_id === '.$this->cms_menu_index, $tempdata_html);
                $tempdata_html = str_replace('{$modelArraySon}', $modelArraySonString, $tempdata_html);
                $tempdata_html = str_replace('{$copyArray}', implode(PHP_EOL,$copyArrayString), $tempdata_html);
                $tempdata_html = str_replace('{$deleteArray}', implode(PHP_EOL,$copyArrayString), $tempdata_html);
                $tempdata_html = str_replace('{$imageCol}', $imageCol, $tempdata_html);
                $tempdata_html = str_replace('{$editContent}', $editContentString, $tempdata_html);

                //匯出
                $export_field = collect($db_data)->where('excel','true')->all();
                $export_field_str = '';
                foreach($export_field as $v){
                    $export_field_str .= "'".$v['name']."' => '".$v['note']."',";
                }
                $getExport_html = '';
                $hasExport_html = '';
                if(!empty($export_field_str)){
                    $hasExport_html = ', GetExport';
                    $Template = app_path() . '/Http/Controllers/LeonBuilder/Template/getExport.php';
                    $tempdata = fopen($Template, "r");
                    $getExport_html = fread($tempdata, filesize($Template));
                    $getExport_html = str_replace('{$getExport}', $export_field_str, $getExport_html);
                }
                $tempdata_html = str_replace('{$getExport}', $getExport_html, $tempdata_html);
                $tempdata_html = str_replace('{$hasExport}', $hasExport_html, $tempdata_html);
                $file = fopen($filepath, "w");
                fwrite($file, $tempdata_html);
                fclose($file);
                $data = [
                    'id'=>$this->cms_menu_index,
                    'w_rank'=>0,
                    'is_active'=>1,
                    'branch_id'=>1,
                    'use_id'=>$this->cms_menu_index,
                    'title'=>$val['contenta'],
                    'key_id'=>$this->cms_menu_index,
                    'type'=>$type,
                    'is_content'=>$is_content,
                    'parent_id'=>$top_id,
                    'model'=>$val['id'],
                    'view_prefix'=>$val['id'],
                    'use_type'=>2
                ];
                DB::table('basic_cms_menu')->updateOrInsert(['id' => $this->cms_menu_index], $data);
                DB::table('basic_cms_menu_use')->updateOrInsert(['id' => $this->cms_menu_index], $data);
                //建立blade
                $blade_folder = collect(Config::get('cms.blade_template'))->where('key',DB::table('basic_branch_origin')->first()->blade_template)->first()['blade_folder'];

                self::dir_mkdir(resource_path() . '\views\\Fantasy\\cms\\'.$blade_folder.'\\'.$val['id']);
                $filepath = resource_path() . '\views\\Fantasy\\cms\\'.$blade_folder.'\\'.$val['id'].'\\' . "edit.blade.php";
                $Template = app_path() . '/Http/Controllers/LeonBuilder/Template/Editblade.php';
                $tempdata = fopen($Template, "r");
                $tempdata_html = fread($tempdata, filesize($Template));

                $search_unit = self::CreateBlade(collect($db_data)->where('search','true')->where('formtype','<>','')->all(),$val['id']);
                $batch_unit = self::CreateBlade(collect($db_data)->where('batch','true')->where('formtype','<>','')->all(),$val['id']);

                //組合tab
                $temp_tablist = ['基本設定'];
                $tab_index = 0;
                $main_unit = [];
                foreach($db_data as $v){
                    if(!empty($v['tab'])){
                        $tab_index = $tab_index + 1;
                        $temp_tablist[] = $v['tab'];
                    }
                    $main_unit[$tab_index][] = $v;
                }
                $main_unit_str = '';
                foreach($main_unit as $key=>$v){
                    $this->bladeTab .= '"Form_tab'.$key.'" => "'.$temp_tablist[$key].'",'.PHP_EOL;
                    $main_unit_str .= '@if($formKey == \'Form_tab'.$key.'\')';
                    $temp_data = [];
                    if($key == 0){
                        if($other_data['is_visible'] == '1'){
                            $temp_data[] = [
                                "note" => "審核通過",
                                "name" => "is_reviewed",
                                "formtype" => "radio_btn_reviewed",
                                "model"=>"",
                                "tip" => ""
                            ];
                            $temp_data[] = [
                                "note" => "是否顯示",
                                "name" => "is_visible",
                                "formtype" => "radio_btn",
                                "model"=>"",
                                "tip" => ""
                            ];
                            $temp_data[] = [
                                "note" => "是否顯示於預覽站",
                                "name" => "is_visible",
                                "formtype" => "radio_btn",
                                "model"=>"",
                                "tip" => ""
                            ];
                        }
                        if($other_data['is_rank'] == '1'){
                            $temp_data[] = [
                                "note" => "排序",
                                "name" => "w_rank",
                                "formtype" => "numberInput",
                                "model"=>"",
                                "tip" => ""
                            ];
                        }
                    }
                    $temp_unit_arr = array_merge($temp_data,collect($v)->where('formtype','<>','')->all());
                    $main_unit_str .= self::CreateBlade($temp_unit_arr,$val['id']);
                    $main_unit_str .= '@endif';
                }
                $childrenModel = $this->getchildrenBlade($val,$leon_database);

                $tempdata_html = str_replace('{$search_unit}', $search_unit, $tempdata_html);
                $tempdata_html = str_replace('{$batch_unit}', $batch_unit, $tempdata_html);
                $tempdata_html = str_replace('{$main_unit}', $main_unit_str, $tempdata_html);
                $tempdata_html = str_replace('{$son_unit}', $childrenModel, $tempdata_html);

                //段落編輯
                

                $file = fopen($filepath, "w");
                fwrite($file, $tempdata_html);
                fclose($file);

                $filepath = resource_path() . '\views\\Fantasy\\cms\\'.$blade_folder.'\\'.$val['id'].'\\' . "setting.php";
                $file = fopen($filepath, "w");
                fwrite($file, '<?php'.PHP_EOL.'$menuList = ['.PHP_EOL.$this->bladeTab.PHP_EOL.'];');
                fclose($file);
            }

            $this->cms_menu_index = $this->cms_menu_index + 1;
            if(isset($val['children']) && !empty($val['children'])){
                $temp_level2_menu = (empty($val['id'])) ? true : false;
                $temp_level = (empty($val['id'])) ? 1 : ($level + 1);
                $this->createCmsMenu($val['children'], $leon_database, $keep_menu_index, $temp_level2_menu,$temp_level);
            }
        }
        if(!empty($unit_set)){
            DB::table('basic_branch_origin_unit')->updateOrInsert(['id' => 1], ['unit_set'=>json_encode($unit_set,JSON_UNESCAPED_UNICODE)]);
        }
    }
    public function getchildrenBlade($data,$leon_database){
        $unit_str  = '';
        foreach($data['children'] ?? [] as $val){
            $this->bladeTab .= '"Form_'.strtolower($val['id']).'" => "'.$val['contenta'].'",';
            $unit_str .= PHP_EOL.'@if($formKey == \'Form_'.strtolower($val['id']).'\')'.PHP_EOL;
            $db_data = json_decode($leon_database[strtolower($val['id'])]['db_data'], true);
            $other_data = json_decode($leon_database[strtolower($val['id'])]['other_data'], true);
            //段落編輯
            if($other_data['isArticle'] == 1){
                $unit_str .= "@include('Fantasy.cms_view.back_article_v3',['Model'=>'".$val['id']."','ThreeModel'=>'".$val['children'][0]['id']."'])".PHP_EOL;
            }else{
                $tableSet = self::tableSet(collect($db_data)->where('show','true')->all(),$other_data);
                $son_unit_str = self::CreateBlade(collect($db_data)->where('formtype','<>','')->all(),$val['id'],true);
                $Template = app_path() . '/Http/Controllers/LeonBuilder/Template/WNsonTable.php';
                $tempdata = fopen($Template, "r");
                $tempdata_html = fread($tempdata, filesize($Template));
                $tempdata_html = str_replace('{$son_unit}', $son_unit_str, $tempdata_html);
                $tempdata_html = str_replace('{$tableSet}', $tableSet, $tempdata_html);
                $tempdata_html = str_replace('{$sort}', ($other_data['is_rank'] == '1') ? 'yes':'no', $tempdata_html);
                $tempdata_html = str_replace('{$create}', ($other_data['isCreate'] == '0') ? 'yes':'no', $tempdata_html);
                $tempdata_html = str_replace('{$delete}', ($other_data['isDelete'] == '0') ? 'yes':'no', $tempdata_html);
                $tempdata_html = str_replace('{$copy}', ($other_data['isCopy'] == '0') ? 'yes':'no', $tempdata_html);
                $tempdata_html = str_replace('{$son_model}', $val['id'], $tempdata_html);
                $tempdata_html = str_replace('{$title}', $val['contenta'], $tempdata_html);
                $MultiImgcreate = collect($db_data)->whereIn('formtype',['imageGroup','imageGroup_all','imageGroup_3size'])->count();
                $tempdata_html = str_replace('{$MultiImgcreate}', ($MultiImgcreate > 0) ? 'yes':'no', $tempdata_html);
    
                $three_unit_list = '';
                foreach($val['children'] ?? [] as $v){
                    $db_data_three = json_decode($leon_database[strtolower($v['id'])]['db_data'], true);
                    $other_data_three = json_decode($leon_database[strtolower($v['id'])]['other_data'], true);

                    $three_tableSet = self::ThreetableSet(collect($db_data_three)->where('show','true')->all(),$other_data_three);
                    $three_unit_str = self::CreateBlade(collect($db_data_three)->where('formtype','<>','')->all(),$val['id'],true);
                    $three_path = app_path() . '/Http/Controllers/LeonBuilder/Template/WNthreeTable.php';
                    $three_tempdata = fopen($three_path, "r");
                    $three_tempdata_html = fread($three_tempdata, filesize($three_path));
                    $three_tempdata_html = str_replace('{$three_unit}', $three_unit_str, $three_tempdata_html);
                    $three_tempdata_html = str_replace('{$three_model}', $v['id'], $three_tempdata_html);
                    $three_tempdata_html = str_replace('{$title}', $v['contenta'], $three_tempdata_html);
                    $three_tempdata_html = str_replace('{$create}', ($other_data_three['isCreate'] == '0') ? 'yes':'no', $three_tempdata_html);
                    $three_tempdata_html = str_replace('{$delete}', ($other_data_three['isDelete'] == '0') ? 'yes':'no', $three_tempdata_html);
                    $three_tempdata_html = str_replace('{$three_tableSet}', $three_tableSet, $three_tempdata_html);
                    $three_unit_list .= $three_tempdata_html;
                }
                
                $tempdata_html = str_replace('{$three_unit}', $three_unit_list, $tempdata_html);
                $unit_str .= $tempdata_html;
            }
            $unit_str .= '@endif';
        }
        return  $unit_str;
    }
    public static function tableSet($data,$other_data){
        $html = '';
        foreach($data as $val){
            if(in_array($val['formtype'],['textInput'])){
                if(!empty($val['img'])){
                    $html .= "['type' => 'imgText','title' => '".$val['note']."','value' => '".$val['name']."','img' => ['".$val['img']."'],'auto' => true],";
                }else{
                    $html .= "['type' => 'just_show','title' => '".$val['note']."','value' => '".$val['name']."','auto' => true],";
                }
            }
        }
        if($other_data['is_visible'] == '1'){
            $html .= "['type' => 'radio_btn','title' => '預覽','value' => 'is_preview'],";
            $html .= "['type' => 'radio_btn','title' => '是否顯示','value' => 'is_visible']";
        }
        return $html;
    }
    public static function ThreetableSet($data,$other_data){
        $html = '';
        foreach($data as $val){
            if(in_array($val['formtype'],['textInput'])){
                if(!empty($val['img'])){
                    $html .= "['type' => 'imgText','title' => '".$val['note']."','value' => '".$val['name']."','img' => ['".$val['img']."'],'auto' => true],";
                }else{
                    $html .= "['type' => 'just_show','title' => '".$val['note']."','value' => '".$val['name']."','auto' => true],";
                }
            }
        }
        return $html;
    }
    public static function CreateBlade($data,$Model,$is_son = false){
        $html = '';
        foreach($data as $val){
            $path = ($is_son) ? 'UnitSon':'Unit';
            $tip = $val['tip'] ?? '';

            $disable = $val['disable'] ?? 'false';

            $Template = app_path() . '/Http/Controllers/LeonBuilder/Template/'.$path.'/'.$val['formtype'].'.php';
            $tempdata = fopen($Template, "r");
            $tempdata_html = fread($tempdata, filesize($Template));
            $tempdata_html = str_replace('{$name}', $val['name'], $tempdata_html);
            $tempdata_html = str_replace('{$title}', $val['note'], $tempdata_html);
            $tempdata_html = str_replace('{$tip}', $tip, $tempdata_html);
            $tempdata_html = str_replace('{$disabled}', $disable == 'true' ? 'disable':'', $tempdata_html);
			if ($val['model'] == "") {
				// $this->CreateOptionFunction($Model . '_' . $data['name'], $data['note']);
				$options = 'OptionFunction::' . $Model . '_' . $val['name'] . '()';
			} else {
				//判斷有無使用同一個自訂function
				if (strpos($val['model'], 'CC_') !== false) {
					// $this->CreateOptionFunction(str_replace("CC_", "", $data['model']), $data['note']);
					$options = 'OptionFunction::' . str_replace("CC_", "", $val['model']) . '()';
				} else {
					$options = '$options[\'' . ucfirst($val['model']) . '\']';
				}
			}
            $tempdata_html = str_replace('{$options}', $options, $tempdata_html);
            $html .= PHP_EOL.$tempdata_html;
        }
        return $html;
    }
    public static function tableType($table, $type, $name, $note)
    {
        $table_return = '';
        if ($type == 'int') {
            $table_return = $table->integer($name)->comment($note);
        }
        if ($type == 'text') {
            $table_return = $table->text($name)->comment($note);
        }
        if ($type == 'varchar') {
            $table_return = $table->string($name)->comment($note);
        }
        if ($type == 'date') {
            $table_return = $table->date($name)->comment($note);
        }
        if ($type == 'datetime') {
            $table_return = $table->dateTime($name)->comment($note);
        }
        if ($type == 'double') {
            $table_return = $table->double($name, 15, 8)->comment($note);
        }
        if ($type == 'json') {
            $table_return = $table->json($name)->comment($note);
        }
        return $table_return;
    }
    public static function tableListType($getData,$other_data,$model)
    {
        $table_return = '';

        foreach($getData as $val){
            if($val['formtype'] == 'textInput'){
                $table_return .= "->textCol('".$val['name']."', '".$val['note']."', 250)".PHP_EOL;
            }
            if($val['formtype'] == 'imageGroup'){
                $table_return .= "->imageCol('".$val['name']."', '".$val['note']."')".PHP_EOL;
            }
            if(in_array($val['formtype'],['radio_btn'])){
                $table_return .= "->radioButtonCol('".$val['name']."', '".$val['note']."')".PHP_EOL;
            }
            if(in_array($val['formtype'],['radio_area','select2'])){
                if (strpos($val['model'], 'CC_') !== false) {
                    $table_return .= "->selectCol('".$val['name']."', '".$val['note']."', OptionFunction::".str_replace("CC_", "", $val['model'])."())".PHP_EOL;
                }else{
                    if(empty($val['model'])){
                        $table_return .= "->selectCol('".$val['name']."', '".$val['note']."', OptionFunction::".str_replace("CC_", "", $model.'_'.$val['name'])."())".PHP_EOL;
                    }else{
                        $table_return .= "->selectCol('".$val['name']."', '".$val['note']."', M('".ucfirst($val['model'])."')::get()->toArray())".PHP_EOL;
                    }
                }
            }
            if($val['formtype'] == 'select2Multi'){
                if (strpos($val['model'], 'CC_') !== false) {
                    $table_return .= "->selectMultiCol('".$val['name']."', '".$val['note']."', OptionFunction::".str_replace("CC_", "", $val['model'])."())".PHP_EOL;
                }else{
                    if(empty($val['model'])){
                        $table_return .= "->selectMultiCol('".$val['name']."', '".$val['note']."', OptionFunction::".str_replace("CC_", "", $model.'_'.$val['name'])."())".PHP_EOL;
                    }else{
                        $table_return .= "->selectMultiCol('".$val['name']."', '".$val['note']."', M('".ucfirst($val['model'])."')::get()->toArray())".PHP_EOL;
                    }
                }
            }
            if($val['formtype'] == 'datePicker'){
                $table_return .= "->dateCol('".$val['name']."', '".$val['note']."')".PHP_EOL;
            }
            if($val['formtype'] == 'colorPicker'){
                $table_return .= "->colorCol('".$val['name']."', '".$val['note']."')".PHP_EOL;
            }
        }
        $radioButtonCol = '';
        if($other_data['is_rank'] == '1'){
            $table_return .= "->rankInputCol('w_rank', '排序')";
        }
        if($other_data['is_visible'] == '1'){
            $radioButtonCol .= "'is_preview' => '預覽',";
            $radioButtonCol .= "'is_visible' => '顯示狀態',";
        }
        if(!empty($radioButtonCol)){
            $table_return .= "->radioButtonCol([".$radioButtonCol."])".PHP_EOL;
        }
        $table_return .= "->timestampCol('updated_at', '最後更新日期')".PHP_EOL;
        $table_return .= '->setConfig([\'draggable\' => true,\'selectable\' => true,\'multiSortable\' => true,\'pagination\' => $pagination])'.PHP_EOL;
        $table_return .= '->setDefault(\'sortable\', true);';
        
        return $table_return;
    }



    public function dir_path($path)
    {
        $path = str_replace('\\', '/', $path);
        if (substr($path, -1) != '/') $path = $path . '/';
        return $path;
    }
    public function dir_list($path, $exts = '', $list = array())
    {
        $path = $this->dir_path($path);
        $files = glob($path . '*');
        foreach ($files as $v) {
            if (!$exts || preg_match('/\.($exts)/i', $v)) {
                $list[] = $v;
                if (is_dir($v)) {
                    $list = $this->dir_list($v, $exts, $list);
                }
            }
        }
        return $list;
    }
    public function recursive_dir_copy($src, $dst)
    {
        if (empty($src) || empty($dst)) {
            return false;
        }
        $dir = opendir($src);
        self::dir_mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $srcRecursiveDir = $src . DIRECTORY_SEPARATOR . $file;
                $dstRecursiveDir = $dst . DIRECTORY_SEPARATOR . $file;
                if (is_dir($srcRecursiveDir)) {
                    self::recursive_dir_copy($srcRecursiveDir, $dstRecursiveDir);
                } else {
                    copy($srcRecursiveDir, $dstRecursiveDir);
                }
            }
        }

        closedir($dir);
        return true;
    }
    public function dir_mkdir($path = '', $mode = 0755, $recursive = true)
    {
        clearstatcache();
        if (!is_dir($path)) {
            mkdir($path, $mode, $recursive);
            return chmod($path, $mode);
        }
        return true;
    }


    public function index(Request $request)
    {
        return view('leon.index');
    }
    public function menu_load($MenuData)
    {
        foreach ($MenuData as $key1 => $v1) {
            $MenuData[$key1]['content'] = $v1['contenta'];
            if(isset($v1['children'])){
                $MenuData[$key1]['children'] = $this->menu_load($MenuData[$key1]['children']);
            }
        }
        return $MenuData;
    }
    public function menu(Request $request)
    {
        $ajax = $request->ajax ?: false;
        if($ajax){
            DB::table('leon_menu')->update(['db_data'=>$request->data]);
            return 'ok';
        }

        $leon_menu = DB::table('leon_menu')->first();
        $leon_database = json_decode(json_encode(DB::table('leon_database')->get()), true);
        $MenuData = json_decode($leon_menu->db_data, true);
        $MenuData = $this->menu_load($MenuData);

        $TheModels = $NewMenuData = [];

        foreach ($leon_database as $key => $val) {
            if (!in_array(ucfirst($val['db_name']), $TheModels)) {
                $NewMenuData[] = ["id" => ucfirst($val['db_name']), "content" => $val['db_note'], "contenta" => $val['db_note']];
            }
        }

        $MenuData_en = json_encode($MenuData, JSON_UNESCAPED_UNICODE);
        $NewMenuData_en = json_encode($NewMenuData, JSON_UNESCAPED_UNICODE);
        return view('leon.menu', ['NewMenuData_en' => $NewMenuData_en,'MenuData'=>$MenuData_en]);
    }
    public function database(Request $request)
    {

        if (!empty($request->ajax)) {
            $key = $request->_key;
            $id = $request->_dataId;
            $value = $request->value;
            $leon_database = DB::table('leon_database')->where('id', $id)->first();
            $other_data = json_decode($leon_database->other_data, true);
            $other_data[$key] = $value;
            $other_data = json_encode($other_data, JSON_UNESCAPED_UNICODE);
            DB::table('leon_database')->where('id', $id)->update(['other_data' => $other_data]);
            return response()->json(['code' => 1]);
        }

        $leon_database = json_decode(json_encode(DB::table('leon_database')->get()), true);
        foreach ($leon_database as $key => $val) {
            $leon_database[$key]['other_data'] = json_decode($val['other_data'], true);
        }

        return view('leon.database', ['leon_database' => $leon_database]);
    }
    public function database_add(Request $request)
    {
        $id = $request->id ?: '';
        $getdata = $request->getdata;
        if(!empty($id)){
            $leon_database = DB::table('leon_database')->where('id', $id)->first();
            $other_data = json_decode($leon_database->other_data, true);
        }

        if ($getdata) {
            $spreadsheetData = json_decode($leon_database->db_data, true);
            array_unshift($spreadsheetData, ['note' => $leon_database->db_note, 'name' => $leon_database->db_name]);
            return $spreadsheetData;
        }

        if ($request->ajax) {
            $data = $request->value;
            DB::table('leon_database')->updateOrInsert(['db_name' => $data['name']], [
                'db_note' => $data['note'],
                'db_name' => $data['name'],
                'db_data' => json_encode($data['list'], JSON_UNESCAPED_UNICODE),
                'other_data' => json_encode($request->otherdata, JSON_UNESCAPED_UNICODE),
            ]);
            return response()->json(['code' => 1]);
        }
        return view('leon.database_add', ['id' => $id,'other_data'=>$other_data ?? []]);
    }
    public function LangData(Request $request)
    {
        if ($request->ajax) {
            $main_lang = $request->main_lang;
            $langs = $request->langs;
            $tables = array_map(function ($value) {
                $temp = (array) $value;
                return substr($temp[array_key_first($temp)], 3);
            }, DB::select('SHOW TABLES LIKE "' . $main_lang . '%"'));

            foreach ($langs as $lang) {
                foreach ($tables as $table) {
                    $main_table = $main_lang . $table;
                    $new_table = $lang . $table;
                    if (!\Schema::hasTable($new_table)) {
                        DB::statement('CREATE TABLE ' . $new_table . ' LIKE ' . $main_table);
                        DB::statement('INSERT ' . $new_table . ' SELECT * FROM ' . $main_table);
                    }
                }
            }
            return response()->json(['code' => 1]);
        }
        return view('leon.LangData');
    }

    public function HtmltoBlade(Request $request)
    {
        if ($request->ajax) {
            $path = $request->path;
            $blade_path = $request->blade_path;
            $allfiles = collect($this->dir_list(public_path($path)))->filter(function ($item) {
                return (strpos($item, '.html') !== false);
            });
            $htmlPath = public_path($path);
            $bladePath = resource_path('views\\' . $blade_path);

            foreach ($allfiles as $val) {
                //判斷不存在
                if (!is_file($bladePath . '\\' . str_replace(".html", ".blade.php", basename($val)))) {
                    copy($val, $bladePath . '\\' . str_replace(".html", ".blade.php", basename($val)));
                }
            }

            return response()->json(['code' => 1]);
        }

        $folderList = collect(array_diff(scandir(public_path()), array('..', '.')))->filter(function ($item, $key) {
            return is_dir(public_path($item));
        });
        $bladeList = collect(array_diff(scandir(resource_path('views')), array('..', '.')))->filter(function ($item, $key) {
            return is_dir(resource_path('views/' . $item));
        });
        return view('leon.HtmltoBlade', ['folderList' => $folderList, 'bladeList' => $bladeList]);
    }

    public function BladelangUI(Request $request)
    {
        if ($request->ajax) {
            $blade_path = $request->blade_path;

            $path = resource_path('views\\' . $blade_path);
            $Copypath = resource_path('views\Front-keep\\' . $blade_path);

            self::recursive_dir_copy($path, $Copypath);

            $allfiles = collect($this->dir_list(resource_path('views\\' . $blade_path)))->filter(function ($item) {
                return (strpos($item, '.blade.php') !== false);
            });

            $strList = [];
            foreach ($allfiles as $pathVal) {
                if (!is_dir($pathVal)) {
                    $filename = str_replace(str_replace("\\", "/", resource_path('views')), "", $pathVal);
                    $filename = str_replace("/", "@", $filename);
                    $filename = str_replace(".blade.php", "", $filename);

                    $langKey = 0;

                    $text = file_get_contents($pathVal);

                    $noedit_arr = [];
                    $output = preg_replace_callback('/data-lang=".*?"/u', function ($m) use (&$langKey, $filename, &$strList) {
                        //排除

                        $break = false;
                        if (strpos($m[0], '()') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '}}') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '{{') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '{!!') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '!!}') !== false) {
                            $break = true;
                        }
                        if ($break) {
                            return $m[0];
                        } else {

                            $m[0] = str_replace("data-lang=\"", "", $m[0]);
                            $m[0] = mb_substr($m[0], 0, -1);
                            $langKey++;
                            $strList[$filename . '_' . $langKey] = $m[0];
                            return 'data-lang="{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'noedit\'=>true]) !!}"';
                        }
                    }, $text);
                    $output = preg_replace_callback('/data-default=".*?"/u', function ($m) use (&$langKey, $filename, &$strList) {
                        //排除

                        $break = false;
                        if (strpos($m[0], '()') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '}}') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '{{') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '{!!') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '!!}') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '@if') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '@endif') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '@lang') !== false) {
                            $break = true;
                        }
                        if ($m[0] == "data-default=\"\"") {
                            $break = true;
                        }
                        if ($break) {
                            return $m[0];
                        } else {
                            $m[0] = str_replace("data-default=\"", "", $m[0]);
                            $m[0] = mb_substr($m[0], 0, -1);
                            $langKey++;
                            $strList[$filename . '_' . $langKey] = $m[0];
                            return 'data-lang="{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'noedit\'=>true]) !!}"';
                        }
                    }, $output);
                    $output = preg_replace_callback('/placeholder=".*?"/u', function ($m) use (&$noedit_arr, &$langKey, $filename, &$strList) {
                        //排除

                        $break = false;
                        if (strpos($m[0], '()') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '}}') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '{{') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '{!!') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '!!}') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '@if') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '@endif') !== false) {
                            $break = true;
                        }
                        if (strpos($m[0], '@lang') !== false) {
                            $break = true;
                        }
                        if ($m[0] == "placeholder=\"\"") {
                            $break = true;
                        }
                        if ($break) {
                            return $m[0];
                        } else {
                            $m[0] = str_replace("placeholder=\"", "", $m[0]);
                            $m[0] = mb_substr($m[0], 0, -1);
                            $langKey++;
                            $strList[$filename . '_' . $langKey] = $m[0];
                            return 'data-lang="{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'noedit\'=>true]) !!}"';
                        }
                    }, $output);
                    $output = preg_replace_callback('/<br>/u', function ($m) use ($noedit_arr) {
                        return '&nbsp;';
                    }, $output);
                    $output = preg_replace_callback('/<\/br>/u', function ($m) use ($noedit_arr) {
                        return '&nbsp;';
                    }, $output);
                    $output = preg_replace_callback('/([a-zA-Z0-9"])>(.*?)</u', function ($m) use (&$langKey, $filename, &$strList) {
                        if ($m[2] != '') {
                            //排除
                            $break = false;
                            $hasOther = false;
                            $exit = false;
                            if (strpos($m[2], '()') !== false) {
                                $break = true;
                            }
                            if (strpos($m[2], '}}') !== false) {
                                $break = true;
                            }
                            if (strpos($m[2], '{{') !== false) {
                                $break = true;
                            }
                            if (strpos($m[2], '{!!') !== false) {
                                $break = true;
                                $exit = true;
                            }
                            if (strpos($m[2], '!!}') !== false) {
                                $break = true;
                                $exit = true;
                            }
                            if (strpos($m[2], '@if') !== false) {
                                $break = true;
                                $exit = true;
                            }
                            if (strpos($m[2], '@endif') !== false) {
                                $break = true;
                                $exit = true;
                            }
                            if (strpos($m[2], '@lang') !== false) {
                                $break = true;
                                $exit = true;
                            }
                            $cancel_arr = [' ', '', '+', '-', '*', '/', '!', '！'];
                            if (in_array(preg_replace('/\s(?=)/', '', $m[2]), $cancel_arr) || is_numeric(preg_replace('/\s(?=)/', '', $m[2]))) {
                                $break = true;
                                $exit = true;
                            }
                            preg_match_all("/{{.*?}}/", $m[2], $matches);

                            if (!empty($matches) && count($matches[0]) == 1 && !$exit) {
                                $temp = $m[0];
                                if (preg_match('/[0-9a-zA-Z\x{4e00}-\x{9fff}]+/u', preg_replace('/x+/', '', preg_replace('/\s+/', '', preg_replace("/{{.*}}/i", '', $m[2]))))) {
                                    $m[2] = preg_replace("/{{.*}}/i", '[value]', $m[2]);
                                    if (preg_replace('/\s+/', '', $m[2]) != '>[value]<' && strpos(preg_replace('/\s+/', '', $m[2]), ')?') === false) {
                                        $matches[0][0] = str_replace("{{", "", $matches[0][0]);
                                        $matches[0][0] = str_replace("}}", "", $matches[0][0]);
                                        $break = false;
                                        $hasOther = true;
                                    } else {
                                        $m[2] = $temp;
                                    }
                                }
                            }
                            if ($break) {
                                return $m[0];
                            } else {
                                if (preg_match('/[0-9a-zA-Z\x{4e00}-\x{9fff}]+/u', $m[2]) || !preg_match('/\$.*?\)/i', $m[2])) {
                                    $langKey++;
                                    $strList[$filename . '_' . $langKey] = $m[2];
                                    if ($hasOther) {
                                        return $m[1] . '>{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'value\'=>' . $matches[0][0] . ' ]) !!}<';
                                    } else {
                                        return $m[1] . '>{!! langkey(\'' . $filename . '_' . $langKey . '\') !!}<';
                                    }
                                } else {
                                    return $m[0];
                                }
                            }
                        } else {
                            return $m[0];
                        }
                    }, $output);
                    $output = preg_replace_callback('/<main/u', function ($m) use ($noedit_arr) {
                        return implode(PHP_EOL, $noedit_arr) . PHP_EOL . $m[0];
                    }, $output);
                    $output = preg_replace_callback('/<!--.*?-->/u', function ($m) use ($noedit_arr) {
                        return '';
                    }, $output);
                    if (empty($request->test)) {
                        $file = fopen($pathVal, "w");
                        fwrite($file, $output);
                        fclose($file);
                    }
                }
            }
            $ss = json_encode($strList, JSON_UNESCAPED_UNICODE);
            $ss = str_replace("\":\"", "\"=>\"", $ss);
            $ss = str_replace("\",\"", "\"," . PHP_EOL . "\"", $ss);
            $ss = str_replace("{\"", "return [" . PHP_EOL . "\"", $ss);
            $ss = str_replace("\"}", "\"" . PHP_EOL . "];", $ss);

            self::dir_mkdir($path . '/lang');
            $file = fopen($path . '/lang/setting.php', "w");
            fwrite($file, '<?php' . PHP_EOL . $ss);
            fclose($file);

            $file = fopen($path . '/lang/setting.csv', "w");
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['key', '待翻譯內容', '翻譯內容']);
            foreach ($strList as $k => $v) {
                fputcsv($file, [$k, $v, '']);
            }
            fclose($file);
            return response()->json(['code' => 1]);
        }
        $bladeList = collect(array_diff(scandir(resource_path('views')), array('..', '.')))->filter(function ($item, $key) {
            return is_dir(resource_path('views/' . $item));
        });
        return view('leon.BladelangUI', ['bladeList' => $bladeList]);
    }

    public function LeonSiteMap_GetHtml($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => array(
                'Cookie: BankOfTaiwanCookie=!PS14pCpeXMBFSBR9DVv05lRmBwxxiegqNSF83DPhyHo8ojlyIC7ki3denOk1FTXGJCVqFp/rFxhCApr5Utap74gS5hPlRMqbF+AR63rW2g==; ASP.NET_SessionId=nephfrqzzolwqx2beprbcrbu; TS01afdfb9=01b742a98f65468179c34a1de554105719dd6fddaf42fb5d1cc629c7f94cd44a8e61631c73a1e78fc933e2ed7907ff1a1b0b81060001be0a39d562a07044ea6d4274d35250c138c7879c57e81fe8aab8a1e7f6c713'
            ),
        ));
        $response = curl_exec($curl);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headerStr = substr($response, 0, $headerSize);
        $bodyStr = substr($response, $headerSize);
        $headers = self::headersToArray($headerStr);

        curl_close($curl);
        return $response;
    }
    public function headersToArray($str)
    {
        $headers = array();
        $headersTmpArray = explode("\r\n", $str);
        for ($i = 0; $i < count($headersTmpArray); ++$i) {
            // we dont care about the two \r\n lines at the end of the headers
            if (strlen($headersTmpArray[$i]) > 0) {
                // the headers start with HTTP status codes, which do not contain a colon so we can filter them out too
                if (strpos($headersTmpArray[$i], ":")) {
                    $headerName = substr($headersTmpArray[$i], 0, strpos($headersTmpArray[$i], ":"));
                    $headerValue = substr($headersTmpArray[$i], strpos($headersTmpArray[$i], ":") + 1);
                    $headers[$headerName] = $headerValue;
                }
            }
        }
        return $headers;
    }
    protected $UrlList;
    public function LeonSiteMap_Scan($url = '')
    {
        $domain = b_url('');
        $url = (!empty($url)) ? $url : $domain;
        $html = self::LeonSiteMap_GetHtml($url);
        $document = HtmlDomParser::str_get_html($html);
        unset($html);
        //掃描本頁面
        foreach ($document->find('a') as $e) {
            if (strpos($e->href, $domain) !== false && strpos($e->href, 'download') === false && !in_array($e->href, array_column($this->UrlList, 'url'))) {
                $pr = number_format(round(1 / count(explode("/", trim(str_ireplace(array("http://", "https://"), "", $e->href), "/"))) + 0.5, 3), 1);
                $this->UrlList[] = ['pr' => $pr, 'url' => $e->href];
                //self::LeonSiteMap_Scan($e->href);
            }
        }
    }
    public function Sitemap(Request $request)
    {

        if ($request->ajax) {
            self::LeonSiteMap_Scan($request->domain, $request->scan_url);
            return response()->json([
                'message' => 'OK',
                'url' => $this->UrlList
            ]);
        }
        return view('leon.Sitemap');
    }
}
