<?php

namespace App\Http\Controllers\Fantasy\ams;

use App\Http\Controllers\Fantasy\AmsController as AmsPaPa;
use App\Http\Controllers\Fantasy\MenuController as MenuFunction;
use Illuminate\Http\Request;

use View;
use Redirect;
use Auth;
use Debugbar;
use Route;
use App;
use Config;
use Session;

use UnitMaker;
use TableMaker;
use BaseFunction;

/**相關Models**/

use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;

class TemplateSettingController extends AmsPaPa
{
	public static $fileInformationArray = [];

	public function __construct()
	{
		parent::__construct();
		// self::$fileInformationArray = BaseFunction::getAllFilesArray();
		// View::share('fileInformationArray', self::$fileInformationArray);
		View::share('langArray', parent::$langArray);
		$branch_options = [];

		// $branchData = BranchOrigin::where('is_active', 1)->get()->toArray();
		$branchData = BranchOrigin::get()->toArray();
		foreach ($branchData as $key => $value) {
			$temp =
				[
					'title' => $value['title'],
					'key' => $value['id']
				];
			$branch_options[$value['id']] = $temp;
		}
		View::share('branch_options', $branch_options);
		View::share('locale_options', parent::$langArray);
	}

	public function index()
	{
		$BranchOrigin = M('BranchOrigin')::where('is_active',1)->get();
		$unit_list = [];
		foreach ($BranchOrigin as $val) {
			$local_set = json_decode($val['local_set']);
			foreach ($local_set as $v) {
				$unit_list[] = [
					'origin_id' => $val['id'],
					'locale' => $v
				];
				$BranchOriginUnit = BranchOriginUnit::where('origin_id', $val['id'])->where('locale', $v)->first();
				if (empty($BranchOriginUnit)) {
					$BranchOriginUnit = new BranchOriginUnit;
					$BranchOriginUnit->origin_id = $val['id'];
					$BranchOriginUnit->locale = $v;
					$BranchOriginUnit->save();
				}
			}
		}

		$unit_list = collect($unit_list);
		$data = BranchOriginUnit::orderby('origin_id', 'asc')->orderby('locale', 'DESC')->get();
		foreach ($data as $key => $val) {
			if (empty($unit_list->where('origin_id', $val['origin_id'])->where('locale', $val['locale'])->first())) {
				unset($data[$key]);
				BranchOriginUnit::where('id', $val['id'])->delete();
			}
		}
		return View::make(
			'Fantasy.ams.template_setting.index',
			[
				'data' => $data
			]
		);
	}

