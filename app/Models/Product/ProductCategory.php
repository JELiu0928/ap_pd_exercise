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

class ProductCategory extends FrontBase
{
	// use getUrlName;
	public function __construct()
	{
		parent::__construct(); //要使用boot(),要使用這行
		$TableName = "product_categories";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}

	protected static function boot()
	{
		parent::boot();
		static::saving(function ($model) {
			$title = $model->banner_title;
			// strip_tags() 函數用於去除字串中的 HTML 和 PHP 標籤
			$model->simple_title = strip_tags($title);
			$intro = $model->banner_intro;
			$model->simple_intro = strip_tags($intro);

		});
	}
	public function ProductCategoryOverview()
	{
		return $this->hasMany(ProductCategoryOverview::class, 'category_id');
	}

	public function ProductCategoryOverviewList()
	{
		return $this->hasMany(ProductCategoryOverviewList::class, 'category_id');
	}

	public function ProductCategoryAdvantagesTags()
	{
		return $this->hasMany(ProductCategoryAdvantagesTags::class, 'category_id');
	}
	public static function getList()
	{
		// dd(ProductCategory::get());
		return self::select('id', 'simple_title')->get()->map(function ($item, $key) {
			return [
				'key' => $item['id'],
				'title' => $item['simple_title']
			];
		})->keyBy('key');
	}


}
