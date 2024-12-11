<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCategoryOverview;
use App\Models\Product\ProductItemPart;
use App\Models\Product\ProductItemSpecContent;
use App\Models\Product\ProductItemSpecTitle;
use App\Models\Product\ProductSeries;
use App\Models\Product\ProductSet;
use Illuminate\Http\Request;
use View;
use BaseFunction;
use Session;
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
        $category = ProductCategory::formatFiles(['list_img', 'banner_pc_img', 'banner_pad_img', 'banner_m_img', 'advantages_zone_img'])
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
        // dd('==', $cateOverviewLists);
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

        // 下拉
        $itemID = ProductItem::where('url_name', $request->productURL)->pluck('id')->first();
        // dd($itemID);
        $partIDs = ProductItemPart::isVisible()->get()->pluck('id');
        $isFilterSpecIDs = ProductItemSpecTitle::isVisible()
            ->where('item_id', $itemID)
            ->where('is_filter', 1)
            ->get()
            ->pluck('id');
        // dump($isFilterSpecIDs);
        //所有型號的內容
        $partContents = ProductItemSpecContent::with('specTitle')
            ->where('item_id', $itemID)
            ->whereIn('part_id', $partIDs)
            ->whereIn('spec_id', $isFilterSpecIDs)
            ->get();

        // dump($partContents);
        $dropdownArr = [];
        foreach ($partContents as $key => $content) {
            # code...
            $specID = $content['spec_id'];
            // dump($content);
            if (!isset($dropdownArr[$specID])) {
                $dropdownArr[$specID] = [
                    'spec_title' => $content->specTitle['title'],
                    'spec_id' => $content['spec_id'],
                    'content' => []
                ];
            }
            if (!in_array($content['content'], $dropdownArr[$specID]['content'])) {
                // dump($dropdownArr[$specID]['content']);
                $dropdownArr[$specID]['content'][] = $content['content'];
            }
        }

        $sessionPartIDs = Session::get('partIDList');
        // dump($sessionPartIDs);
        if (!empty($sessionPartIDs)) {
            $partItems = self::getConsult($sessionPartIDs);
            $partItemCounts = count($partItems);
        }

        // dd($partItems);
        return view(self::$blade_template . '.product.detail', [
            'productInfo' => $productInfo,
            'is_article' => $is_article, //產品類別
            'specTitles' => $specTitles, //表頭
            'specParts' => $specParts, //型號
            'specContentArr' => $specContentArr, //處理過的內容
            'dropdownArr' => $dropdownArr, //下拉選單
            'partItemCounts' => $partItemCounts ?? 0,
            'basic_seo' => Seo(),
            // 'view' => View::make(self::$blade_template . '.product.consult_pd_list', [
            'partItems' => $partItems ?? [],
            // ])->render(),
        ]);
    }
    public function deleteProductFromConsultList(Request $request)
    {
        $res = [];
        $res['status'] = true;

        $partIDList = Session::get('partIDList', []);
        // dump($partIDList);
        $partID = $request->get('partID');
        // dd($partID);
        // $res['partIDs'] = [];
        $itemID = ProductItem::with('parts')->isVisible()->whereHas('parts', function ($q) use ($partID) {
            $q->where('id', $partID);
        })->pluck('id')->first();

        if (!empty($itemID)) {
            $key = array_search($partID, $partIDList); //index位置
            // dd('$key==', $key);
            if ($key !== false) {
                unset($partIDList[$key]);
                //刪除被選擇的後重新設置
                Session::put('partIDList', $partIDList);
                Session::save(); //可加可不加，增加可讀性
            } else {
                $res['status'] = false;
            }
        }



        // $partID = $request->all();
        // $res['result'] = $partID;
        // $partID = $request->all();
        // dd('del partID', $partID);
        return $res;
    }
    // public function validatedPart($partID) : Returntype {
    //     $itemID = ProductItem::with('parts')->isVisible()->whereHas('parts', function ($q) use ($partID) {
    //         $q->where('id', $partID);
    //     })->pluck('id')->first();

    // }
    public function addProductToConsultList(Request $request)
    {
        // Session::forget('partIDList');

        $res = [];
        $res['status'] = true;
        $res['partIDs'] = [];
        // partIDList 為以產品id為資料的陣列
        $partIDList = Session::get('partIDList', []);

        // dd($request->all());
        //取得前端傳入id 一次一個
        $partID = $request->get('partID') ?? 0;
        $itemID = ProductItem::with('parts')->isVisible()->whereHas('parts', function ($q) use ($partID) {
            $q->where('id', $partID);
        })->pluck('id')->first();
        // dd('ssss', $itemID);
        // dd('==>', ProductItem::with('ProductItemPart')->get());
        //檢驗產品是否合法
        if (!empty($itemID)) {
            $partItem = ProductItemPart::with('item.series.category')
                ->where('id', $partID)
                ->first();
        }
        // dd('partItem', $partItem);
        if (empty($partItem)) {
            $res['status'] = false;
            return $res;
        }

        //檢驗是否已記錄 加入陣列
        if (!in_array($partID, $partIDList)) {
            $partIDList[] = $partID;
            Session::put('partIDList', $partIDList);
            Session::save(); //可加可不加，增加可讀性
        }

        $res['count'] = count($partIDList);
        $res['partIDs'] = $partIDList;

        return $res;
    }
    public function getConsultData(Request $request)
    {
        $partIDList = Session::get('partIDList', []);
        $partItems = ProductItemPart::with('item.series.category')->whereIn('id', $partIDList)->isVisible()->get();
        // dd('partItems', $partItems);
        return response([
            'view' => View::make(self::$blade_template . '.product.consult_pd_list', [
                'partItems' => $partItems,
            ])->render(),
            // 'ids' => $list,
            // 'count' => $consult_count,
            // 'consult_list_count_text' => $consult_list_count_text,
        ]);

    }
    public function getConsult($ids)
    {
        $tempList = [];
        foreach ($ids as $id) {
            if (!in_array($id, $tempList)) {
                array_push($tempList, $id);
            }
        }
        $partItems = ProductItemPart::with('item.series.category')->whereIn('id', $tempList)->isVisible()->get();

        return $partItems;
    }
}
