<?php

namespace App\Http\Controllers\Fantasy;

use Illuminate\Support\Arr;
use View;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\BaseFunctions;
use Illuminate\Routing\Controller as BaseController;

class MakeTable extends BackendController
{
    /*列表NewTable*/
    public static function listNewTable($set = [])
    {
        $isBatch = (isset($set['isBatch'])) ? $set['isBatch'] : "";
        $isLink = (isset($set['isLink'])) ? $set['isLink'] : "";
        $isClone = (isset($set['isClone'])) ? $set['isClone'] : 0;
        $isFMS = (isset($set['isFMS'])) ? $set['isFMS'] : 1;
        $isExport = (isset($set['isExport'])) ? $set['isExport'] : 0;
        $isExport2 = (isset($set['isExport2'])) ? $set['isExport2'] : 0;
        $isImport = (isset($set['isImport'])) ? $set['isImport'] : 0;
        $exportName = (isset($set['exportName'])) ? $set['exportName'] : '';

        $isEdit = (isset($set['isEdit'])) ? $set['isEdit'] : 1;
        $isDelete = (isset($set['isDelete'])) ? $set['isDelete'] : 1;
        $isCreate = $set['isCreate'] ?? 0;
        $tableSet = (!empty($set['tableSet'])) ? $set['tableSet'] : [];
        $page = (isset($set['page'])) ? $set['page'] : 1;
        $search = (!empty($set['search'])) ? $set['search'] : [];
        $search_type = (!empty($set['search_type'])) ? $set['search_type'] : 'basic';
        $modelName = $set['modelName'];
        $isSearch = (isset($set['isSearch'])) ? $set['isSearch'] : 1;

        $pageTitle = (isset($set['pageTitle'])) ? $set['pageTitle'] : '';
        $pageId = (isset($set['pageId'])) ? $set['pageId'] : '';
        $pageIntroduction = (isset($set['pageIntroduction'])) ? $set['pageIntroduction'] : '';
        $hasAuth = (isset($set['hasAuth'])) ? $set['hasAuth'] : 0;
        $QuickSearch = (isset($set['QuickSearch'])) ? $set['QuickSearch'] : '';
        $QuickType = (isset($set['QuickType'])) ? $set['QuickType'] : 'text';
        //leon
        $menu_id = (isset($set['menu_id'])) ? $set['menu_id'] : '';
        $can_review = (isset($set['can_review'])) ? $set['can_review'] : '';
        $need_Review = (isset($set['need_Review'])) ? $set['need_Review'] : '';
        $menuData = parent::$ModelsArray['CmsMenu']::where('id', $menu_id)->first();
        if ($modelName == 'Elite_professional') {
            $isImport = 1;
        }
        //要審核替換
        if ($need_Review) {
            foreach ($tableSet as $key => $val) {
                if ($val['type'] == 'visible') {
                    $tableSet[$key]['type'] = 'review';
                }
            }
        }

        /*能否開內容頁的class*/
        $editClass = ($isEdit == 1 || $can_review == 1) ? 'open_builder' : '';

        // if ($modelName == 'CmsMenu') {
        //     $info = parent::getDataNew($menuData, $page, $search, 1000, $menu_id);
        // } else {
        //     $info = parent::getDataNew($menuData, $page, $search, Config::get('cms.pageSize', 10), $menu_id);
        // }

        // $count = $info['count'];
        // $data = $info['data'];
        // $pn = (isset($info['pn'])) ? $info['pn'] : 1;

        $count = $set['count'];
        $data = $set['data'];
        $pn = (isset($set['pn'])) ? $set['pn'] : 1;

        $fileRouteArray = [];
        $fileIds = [];
        foreach ($data as $key => $value) {
            foreach ($tableSet as $key2 => $value2) {
                if ($value2['type'] == 'text_image') {
                    $img_array = explode(",", $value2['img']);
                    $find_img = '';
                    foreach ($img_array as $img_array_val) {
                        if ($value[$img_array_val] != '') {
                            $find_img = $value[$img_array_val];
                            //$tableSet[$key2]['img'] = $img_array_val;
                            break;
                        }
                    }
                    array_push($fileIds, $find_img);
                }
            }
        }
        if (!empty($fileIds)) {
            $fileRouteArray = BaseFunctions::getFilesArrayWithKey($fileIds);
        }

        $fantasyUser = Arr::pluck(config('models.FantasyUsers')::all()->toarray(), 'name', 'id');

        $html =  View::make('Fantasy.cms_view.includes.makeTable', [
            'isBatch' => $isBatch,
            'isLink' => $isLink,
            'isClone' => $isClone,
            'isFMS' => $isFMS,
            'isExport' => $isExport,
            'isExport2' => $isExport2,
            'isImport' => $isImport,
            'exportName' => $exportName,
            'isEdit' => $isEdit,
            'isDelete' => $isDelete,
            'isCreate' => $isCreate,
            'tableSet' => $tableSet,
            'page' => $page,
            'search' => $search,
            'search_type' => $search_type,
            'modelName' => $modelName,
            'isSearch' => $isSearch,
            'pageTitle' => $pageTitle,
            'pageIntroduction' => $pageIntroduction,
            'hasAuth' => $hasAuth,
            'QuickSearch' => $QuickSearch,
            'QuickType' => $QuickType,
            'editClass' => $editClass,
            'count' => $count,
            'data' => $data,
            'pn' => $pn,
            'fileRouteArray' => $fileRouteArray,
            'fileIds' => $fileIds,
            'fantasyUser' => $fantasyUser,
            'can_review' => $can_review,
            'need_Review' => $need_Review,
            'menu_id' => $menu_id
        ])->render();

        print($html);
    }
}
