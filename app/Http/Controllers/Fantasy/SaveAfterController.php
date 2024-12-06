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
use \Carbon\Carbon;

class SaveAfterController extends BackendController
{
	public function __construct()
	{
		parent::__construct();
	}
	public static function CustomizeSave($modelName, $data)
	{
		if ((int) method_exists('\App\Http\Controllers\Fantasy\SaveAfterController', $modelName)) {
			return self::$modelName($data);
		}
		return $data;
	}
	public static function Orderform_room($data)
	{
		$orderform = M('orderform')::where('id', $data['parent_id'])->with(['orderform_room', 'orderform_service', 'orderform_product'])->first();
		if ($orderform['orderform_room']->where('w_state', '>', 0)->count() == $orderform['orderform_room']->count() && $orderform['orderform_service']->where('w_state', '>', 0)->count() == $orderform['orderform_service']->count()) {
			if ((!empty($orderform['orderform_product']) && $orderform['orderform_product']['w_state'] != 0) || empty($orderform['orderform_product'])) {
				$orderform->w_state = 1;
				$orderform->save();
			}
		}
	}
	public static function Orderform_service($data)
	{
		$orderform = M('orderform')::where('id', $data['parent_id'])->with(['orderform_room', 'orderform_service', 'orderform_product'])->first();
		if ($orderform['orderform_room']->where('w_state', '>', 0)->count() == $orderform['orderform_room']->count() && $orderform['orderform_service']->where('w_state', '>', 0)->count() == $orderform['orderform_service']->count()) {
			if ((!empty($orderform['orderform_product']) && $orderform['orderform_product']['w_state'] != 0) || empty($orderform['orderform_product'])) {
				$orderform->w_state = 1;
				$orderform->save();
			}
		}
	}
	public static function Orderform_product($data)
	{
		$orderform = M('orderform')::where('id', $data['parent_id'])->with(['orderform_room', 'orderform_service', 'orderform_product'])->first();
		if ($orderform['orderform_room']->where('w_state', '>', 0)->count() == $orderform['orderform_room']->count() && $orderform['orderform_service']->where('w_state', '>', 0)->count() == $orderform['orderform_service']->count()) {
			if ((!empty($orderform['orderform_product']) && $orderform['orderform_product']['w_state'] != 0) || empty($orderform['orderform_product'])) {
				$orderform->w_state = 1;
				$orderform->save();
			}
		}
	}
}