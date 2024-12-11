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
		parent::__construct();

		$TableName = "product_items";
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
			// $intro = $model->banner_intro;
			// $model->simple_intro = strip_tags($intro);

		});
	}
	public function ProductItemKeyword()
	{
		return $this->hasMany(ProductItemKeyword::class, 'item_id');
	}
	public function keywords()
	{
		return $this->hasMany(ProductItemKeyword::class, 'item_id')->isVisible();
	}

	public function series()
	{
		return $this->belongsTo(ProductSeries::class, 'series_id');
	}

	public function ProductArticle()
	{
		return $this->hasMany(ProductArticle::class, 'parent_id');
	}
	public function articles()
	{
		return $this->hasMany(ProductArticle::class, 'parent_id')->isVisible();
	}
	// 多個產品型號
	public function ProductItemPart()
	{
		return $this->hasMany(ProductItemPart::class, 'item_id');
	}
	public function ProductItemSpecTitle()
	{
		return $this->hasMany(ProductItemSpecTitle::class, 'item_id');
	}
	public function parts()
	{
		return $this->hasMany(ProductItemPart::class, 'item_id')->isVisible();
		// return $this->hasMany(ProductItemPart::class, 'item_id');
	}
	public function specTitles()
	{
		return $this->hasMany(ProductItemSpecTitle::class, 'item_id')->isVisible();
	}
	//     public function specTitles()
// {
//     return $this->belongsToMany('App\Models\Product\ProductItemSpecTitle', 'product_item_part_spec_title', 'part_id', 'spec_id');
// }
}
