<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\ProductCategory;
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
		// dd($unit_set);
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
	public function sub(Request $request)
	{
		return view(self::$blade_template . '.home.index', ['basic_seo' => Seo()]);
	}
}
