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

use App\Models\Basic\FantasyUsers;

class FantasyAccountController extends AmsPaPa
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
		$data = FantasyUsers::with('_photo_image')->get();
		return View::make(
			'Fantasy.ams.fantasy_account.index',
			[
				'data' => $data
			]
		);
	}
	public function update(Request $request)
	{
		$data = $request->input('amsData');
		if (isset($data['password'])) {
			if ($data['password'] === $data['password2']) {
				unset($data['password2']);
			} else {
				$reback =
					[
						'result' => false,
						'warning' => '重複輸入密碼錯誤。'
					];
				return $reback;
			}

			if (!empty($data['password'])) {
				$data['password'] = bcrypt($data['password']);
			}
		}
		if ($data['id'] == 0) {
			$info = new FantasyUsers;

			foreach ($data as $key => $value) {
				if ($key == 'password') {
					if (!empty($value)) {
						$info->$key = $value;
					}
				} else {
					if ($key != 'id' && $key != 'password2') {
						$info->$key = $value??'';
					}
				}
			}

			$info->save();
			$reback =
				[
					'id' => $info->id,
					'result' => true,
					'status' => 'create'
				];
		} else {
			$info = FantasyUsers::where('id', $data['id'])->first();
			if (!empty($info)) {
				foreach ($data as $key => $value) {
					if ($key == 'password') {
						if (!empty($value)) {
							$info->$key = $value;
						}
					} else {
						if ($key != 'id' && $key != 'password2') {
							$info->$key = $value??'';
						}
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
		$info = FantasyUsers::where('id', $kill_id)->first();
		if (!empty($info)) {
			$info->delete();
		}
	}
	public function reset()
	{
		$data = FantasyUsers::with('_photo_image')->get();
		return View::make(
			'Fantasy.ams.fantasy_account.ajax.table',
			[
				'data' => $data
			]
		);
	}
}
