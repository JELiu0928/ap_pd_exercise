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
	public function ProductCategory()
	{
		return $this->belongsTo(ProductCategory::class, 'category_id');
	}
	public function category()
	{
		return $this->belongsTo(ProductCategory::class, 'category_id')->isVisible();
	}

	public function ProductItem()
	{
		return $this->hasMany(ProductItem::class, 'series_id');
	}
	public function items()
	{
		return $this->hasMany(ProductItem::class, 'series_id')
        ->formatFiles(['list_img','banner_pc_img','banner_pad_img','banner_m_img','product_pc_img','product_m_img'])->isVisible();
	}

	public static function getSeriesList()
	{
		// dd(ProductCategory::get());

		$list = self::with('category')
			// ->select('id', 'title')
			->get()
            ->map(function($item){
                // dump($item);
                return [
                    'key'=>$item['id'],
                    'title' =>(isset($item->category['simple_title']) ? $item->category['simple_title'].' > ' : '' ) . $item['title']
                ];
            })->keyBy('key');

			// ->mapWithKeys(function ($cate) {
			// 	// 扁平化 ProductSeries 的结果，直接返回数组，而不是嵌套 Collection
			// 	return $cate->ProductSeries->mapWithKeys(function ($item) use ($cate) {
			// 		return [
			// 			$item->id => [  // 用 ProductSeries 的 id 作为键
			// 				'key' => $item->id,
			// 				'title' => $cate->simple_title . ' > ' . $item->title
			// 			]
			// 		];
			// 	});
			// })
			// ->toArray();  // 最终转化为数组，避免 Collection
        // dd($list);
		return $list;
	}
}
