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
use Cache;

/**相關Models**/

use App\Models\Basic\Branch\BranchOrigin;

class TemplateManagerController extends AmsPaPa
{
	public static $fileInformationArray = [];

	public function __construct()
	{
		parent::__construct();
		// self::$fileInformationArray = BaseFunction::getAllFilesArray();
		// View::share('fileInformationArray', self::$fileInformationArray);
		View::share('langArray', parent::$langArray);
	}

	public function index()
	{
		$data = BranchOrigin::get();
		return View::make(
			'Fantasy.ams.template_manager.index',
			[
				'data' => $data
			]
		);
	}
	public function update(Request $request)
	{
		$data = $request->input('amsData');
		if (!empty($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		}
		if ($data['id'] == 0) {
			$info = new BranchOrigin;
			foreach ($data as $key => $value) {
                if($key == 'local_set'){
                    $value = array_filter($value);
                }
				if ($key != 'id') {
					$value = (is_array($value)) ? json_encode($value) : $value;
					$info->$key = $value;
				}
			}
			$info->save();
			$reback = ['id' => $info->id, 'result' => true, 'status' => 'create'];
		} else {
			$info = BranchOrigin::where('id', $data['id'])->first();
			if (!empty($info)) {
				if(isset($data['url_title'])){
					Cache::forget('branch_'.$info['url_title']);
					Cache::forget('branch_'.$data['url_title']);
				}
				foreach ($data as $key => $value) {
                    if($key == 'local_set'){
                        $value = array_filter($value);
                    }
					$value = (is_array($value)) ? json_encode($value) : $value;
					if ($key != 'id') {
						$info->$key = $value;
					}
				}
				$info->save();
				$reback = ['id' => $data['id'], 'result' => true, 'status' => 'update'];
			} else {
				$reback = ['result' => false];
			}
		}
		return $reback;
	}
	public function delete(Request $request)
	{
		$kill_id = $request->input('id');
		$info = BranchOrigin::where('id', $kill_id)->first();
		if (!empty($info)) {
			$info->delete();
		}
	}
	public function reset()
	{
		$data = BranchOrigin::get();
		return View::make(
			'Fantasy.ams.template_manager.ajax.table',
			[
				'data' => $data
			]
		);
	}
}
