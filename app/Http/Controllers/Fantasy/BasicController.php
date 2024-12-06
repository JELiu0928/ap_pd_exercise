<?php

namespace App\Http\Controllers\Fantasy;

use App;
use App\Http\Controllers\Fantasy\PermissionController as PermissionFunction;
use App\Http\Controllers\OptionFunction;
use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;
use App\Models\Basic\Cms\CmsDataAuth;
use App\Models\Basic\Cms\CmsMenu;
use App\Models\Basic\FantasyUsers;
use App\Models\Basic\Fms\FmsFile;
use BaseFunction;
use Config;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Mail;
use Redirect;
use View;

class BasicController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
    }
    public function selectSearch($branch, Request $request)
    {
        $options_model = $request->options_model;
        $main_model = $request->main_model;
        $keyword = $request->keyword;
        if(!empty($main_model)){
            $data = M($options_model)::getListSon($main_model,$keyword);
        }else{
            $data = M($options_model)::getList(false,$keyword);
        }
        return ['data'=>$data,'count'=>count($data)];
    }
    public function ClearPreviewRecord($branch, Request $request)
    {
        Session::forget('Preview_record');
        Session::save();
        return 'ok';
    }
    //檔案下載
    public function download($branch, Request $request)
    {
        try {
            $id = Crypt::decrypt($request->idorname);
            $FmsFile = M('FmsFile')::find($id);
        } catch (DecryptException $e) {
            $url_name = $request->idorname;
            $FmsFile = M('FmsFile')::where('url_name', $url_name)->first();
        }
        if (isset($FmsFile) && !empty($FmsFile)) {
            //pdf直接網頁打開
            if (strtolower($FmsFile['type']) == 'pdf') {
                $header = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $FmsFile['title'] . '.' . $FmsFile['type'] . '"',
                ];
                return response()->file(public_path($FmsFile['real_route']), $header);
            }
            return \Response::download(public_path($FmsFile['real_route']), $FmsFile['title'] . '.' . $FmsFile['type']);
        }
    }

    /*根據model name 跟 id 得該筆資料*/
    public function getInformation()
    {
        $branch = request()->branch;
        $locale = request()->locale;
        $model = request()->model;
        $id = request()->id;

        $data = Config::get('models')[$model]::find($id);

        if (!empty($data->title)) {
            $data->title = $data->title;
        }
        if (!empty($data->w_title)) {
            $data->title = $data->w_title;
        }
        if (!empty($data->tw_title)) {
            $data->title = $data->tw_title;
        }

        $message['info'] = $data;

        return $data;
    }
    /*得編輯區塊*/
    public static function copyThree(Request $request)
    {
        $CopyData = $request->CopyData;
        $setting = json_decode($request->setting, true);
        $NewData = [];
        foreach ($CopyData as $key => $val) {
            $name_array = array_keys($val);
            $result = array_combine($name_array, array_reduce($val, 'array_merge', []));
            foreach ($result as $k => $val) {
                if (is_array($result[$k])) {
                    $result[$k] = array_filter($result[$k]);
                    $result[$k] = json_encode($result[$k], JSON_UNESCAPED_UNICODE);
                }
            }
            $NewData[$key] = $result;
        }
        $setting['row']['son'][array_key_first($NewData)] = [$NewData[array_key_first($NewData)]];
        $setting['son_son_db'] = array_key_first($NewData);
        $setting['randomWord_va'] = $NewData[array_key_first($NewData)]['quillSonFantasyKey'];
        $setting['three_select2MultiIndex'] = 0;
        foreach ($setting['tabSet'] as $val) {
            if (isset($val['is_three']) && $val['is_three'] == 'yes') {
                $setting['three'] = $val['three'];
                $setting['row_2'] = $val;
            }
        }
        return ['copydata' => View::make('Fantasy.cms_view.includes.template.WNsontable.copy_three', $setting)->render()];
    }
    public static function copySon(Request $request)
    {
        $CopyData = $request->CopyData;
        $NewData = [];
        $index = 0;
        foreach ($CopyData as $key => $result) {
            // $name_array = array_keys($val);
            if ($index == 0) {
                // $result = array_combine($name_array, array_reduce($val, 'array_merge', []));
                foreach ($result as $k => $val) {
                    if (is_array($result[$k])) {
                        $result[$k] = array_filter($result[$k]);
                        $result[$k] = json_encode($result[$k], JSON_UNESCAPED_UNICODE);
                    }
                }
                $NewData[$key] = $result;
            } else {
                $temp_array = [];
                foreach ($val['id'] as $k => $v) {
                    $temp_arr = [];
                    foreach ($result as $name_array_val) {
                        $temp_arr[$name_array_val] = $val[$name_array_val][$k] ?? '';
                        if (is_array($temp_arr[$name_array_val])) {
                            $temp_arr[$name_array_val] = array_filter($temp_arr[$name_array_val]);
                            $temp_arr[$name_array_val] = json_encode($temp_arr[$name_array_val], JSON_UNESCAPED_UNICODE);
                        }
                    }
                    $temp_array[] = $temp_arr;
                }
                $NewData[array_key_first($CopyData)]['son'][$key] = $temp_array;
            }
            $index++;
        }
        $setting = json_decode($request->setting, true);
        $setting['value'] = $NewData;
        return ['copydata' => View::make('Fantasy.cms_view.includes.template.WNsontable.copy_son', $setting)->render()];
    }
    public static function getEditContent(Request $request)
    {
        $formKey = $request->formKey;
        $menuId = $request->menuId;
        $dataId = $request->dataId;
        $route = $request->route;
        $data = $associationData = [];

        $menuData = parent::$ModelsArray['CmsMenu']::where('id', $menuId)->first();
        if (!empty($dataId)) {
            $data = parent::$ModelsArray[$menuData['model']]::where('id', $dataId)->first();
            $associationData = parent::getAssociationData($menuId, $dataId);
        }
        $josnArray = parent::getJsonArray($menuId);
        if (!empty($josnArray)) {
            foreach ($josnArray as $key => $value) {
                $data['json'][$value] = json_decode($data[$value], true);
            }
        }
        $options = parent::getOption($menuId);
        return View::make(
            'Fantasy.cms.' . $route . '.edit',
            [
                "formKey" => $formKey,
                "data" => $data,
                "model" => $menuData['model'],
                "options" => $options,
                "associationData" => $associationData,
                "menu_id" => $menuId,
                "need_review" => true,
                "can_review" => true,
            ]
        )->render();
    }
    public static function getBatchContent(Request $request)
    {
        $formKey = $request->formKey;
        $menuId = $request->menuId;
        $dataId = $request->dataId;
        $route = $request->route;
        $data = $associationData = [];

        $menuData = parent::$ModelsArray['CmsMenu']::where('id', $menuId)->first();
        if (!empty($dataId)) {
            $data = parent::$ModelsArray[$menuData['model']]::where('id', $dataId)->first();
            $associationData = parent::getAssociationData($menuId, $dataId);
        }
        $josnArray = parent::getJsonArray($menuId);
        if (!empty($josnArray)) {
            foreach ($josnArray as $key => $value) {
                $data['json'][$value] = json_decode($data[$value], true);
            }
        }
        $options = parent::getOption($menuId);
        return View::make(
            'Fantasy.cms.' . $route . '.batch',
            [
                "formKey" => $formKey,
                "data" => $data,
                "model" => $menuData['model'],
                "options" => $options,
                "associationData" => $associationData,
                "menu_id" => $menuId,
                "need_review" => true,
                "can_review" => true,
            ]
        )->render();
    }
    /*update*/
    public static function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
    public function verifyData(Request $request)
    {
        $field = $request->field;
        $value = $request->value;
        $dataId = $request->dataId;
        if (empty($value)) {
            return ['state' => true];
        }
        $field = str_replace('[]', '', $field);
        $re = '/\[(.*?)\]/';
        preg_match_all($re, $field, $matches, PREG_SET_ORDER, 0);
        $model = explode("[", $field)[0];
        $field = $matches[array_key_last($matches)][1];
        $data = M($model)::where('id', '<>', $dataId)->where($field, $value)->count();

        $state = ($data > 0) ? false : true;
        return ['state' => $state];
    }
    public static function updateData(Request $request)
    {
        $form_data = $request->form_data;
        $branch = $request->branch;
        $locale = $request->locale;
        $action = $request->action;

        //取得使用者IP
        $ViewerIP = $request->ip();
        $branch_id = BranchOrigin::where('url_title', $branch)->first()->id;
        $message = [];
        if ($action == 'create') {
            $createData = self::createData();
            if (!$createData['state']) {
                return ['state' => false, 'data' => ''];
            }
        }
        foreach ($form_data as $form_key => $form_data_val) {
            $all = json_decode($form_data_val, true);
            $firstUpdata = ($action == 'create') ? true : false;
            $modelName = $all['modelName'];
            $message[$form_key]['modelName'] = $all;
            $id = $createData['dataId'] ?? $all['dataId'];
            $menu_id = (isset($all['menu_id'])) ? $all['menu_id'] : '';
            $roles = PermissionFunction::getCmsAuthority($menu_id);
            $is_content = CmsMenu::where('id', $menu_id)->where('is_content', 1)->first();
            /*是否有自己的資料要updated*/
            if (isset($all[$modelName])) {
                $GetPostData = $all[$modelName];
                $data = [];
                //有審核編輯時 自動關閉啟用
                if (empty($is_content) && !$roles['can_review']) {
                    //如果沒開非審核權限編輯無須再次審核
                    if (!$roles['is_review_edit']) {
                        $GetPostData['is_visible'] = 0;
                    }
                }
                //如果只有單獨審核功能
                if ($roles['can_review'] && $roles['edit'] == 0 && isset($GetPostData['is_visible'])) {
                    $data['is_visible'] = $GetPostData['is_visible'];
                } else {
                    $data = $GetPostData;
                }
                //例外判斷
                $data = \App\Http\Controllers\Fantasy\SaveController::CustomizeSave($modelName, $data, $id);

                $copytoall = Config::get('cms.copytoall');
                $langArray = Config::get('cms.langArray');

                $locale_list = [$locale];
                $LeonTableName = M_table($modelName);
                $model_locale = explode("_", $LeonTableName);
                $SaveToMany = false;
                if (count($model_locale) > 1 && in_array($model_locale[0], array_column($langArray, 'key'))) {
                    unset($model_locale[0]);
                    $LeonTableName = implode("_", $model_locale);
                    $SaveToMany = true;
                }
                //Leon 一次更新到所有語系
                if ($copytoall) {
                    $locale_list = ($firstUpdata) ? array_keys($langArray) : [$locale];
                }

                foreach ($locale_list as $val) {
                    $TableName = ($SaveToMany) ? $val . '_' . $LeonTableName : $LeonTableName;
                    $information = M($modelName)::where('id', $id)->first();
                    $information->setTable($TableName);
                    foreach ($data as $key => $value) {
                        if (is_array($value)) {
                            $value = json_encode(array_filter($value), JSON_UNESCAPED_UNICODE);
                        }
                        //檢查暫存網址或SEO網址是否有重複
                        if ($key == 'temp_url' && !empty($value)) {
                            $temp_url_count = DB::table($TableName)->where('temp_url', $value)->count();
                            if ($temp_url_count > 1) {
                                $value = $value . '_' . $id;
                            }
                        }
                        if ($key == 'url_name' && !empty($value)) {
                            $url_name_count = DB::table($TableName)->where('url_name', $value)->count();
                            if ($url_name_count > 1) {
                                $value = $value . '_' . $id;
                            }
                        }
                        //若欄位名稱有url關鍵字 - 嘗試替換主網域
                        if (strpos($key, 'url') !== false) {
                            $CoverHost = parse_url(\URL::current())['host'];
                            $CoverData = parse_url($value);
                            if (isset($CoverData['host'])) {
                                if ($CoverData['host'] == $CoverHost) {
                                    foreach ($locale_list as $v) {
                                        $value = str_replace($CoverHost . '/' . $v . '/', "", $value);
                                    }
                                    $value = str_replace($CoverHost, "", $value);
                                    $value = str_replace("http://", "", $value);
                                    $value = str_replace("https://", "", $value);
                                    $value = str_replace("preview_", "", $value);
                                }
                            }
                        }
                        $information->{$key} = $value;
                        //停用其他語系的資料
                        if ($locale != $val) {
                            $information->is_reviewed = 0;
                            $information->is_visible = 0;
                        }
                    }
                    $information->create_id = Session::get('fantasy_user.id');
                    $information->branch_id = $branch_id;

                    $writeAction = ($firstUpdata) ? 'insert' : 'edit';
                    $attributes_en = json_encode($information, JSON_UNESCAPED_UNICODE);
                    BaseFunction::writeLogData($writeAction, ['table' => $TableName, 'id' => $id, 'ChangeData' => $attributes_en, 'classname' => 'CMS', 'ip' => $ViewerIP]);
                    if ($is_content) {
                        $information->is_preview = 1;
                        $information->is_reviewed = 1;
                        $information->is_visible = 1;
                    }

                    $information->save();
                    //刪除審核通知
                    if ($information->is_visible) {
                        M('ReviewNotify')::where('branch_id', $branch_id)->where('locale', $val)->where('model', $modelName)->where('data_id', $id)->delete();
                    }
                    //自動更新分類權限
                    if ($menu_id != "") {
                        $isAuth = intval(CmsMenu::find($menu_id)->toArray()['has_auth']);
                        $branch_unit_id = M('BranchOriginUnit')::where('origin_id', $branch_id)->where('locale', $val)->first()->id;
                        if ($isAuth > 0) {
                            $CmsDataAuth = CmsDataAuth::where('menu_id', $menu_id)->where('lang', $val)->whereHas('CmsRole', function ($query) use ($branch_unit_id) {
                                $query->where('user_id', Session::get('fantasy_user.id'))->where('branch_unit_id', $branch_unit_id);
                            })->first();
                            if (!empty($CmsDataAuth)) {
                                $NewDataId = json_decode($CmsDataAuth->data_id, true);
                                //如果有pass就不增加
                                if (!in_array("pass", $NewDataId)) {
                                    if (!in_array($id, $NewDataId)) {
                                        $NewDataId[] = $id;
                                    }
                                }
                                $CmsDataAuth = CmsDataAuth::where('id', $CmsDataAuth->id)->first();
                                $CmsDataAuth->data_id = json_encode($NewDataId, JSON_UNESCAPED_UNICODE);
                                $CmsDataAuth->save();
                            }
                        }
                    }
                }
            }
            /*確認關聯資料*/
            $message[$form_key]['change_id'] = self::checkAssociationData($branch_id, $locale, $all, $all['menu_id'], $id, $firstUpdata, $menu_id);
            $message[$form_key]['result'] = true;
        }
        return ['state' => true, 'data' => $message, 'dataId' => $createData['dataId'] ?? ''];
    }
    /*確認與整理關聯資料*/
    public static function checkAssociationData($branch_id, $locale, $data, $page, $id, $firstUpdata, $menu_id)
    {
        $newDataArray = [];
        $type = gettype($page);
        if ($page == 'menu') {
            if (isset($data['CmsChild'])) {
                $name_array = [];
                foreach ($data['CmsChild'] as $key => $value) {
                    array_push($name_array, $key);
                }

                foreach ($data['CmsChild']['id'] as $key => $value) {
                    if (empty($value)) {
                        $tempData = new parent::$ModelsArray['CmsChild'];
                    } else {
                        $tempData = parent::$ModelsArray['CmsChild']::where('id', $value)->first();
                    }
                    foreach ($name_array as $key2 => $value2) {
                        if ($value2 != 'id' && $value2 != 'quillFantasyKey') {
                            $tempData->$value2 = $data['CmsChild'][$value2][$key];
                        }
                    }
                    $tempData->menu_id = $id;
                    //$tempData->updated_at = date();
                    $tempData->save();

                    if (empty($value)) {
                        $temp['key'] = $data['CmsChild']['quillFantasyKey'][$key];
                        $temp['id'] = $tempData->id;
                        array_push($newDataArray, $temp);
                    }
                }
            }

            if (isset($data['CmsParent'])) {
                $name_array = [];
                foreach ($data['CmsParent'] as $key => $value) {
                    array_push($name_array, $key);
                }

                foreach ($data['CmsParent']['id'] as $key => $value) {
                    if (empty($value)) {
                        $tempData = new parent::$ModelsArray['CmsParent'];
                    } else {
                        $tempData = parent::$ModelsArray['CmsParent']::where('id', $value)->first();
                    }
                    foreach ($name_array as $key2 => $value2) {
                        if ($value2 != 'id' && $value2 != 'quillFantasyKey') {
                            $tempData->$value2 = $data['CmsParent'][$value2][$key];
                        }
                    }
                    $tempData->menu_id = $id;
                    //$tempData->updated_at = date();
                    $tempData->save();

                    if (empty($value)) {
                        $temp['key'] = $data['CmsParent']['quillFantasyKey'][$key];
                        $temp['id'] = $tempData->id;
                        array_push($newDataArray, $temp);
                    }
                }
            }
        } else if ($page == 'option') {
            if (isset($data['OptionItem'])) {
                $name_array = [];

                foreach ($data['OptionItem'] as $key => $value) {
                    array_push($name_array, $key);
                }

                foreach ($data['OptionItem']['id'] as $key => $value) {
                    if (empty($value)) {
                        $tempData = new parent::$ModelsArray['OptionItem'];
                    } else {
                        $model_temp = parent::$ModelsArray['OptionItem'];
                        $tempData = $model_temp::where('id', $value)->first();
                    }
                    foreach ($name_array as $key2 => $value2) {
                        if ($value2 != 'id' && $value2 != 'quillFantasyKey') {
                            $tempData->$value2 = $data['OptionItem'][$value2][$key];
                        }
                    }
                    $tempData->option_set_id = $id;
                    //$tempData->updated_at = date();
                    $tempData->save();

                    if (empty($value)) {
                        $temp['key'] = $data['OptionItem']['quillFantasyKey'][$key];
                        $temp['id'] = $tempData->id;
                        array_push($newDataArray, $temp);
                    }
                }
            }
        } else if ($page == 'key') {} else if ($page == 'file') {} else {
            $wait_del_son = [];
            $wait_del_three = [];

            $page = M('CmsMenu')::where('id', $page)->first()['use_id'];
            $copytoall = Config::get('cms.copytoall');
            $langArray = Config::get('cms.langArray');

            $locale_list = [$locale];
            //Leon 一次更新到所有語系
            if ($copytoall) {
                $locale_list = ($firstUpdata) ? array_keys($langArray) : [$locale];
            }

            $sonData = M('CmsChild')::where('menu_id', $page)->get()->toArray();
            $tempSon = [];
            foreach ($sonData as $key => $row) {
                if (isset($data[$row['child_model']])) {
                    if (isset($data[$row['child_model']]['id'])) {
                        $LeonTableName = M_table_Config(M($row['child_model']));
                        $model_locale = explode("_", $LeonTableName);
                        $SaveToMany = false;
                        if (count($model_locale) > 1 && in_array($model_locale[0], array_column($langArray, 'key'))) {
                            unset($model_locale[0]);
                            $LeonTableName = implode("_", $model_locale);
                            $SaveToMany = true;
                        }

                        // child 例外判斷
                        $data[$row['child_model']] = \App\Http\Controllers\Fantasy\SaveController::CustomizeSave($row['child_model'], $data[$row['child_model']]);
                        $name_array = array_keys($data[$row['child_model']]);
                        foreach ($data[$row['child_model']]['id'] as $key => $value) {
                            foreach ($locale_list as $val) {
                                $TableName = ($SaveToMany) ? $val . '_' . $LeonTableName : $LeonTableName;
                                //判斷刪除
                                if ($data[$row['child_model']]['wait_save_del'][$key]) {
                                    if (!empty($value)) {
                                        $wait_del_son[$row['child_model']][] = $value;
                                    }
                                } else {
                                    if (empty($value)) {
                                        $tempData = M($row['child_model'], true);
                                    } else {
                                        $tempData = M($row['child_model'])::where('id', $value)->first();
                                    }
                                    $tempData->setTable($TableName);
                                    $name_array = array_combine($name_array, $name_array);
                                    unset($name_array['wait_save_del']);

                                    foreach ($name_array as $key2 => $value2) {
                                        if ($value2 != 'id' && $value2 != 'quillFantasyKey') {
                                            $sonVal = (isset($data[$row['child_model']][$value2][$key])) ? $data[$row['child_model']][$value2][$key] : '';
                                            if (is_array($sonVal)) {
                                                $sonVal = json_encode($sonVal, JSON_UNESCAPED_UNICODE);
                                            }
                                            //若欄位名稱有url關鍵字 - 嘗試替換主網域
                                            if (strpos($value2, 'url') !== false) {
                                                $CoverHost = parse_url(\URL::current())['host'];
                                                $CoverData = parse_url($sonVal);
                                                if (isset($CoverData['host'])) {
                                                    if ($CoverData['host'] == $CoverHost) {
                                                        $sonVal = str_replace($CoverHost, "", $sonVal);
                                                        $sonVal = str_replace("http://", "", $sonVal);
                                                        $sonVal = str_replace("https://", "", $sonVal);
                                                        $sonVal = str_replace("preview_", "", $sonVal);
                                                    }
                                                }
                                            }
                                            $tempData->$value2 = $sonVal;
                                            $leon_arr[$value2] = $sonVal;
                                        }
                                    }
                                    $child_key = $row['child_key'];

                                    if (empty($value)) {
                                        $tempData->$child_key = $id;
                                        $tempData->branch_id = parent::$baseBranchId;
                                        $tempData->save();

                                        $temp['key'] = $data[$row['child_model']]['quillFantasyKey'][$key];
                                        $temp['id'] = $tempData->id;
                                        array_push($newDataArray, $temp);
                                        $newDataArray[$key]['son'] = [];
                                    } else {
                                        $tempData->save();

                                        $temp['key'] = $data[$row['child_model']]['quillFantasyKey'][$key];
                                        $temp['id'] = $data[$row['child_model']]['id'][$key];
                                        array_push($newDataArray, $temp);
                                        $newDataArray[$key]['son'] = [];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            foreach ($sonData as $key => $row) {
                if (isset($data[$row['child_model']])) {
                    $model_ass_son = parent::$ModelsArray['CmsChildSon'];
                    $son_son_Data = $model_ass_son::where('child_id', $row['id'])->get()->toArray();
                    foreach ($son_son_Data as $key22 => $row22) {
                        if (isset($data[$row22['model_name']])) {
                            if (isset($data[$row22['model_name']]['id'])) {
                                $LeonTableName = M_table_Config(M($row22['model_name']));
                                $model_locale = explode("_", $LeonTableName);
                                $SaveToMany = false;
                                if (count($model_locale) > 1 && in_array($model_locale[0], array_column($langArray, 'key'))) {
                                    unset($model_locale[0]);
                                    $LeonTableName = implode("_", $model_locale);
                                    $SaveToMany = true;
                                }

                                // son 例外判斷
                                $data[$row22['model_name']] = \App\Http\Controllers\Fantasy\SaveController::CustomizeSave($row22['model_name'], $data[$row22['model_name']]);
                                $name22_array = array_keys($data[$row22['model_name']]);

                                foreach ($locale_list as $val) {
                                    foreach ($data[$row22['model_name']]['id'] as $key33 => $value33) {
                                        $TableName = ($SaveToMany) ? $val . '_' . $LeonTableName : $LeonTableName;
                                        if ($data[$row22['model_name']]['wait_save_del'][$key33]) {
                                            $wait_del_three[$row22['model_name']][] = $value33;
                                        } else {
                                            $name22_array = array_combine($name22_array, $name22_array);
                                            unset($name22_array['wait_save_del']);
                                            if (empty($value33)) {
                                                $tempData22 = M($row22['model_name'], true);
                                            } else {
                                                $tempData22 = M($row22['model_name'])::where('id', $value33)->first();
                                            }
                                            $tempData22->setTable($TableName);
                                            foreach ($name22_array as $key77 => $value77) {
                                                if ($value77 != 'id' && $value77 != 'quillSonFantasyKey') {
                                                    $threeVal = (isset($data[$row22['model_name']][$value77][$key33])) ? $data[$row22['model_name']][$value77][$key33] : '';
                                                    if (is_array($threeVal)) {
                                                        $threeVal = json_encode($threeVal, JSON_UNESCAPED_UNICODE);
                                                    }
                                                    $tempData22->$value77 = $threeVal;
                                                }
                                            }
                                            foreach ($newDataArray as $key_88 => $value_88) {
                                                $temp_22_id = $row22['child_key'];
                                                if (isset($value_88['key']) && $data[$row22['model_name']]['quillSonFantasyKey'][$key33] == $value_88['key']) {
                                                    $tempData22->$temp_22_id = $value_88['id'];
                                                }
                                            }
                                            $tempData22->branch_id = parent::$baseBranchId;
                                            $tempData22->save();
                                            if (empty($value33)) {
                                                $tempSon[$data[$row22['model_name']]['quillSonFantasyKey'][$key33]][] = $tempData22->id;
                                            } else {
                                                $tempSon[$data[$row22['model_name']]['quillSonFantasyKey'][$key33]][] = $data[$row22['model_name']]['id'][$key33];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                foreach ($tempSon as $son_key => $son_value) {
                    foreach ($newDataArray as $par_key => $par_value) {
                        if (isset($par_value['key']) && $son_key == $par_value['key']) {
                            $newDataArray[$par_key]['son'] = $son_value;
                        }
                    }
                }
            }

            $new_request = new \Illuminate\Http\Request();
            //先刪第三層
            if (!empty($wait_del_three)) {
                foreach ($wait_del_three as $key => $val) {
                    $new_request->replace(['branch' => $branch_id, 'locale' => $locale, 'model' => $key, 'menu_id' => $menu_id, 'ids' => $val]);
                    self::deleteDataArray($new_request);
                }
            }
            //刪第二層
            if (!empty($wait_del_son)) {
                foreach ($wait_del_son as $key => $val) {
                    $new_request->replace(['branch' => $branch_id, 'locale' => $locale, 'model' => $key, 'menu_id' => $menu_id, 'ids' => $val]);
                    self::deleteDataArray($new_request);
                }
            }
        }
        return $newDataArray;
    }
    /*Create*/
    public static function createData()
    {
        $branch = request()->branch;
        $locale = request()->locale;
        $modelName = request()->model;

        $copytoall = Config::get('cms.copytoall');
        $langArrayAll = $langArray = Config::get('cms.langArray');
        //如果資料要同步到其他語系,則同步ID
        $setID = -1;
        if ($copytoall) {
            $LeonTableName = M_table($modelName);
            $model_locale = explode("_", $LeonTableName);
            if (in_array($model_locale[0], array_column($langArray, 'key'))) {
                unset($langArray[$locale], $model_locale[0]);
                $LeonTableName = implode("_", $model_locale);
            }
            foreach ($langArray as $key => $val) {
                $other_tableName = $key . '_' . $LeonTableName;
                if (!\Schema::hasTable($other_tableName)) {
                    return ['state' => false, 'callback' => $other_tableName . '資料表不存在'];
                }
            }
            foreach ($langArrayAll as $key => $val) {
                $other_tableName = $key . '_' . $LeonTableName;
                $maxID = DB::table($other_tableName)->max('id') ?: 0;
                if ($maxID > $setID) {
                    $setID = $maxID + 1;
                }
            }
        }
        $modelData = M($modelName, true);
        if ($copytoall) {
            $modelData->id = $setID;
        }
        if ($modelData->save()) {
            $message['id'] = ($copytoall) ? $setID : $modelData->id;
            if ($copytoall) {
                foreach ($langArray as $key => $val) {
                    $other_tableName = $key . '_' . $LeonTableName;
                    $CopyData = M($modelName, true);
                    $CopyData->setTable($other_tableName);
                    $CopyData->id = $message['id'];
                    $chk_table = DB::table($other_tableName)->select('id')->where('id', $message['id'])->count();
                    if ($chk_table < 1) {
                        $CopyData->save();
                    }
                }
            }
            return ['state' => true, 'dataId' => $modelData->id];
        }
        return ['state' => false, 'callback' => '系統異常'];
    }
    public function notify_admin(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;
        $modelName = request()->model;
        $cancel = request()->cancel;

        $action = ($request->action == 'review') ? '審核' : '刪除';
        $menu_id = $request->input('menu_id');
        $dataList = $request->data_id ?: [];

        $fantasy_user = Session::get('fantasy_user', []);
        $CmsData = CmsMenu::find($menu_id)->toArray();
        $branch_data = DB::table('basic_branch_origin')->where('url_title', $branch)->first();
        $ReviewData = [];
        //取得可審核的管理者
        $origin_unit_id = app(Config::get('models.' . 'BranchOriginUnit'))::where('origin_id', $branch_data->id)->where('locale', $locale)->first()->id;
        $user_Permission = Config('models.CmsRole')::where('branch_unit_id', $origin_unit_id)->get()->toArray();
        $CanReviewUser = [];
        foreach ($user_Permission as $val) {
            $roles = json_decode($val['roles'], true);
            $has_Permission = (isset($roles[$menu_id])) ? explode(";", $roles[$menu_id]) : [];
            $has_Permission_review = (isset($has_Permission[4]) && $has_Permission[4] == 1) ? 1 : 0;
            if ($has_Permission_review) {
                $CanReviewUser[] = $val['user_id'];
            }
        }
        $FantasyUsers = FantasyUsers::select('id', 'mail')->where('is_active', 1)->where('id', '<>', $fantasy_user['id'])->whereIn('id', $CanReviewUser)->get()->toArray();
        $FantasyUsersMails = collect($FantasyUsers)->where('mail', '<>', '')->pluck('mail')->all();

        foreach ($dataList as $data_id) {
            //取消審核
            if (!empty($cancel)) {
                M('ReviewNotify')::where('branch_id', $branch_data->id)->where('model', $modelName)->where('data_id', $data_id)->where('user_id', $fantasy_user['id'])->delete();
            } else {
                $WaitDelData = parent::$ModelsArray[$modelName]::where('id', $data_id)->first()->toArray();
                $data_title = $WaitDelData['title'] ?? $WaitDelData['w_title'] ?? '資料編號' . $data_id;
                //審核
                DB::table('basic_review_notify')->updateOrInsert(['branch_id' => $branch_data->id, 'model' => $modelName, 'data_id' => $data_id], [
                    'branch_id' => $branch_data->id,
                    'user_id' => $fantasy_user['id'],
                    'locale' => $locale,
                    'model' => $modelName,
                    'admins' => json_encode(array_column($FantasyUsers, 'id')),
                    'branch_title' => $branch_data->title,
                    'unit_title' => $CmsData['title'],
                    'data_title' => $data_title,
                    'data_id' => $data_id,
                    'data_url' => BaseFunction::cms_url($menu_id . '/' . $data_id),
                    'action' => $action,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $ReviewData[] = ['title' => $data_title, 'url' => BaseFunction::cms_url($menu_id . '/' . $data_id)];
            }
        }

        if (!empty($FantasyUsersMails)) {
            $MailInfo = [
                'from' => 'no-replay@' . $_SERVER['HTTP_HOST'],
                'from_name' => $branch_data->title,
                'subject' => '【申請' . $action . '通知】網站有' . count($dataList) . '筆資料申請',
                'data_name' => $fantasy_user['name'],
                'data_unit' => $CmsData['title'],
                'data_post' => $ReviewData,
                'to' => $FantasyUsersMails,
            ];
            try {
                Mail::send('Fantasy.mail.review', ['data' => $MailInfo], function ($message) use ($MailInfo) {
                    $message->from($MailInfo['from'], $MailInfo['from_name']);
                    $message->subject($MailInfo['subject']);
                    $message->to($MailInfo['to']);
                });
            } catch (\Exception$e) {
                // Never reached
                return $e;
            }
        }
        return ['callback' => 'ok'];
    }
    /*Delete Data Group*/
    public static function deleteDataArray(Request $request)
    {
        $branch = $request->branch;
        $locale = $request->locale;
        $modelName = $request->model;
        //取得使用者IP
        $ViewerIP = $request->ip();

        $menu_id = $request->menu_id ?: $request->input('menu_id');
        $roles = PermissionFunction::getCmsAuthority($menu_id);
        if ($roles['need_review'] && !$roles['can_review']) {
            $message['result'] = true;
            return $message;
        }
        $id_array = $request->ids ?: $request->input('ids');
        if (!empty($id_array)) {
            if ($roles['delete']) {
                $tempData = parent::$ModelsArray[$modelName]::whereIn('id', $id_array)->get()->toArray();
                $TableName = M_table_Config(Config('models.' . $modelName));
                foreach ($tempData as $val) {
                    $attributes_en = json_encode($val, JSON_UNESCAPED_UNICODE);
                    BaseFunction::writeLogData('del', ['table' => $TableName, 'id' => $val['id'], 'ChangeData' => $attributes_en, 'classname' => 'CMS', 'ip' => $ViewerIP]);
                }

                // 改使用model delete => 觸發event
                M($modelName)::whereIn('id', $id_array)->get()->map(function ($item) use ($locale, $modelName) {
                    M('ReviewNotify')::where('branch_id', $item->branch_id)->where('locale', $locale)->where('model', $modelName)->where('data_id', $item->id)->delete();
                    $item->delete();
                });

                //找第一層
                $basic_cms_menu = DB::table('basic_cms_menu_use')->where('model', $modelName)->first();
                if (!empty($basic_cms_menu)) {
                    //第二層
                    $basic_cms_child = DB::table('basic_cms_child')->where('menu_id', $basic_cms_menu->id)->get()->toArray();
                    if (!empty($basic_cms_child)) {
                        foreach ($basic_cms_child as $childVal) {
                            //抓第二層資料
                            $basic_cms_child_data = parent::$ModelsArray[$childVal->child_model]::whereIn($childVal->child_key, $id_array)->get()->toArray();
                            //刪除第二層
                            parent::$ModelsArray[$childVal->child_model]::whereIn($childVal->child_key, $id_array)->delete();
                            //抓第三層
                            $basic_cms_child_son = DB::table('basic_cms_child_son')->where('child_id', $childVal->id)->get()->toArray();
                            if (!empty($basic_cms_child_son)) {
                                //刪除第三層
                                foreach ($basic_cms_child_son as $sonVal) {
                                    parent::$ModelsArray[$sonVal->model_name]::whereIn($sonVal->child_key, array_column($basic_cms_child_data, 'id'))->delete();
                                }
                            }
                        }
                    }
                }
                //sonTable刪除抓第二層
                // $basic_cms_child = DB::table('basic_cms_child')->where('child_model', $modelName)->first();
                // if (!empty($basic_cms_child)) {
                //     //抓第二層資料
                //     $basic_cms_child_data = parent::$ModelsArray[$modelName]::whereIn('id', [$id_array])->get()->toArray();
                //     $basic_cms_child_son = DB::table('basic_cms_child_son')->where('child_id', $basic_cms_child->id)->first();
                //     if (!empty($basic_cms_child_son)) {
                //         parent::$ModelsArray[$basic_cms_child_son->model_name]::whereIn('second_id', array_column($basic_cms_child_data, 'id'))->delete();
                //     }
                // }
            }
        }
        $message['result'] = true;

        return $message;
    }
    /*Clone Data Group*/
    public static function cloneDataArray(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;
        $modelName = request()->model;

        $ViewerIP = $request->ip();
        $id_array = $request->input('clone_id');
        $menu_id = $request->menu_id;
        $TableName = M_table_Config(Config('models.' . $modelName));
        $newId_array = [];
        if (count($id_array) > 0) {
            //回傳複製後的id
            $newId_array = BaseFunction::cloneData($modelName, $id_array, $locale, $menu_id, $branch);
        }
        // $tempData = parent::$ModelsArray[$modelName]::whereIn('id', $newId_array)->get()->toArray();
        // foreach ($tempData as $val) {
        //     $attributes_en = json_encode($val, JSON_UNESCAPED_UNICODE);
        //     BaseFunction::writeLogData('insert', ['table' => $TableName, 'id' => $val['id'], 'ChangeData' => $attributes_en, 'classname' => 'CMS', 'ip' => $ViewerIP]);
        // }
        $message['result'] = true;

        return $message;
    }
    /*關聯式下拉選單*/
    public function relateSelect($branch, $locale, $parent_model, $model, $id, Request $request)
    {
        $option_text = $request->input('option_text');
        $_model = app(Config::get('models.' . $model));
        return $_model::select('id', DB::Raw($option_text . ' AS option_text'))->where($_model::parent_key[$parent_model], $id)->get()->toArray();
    }
    /*狀態列ajax更改*/
    public function radioSwitch(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;
        $model = request()->model;
        $id = request()->id;

        $member = Session::get('fantasy_user');
        $branch_id = app(Config::get('models.' . 'BranchOrigin'))::where('url_title', $branch)->select('id')->first()->id;
        $origin_unit_id = app(Config::get('models.' . 'BranchOriginUnit'))::where('origin_id', $branch_id)->where('locale', $locale)->first()->id;
        $cms_id = app(Config::get('models.' . 'CmsMenu'))::where('model', $model)->select('id')->first()->id;
        $user_Permission = Config('models.CmsRole')::where('user_id', $member['id'])->where('branch_unit_id', $origin_unit_id)->first()->roles;

        $has_Permission = explode(";", json_decode($user_Permission, true)[$cms_id]);
        $has_Permission_review = (isset($has_Permission[4])) ? $has_Permission[4] : 0;
        if ($has_Permission[3] == 0 && $has_Permission_review == 0) {
            $message['result'] = false;
            $message['error_msg'] = '您無權限編輯';

            return $message;
        }
        $column = $request->input('column');
        $item = $request->input('item');

        $data = parent::$ModelsArray[$model]::where('id', $id)->first();

        $data->$column = $item;

        if ($data->save()) {
            $message['result'] = true;

            return $message;
        }
    }
    /*Table Reset*/
    public function tableReset(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;
        $model = request()->model;
        $page = request()->page;

        $isBatch = $request->input('_table_isBatch');
        $isEdit = $request->input('_table_edit');
        $isDelete = $request->input('_table_delete');
        $isCreate = $request->input('_table_create');
        $isSearch = $request->input('_table_isSearch');
        $isClone = $request->input('_table_isClone');
        $isExport = $request->input('_table_isExport');
        $can_review = $request->input('_table_can_review');
        $need_Review = $request->input('_table_need_review');

        $search = $request->input('_table_search');
        $key = $request->input('_table_key');
        $menuData = parent::$ModelsArray['CmsMenu']::where('id', $key)->first();
        $route = $request->input('_table_route');
        $search = (!empty($search)) ? json_decode($search, true) : [];
        $hasAuth = $request->input('_table_auth');
        $pageTitle = $request->input('_table_pagetitle');
        $search_type = $request->input('_search_type');

        $isSearch = (int) $request->_table_is_search;
        //Leon
        $New_Search = [];

        foreach ($search as $search_key => $val) {
            $Temp_Search = explode(",", $search_key);
            foreach ($Temp_Search as $v) {
                if ($v == 'sort') {
                    $New_Search[$v] = $val;
                } else {
                    $New_Search[$v] = ['type' => 'text', 'value' => $val['value']];
                }
            }
        }
        $search = $New_Search ?: $search;

        if (empty($search)) {
            $search_type = 'basic';
        }
        if ($model == 'CmsMenu') {
            $data = parent::getDataNew($menuData, $page, $search, $search_type, 1000, $key);
        } else {
            $page = $isSearch ? 1 : $page;
            $data = parent::getDataNew($menuData, $page, $search, $search_type, Config::get('cms.pageSize', 10), $key);
        }

        $options = parent::getOption($key);
        /*組Table頁面*/
        $content['view'] = View::make(
            $route . '.table',
            [
                'modelName' => $model,
                'isEdit' => $isEdit,
                'isDelete' => $isDelete,
                'isCreate' => $isCreate,
                'isSearch' => $isSearch,
                'isClone' => $isClone,
                'isExport' => $isExport,
                'isBatch' => $isBatch,
                'exportName' => $model . ',' . $key,
                'options' => $options,
                'data' => $data['data'],
                'count' => $data['count'],
                'pn' => $data['pn'],
                'search' => $search,
                'search_type' => $search_type,
                'page' => $page,
                'hasAuth' => $hasAuth,
                'pageTitle' => $pageTitle,
                'pageId' => $key,
                'pageKey' => $key,
                'can_review' => $can_review,
                'need_Review' => $need_Review,
            ]
        )->render();

        $content['count'] = $data['count'];

        return $content;
    }
    /*後台----------End*/
    /*前台路徑無語系無分舘*/
    public function prefixBranch()
    {
        $subdomain = Route::current()->parameter('subdomain');
        $domain = explode(".", str_replace(["www."], "", Route::current()->parameter('branch')))[0];
        $subdomainORlocale = Route::current()->parameter('branch_url');
        $subdomain = (empty($subdomain)) ? $subdomainORlocale ?: $domain : $subdomain;

        //導向分館第一個語系
        $branch_origin = M('BranchOrigin')::where('is_active', 1)->where('url_title', $subdomain)->first();
        if(!empty($branch_origin)){
            $local_set = json_decode($branch_origin['local_set']);
            $subdomainORlocale = (!empty($subdomainORlocale)) ? $subdomainORlocale.'/':'';
            return redirect(url($subdomainORlocale.$local_set[0]))->send();
        }
        return Redirect::to('404')->send();
    }
    /*前台路徑無語系*/
    public function prefixLocale($branch)
    {
        $branch_title = BaseFunction::revertUrlToTitle($branch);
        $thisBranch = parent::$ModelsArray['BranchOrigin']::where('url_title', $branch_title)->first();
        if (!empty($thisBranch)) {
            $thisId = $thisBranch->id;
            $model_temp = parent::$ModelsArray['BranchOriginUnit'];
            $firstBranchLocale = $model_temp::where('origin_id', $thisId)->first();
            if (empty($firstBranchLocale)) {
                return redirect(url('/'));
            } else {
                // return redirect( url( $branch.'/'.$firstBranchLocale->locale ) );
                return redirect(url($firstBranchLocale->locale)); //此為無分館要把分館層級移除的方法
            }
        } else {
            return redirect(url('/'));
        }
    }

    public function db_lbox()
    {
        $isBranch = parent::$setBranchs;

        return View::make(
            'Fantasy.load.db_lbox',
            []
        );
    }
}
