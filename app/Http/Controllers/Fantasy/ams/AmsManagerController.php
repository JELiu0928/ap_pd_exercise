<?php

namespace App\Http\Controllers\Fantasy\ams;

use App\Http\Controllers\Fantasy\AmsController as AmsPaPa;
use App\Http\Controllers\Fantasy\MenuController as MenuFunction;
use Illuminate\Http\Request;

use View;
use Redirect;
use Auth;
use Route;
use App;
use Config;
use Session;

use UnitMaker;
use TableMaker;
use BaseFunction;

/**相關Models**/

use App\Models\Basic\Ams\AmsRole;

class AmsManagerController extends AmsPaPa
{
	public static $fileInformationArray = [];

	public function __construct()
	{
		parent::__construct();
		// self::$fileInformationArray = BaseFunction::getAllFilesArray();
		// View::share('fileInformationArray', self::$fileInformationArray);

	}

	public function index()
	{
		$data = AmsRole::orderBy('updated_at', 'desc')->wherehas('UsersData')->with('UsersData')->get();
		// 自行設定使用
		$role_to_ch = [
			'is_ams' => 'AMS 管理權限',
			'is_cover_page' => 'CMS 分館語系設定',
			'is_cms_template' => 'CMS 分館資料設定',
			'is_fantasy' => 'Fantasy Account 管理權限',
			'is_autoredirect' => 'Website Redirect 管理權限',
			'is_cms_template_ma' => 'CMS 帳號權限管理',
			'is_folder' => 'FMS 管理權限',
			'is_log' => 'Log 管理權限'
		];
		foreach ($data as $key => $value) {
			$role_identity = '';
			$role_group = '';
			$role_array = [];

			if ($value['a_or_m'] == 1) {
				$role_identity = 'Administrator';
			} else if ($value['a_or_m'] == 2) {
				$role_identity = 'Manager';
			}

			if ($value['is_ams'] == 1) {
				array_push($role_array, 'AMS');
			}
			if ($value['is_cover_page'] == 1) {
				array_push($role_array, $role_to_ch['is_cover_page']);
			}
			if ($value['is_cms_template'] == 1) {
				array_push($role_array, $role_to_ch['is_cms_template']);
			}
			if ($value['is_cms_template_ma'] == 1) {
				array_push($role_array, $role_to_ch['is_cms_template_ma']);
			}
			if ($value['is_cms_template_setting'] == 1) {
				array_push($role_array, 'Cms Template Setting');
			}
			// if($value['is_cover_page_setting'] == 1)
			// {
			// 	array_push($role_array, 'Cover Page Setting');
			// }
			if ($value['is_crs_role'] == 1) {
				array_push($role_array, 'Crs Template Roles');
			}
			if ($value['is_overview_crs'] == 1) {
				array_push($role_array, 'Crs Cover Page Roles');
			}
			// if($value['is_cms'] == 1)
			// {
			// 	array_push($role_array, 'CMS');
			// }
			// if($value['is_cms_temp'] == 1)
			// {
			// 	array_push($role_array, 'CMS Template');
			// }
			// if($value['is_crs'] == 1)
			// {
			// 	array_push($role_array, 'CMS Review');
			// }
			// if($value['is_fms'] == 1)
			// {
			// 	array_push($role_array, 'FMS');
			// }
			// if($value['is_web'] == 1)
			// {
			// 	array_push($role_array, 'Message');
			// }
			// if($value['is_message'] == 1)
			// {
			// 	array_push($role_array, 'Web Analyties');
			// }
			// if($value['is_google'] == 1)
			// {
			// 	array_push($role_array, 'Google Analyties');
			// }
			if ($value['is_folder'] == 1) {
				array_push($role_array, $role_to_ch['is_folder']);
			}
			if ($value['is_fantasy'] == 1) {
				array_push($role_array, 'Fantasy Accoutn');
			}
			// if($value['is_fantasy_setting'] == 1)
			// {
			// 	array_push($role_array, 'Fantasy Setting');
			// }
			if ($value['is_autoredirect'] == 1) {
				array_push($role_array, 'Website Redirect');
			}
			if ($value['is_log'] == 1) {
				array_push($role_array, 'Log');
			}
			foreach ($role_array as $key2 => $value2) {
				if ($key2 != 0) {
					$role_group .= '/ ' . $value2 . ' ';
				} else {
					$role_group .= $value2 . ' ';
				}
			}

			$data[$key]['role_identity'] = $role_identity;
			$data[$key]['role_group'] = $role_group;
			$configSet = Config::get('cms');
		}
		return View::make(
			'Fantasy.ams.ams_manager.index',
			[
				'data' => $data,
				'configSet' => $configSet,
			]
		);
	}
	public function update(Request $request)
	{
		$data = $request->input('amsData');
		if ($data['id'] == 0) {
			$info = new AmsRole;

			foreach ($data as $key => $value) {
				if ($key != 'id') {
					$info->$key = $value;
				}
			}
			$info->a_or_m = 2;
			$info->save();
			$reback =
				[
					'id' => $info->id,
					'result' => true,
					'status' => 'create'
				];
		} else {
			$info = AmsRole::where('id', $data['id'])->first();
			if (!empty($info)) {
				foreach ($data as $key => $value) {
					if ($key != 'id') {
						$info->$key = $value;
					}
				}
				$info->save();
				$reback =
					[
						'id' => $data['id'],
						'result' => true,
						'status' => 'update'
					];
			} else {
				$reback =
					[
						'result' => false
					];
			}
		}
		return $reback;
	}
	public function delete(Request $request)
	{
		$kill_id = $request->input('id');
		$info = AmsRole::where('id', $kill_id)->first();
		if (!empty($info)) {
			$info->delete();
		}
	}
	public function reset()
	{
		$data = AmsRole::orderBy('updated_at', 'desc')->wherehas('UsersData')->with('UsersData')->get();
		foreach ($data as $key => $value) {
			$role_identity = '';
			$role_group = '';
			$role_array = [];
			if ($value['a_or_m'] == 1) {
				$role_identity = 'Administrator';
			} else if ($value['a_or_m'] == 2) {
				$role_identity = 'Manager';
			}

			if ($value['is_ams'] == 1) {
				array_push($role_array, 'Ams');
			}
			if ($value['is_cover_page'] == 1) {
				array_push($role_array, 'Cover Page Roles');
			}
			if ($value['is_cms_template'] == 1) {
				array_push($role_array, 'Cms Template Roles');
			}
			if ($value['is_cms_template_ma'] == 1) {
				array_push($role_array, 'Cms Template Manager');
			}
			if ($value['is_cms_template_setting'] == 1) {
				array_push($role_array, 'Cms Template Setting');
			}
			if ($value['is_cover_page_setting'] == 1) {
				array_push($role_array, 'Cover Page Setting');
			}
			if ($value['is_crs_role'] == 1) {
				array_push($role_array, 'Crs Template Roles');
			}
			if ($value['is_overview_crs'] == 1) {
				array_push($role_array, 'Crs Cover Page Roles');
			}
			// if($value['is_cms'] == 1)
			// {
			// 	array_push($role_array, 'CMS');
			// }
			// if($value['is_cms_temp'] == 1)
			// {
			// 	array_push($role_array, 'CMS Template');
			// }
			// if($value['is_crs'] == 1)
			// {
			// 	array_push($role_array, 'CMS Review');
			// }
			// if($value['is_fms'] == 1)
			// {
			// 	array_push($role_array, 'FMS');
			// }
			// if($value['is_web'] == 1)
			// {
			// 	array_push($role_array, 'Message');
			// }
			// if($value['is_message'] == 1)
			// {
			// 	array_push($role_array, 'Web Analyties');
			// }
			// if($value['is_google'] == 1)
			// {
			// 	array_push($role_array, 'Google Analyties');
			// }
			if ($value['is_fantasy'] == 1) {
				array_push($role_array, 'Fantasy Account');
			}
			// if($value['is_fantasy_setting'] == 1)
			// {
			// 	array_push($role_array, 'Fantasy Setting');
			// }
			if ($value['is_autoredirect'] == 1) {
				array_push($role_array, 'Website Redirect');
			}
			if ($value['is_log'] == 1) {
				array_push($role_array, 'Log');
			}

			foreach ($role_array as $key2 => $value2) {
				if ($key2 != 0) {
					$role_group .= '/ ' . $value2 . ' ';
				} else {
					$role_group .= $value2 . ' ';
				}
			}

			$data[$key]['role_identity'] = $role_identity;
			$data[$key]['role_group'] = $role_group;
		}

		return View::make(
			'Fantasy.ams.ams_manager.ajax.table',
			[
				'data' => $data
			]
		);
	}
}
