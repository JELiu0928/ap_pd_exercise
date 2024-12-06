<?php

namespace App\Http\Controllers\Fantasy\ams;

use App\Http\Controllers\Fantasy\AmsController as AmsPaPa;
use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;
use App\Models\Basic\Cms\CmsDataAuth;
use App\Models\Basic\Cms\CmsRole;
use App\Models\Basic\WebKey;

/**相關Models**/

use Illuminate\Http\Request;
use View;

class CmsManagerController extends AmsPaPa
{
    public static $fileInformationArray = [];

    public function __construct()
    {
        parent::__construct();
        // self::$fileInformationArray = BaseFunction::getAllFilesArray();
        // View::share('fileInformationArray', self::$fileInformationArray);
        $branch_unit_options = BranchOriginUnit::where('is_active', 1)->with('BranchOrigin')->orderby('origin_id', 'asc')->orderby('locale', 'DESC')->get()->map(function ($item) {
            return [
                'key' => $item['id'],
                'title' => $item['BranchOrigin']['title'] . ' - ' . parent::$langArray[$item['locale']]['title'],
                'branch' => $item['BranchOrigin']['title'],
                'locale' => parent::$langArray[$item['locale']]['title'],
            ];
        });
        $FantasyUsers = M('FantasyUsers')::all()->map(function ($item) {
            return [
                'key' => $item['id'],
                'title' => $item['name'],
            ];
        });
        View::share('FantasyUsers', $FantasyUsers);
        View::share('branch_unit_options', $branch_unit_options);
    }

    public function index()
    {
        $data = CmsRole::where('type', 2)->wherehas('UsersData')->with('UsersData')->orderby('user_id', 'asc')->orderby('branch_unit_id', 'asc')->get();

        return View::make(
            'Fantasy.ams.cms_manager.index',
            [
                'data' => $data,
            ]
        );
    }
    public function update(Request $request)
    {
        $data = $request->input('amsData');

        //單元 個別分類 權限 authdata['auth_data']['menu_id']['category_id']
        $auth_data = (isset($request->input('authData')['auth_data'])) ? $request->input('authData')['auth_data'] : [];
        // menu_id => category_id[], pass=全選
        foreach ($auth_data as $key => $val) {
            $auth_data[$key] = array_filter($auth_data[$key]);
        }
        //單元 編輯權限 amsData[]
        $json = $request->input('jsonData');
        $temp_json = [];
        foreach ($json as $key => $value) {
            $temp_json[$key] = '';
            foreach ($value as $key2 => $value2) {
                if($key2!=0) $temp_json[$key] .= ';';
                $temp_json[$key] .= $value2;
            }
        }

        $info = CmsRole::where('branch_unit_id', $data['branch_unit_id'])->where('user_id', $data['user_id'])->first() ?? new CmsRole;
        if (!empty($info)) {
            foreach ($data as $key => $value) {
                if ($key != 'id') {
                    $info->$key = $value;
                }
            }
            $info->roles = json_encode($temp_json);
            $info->type = 2;
            $info->save();
            $this->edit_data_auth($info->id, $auth_data, $request->input('_lang'));
            $reback =
                [
                'id' => $info->id,
                'result' => true,
                'status' => 'update',
            ];
        } else {
            $reback =
                [
                'result' => false,
            ];
        }

        return $reback;
    }
    public function delete(Request $request)
    {
        $kill_id = $request->input('id');
        $info = CmsRole::where('id', $kill_id)->first();
        if (!empty($info)) {
            $info->delete();
        }
    }
    public function reset()
    {
        $data = CmsRole::where('type', 2)->wherehas('UsersData')->with('UsersData')->orderby('user_id', 'asc')->orderby('branch_unit_id', 'asc')->get();
        return View::make(
            'Fantasy.ams.cms_manager.ajax.table',
            [
                'data' => $data,
            ]
        );
    }
    protected function edit_data_auth($cms_role_id, $authData, $lang)
    {
        $lang = $lang == '' ? '' : substr($lang, 0, 2);
        if (!empty($authData)) {
            // $authData  menu_id => category_id[], pass=全選
            foreach ($authData as $menu_id => $row) {
                $cmscatacuth = CmsDataAuth::where('cms_role_id', $cms_role_id)->where('menu_id', $menu_id)->first();
                if (!$cmscatacuth) {
                    $cmscatacuth = new CmsDataAuth();
                    $cmscatacuth->cms_role_id = $cms_role_id;
                    $cmscatacuth->menu_id = $menu_id;
                    $cmscatacuth->data_id = json_encode($row);
                    $cmscatacuth->lang = $lang;
                } else {
                    $cmscatacuth->data_id = json_encode($row);
                    $cmscatacuth->lang = $lang;
                }
                $cmscatacuth->save();
            }
        }
    }

    public function changeBranch(Request $request)
    {
        $branch_unit_id = request()->branch_unit_id;
        if (empty($branch_unit_id)) {
            return false;
        }
        $need_review = false;

        $branch_unit = BranchOriginUnit::find($branch_unit_id);

        BranchOriginUnit::where('id', $branch_unit_id)->with('BranchOrigin')->get()->map(function ($item) use (&$need_review) {
			if (in_array($item['locale'], json_decode($item->BranchOrigin->local_review_set ?: '[]'))) {
				$need_review = true;
			}
		})->all();


        // $need_review = BranchOrigin::where('id', $branch_unit['origin_id'] ?? 0)
        //     ->whereJsonContains('local_review_set', $branch_unit['locale'] ?? 'none')->count() > 0;
        //可管理的單元
        $unit_set = json_decode($branch_unit->unit_set, true);

        $key_group = WebKey::getCmsRoleList($branch_unit);

        $data = CmsRole::wherehas('UsersData')
            ->with('UsersData')
            ->with('CmsDataAuth')
            ->where('branch_unit_id', $branch_unit_id)
            ->where('user_id', $request->set_id ?? 0)
            ->first();
        if(empty($data)) $data = [];
        $data['CmsDataAuth'] = (isset($data['CmsDataAuth']) && count($data['CmsDataAuth'])>0) ? $data['CmsDataAuth']->keyBy('menu_id') : [];
        $data['branch_unit_id'] = $branch_unit_id;

        $jsonSup = empty($data['roles']) ? [] : collect(json_decode($data['roles'], true))->mapwithkeys(function ($item, $key) {
            return [$key => explode(";", $item)];
        })->all();

        $editView = View::make(
            'Fantasy.ams.cms_manager.ajax.unit',
            [
                'data' => $data,
                'jsonSup' => $jsonSup,
                'key_group' => $key_group,
                'need_review' => $need_review,
                'BranchOriginUnit' => $branch_unit,
                'unit_set' => $unit_set,
            ]
        )->render();
        $result = array([
            'locale' => $branch_unit->locale . '_',
            'unit_set' => $unit_set,
            'need_review' => $need_review,
            'html' => $editView,
            'is_active' => $data['is_active'] ?? 0,
            'id' => $data['id'] ?? 0,
        ]);
        return $result;
    }
}
