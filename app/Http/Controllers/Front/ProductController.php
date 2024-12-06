<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCategoryOverview;
use App\Models\Product\ProductSeries;
use App\Models\Product\ProductSet;
use Illuminate\Http\Request;
use View;
use BaseFunction;
use App\Http\Controllers\OptionFunction;

class ProductController extends FrontBaseController
{
	static $unit;
	public function __construct()
	{
		parent::__construct();
		//sitemap過濾用 避免sitemap進入以下程式
		// if (!parent::__construct()) {
		// 	//原本該單元需要做的事情
		// }
		self::$unit = ProductSet::first();
		View::share('unit', self::$unit);

	}
	public function index(Request $request)
	{
		$unitSet = ProductSet::formatFiles(['banner_pc_img', 'banner_pad_img', 'banner_m_img'])->first();
		// dd($unitSet);
		$productCategories = ProductCategory::formatFiles(['list_img'])->doSort()->get();
		// dd($productCategories);
		return view(
			self::$blade_template . '.product.index',
			[
				'basic_seo' => Seo(),
				'unitSet' => $unitSet,
				'productCategories' => $productCategories,

			]
		);
	}
	public function list(Request $request, )
	{
		// $unitSet = ProductSet::formatFiles(['banner_pc_img', 'banner_pad_img', 'banner_m_img'])->first();
		$categoryURL = $request->categoryURL ?? '';
		// dd($categoryURL);
		$productCategories = ProductCategory::formatFiles(['list_img'])->doSort()->get();
		$category = ProductCategory::formatFiles(['list_img', 'banner_pc_img', 'banner_pad_img', 'banner_m_img'])
			->where('url_name', $categoryURL)->doSort()->first();
		// dump($category);
		$cateOverviews = ProductCategory::with('overviews')->where('url_name', $categoryURL)->first();
		$cateOverviewLists = ProductCategory::with('overviewLists')->where('url_name', $categoryURL)->first();
		$cateAdvantages = ProductCategory::with('advantagesTags.advantagesLists')->where('url_name', $categoryURL)->first();
		// dd($cateOverviews);
		// $cateAdvantages = ProductCategory::with('advantagesTags.advantagesLists')->where('url_name', $categoryURL)->first();
		$cateProducts = ProductCategory::with('series.items')->where('url_name', $categoryURL)->first();
		// dump($cateProducts->series);

		return view(self::$blade_template . '.product.list', [
			'category' => $category,
			'productCategories' => $productCategories,
			'cateOverviews' => $cateOverviews,
			'cateOverviewLists' => $cateOverviewLists,
			'cateAdvantages' => $cateAdvantages,
			'cateProducts' => $cateProducts,
			'basic_seo' => Seo()
		]);
	}
}
