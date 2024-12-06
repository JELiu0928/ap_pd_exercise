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
// use App\Models\Product\ProductItem;
use App\Models\Product\ProductItemKeyword;

// use App\Models\Traits\getUrlName;

class ProductItem extends FrontBase
{
	// use getUrlName;
	public function __construct()
	{
		$TableName = "product_items";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}
	public function ProductItemKeyword()
	{
		return $this->hasMany(ProductItemKeyword::class, 'item_id');
	}
	public function productItemKeywords()
	{
		return $this->hasMany(ProductItemKeyword::class, 'item_id')->isVisible();
	}

	// public function ProductCategoryOverviewList()
	// {
	// 	return $this->hasMany(ProductCategoryOverviewList::class, 'category_id');
	// }

	// public function ProductCategoryAdvantagesTags()
	// {
	// 	return $this->hasMany(ProductCategoryAdvantagesTags::class, 'category_id');
	// }
}
