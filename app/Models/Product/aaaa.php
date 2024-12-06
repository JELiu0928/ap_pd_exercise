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
use App\Models\Product\ProductCategoryOverview;

// use App\Models\Traits\getUrlName;

class ProductCategoryOverviewLisaa extends FrontBase
{
	// use getUrlName;
	public function __construct()
	{
		$TableName = "product_category_overview_list";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}
	// public function ProductCategoryOverview()
	// {
	// 	return $this->hasMany(ProductCategoryOverview::class, 'category_id');
	// }
}
