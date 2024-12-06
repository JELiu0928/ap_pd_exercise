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

use App\Models\Basic\Crs\CrsRole;
use App\Models\Basic\Branch\BranchOriginUnit;

class CrsOverviewController extends AmsPaPa
{
	public static $fileInformationArray = [];

	public function __construct()
	{
		parent::__construct();
		// self::$fileInformationArray = BaseFunction::getAllFilesArray();
		// View::share('fileInformationArray', self::$fileInformationArray);

		$branch_unit_options = [];
		$tempData = BranchOriginUnit::where('is_active', 1)->with('BranchOrigin')->orderby('origin_id', 'asc')->orderby('locale', 'DESC')->get()->toArray();
		foreach ($tempData as $key => $value) {
			$temp =
				[
					'title' => $value['branch_origin']['title'] . '-' . parent::$langArray[$value['locale']]['title'],
					'key' => $value['id']
				];
			$branch_unit_options[$value['id']] = $temp;
		}

		View::share('branch_unit_options', $branch_unit_options);
	}

	public function index()
	{
		$data = CrsRole::where('type', 1)->wherehas('UsersData')->with('UsersData')->get()->toArray();
		return View::make(
			'Fantasy.ams.crs_overview.index',
			[
				'data' => $data
			]
		);
	}
	public function update(Request $request)
	{
		$data = $request->input('amsData');
		$json = $request->input('jsonData');
		$temp_json = [];
		foreach ($json as $key => $value) {
			$temp_json[$key] = '';
			foreach ($value as $key2 => $value2) {
				$temp_json[$key] .= ';';
				$temp_json[$key] .= $value2;
			}
		}
		if ($data['id'] == 0) {
			$info = new CrsRole;

			foreach ($data as $key => $value) {
				if ($key != 'id') {
					$info->$key = $value;
				}
			}
			$info->roles = json_encode($temp_json);
			$info->type = 1;
			$info->save();
			$reback =
				[
					'id' => $info->id,
					'result' => true,
					'status' => 'create'
				];
		} else {
			$info = CrsRole::where('id', $data['id'])->first();
			if (!empty($info)) {
				foreach ($data as $key => $value) {
					if ($key != 'id') {
						$info->$key = $value;
					}
				}
				$info->roles = json_encode($temp_json);
				$info->type = 1;
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
		$info = CrsRole::where('id', $kill_id)->first();
		if (!empty($info)) {
			$info->delete();
		}
	}
	public function reset()
	{
		$data = CrsRole::where('type', 1)->wherehas('UsersData')->with('UsersData')->get()->toArray();
		return View::make(
			'Fantasy.ams.crs_overview.ajax.table',
			[
				'data' => $data
			]
		);
	}
}