    // 分頁資料按下儲存後
	public function update(Request $request)
	{
		$data = $request->input('amsData');
		$json = $request->input('jsonData');
		$CmsMenuUse = array_filter(M('CmsMenuUse')::where('parent_id', 0)->get()->map(function ($item) use ($json) {
			$item['branch_active'] = $json[$item['key_id']] ?? 0;
			return ($item['branch_active']) ? $item : [];
		})->toArray());
		foreach ($CmsMenuUse as $key => $row) {
			if ($row['type'] == 1) {
				$CmsMenuUse[$key]['list'] = M('CmsMenuUse')::where('use_type', 2)->whereIn('type', ['3', '4'])->where('parent_id', $row['id'])->orderBy('w_rank', 'asc')->get()->map(function ($item, $key) {
					$item['list'] = M('CmsMenuUse')::where('use_type', 2)->where('type', '5')->where('parent_id', $item['id'])->orderBy('w_rank', 'asc')->get()->toArray();
					return $item;
				})->toArray();
			}
		}
		//建立分館選單資料
		$has_auth_list = [];
		foreach ($CmsMenuUse as $val) {
			$val['branch_id'] = $data['origin_id'];
			$tempData = $val;
			unset($tempData['id'], $tempData['branch_active'], $tempData['list']);

			$level_1 = M('CmsMenu')::where("branch_id", $data['origin_id'])->where('use_id', $val['id'])->first() ?: M('CmsMenu', true);
			foreach ($tempData as $key => $v) {
				$level_1->$key = $v;
			}
			$level_1->use_id = $val['id'];
			$level_1->save();
			//分類權限
			if (!empty($val['has_auth'])) {
				$has_auth_list[] = ['menu_id' => $level_1->id, 'menu_use_id' => $val['has_auth'], 'branch_id' => $data['origin_id']];
			}
			$val['list'] = $val['list'] ?? [];
			foreach ($val['list'] as $val2) {
				$val2['branch_id'] = $data['origin_id'];
				$val2['parent_id'] = $level_1->id;

				$tempData = $val2;
				unset($tempData['id'], $tempData['branch_active'], $tempData['list']);
				$level_2 = M('CmsMenu')::where("branch_id", $data['origin_id'])->where('use_id', $val2['id'])->first() ?: M('CmsMenu', true);
				foreach ($tempData as $key => $v) {
					$level_2->$key = $v;
				}
				$level_2->use_id = $val2['id'];
				$level_2->save();
				//分類權限
				if (!empty($val2['has_auth'])) {
					$has_auth_list[] = ['menu_id' => $level_2->id, 'menu_use_id' => $val2['has_auth'], 'branch_id' => $data['origin_id']];
				}
				$val2['list'] = $val2['list'] ?? [];
				foreach ($val2['list'] as $val3) {
					$val3['branch_id'] = $data['origin_id'];
					$val3['parent_id'] = $level_2->id;
					$tempData = $val3;
					unset($tempData['id'], $tempData['branch_active'], $tempData['list']);
					$level_3 = M('CmsMenu')::where("branch_id", $data['origin_id'])->where('use_id', $val3['id'])->first() ?: M('CmsMenu', true);

					foreach ($tempData as $key => $v) {
						$level_3->$key = $v;
					}
					$level_3->use_id = $val3['id'];
					$level_3->save();
					//分類權限
					if (!empty($val['has_auth'])) {
						$has_auth_list[] = ['menu_id' => $level_3->id, 'menu_use_id' => $val3['has_auth'], 'branch_id' => $data['origin_id']];
					}
				}
			}
		}
		//更新分類權限的ID

		foreach ($has_auth_list as $val) {
			$CmsMenuUse = M('CmsMenuUse')::where('id', $val['menu_use_id'])->first();
			$CmsMenu = M('CmsMenu')::where('branch_id', $val['branch_id'])->where('key_id', $CmsMenuUse['key_id'])->where('model', $CmsMenuUse['model'])->first();
			$CmsMenuEdit = M('CmsMenu')::where('id', $val['menu_id'])->first();
			$CmsMenuEdit->has_auth = $CmsMenu->id;
			$CmsMenuEdit->save();
		}


		$BranchOriginUnit = ($data['id'] == 0) ?  M('BranchOriginUnit', true) : M('BranchOriginUnit')::where('id', $data['id'])->first();
		foreach ($data as $key => $value) {
			if ($key != 'id') {
				$BranchOriginUnit->$key = $value;
			}
		}
		$BranchOriginUnit->unit_set = json_encode($json);
		$BranchOriginUnit->save();

		$reback = ['id' => $BranchOriginUnit->id, 'result' => true, 'status' => ($data['id'] == 0) ? 'create' : 'update'];
		return $reback;
	}
	public function delete(Request $request)
	{
		$kill_id = $request->input('id');
		$info = BranchOriginUnit::where('id', $kill_id)->first();
		if (!empty($info)) {
			$info->delete();
		}
	}
	public function reset()
	{
		$data = BranchOriginUnit::orderby('origin_id', 'asc')->orderby('locale', 'DESC')->get();
		return View::make(
			'Fantasy.ams.template_setting.ajax.table',
			[
				'data' => $data
			]
		);
	}
}
