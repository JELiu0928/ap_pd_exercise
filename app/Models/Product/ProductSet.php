<?php
namespace App\Models\Product;
use Config;
use BaseFunction;
use Session;
use DB;
use Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as Model_Builder;
use App\Models\FrontBase;


// use App\Models\Traits\getUrlName;

class ProductSet extends FrontBase
{
	// use getUrlName;
	public function __construct()
	{
		$TableName = "product_set";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}
	// public function scopegetUrlName($query, $empty = false)
	// {
	// 	$data = self::select('url_name')->get()->pluck('url_name')->toArray();
	// 	if ($empty) {
	// 		array_unshift($data, '');  // 讓空值也可以選擇
	// 	}
	// 	return $data;
	// }
}
