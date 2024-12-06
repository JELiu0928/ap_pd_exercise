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


class WhereController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}
	public static function Customize($modelName, $menu_id, $data)
	{
		// if ($modelName == 'Orderform_room') {
		// 	if ($menu_id == 201) {
		// 		$data->where('w_state', 0)->wherehas('orderform');
		// 	}
		// }
		return $data;
	}
}