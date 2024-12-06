<?php

namespace App\Http\Controllers\Fantasy;

use App\Models\Basic\Ams\AmsRole;
use App\Models\Basic\Ams\Autoredirect;
use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;
use App\Models\Basic\Cms\CmsMenu;
use App\Models\Basic\Cms\CmsRole;

/**相關Models**/
/*Branch*/

use App\Models\Basic\Crs\CrsRole;
/*Cms*/
use App\Models\Basic\FantasyUsers;
use App\Models\Basic\Fms\FmsZero;
use App\Models\Basic\LogData;
/*Crs*/
/*Auth*/
use App\Models\Basic\WebKey;
/*Fms*/
use Config;
use Illuminate\Http\Request;
/*Option*/
use Route;
/*Basic*/
use Session;
/*AMS*/
use View;
use DB;

class AmsController extends BackendController
{
    public static $fileInformationArray = [];
    public static $langArray = [];

    public function __construct()
    {
        parent::__construct();
        /*======取得sidebar可用選單======*/
        $amsRole = AmsRole::where('user_id', Session::get('fantasy_user.id'))->first();
        $amsRole = (!empty($amsRole)) ? $amsRole->toArray() : ['is_active' => 0];
        /*======取得sidebar可用選單======*/

        /*======檢查是否有Ams及目前功能的使用權限======*/
        $now_route = explode('/', Route::current()->uri);
        // $role_col = ''; //此功能在basic_ams_role的對應欄位
        // switch ($now_route[count($now_route) - 1]) {
        //     default: //ajax不檢查
        //         break;
        //     case 'Ams':
        //         $role_col = 'is_active';
        //         break;
        //     case 'ams-manager':
        //         $role_col = 'is_ams';
        //         break;
        //     case 'template-manager':
        //         $role_col = 'is_cover_page';
        //         break;
        //     case 'template-setting':
        //         $role_col = 'is_cms_template';
        //         break;
        //     case 'cms-manager':
        //         $role_col = 'is_cms_template_ma';
        //         break;
        //     case 'crs-template':
        //         $role_col = 'is_cms_template_setting';
        //         break;
        //     case 'cms-overview':
        //         $role_col = 'is_crs_role';
        //         break;
        //     case 'crs-overview':
        //         $role_col = 'is_overview_crs';
        //         break;
        //     case 'fantasy-account':
        //         $role_col = 'is_fantasy';
        //         break;
        // }

        // if ($role_col != '' && ($amsRole['is_active'] != '1' || $amsRole[$role_col] != '1')) return Redirect::to('/Fantasy')->send();
        /*======檢查是否有Ams及目前功能的使用權限======*/
        $configSet = Config::get('cms');
        self::$langArray = $configSet['langArray'];

        View::share('unitTitle', 'Ams');
        View::share('unitSubTitle', 'Account Management System');
        // self::$fileInformationArray = BaseFunction::getAllFilesArray();
        // View::share('fileInformationArray', self::$fileInformationArray);
        View::share('langArray', self::$langArray);
        View::share('amsRoleArray', $amsRole);
        View::share('configSet', $configSet);
        View::share('FantasyUser', session('fantasy_user'));

        // .test 切換帳號
        // $FantasyUsersList = (strpos(\Route::getCurrentRequest()->server('HTTP_HOST'), '.test') !== false) ? $FantasyUsersList = FantasyUsers::get()->toArray() : [];
        // View::share('FantasyUsersList', $FantasyUsersList);
        // 禁止切換帳號
        View::share('FantasyUsersList', []);

        $FantasyUsers = M('FantasyUsers')::all()->map(function ($item) {
            return [
                'key' => $item['id'],
                'title' => $item['name'],
            ];
        })->keyBy('key')->toArray();
        View::share('FantasyUsers', $FantasyUsers);
    }
    public function index()
    {
        $configSet = Config::get('cms');
        return View::make(
            'Fantasy.ams.index',
            [
                'configSet' => $configSet,
            ]
        );
    }
    public function sidebar()
    {
        return View::make(
            'Fantasy.ams.includes.sidebar',
            []
        );
    }
    public function edit(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $index = $request->index ?? '';

        if ($type == 'ams-manager') {
            $data = AmsRole::where('id', $id)->wherehas('UsersData')->with('UsersData')->first();

            $AmsRoleUserID = (!empty($data)) ? AmsRole::where('user_id', '<>', $data['user_id'])->pluck('user_id') : AmsRole::all()->pluck('user_id');
            $FantasyUserEmpty = M('FantasyUsers')::whereNotIn('id', $AmsRoleUserID)->get()->map(function ($item) {
                return [
                    'key' => $item['id'],
                    'title' => $item['name'],
                ];
            })->keyBy('key')->toArray();
            $editView = View::make('Fantasy.ams.ams_manager.ajax.edit', ['data' => $data, 'FantasyUserEmpty' => $FantasyUserEmpty])->render();
            $reback = ['content' => $editView];
        } else if ($type == 'fantasy-account') {
            $data = FantasyUsers::where('id', $id)->first();
            
            $user = session('fantasy_user');
            $editView = View::make(
                'Fantasy.ams.fantasy_account.ajax.edit',
                [
                    'data' => $data,
                    'editPassword' => ($user['id'] == $id || $user['ams']['a_or_m'] == 1) ? true : false,
                ]
            )->render();
            $reback = ['content' => $editView];
        } else if ($type == 'template-manager') {
            $data = BranchOrigin::where('id', $id)->first();

            $editView = View::make(
                'Fantasy.ams.template_manager.ajax.edit',
                [
                    'data' => $data,
                ]
            )->render();

            $reback =
                [
                'content' => $editView,
            ];
        } else if ($type == 'template-setting') {
            $data = BranchOriginUnit::orderby('origin_id', 'asc')->orderby('locale', 'DESC')->where('id', $id)->first();
            $branch_options = M('BranchOrigin')::all()->keyBy('id')->map(function ($item) {
                return $item['title'];
            })->toArray();
            // 原本的
            // $branch_options = M('BranchOrigin')::all()->map(function ($item) {
            //     return [
            //         'key' => $item['id'],
            //         'title' => $item['title'],
            //     ];
            // })->keyBy('key')->toArray();
            if (!empty($data)) {
                $json = json_decode($data['unit_set'], true);
            } else {
                $json = [];
            }
            if(config('cms.branch_create')){
                $branch=BranchOrigin::find($data['origin_id']);
                $templateId=$branch['blade_template'];
                 // 若可新增分館要看template_id
                 $key_group = WebKey::where('template_id', 'LIKE', '%"' . $templateId . '"%')->get()->mapWithKeys(function ($q) use ($json) {
                    $q['is_active'] = $json[$q['id']] ?? '';
                    return [$q['id'] => $q];
                });
            }else{
                // 若固定分館要看branch_id屬於哪一個分館
                $key_group = WebKey::where('branch_id', 'LIKE', '%"' . $data['origin_id'] . '"%')->orwhere('branch_id', '')->get()->mapWithKeys(function ($q) use ($json) {
                    $q['is_active'] = $json[$q['id']] ?? '';
                    return [$q['id'] => $q];
                });
            }
            foreach(self::$langArray as $key=>$row){
                $langArray[$key]=$row['title'];
            }
            $editView = View::make(
                'Fantasy.ams.template_setting.ajax.edit',
                [
                    'data' => $data,
                    'branch_options' => $branch_options,
                    'locale_options' => $langArray,
                    'json' => $json,
                    'key_group' => $key_group,
                ]
            )->render();
            $reback = ['content' => $editView];
        } else if ($type == 'cms-manager') {
            $need_review=false;
            $data = CmsRole::wherehas('UsersData')->with('UsersData')->with('CmsDataAuth')->find($id);
            if(empty($data)) $data = [];
            $data['CmsDataAuth'] = (isset($data['CmsDataAuth']) && count($data['CmsDataAuth'])>0) ? $data['CmsDataAuth']->keyBy('menu_id') : [];
            $branch_unit_options = BranchOriginUnit::where('is_active', 1)->orderby('origin_id', 'asc')->orderby('locale', 'DESC')
                ->with('BranchOrigin')
                ->get()
                ->mapwithkeys(function ($item) use ($data, &$need_review) {
                    $branch_unit_id = $data['branch_unit_id'] ?? 0;
                    if ($branch_unit_id == $item['id']) {
                        if (config('cms.reviewfunction') && in_array($item['locale'], json_decode($item->BranchOrigin->local_review_set) ?: [])) {
                            $need_review = true;
                        }
                    }
                    return [
                        $item['id'] => [
                            'title' => $item->BranchOrigin->title . '-' . self::$langArray[$item['locale']]['title'],
                            'key' => $item['id'],
                            'unit_set' => $item['unit_set'],
                            'local_review_set' => $item->BranchOrigin->local_review_set,
                        ],
                    ];
                })
                ->all();
            array_unshift($branch_unit_options, ["key" => "", "title" => "-"]);
            //分館資料
            $BranchOriginUnit = (isset($data['branch_unit_id'])) ? BranchOriginUnit::where('id', $data['branch_unit_id'])->first() : [];
            $unit_set = (!empty($BranchOriginUnit)) ? json_decode($BranchOriginUnit['unit_set'], true) : [];

            // $need_review = BranchOrigin::where('id', $BranchOriginUnit['origin_id'] ?? 0)
            //     ->whereJsonContains('local_review_set', $BranchOriginUnit['locale'] ?? 'none')->count() > 0;

            $jsonSup = empty($data['roles']) ? [] : collect(json_decode($data['roles'], true))->mapwithkeys(function ($item, $key) {
                return [$key => explode(";", $item)];
            })->all();

            $key_group = WebKey::getCmsRoleList($BranchOriginUnit);
            $editView = View::make(
                'Fantasy.ams.cms_manager.ajax.edit',
                [
                    'data' => $data,
                    'branch_unit_options' => $branch_unit_options,
                    'jsonSup' => $jsonSup,
                    'key_group' => $key_group,
                    'index' => $index,
                    'unit_set' => $unit_set,
                    'BranchOriginUnit' => $BranchOriginUnit,
                    'need_review' => $need_review,
                ]
            )->render();
            $reback =
                [
                'content' => $editView,
            ];
        } else if ($type == 'cms-overview') {
            $data = CmsRole::where('id', $id)->wherehas('UsersData')->with('UsersData')->first();
            $data = !empty($data) ? $data->toArray() : [];

            $branch_unit_options = [];
            $tempData = BranchOriginUnit::where('is_active', 1)->with('BranchOrigin')->orderby('origin_id', 'asc')->orderby('locale', 'DESC')->get()->toArray();
            foreach ($tempData as $key => $value) {
                $temp =
                    [
                    'title' => $value['branch_origin']['title'] . '-' . self::$langArray[$value['locale']]['title'],
                    'key' => $value['id'],
                ];
                $branch_unit_options[$value['id']] = $temp;
            }
            $jsonSup = [];
            if (!empty($data)) {
                $json = json_decode($data['roles'], true);
            } else {
                $json = [];
            }
            if (!empty($json)) {
                foreach ($json as $key => $value) {
                    $jsonSup[$key] = explode(";", $value);
                }
            }
            $key_group = WebKey::get()->toArray();
            foreach ($key_group as $key => $value) {
                $templateMenu = CmsMenu::where('use_type', 1)->where('key_id', $value['id'])->where('is_active', 1)->get()->toArray();

                if (empty($templateMenu)) {
                    unset($key_group[$key]);
                    continue;
                }

                $key_group[$key]['templateMenu'] = $templateMenu;
            }

            $editView = View::make(
                'Fantasy.ams.cms_overview.ajax.edit',
                [
                    'data' => $data,
                    'branch_unit_options' => $branch_unit_options,
                    'json' => $json,
                    'jsonSup' => $jsonSup,
                    'key_group' => $key_group,
                ]
            )->render();

            $reback =
                [
                'content' => $editView,
            ];
        } else if ($type == 'crs-template') {
            $data = CrsRole::where('id', $id)->wherehas('UsersData')->with('UsersData')->first();
            $data = !empty($data) ? $data->toArray() : [];

            $branch_unit_options = [];
            $tempData = BranchOriginUnit::where('is_active', 1)->with('BranchOrigin')->orderby('origin_id', 'asc')->orderby('locale', 'DESC')->get()->toArray();
            foreach ($tempData as $key => $value) {
                $temp =
                    [
                    'title' => $value['branch_origin']['title'] . '-' . self::$langArray[$value['locale']]['title'],
                    'key' => $value['id'],
                ];
                $branch_unit_options[$value['id']] = $temp;
            }
            $jsonSup = [];
            if (!empty($data)) {
                $json = json_decode($data['roles'], true);
            } else {
                $json = [];
            }
            if (!empty($json)) {
                foreach ($json as $key => $value) {
                    $jsonSup[$key] = explode(";", $value);
                }
            }
            $key_group = WebKey::get()->toArray();
            foreach ($key_group as $key => $value) {
                $templateMenu = CmsMenu::where('use_type', 2)->where('key_id', $value['id'])->where('is_active', 1)->get()->toArray();
                $key_group[$key]['templateMenu'] = $templateMenu;
            }

            $editView = View::make(
                'Fantasy.ams.crs_template.ajax.edit',
                [
                    'data' => $data,
                    'branch_unit_options' => $branch_unit_options,
                    'json' => $json,
                    'jsonSup' => $jsonSup,
                    'key_group' => $key_group,
                ]
            )->render();

            $reback =
                [
                'content' => $editView,
            ];
        } else if ($type == 'crs-overview') {
            $data = CrsRole::where('id', $id)->wherehas('UsersData')->with('UsersData')->first();
            $data = !empty($data) ? $data->toArray() : [];

            $branch_unit_options = [];
            $tempData = BranchOriginUnit::where('is_active', 1)->with('BranchOrigin')->orderby('origin_id', 'asc')->orderby('locale', 'DESC')->get()->toArray();
            foreach ($tempData as $key => $value) {
                $temp =
                    [
                    'title' => $value['branch_origin']['title'] . '-' . self::$langArray[$value['locale']]['title'],
                    'key' => $value['id'],
                ];
                $branch_unit_options[$value['id']] = $temp;
            }
            $jsonSup = [];
            if (!empty($data)) {
                $json = json_decode($data['roles'], true);
            } else {
                $json = [];
            }
            if (!empty($json)) {
                foreach ($json as $key => $value) {
                    $jsonSup[$key] = explode(";", $value);
                }
            }
            $key_group = WebKey::get()->toArray();
            foreach ($key_group as $key => $value) {
                $templateMenu = CmsMenu::where('use_type', 1)->where('key_id', $value['id'])->where('is_active', 1)->get()->toArray();
                $key_group[$key]['templateMenu'] = $templateMenu;
            }

            $editView = View::make(
                'Fantasy.ams.crs_overview.ajax.edit',
                [
                    'data' => $data,
                    'branch_unit_options' => $branch_unit_options,
                    'json' => $json,
                    'jsonSup' => $jsonSup,
                    'key_group' => $key_group,
                ]
            )->render();

            $reback =
                [
                'content' => $editView,
            ];
        } else if ($type == 'fms-folder') {
            $data = FmsZero::where('id', $id)->first();
            $data = !empty($data) ? $data->toArray() : [];

            $editView = View::make(
                'Fantasy.ams.fms_folder.ajax.edit',
                [
                    'data' => $data,
                ]
            )->render();

            $reback =
                [
                'content' => $editView,
            ];
        } else if ($type == 'autoredirect') {
            $data = Autoredirect::where('id', $id)->first();
            $data = !empty($data) ? $data->toArray() : [];

            $editView = View::make(
                'Fantasy.ams.website_redirect.ajax.edit',
                [
                    'data' => $data,
                ]
            )->render();

            $reback =
                [
                'content' => $editView,
            ];
        } else if ($type == 'log') {
            $selectDate = $_GET['date'];
            $nowYm = date('Ym');
            $selectTableName = 'basic_log_data';
            if($selectDate != $nowYm) $selectTableName .= '_'.$selectDate;

            $data = DB::table($selectTableName)->where('id', $id)->first();
            $data = collect($data);
            //取得上一次的資料
            $old_data = DB::table($selectTableName)
                ->where('id', '<', $data['id'])
                ->where('table_name', $data['table_name'])
                ->where('data_id', $data['data_id'])
                ->orderby('id', 'desc')
                ->first();
            $old_data = collect($old_data);

            $columns = array_reduce(empty($data['table_name']) ? [] : json_decode(json_encode(\DB::select('show full columns from ' . $data['table_name'])), true), function ($res, $col) {
                $res[$col['Field']] = $col;
                return $res;
            }, []);

            $actions = [
                'create' => '新增了資料。',
                'update' => '修改了資料。',
                'delete' => '刪除了資料。',
                'login' => "登入了後台。",
                'insert' => '新增了資料。',
                'edit' => '修改了資料。',
                'del' => '刪除了資料。',
            ];

            $editView = View::make(
                'Fantasy.ams.log.ajax.edit',
                [
                    'actions' => $actions,
                    'data' => $data,
                    'old_data' => $old_data,
                    'columns' => $columns,
                ]
            )->render();

            $reback =
                [
                'content' => $editView,
            ];
        }
        return $reback;
    }
    public function member($key_pp)
    {
        $key_pp = request()->key;

        $fileInformationArray = self::$fileInformationArray;
        $data = FantasyUsers::where('is_active', 1)->select('id', 'is_active', 'name', 'account', 'mail', 'photo_image', 'updated_at', 'created_at')->get()->toArray();
        foreach ($data as $key => $value) {
            if (isset($fileInformationArray[$value['photo_image']]) and !empty($fileInformationArray[$value['photo_image']])) {
                $data[$key]['img_route'] = $fileInformationArray[$value['photo_image']]['real_route'];
            } else {
                $data[$key]['img_route'] = '';
            }
        }
        foreach ($data as $key => $value) {
            $data[$key]['json_data'] = json_encode($value);
        }
        return View::make(
            'Fantasy.ams.includes.user_list',
            [
                'key_pp' => $key_pp,
                'data' => $data,
            ]
        );
    }
}
