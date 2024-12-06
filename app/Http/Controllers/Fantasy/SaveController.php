<?php

namespace App\Http\Controllers\Fantasy;

use Illuminate\Http\Request;

use View;
use Redirect;
use Auth;
use Debugbar;
use Route;
use App;
use App\Http\Controllers\BaseFunctions;
use Config;
use Session;
use Crypt;
use DB;
use Mail;
use Hash;

use UnitMaker;
use TableMaker;
use BaseFunction;


class SaveController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}
	public static function CustomizeSave($modelName, $data)
	{
		if ((int) method_exists('\App\Http\Controllers\Fantasy\SaveController', $modelName)) {
			return self::$modelName($data);
		}
		return $data;
	}
	public static function Gift_budget($data)
	{
		return $data;
	}
}