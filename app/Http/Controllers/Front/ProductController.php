<?php

namespace App\Http\Controllers\Front;

use App\Cms\Api\Product\ContactJobApi;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCategoryOverview;
use App\Models\Product\ProductConsult;
use App\Models\Product\ProductConsultList;
use App\Models\Product\ProductItemPart;
use App\Models\Product\ProductItemSpecContent;
use App\Models\Product\ProductItemSpecTitle;
use App\Models\Product\ProductSeries;
use App\Models\Product\ProductSet;
use App\Models\Product\ProductItem;
use App\Models\Product\ConsultJob;
use Illuminate\Http\Request;
use View;
use App\Http\Controllers\BaseFunctions;

use Session;
use Validator;
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
        // dd(self::$branch_id);
    }
    public function index(Request $request)
    {
        $unitSet = ProductSet::formatFiles(['banner_pc_img', 'banner_pad_img', 'banner_m_img'])->first();
        // dd($unitSet);
        $productCategories = ProductCategory::formatFiles(['list_img'])->isVisible()->doSort()->get();
        // dd($productCategories);
        $consultJobs = ConsultJob::isVisible()->doSort()->get();
        $genders = array(0 => '先生', 1 => '小姐', 2 => '其他', );
        $sessionPartIDs = Session::get('partIDList');
        if (!empty($sessionPartIDs)) {
            $partItemCounts = count($sessionPartIDs);
        }
        return view(
            self::$blade_template . '.product.index',
            [
                'basic_seo' => Seo(),
                'unitSet' => $unitSet,
                'productCategories' => $productCategories,
                'partItemCounts' => $partItemCounts ?? 0,
                'consultJobs' => $consultJobs,
                'genders' => $genders,
            ]
        );

    }
    public function list(Request $request)
    {
        $categoryURL = $request->categoryURL ?? '';
        // if($categoryURL)
        $productCategories = ProductCategory::formatFiles(['list_img'])->isVisible()->doSort()->get();

        $category = ProductCategory::formatFiles(['list_img', 'banner_pc_img', 'banner_pad_img', 'banner_m_img', 'advantages_zone_img'])
            ->where('url_name', $categoryURL)->doSort()->first();
        // dump($category);
        if (!isset($category) || empty($category)) {
            return error404(BaseFunctions::b_url('product'));
        }

        // dd($category['url_name']);
        if ($category['url_name'] == $categoryURL) {
            $setActiveKey = $category['id'];
        }
        $cateOverviews = ProductCategory::with('overviews')->where('url_name', $categoryURL)->first();
        $cateOverviewLists = ProductCategory::with('overviewLists')->where('url_name', $categoryURL)->first();
        $cateAdvantages = ProductCategory::with('advantagesTags.advantagesLists')->where('url_name', $categoryURL)->first();
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
        $consultJobs = ConsultJob::isVisible()->doSort()->get();
        $genders = array(0 => '先生', 1 => '小姐', 2 => '其他', );
        $sessionPartIDs = Session::get('partIDList');
        if (!empty($sessionPartIDs)) {
            $partItemCounts = count($sessionPartIDs);
        }

        return view(self::$blade_template . '.product.list', [
            'category' => $category,
            'setActiveKey' => $setActiveKey,
            'productCategories' => $productCategories, //產品類別
            'cateOverviews' => $cateOverviews, //概述
            'cateOverviewLists' => $cateOverviewLists, //概述List
            'cateAdvantages' => $cateAdvantages,
            'cateProducts' => $cateProducts,
            'is_overview' => $is_overview,
            'is_overviewList' => $is_overviewList,
            'is_advantages' => $is_advantages,
            'is_product' => $is_product,
            'partItemCounts' => $partItemCounts ?? 0,
            'consultJobs' => $consultJobs,
            'genders' => $genders,
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

        // dd($productInfo);
        $selectCateUrl = ProductCategory::where('url_name', $categoryURL)->pluck('url_name')->first();
        if (!isset($productInfo) || empty($productInfo)) {
            return error404(BaseFunctions::b_url('product/' . $selectCateUrl));
        }
        $is_article = false;
        if (count($productInfo->articles) > 0) {
            $is_article = true;
        }
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
        $cateProducts = ProductCategory::with('series.items')->where('url_name', $categoryURL)->first();

        //每個頁面要有
        $sessionPartIDs = Session::get('partIDList');
        // dump($sessionPartIDs);
        //bug??
        // if (!empty($sessionPartIDs)) {
        //     $partItems = self::getConsult($sessionPartIDs);
        //     $partItemCounts = count($partItems);
        // }

        if (!empty($sessionPartIDs)) {
            // $partItems = self::getConsult($sessionPartIDs);
            $partItemCounts = count($sessionPartIDs);
        }

        $consultJobs = ConsultJob::isVisible()->doSort()->get();
        $genders = array(0 => '先生', 1 => '小姐', 2 => '其他', );

        return view(self::$blade_template . '.product.detail', [
            'productInfo' => $productInfo,
            'is_article' => $is_article, //產品類別
            'specTitles' => $specTitles, //表頭
            'specParts' => $specParts, //型號
            'specContentArr' => $specContentArr, //處理過的內容
            'dropdownArr' => $dropdownArr, //下拉選單
            'partItemCounts' => $partItemCounts ?? 0,
            'sessionPartIDs' => $sessionPartIDs,
            'consultJobs' => $consultJobs,
            'genders' => $genders,
            'cateProducts' => $cateProducts,

            'basic_seo' => Seo(),
            // 'view' => View::make(self::$blade_template . '.product.consult_pd_list', [
            'partItems' => $partItems ?? [],
            // ])->render(),
        ]);
    }
    public function success(Request $request)
    {
        $consultID = Session::get('consultSuccess');
        // dd($consultID);
        if (!isset($consultID) || empty($consultID)) {
            return error404(BaseFunctions::b_url('product'));
        }
        $consultItem = ProductConsult::where('id', $consultID)->with('ProductConsultList.part.item.series.category')->first();
        // dump($consultItem);
        $successCount = count($consultItem->ProductConsultList);
        // $consultItemParts = $consultItem->ProductConsultList->part;
        // dump('型號', $consultItemParts);
        foreach ($consultItem->ProductConsultList as $list) {
            // dump('000', $list);
            if (empty($list['description'])) {
                $list['description'] = '無';
            }
        }
        // foreach ($consultItem as $item) {
        // dump('000', $list);
        if (empty($consultItem['description'])) {
            $consultItem['description'] = '無';
        }
        if (empty($consultItem['service'])) {
            $consultItem['service'] = '無';
        }
        if (empty($consultItem['job'])) {
            $consultItem['job'] = '無';
        }
        if (empty($consultItem['other_Require'])) {
            $consultItem['other_Require'] = '無';
        }
        // }
        //諮詢清單所需
        $consultJobs = ConsultJob::isVisible()->doSort()->get();
        $genders = array(0 => '先生', 1 => '小姐', 2 => '其他', );
        $sessionPartIDs = Session::get('partIDList');
        if (!empty($sessionPartIDs)) {
            $partItemCounts = count($sessionPartIDs);
        }

        Session::forget('consultSuccess');


        return view(self::$blade_template . '.product.consult_success', [
            'partItemCounts' => $partItemCounts ?? 0,
            'consultJobs' => $consultJobs,
            'genders' => $genders,
            'consultItem' => $consultItem,
            'successCount' => $successCount,
            'basic_seo' => Seo(),

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
            // if ($key !== false) {
            //     unset($partIDList[$key]);
            //     //刪除被選擇的後重新設置
            //     $res['count'] = count($partIDList);
            //     Session::put('partIDList', $partIDList);
            //     Session::save(); //可加可不加，增加可讀性
            // } else {
            //     $res['status'] = false;
            // }
            if (($key = array_search($partID, $partIDList)) !== false) {
                unset($partIDList[$key]); // 刪除該項
                $partIDList = array_values($partIDList); // 重建索引
                $res['count'] = count($partIDList);
                Session::put('partIDList', $partIDList);
                // dump('多少',$res['count'] );
            }
        }
        return $res;
    }
    public function deleteAllFromConsultList(Request $request)
    {
        $res = [];
        $res['status'] = true;

        Session::forget('partIDList');
        $res['count'] = 0;

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
        // $partIDList[$partID] = $partID;
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
        // $res
        $partIDList = Session::get('partIDList', []);
        $partItems = ProductItemPart::with('item.series.category')->whereIn('id', $partIDList)->isVisible()->get();
        $count = count($partIDList);

        // dd('partItems', $partItems);
        return response([
            'view' => View::make(self::$blade_template . '.product.consult_pd_list', [
                'partItems' => $partItems,
            ])->render(),
            'partIDList' => $partIDList,
            'count' => $count
        ]);

    }

    public function submitForm(Request $request)
    {

        $res = [];
        $res['status'] = true;
        $data = $request->get('data');
        // dump($data);
        $data['job'] = $data['job']['value'] ?? '';
        $data['gender'] = $data['gender']['value'] ?? '';
        $data['branch_id'] = self::$branch_id;
        // $data['partID'] = 
        $partList = $request->get('partList');

        // dd($data, $partList);
        $rule = [
            'companyName' => 'required',
            'name' => 'required',
            'mail' => 'required|email',
            'tel' => 'required',
            'description' => 'required',
            'verifyCode' => 'required|captcha',
        ];
        $message = [
            'companyName.required' => "請填寫您的公司名稱",
            'name.required' => "請填寫您的聯絡姓名",
            'tel.required' => "欄位格式輸入錯誤",
            'description.required' => "請填寫備註",
            'mail.required' => "請填寫您的電子信箱",
            'mail.email' => "欄位格式輸入錯誤",
            'verifyCode.required' => "請填寫驗證碼",
            'verifyCode.captcha' => "驗證碼輸入錯誤",
        ];
        $validator = Validator::make($data, $rule, $message);
        // 驗證失敗時
        if ($validator->fails()) {
            // 儲存所有錯誤訊息
            $errorMsg = [];
            foreach ($validator->errors()->messages() as $key => $item) {
                $errorMsg[$key] = $item[0];
                // dd($item);
            }
            $res['status'] = false;
            $res['errorMsg'] = $errorMsg;
            return $res;
        }
        // 新增到諮詢表單表
        $newConsult = ProductConsult::create($data);
        $consutID = $newConsult['id'];
        //清除諮詢表單的session
        Session::forget('partIDList');

        if (!empty($consutID)) {
            foreach ($partList as $part) {
                // dump('$part', $part);
                $part['consult_id'] = $consutID;
                $part['branch_id'] = self::$branch_id;
                ProductConsultList::create($part);
            }
            $res['status'] = true;
            Session::put('consultSuccess', $consutID);

            return $res;
        } else {
            $res['status'] = false;
            return $res;
        }


    }
    // public function getConsult($ids)
    // {
    //     $tempList = [];
    //     foreach ($ids as $id) {
    //         if (!in_array($id, $tempList)) {
    //             array_push($tempList, $id);
    //         }
    //     }
    //     $partItems = ProductItemPart::with('item.series.category')->whereIn('id', $tempList)->isVisible()->get();

    //     return $partItems;
    // }
}
