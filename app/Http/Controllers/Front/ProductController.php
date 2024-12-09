<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCategoryOverview;
use App\Models\Product\ProductItemSpecContent;
use App\Models\Product\ProductSeries;
use App\Models\Product\ProductSet;
use Illuminate\Http\Request;
use View;
use BaseFunction;
use App\Http\Controllers\OptionFunction;
use App\Models\Product\ProductItem;

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
    public function list(Request $request)
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

        $is_overview = false;
        $is_overviewList = false;
        $is_advantages = false;
        $is_product = false;
        if (count($cateOverviews->overviews) > 0) {
            $is_overview = true;
        }
        if (count($cateOverviewLists->overviewLists) > 0) {
            $is_overviewList = true;
        }
        if (count($cateAdvantages->advantagesTags) > 0) {
            $is_advantages = true;
        }
        foreach ($cateProducts->series as $series) {
            if (count($series->items)) {
                // dd('ss', $series->items);
                // if(count($cateProducts->series) ||count($cateProducts->series->items)){
                $is_product = true;
            }
        }
        return view(self::$blade_template . '.product.list', [
            'category' => $category,
            'productCategories' => $productCategories, //產品類別
            'cateOverviews' => $cateOverviews, //概述
            'cateOverviewLists' => $cateOverviewLists, //概述List
            'cateAdvantages' => $cateAdvantages,
            'cateProducts' => $cateProducts,
            'is_overview' => $is_overview,
            'is_overviewList' => $is_overviewList,
            'is_advantages' => $is_advantages,
            'is_product' => $is_product,
            'basic_seo' => Seo()
        ]);
    }
    public function detail(Request $request)
    {
        // $unitSet = ProductSet::formatFiles(['banner_pc_img', 'banner_pad_img', 'banner_m_img'])->first();
        $categoryURL = $request->categoryURL ?? '';
        $productURL = $request->productURL ?? '';

        $query = ProductItem::with(['series.category', 'keywords', 'articles.articleImgs'])
            ->formatFiles(['list_img', 'banner_pc_img', 'banner_pad_img', 'banner_m_img', 'product_pc_img', 'product_m_img'])
            ->where('url_name', $productURL)
            ->whereHas('series.category', function ($query) use ($categoryURL) {
                $query->where('url_name', $categoryURL);
            });

        $productInfo = $query->first();
        // dump($productInfo);
        // dump(count($productInfo->articles));
        $is_article = false;
        if (count($productInfo->articles) > 0) {
            $is_article = true;
        }
        // dump('article是',$is_article);

        // 產品規格表

        $productItem = ProductItem::with(['series.category', 'parts', 'specTitles.contents'])
            ->where('url_name', $productURL)
            ->whereHas('series.category', function ($query) use ($categoryURL) {
                $query->where('url_name', $categoryURL);
            })->first();
        // dump($productItem->first());

        // $productItemSpec = $SpecQuery->with(['parts', 'specTitles'])->first();
        $specParts = $productItem->parts;
        $specTitles = $productItem->specTitles;

        $contents = ProductItemSpecContent::whereIn('spec_id', $specTitles->pluck('id'))->get();
        // dump($contents);
        $specContentArr = [];
        foreach ($contents as $content) {
            $specContentArr[$content->spec_id][$content->part_id] = $content->content;
        }
        // dd($specContentArr);
        return view(self::$blade_template . '.product.detail', [
            'productInfo' => $productInfo,
            'is_article' => $is_article, //產品類別
            'specTitles' => $specTitles, //表頭
            'specParts' => $specParts, //型號
            'specContentArr' => $specContentArr, //處理過的內容
            // 'cateAdvantages' => $cateAdvantages,
            // 'cateProducts' => $cateProducts,
            'basic_seo' => Seo()
        ]);
    }

}
