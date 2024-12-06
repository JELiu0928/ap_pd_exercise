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
use App\Models\Product\ProductCategoryOverviewList;

// use App\Models\Traits\getUrlName;

class ProductSeries extends FrontBase
{
	// use getUrlName;
	public function __construct()
	{
		$TableName = "product_series";
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

	// public function ProductCategoryOverviewList()
	// {
	// 	return $this->hasMany(ProductCategoryOverviewList::class, 'category_id');
	// }

	// public function ProductCategoryAdvantagesTags()
	// {
	// 	return $this->hasMany(ProductCategoryAdvantagesTags::class, 'category_id');
	// }
}
